<?php
// modules/apps/api_get_reviews.php
require_once __DIR__ . '/../../includes/config/database.php';

header('Content-Type: application/json');

$app_id = $_GET['id'] ?? 0;
if (empty($app_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid App ID']);
    exit;
}

try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT play_store_link, indus_store_link, cached_reviews, reviews_updated_at FROM apps WHERE id = :id LIMIT 1");
    $stmt->bindValue(':id', $app_id, PDO::PARAM_INT);
    $stmt->execute();
    $app = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$app) {
        echo json_encode(['success' => false, 'message' => 'App not found']);
        exit;
    }

    // Check if we have a valid 4-hour cache
    if (!empty($app['cached_reviews']) && !empty($app['reviews_updated_at'])) {
        $cache_time = strtotime($app['reviews_updated_at']);
        if (time() - $cache_time < 14400) { // 14400 seconds = 4 hours
            echo $app['cached_reviews'];
            exit;
        }
    }

    // Increase max execution time for scraping
    set_time_limit(120);

    $reviews = [];
    $play_store_count = 0;
    $indus_store_count = 0;

    // Helper function to fetch URL with a reasonable timeout and User-Agent
    function fetch_url($url) {
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36\r\n" .
                            "Accept-Language: en-US,en;q=0.9\r\n" .
                            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n",
                'timeout' => 60
            ]
        ];
        $context = stream_context_create($options);
        return @file_get_contents($url, false, $context);
    }

    // Try to scrape Google Play Store via the new Vercel API
    if (!empty($app['play_store_link'])) {
        // Extract appId from play_store_link
        $parsed_url = parse_url($app['play_store_link']);
        $app_id_str = '';
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $query_params);
            $app_id_str = $query_params['id'] ?? '';
        }

        if (!empty($app_id_str)) {
            $api_url = "https://play-store-9q1yzmemz-techily-fly-apps-team.vercel.app/api/reviews?appId=" . urlencode($app_id_str);
            $json_response = fetch_url($api_url);
            
            if ($json_response) {
                $api_data = json_decode($json_response, true);
                if (isset($api_data['success']) && $api_data['success'] && !empty($api_data['data'])) {
                    $play_store_count = count($api_data['data']);
                    foreach ($api_data['data'] as $r) {
                        $reviews[] = [
                            'reviewer_name' => htmlspecialchars($r['userName'] ?? 'Unknown'),
                            'rating' => isset($r['score']) ? floatval($r['score']) : 5,
                            'review_text' => htmlspecialchars($r['text'] ?? ''),
                            'date' => isset($r['date']) ? date('M d, Y', strtotime($r['date'])) : '',
                            'source' => 'Google Play Store',
                            'avatar' => $r['userImage'] ?? ''
                        ];
                    }
                }
            }
        }
    }

    // Try to scrape Indus App Store using the live Render Playwright API
    if (!empty($app['indus_store_link'])) {
        $indus_api_url = "https://indus-appstore-api-0wku.onrender.com/api/reviews?url=" . urlencode($app['indus_store_link']);
        $json_response = fetch_url($indus_api_url);
        
        if ($json_response) {
            $api_data = json_decode($json_response, true);
            if (isset($api_data['success']) && $api_data['success'] && !empty($api_data['data'])) {
                $indus_store_count = count($api_data['data']);
                foreach ($api_data['data'] as $r) {
                    $reviews[] = [
                        'reviewer_name' => htmlspecialchars($r['userName'] ?? 'Unknown'),
                        'rating' => isset($r['score']) ? floatval($r['score']) : 5,
                        'review_text' => htmlspecialchars($r['text'] ?? ''),
                        'date' => htmlspecialchars($r['date'] ?? ''),
                        'source' => 'Indus App Store',
                        'avatar' => ''
                    ];
                }
            }
        }
    }

    // Sort reviews by rating (highest first)
    usort($reviews, function($a, $b) {
        return $b['rating'] <=> $a['rating'];
    });

    // Get top 25 reviews
    $top_reviews = array_slice($reviews, 0, 25);

    $json_output = json_encode([
        'success' => true, 
        'reviews' => $top_reviews,
        'play_store_count' => $play_store_count,
        'indus_store_count' => $indus_store_count
    ]);
    
    // Save the new data into the cache
    $update_stmt = $pdo->prepare("UPDATE apps SET cached_reviews = :cache, reviews_updated_at = NOW() WHERE id = :id");
    $update_stmt->bindValue(':cache', $json_output);
    $update_stmt->bindValue(':id', $app_id, PDO::PARAM_INT);
    $update_stmt->execute();

    echo $json_output;

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

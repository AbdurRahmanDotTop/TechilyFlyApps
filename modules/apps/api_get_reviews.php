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

    $reviews = [];

    // Helper function to fetch URL with a reasonable timeout and User-Agent
    function fetch_url($url) {
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36\r\n" .
                            "Accept-Language: en-US,en;q=0.9\r\n" .
                            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n",
                'timeout' => 5
            ]
        ];
        $context = stream_context_create($options);
        return @file_get_contents($url, false, $context);
    }

    // Try to scrape Google Play Store directly in PHP
    if (!empty($app['play_store_link'])) {
        $html = fetch_url($app['play_store_link'] . '&hl=en&gl=US');
        if ($html) {
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);
            
            $nodes = $xpath->query('//div[contains(@class, "EGFGHd")]');
            foreach ($nodes as $node) {
                $reviewer_name = 'Unknown';
                $rating = 5;
                $review_text = '';
                $date = '';

                $nameNode = $xpath->query('.//div[contains(@class, "X5PpBb")]', $node);
                if ($nameNode->length > 0) $reviewer_name = $nameNode->item(0)->textContent;

                $textNode = $xpath->query('.//div[contains(@class, "h3YV2d")]', $node);
                if ($textNode->length > 0) $review_text = $textNode->item(0)->textContent;

                $ratingNode = $xpath->query('.//div[contains(@aria-label, "Rated")]', $node);
                if ($ratingNode->length > 0) {
                    $aria = $ratingNode->item(0)->getAttribute('aria-label');
                    if (preg_match('/Rated (\d+) stars/', $aria, $matches)) {
                        $rating = (float)$matches[1];
                    }
                }

                $dateNode = $xpath->query('.//span[contains(@class, "bp9cbj")]', $node);
                if ($dateNode->length > 0) $date = $dateNode->item(0)->textContent;

                if (!empty($review_text)) {
                    $reviews[] = [
                        'reviewer_name' => htmlspecialchars($reviewer_name),
                        'rating' => $rating,
                        'review_text' => htmlspecialchars($review_text),
                        'date' => htmlspecialchars($date),
                        'source' => 'Google Play Store',
                        'avatar' => ''
                    ];
                }
            }
        }
    }

    // Try to scrape Indus App Store directly (Fallback / Simple attempt)
    if (!empty($app['indus_store_link'])) {
        // Since Indus relies heavily on JS, a basic fetch might not get reviews
        // But we still attempt to fetch it directly to fulfill the requirement
        $indus_html = fetch_url($app['indus_store_link']);
        if ($indus_html) {
            $dom = new DOMDocument();
            @$dom->loadHTML($indus_html);
            $xpath = new DOMXPath($dom);
            
            // Looking for typical review patterns if any exist in the static DOM
            // This might yield empty results if entirely JS-rendered
            $indusNodes = $xpath->query('//*[contains(@class, "review") or contains(@class, "comment")]');
            $count = 0;
            foreach ($indusNodes as $node) {
                if ($count >= 5) break; // limit to 5
                $text = trim($node->textContent);
                if (strlen($text) > 20 && strlen($text) < 500) {
                    $reviews[] = [
                        'reviewer_name' => 'Indus User',
                        'rating' => 5,
                        'review_text' => htmlspecialchars($text),
                        'date' => date('M d, Y'),
                        'source' => 'Indus App Store',
                        'avatar' => ''
                    ];
                    $count++;
                }
            }
        }
    }

    $json_output = json_encode(['success' => true, 'reviews' => $reviews]);
    
    // Save the new data into the cache
    $update_stmt = $pdo->prepare("UPDATE apps SET cached_reviews = :cache, reviews_updated_at = NOW() WHERE id = :id");
    $update_stmt->bindValue(':cache', $json_output);
    $update_stmt->bindValue(':id', $app_id, PDO::PARAM_INT);
    $update_stmt->execute();

    echo $json_output;

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

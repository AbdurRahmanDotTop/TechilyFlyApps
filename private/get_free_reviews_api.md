# Guide: Getting Free APIs for App Store Reviews

Getting reviews programmatically from app stores can be challenging because neither Google nor Indus App Store provides a simple, completely free official public API for fetching user reviews without authentication constraints or costs. 

However, there are completely free workarounds and generous free-tier services you can use to build this out. Here is a detailed step-by-step guide on how to get or build an API for this completely free.

---

## Part 1: Google Play Store Reviews

Google does not have an open public API for reviews. You generally have two free paths: build your own micro-service using an open-source library, or use a third-party API with a free tier.

### Option A: Build Your Own Free API (Highly Recommended)
You can use the open-source Node.js library `google-play-scraper`, which requires no API keys and is completely free. You can host it for free on platforms like Vercel, Render, or Railway.

**Step 1: Setup a local Node.js project**
1. Install Node.js on your machine.
2. Create a new folder on your computer (e.g., `play-store-api`) and open it in your terminal.
3. Run `npm init -y` to initialize the project.
4. Run `npm install express google-play-scraper@9` to install the required libraries (we use version 9 to ensure maximum compatibility).

**Step 2: Create the API Code (`index.js`)**
Create a file named `index.js` and paste this code:
```javascript
const express = require('express');
const gplay = require('google-play-scraper');

const app = express();

app.get('/api/reviews', async (req, res) => {
    const appId = req.query.appId; // e.g., com.whatsapp
    
    if (!appId) {
        return res.status(400).json({ error: 'appId is required' });
    }

    try {
        const reviews = await gplay.reviews({
            appId: appId,
            sort: gplay.sort.NEWEST,
            num: 10 // Number of reviews to fetch
        });
        res.json({ success: true, data: reviews.data });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

const PORT = process.env.PORT || 3000;
if (process.env.NODE_ENV !== 'production') {
    app.listen(PORT, () => console.log(`API running on port ${PORT}`));
}

module.exports = app;
```

**Step 3: Add a `vercel.json` file**
Create a new file named `vercel.json` in the same folder and add this code so Vercel knows how to route your Express app:
```json
{
  "version": 2,
  "builds": [
    {
      "src": "index.js",
      "use": "@vercel/node"
    }
  ],
  "routes": [
    {
      "src": "/(.*)",
      "dest": "index.js"
    }
  ]
}
```

**Step 4: Host it for Free on Vercel**
1. Install the Vercel CLI: `npm i -g vercel`.
2. In your terminal, run `vercel` and follow the prompts to deploy.
3. You now have a permanent, completely free API! 
*Example usage:* `https://your-vercel-app.vercel.app/api/reviews?appId=com.whatsapp`

### Option B: Use Third-Party APIs (Free Tiers)
If you do not want to host your own Node.js app, you can use third-party APIs that give you free monthly credits forever.

1. **SerpApi (Google Play Reviews API)**
   - **Cost:** Free up to 100 searches/month.
   - **Steps:** Go to [SerpApi](https://serpapi.com/), sign up for a free account, and get your API key. 
   - **Endpoint:** `https://serpapi.com/search.json?engine=google_play_product&store=apps&gl=us&hl=en&product_id=com.whatsapp&all_reviews=true&api_key=YOUR_KEY`

2. **Outscraper (Google Play Reviews API)**
   - **Cost:** Free Tier gives thousands of free records.
   - **Steps:** Sign up at [Outscraper](https://outscraper.com/google-play-reviews-scraper/).

---

## Part 2: Indus App Store Reviews

The Indus App Store is relatively new and currently does not have an official public API, nor are there popular open-source scrapers like there are for Google Play. To get this data for free, you must use **Custom Web Scraping** or **Network Inspection**.

### Option A: Inspect the Network Tab (The "Hidden API" Method)
When you visit an app's page on the Indus App Store in your browser, the website itself makes an API call to load the reviews. You can intercept this and use it as a free API.

1. Open your browser (Chrome/Edge) and go to an app's page on the Indus App Store.
2. Right-click anywhere on the page and select **Inspect**.
3. Go to the **Network** tab in the developer tools.
4. Filter by `Fetch/XHR`.
5. Scroll down to the reviews section on the webpage. You will see a new network request pop up in the developer tools (it usually returns a JSON file).
6. Click on that request and look at the **Request URL**. This is their internal API! 
7. You can copy this URL and use it in your PHP code (`file_get_contents($url)`) to fetch the JSON directly. *Note: You may need to copy the `Headers` (like User-Agent or Authorization tokens) if the request fails without them.*

### Option B: PHP DOM Scraping
If they render the reviews directly in the HTML (Server-Side Rendering), you can scrape the HTML directly using PHP, which is completely free.

1. Install the `simplehtmldom` library for PHP.
2. Fetch the HTML:
   ```php
   include('simple_html_dom.php');
   $html = file_get_html('https://www.indusappstore.com/app/com.example.app');
   ```
3. Find the CSS class of the review cards and extract the text:
   ```php
   foreach($html->find('div.review-card-class') as $review) {
       $reviewer_name = $review->find('.user-name', 0)->plaintext;
       $review_text = $review->find('.review-text', 0)->plaintext;
   }
   ```
*(Note: You will need to inspect the HTML of the Indus App Store to find the exact class names `review-card-class`, etc.)*

---

## How to Integrate this into your TechilyFly App

Once you choose a method (e.g., Option A for Play Store using Vercel), simply update the `c:\xampp\htdocs\TechilyFly\TechilyFlyApps\TechilyFlyApps\modules\apps\api_get_reviews.php` file we created earlier.

Instead of the mock fallback, you will make an HTTP request to your new free API:

```php
// Inside api_get_reviews.php
$play_store_id = "com.whatsapp"; // Extract this from your database link
$free_api_url = "https://your-vercel-app.vercel.app/api/reviews?appId=" . $play_store_id;

$response = file_get_contents($free_api_url);
$data = json_decode($response, true);

if ($data['success']) {
    foreach ($data['data'] as $review) {
        $reviews[] = [
            'reviewer_name' => $review['userName'],
            'rating' => $review['score'],
            'review_text' => $review['text'],
            'date' => $review['date'],
            'source' => 'Google Play Store'
        ];
    }
}
```

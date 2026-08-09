const express = require('express');
const gplay = require('google-play-scraper');

const app = express();

app.get('/', (req, res) => {
    res.send('Google Play Store Reviews API is running! Use /api/reviews?appId=com.whatsapp to fetch reviews.');
});

app.get('/api/reviews', async (req, res) => {
    const appId = req.query.appId;
    
    if (!appId) {
        return res.status(400).json({ error: 'appId is required' });
    }

    try {
        const reviews = await gplay.reviews({
            appId: appId,
            sort: gplay.sort.NEWEST,
            num: 10
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

// Export the app for Vercel Serverless environment
module.exports = app;

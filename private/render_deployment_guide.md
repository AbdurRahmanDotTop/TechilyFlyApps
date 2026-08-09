# How to Deploy Indus App Store API to Render.com (100% Free)

Since Playwright is too large for Vercel's free tier (it has a 50MB limit), you can host this specific API on **Render.com** completely for free. It will run 24/7 without needing your PC to be on.

Follow these simple steps:

## Step 1: Upload the API to GitHub
1. Create a new repository on your GitHub account called `indus-store-api`.
2. Do **not** initialize it with a README.
3. Open your terminal on your PC and navigate to the `APIsByTechilyFly/indus-spp-store-api` folder:
   ```bash
   cd c:\xampp\htdocs\TechilyFly\TechilyFlyApps\TechilyFlyApps\APIsByTechilyFly\indus-spp-store-api
   ```
4. Run these commands to push the code to GitHub:
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git remote add origin https://github.com/AbdurRahmanDotTop/Indus-Appstore-API.git
   git push -u origin main
   ```
*(Replace `YOUR_USERNAME` with your actual GitHub username).*

## Step 2: Deploy to Render.com
1. Go to [Render.com](https://render.com/) and create a free account (sign up with GitHub).
2. On your Render dashboard, click **"New"** and select **"Web Service"**.
3. Choose **"Build and deploy from a Git repository"** and connect your GitHub account.
4. Select the `indus-store-api` repository you just created.
5. Fill out the deployment details:
   - **Name**: `Indus-Appstore-API` (or whatever you like)
   - **Language**: `Node`
   - **Branch**: `main`
   - **Region**: (Choose any, e.g., Virginia (US East) or Frankfurt)
   - **Root Directory**: (Leave this blank)
   - **Build Command**: `npm install && npx playwright install chromium` (⚠️ **Very Important**: Make sure to paste this exactly, do not just leave it as `npm install`)
   - **Start Command**: `node index.js`
6. Select the **Free** instance type ($0/month).
7. Click **"Create Web Service"**.

## Step 3: Update TechilyFly Source Code
Render will take a few minutes to build the project and install Chromium. Once it finishes, it will give you a live URL at the top left of your dashboard (e.g., `https://indus-store-api-1234.onrender.com`).

Once you have this URL:
1. Open your TechilyFly code editor.
2. Go to `modules/apps/api_get_reviews.php`.
3. Scroll down to line **77** and replace `http://127.0.0.1:3001/api/reviews?url=` with your new Render URL:
   ```php
   $indus_api_url = "https://indus-store-api-1234.onrender.com/api/reviews?url=" . urlencode($app['indus_store_link']);
   ```
4. Save the file.

That's it! Your production environment will now automatically and reliably scrape Indus App Store reviews 24/7 without needing your PC!

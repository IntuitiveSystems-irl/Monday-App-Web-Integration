# GitHub App Local Testing Setup

This guide will help you set up and test the Monday.com App Web Integration as a GitHub App locally.

## Prerequisites

- Node.js 18.x or higher
- A GitHub account
- Git installed
- Terminal/command line access

## Step 1: Clone and Install Dependencies

```bash
# Navigate to the project
cd /Users/lindsay/DD

# Install web dependencies
cd web
npm install

# This will install:
# - probot (GitHub App framework)
# - express (web server)
# - dotenv (environment variables)
# - smee-client (webhook proxy)
```

## Step 2: Get a Webhook Proxy URL

Since you're developing locally, you need a way to receive webhooks from GitHub.

1. **Open your browser** and navigate to: https://smee.io/
2. **Click "Start a new channel"**
3. **Copy the full URL** (it will look like `https://smee.io/abc123xyz`)
4. **Save this URL** - you'll need it in the next steps

## Step 3: Register Your GitHub App

1. **Go to GitHub Settings**
   - Click your profile picture (top right)
   - Click **Settings**
   - Scroll down to **Developer settings** (left sidebar)
   - Click **GitHub Apps**
   - Click **New GitHub App**

2. **Fill in the Basic Information**
   - **GitHub App name**: `monday-app-integration-YOUR-USERNAME` (must be unique)
   - **Homepage URL**: `https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration`
   - **Description**: `Automate Monday.com workflows with GitHub integration`

3. **Configure Webhooks**
   - ✅ Check **Active** under "Webhooks"
   - **Webhook URL**: Paste your Smee.io URL from Step 2
   - **Webhook secret**: Create a random string (e.g., `my-super-secret-webhook-key-123`)
     - Save this! You'll need it for your `.env` file

4. **Set Permissions**
   Under "Repository permissions":
   - **Pull requests**: Read & write
   - **Issues**: Read & write
   - **Metadata**: Read-only

5. **Subscribe to Events**
   Check these boxes:
   - ✅ Pull request
   - ✅ Issues
   - ✅ Marketplace purchase (for marketplace integration)

6. **Where can this GitHub App be installed?**
   - Select **"Only on this account"** (for testing)

7. **Click "Create GitHub App"**

## Step 4: Get Your App Credentials

After creating your app, you'll be on the app settings page.

### Get App ID
1. Look for **"App ID"** near the top of the page
2. Copy this number (e.g., `123456`)

### Generate Private Key
1. Scroll down to **"Private keys"**
2. Click **"Generate a private key"**
3. A `.pem` file will download to your computer
4. **Move this file** to your project directory:
   ```bash
   mv ~/Downloads/your-app-name.2026-01-08.private-key.pem /Users/lindsay/DD/web/
   ```

### Get Client ID and Secret (Optional)
1. Scroll to **"Client secrets"**
2. Click **"Generate a new client secret"**
3. Copy the client ID and secret

## Step 5: Create Your .env File

Create a `.env` file in the `/Users/lindsay/DD/web/` directory:

```bash
cd /Users/lindsay/DD/web
touch .env
```

Add the following content (replace with your actual values):

```bash
# GitHub App Configuration
APP_ID=123456
WEBHOOK_SECRET=my-super-secret-webhook-key-123
PRIVATE_KEY_PATH=./your-app-name.2026-01-08.private-key.pem
GITHUB_CLIENT_ID=Iv1.abc123xyz
GITHUB_CLIENT_SECRET=your_client_secret_here

# Webhook Proxy URL
WEBHOOK_PROXY_URL=https://smee.io/abc123xyz

# Server Configuration
PORT=3000
NODE_ENV=development

# Monday.com API (optional for now)
MONDAY_API_TOKEN=your_monday_token
MONDAY_BOARD_ID=your_board_id

# Email Service (optional for now)
RESEND_API_KEY=your_resend_key
```

## Step 6: Install Your App on a Test Repository

1. **Create a test repository** (or use an existing one)
   - Go to GitHub
   - Click the **+** icon → **New repository**
   - Name it something like `test-monday-app`
   - Make it public or private (your choice)
   - Click **Create repository**

2. **Install your app**
   - Go back to your app settings page
   - Click **"Public page"** (left sidebar)
   - Click **"Install"**
   - Select **"Only select repositories"**
   - Choose your test repository
   - Click **"Install"**

## Step 7: Start Your Local Server

Open **two terminal windows**.

### Terminal 1: Start the Smee.io Proxy

```bash
cd /Users/lindsay/DD/web
npx smee -u https://smee.io/YOUR-UNIQUE-URL -t http://localhost:3000/api/webhook
```

Replace `YOUR-UNIQUE-URL` with your actual Smee.io URL.

You should see:
```
Forwarding https://smee.io/abc123xyz to http://localhost:3000/api/webhook
Connected https://smee.io/abc123xyz
```

### Terminal 2: Start the App Server

```bash
cd /Users/lindsay/DD/web
npm run server
```

You should see:
```
Server is listening for events at: http://localhost:3000/api/webhook
```

## Step 8: Test Your App!

1. **Open a Pull Request** in your test repository
   - Go to your test repository
   - Create a new branch
   - Make a small change (edit README, add a file, etc.)
   - Open a pull request

2. **Check the Results**
   - **Terminal 1** (Smee): You should see a `pull_request` event
   - **Terminal 2** (Server): You should see "Pull request opened event received"
   - **GitHub PR**: Your app should add a comment to the pull request!

## Troubleshooting

### "Cannot find module 'probot'"
```bash
cd /Users/lindsay/DD/web
npm install
```

### "ENOENT: no such file or directory, open 'private-key.pem'"
- Make sure your `.pem` file is in the `/Users/lindsay/DD/web/` directory
- Check that `PRIVATE_KEY_PATH` in `.env` matches the filename exactly

### "Webhook secret does not match"
- Verify `WEBHOOK_SECRET` in `.env` matches what you set in GitHub App settings

### No events showing up
- Check that Smee.io proxy is running
- Verify webhook URL in GitHub App settings matches your Smee.io URL
- Make sure both terminals are running

### Port 3000 already in use
```bash
# Change PORT in .env to a different number
PORT=3001
```

## Next Steps

Once your app is working locally:

1. **Modify the code** in `web/app.js` to add your own functionality
2. **Test different events** (issues, comments, etc.)
3. **Deploy to production** when ready (see deployment guide)
4. **Submit to GitHub Marketplace** (see marketplace listing guide)

## Useful Commands

```bash
# Install dependencies
npm install

# Start server
npm run server

# Start with auto-reload (development)
npm run dev

# Check logs
# Logs appear in the terminal where you ran npm run server

# Stop server
# Press Ctrl+C in the terminal
```

## Resources

- [Probot Documentation](https://probot.github.io/docs/)
- [GitHub Apps Documentation](https://docs.github.com/en/apps)
- [Smee.io Documentation](https://smee.io/)
- [Our Support Guide](./SUPPORT.md)

## Security Notes

⚠️ **Important:**
- Never commit your `.env` file
- Never share your private key
- Never commit your `.pem` file
- Keep your webhook secret private

The `.gitignore` file already excludes these files, but always double-check!

---

**Need help?** Email info@manageonsite.com or open an issue on GitHub.

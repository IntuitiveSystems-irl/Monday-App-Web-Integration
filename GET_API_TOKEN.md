# How to Get Your Monday.com API Token

## Method 1: Personal API Token (Most Common)

1. **Click your profile picture** (bottom left corner of Monday.com)
2. **Select one of these options** (depends on your account):
   - **"Developers"** → then click **"Developer"** → **"My Access Tokens"**
   - **"Admin"** → **"API"** (if you're an admin)
   - **"My Profile"** → Look for **"API"** or **"Developers"** section

3. **Generate a new token**:
   - Click **"Generate"** or **"Create Token"**
   - Give it a name (e.g., "Scraper Token")
   - Copy the token immediately (you won't see it again!)

## Method 2: Direct URL

Try going directly to:
```
https://YOUR_COMPANY.monday.com/admin/integrations/api
```
Replace `YOUR_COMPANY` with your Monday.com subdomain.

## Method 3: Via Account Settings

1. Click your **profile picture** (bottom left)
2. Go to **"Administration"** or **"Admin"**
3. Look in the left sidebar for:
   - **"API"**
   - **"Integrations"** → **"API"**
   - **"Security"** → **"API"**

## Method 4: If You're Not an Admin

If you don't have admin access:
1. Click your **profile picture**
2. Go to **"My Profile"** or **"Account"**
3. Look for **"Developer"** or **"API"** tab
4. Generate a **Personal API Token**

## Alternative: OAuth (More Complex)

If your organization restricts API tokens, you may need to:
- Ask your Monday.com admin to generate a token for you
- Use OAuth authentication (requires more setup)

## Common Issues

- **Can't find API section**: You might not have permissions. Ask your admin.
- **No "Generate" button**: Your organization may have restricted API access.
- **Token not working**: Make sure you copied the entire token (they're long strings).

## Once You Have Your Token

1. Copy the token
2. Create `.env` file in `/Users/lindsay/DD/`
3. Add: `MONDAY_API_TOKEN=your_token_here`
4. Add: `MONDAY_BOARD_ID=your_board_id`
5. Run: `python3 scraper.py`

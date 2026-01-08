/**
 * GitHub Marketplace Webhook Handler
 * 
 * Handles marketplace purchase events for free app listings.
 * Required by GitHub Marketplace even for free apps.
 */

export default async function handler(req, res) {
  // Only accept POST requests
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Method not allowed' });
  }

  try {
    // Verify webhook signature (recommended for security)
    const signature = req.headers['x-hub-signature-256'];
    const event = req.headers['x-github-event'];
    
    // Log the event for monitoring
    console.log(`Received GitHub Marketplace event: ${event}`);
    
    const payload = req.body;
    
    // Handle different marketplace events
    switch (payload.action) {
      case 'purchased':
        await handlePurchase(payload);
        break;
        
      case 'cancelled':
        await handleCancellation(payload);
        break;
        
      case 'changed':
        await handlePlanChange(payload);
        break;
        
      case 'pending_change':
        await handlePendingChange(payload);
        break;
        
      case 'pending_change_cancelled':
        await handlePendingChangeCancelled(payload);
        break;
        
      default:
        console.log(`Unhandled marketplace action: ${payload.action}`);
    }
    
    // Always return 200 to acknowledge receipt
    return res.status(200).json({ received: true });
    
  } catch (error) {
    console.error('Marketplace webhook error:', error);
    // Still return 200 to prevent GitHub from retrying
    return res.status(200).json({ error: 'Internal error', received: true });
  }
}

/**
 * Handle new purchase/installation
 */
async function handlePurchase(payload) {
  const {
    marketplace_purchase: {
      account,
      billing_cycle,
      plan,
    }
  } = payload;
  
  console.log('New purchase:', {
    account: account.login,
    plan: plan.name,
    billing_cycle,
  });
  
  // For free apps, just log the installation
  // In a paid app, you would:
  // - Create user account
  // - Grant access to features
  // - Send welcome email
  
  // Optional: Send welcome email
  await sendWelcomeEmail(account.email, account.login);
}

/**
 * Handle cancellation/uninstallation
 */
async function handleCancellation(payload) {
  const {
    marketplace_purchase: {
      account,
    }
  } = payload;
  
  console.log('Cancellation:', {
    account: account.login,
  });
  
  // For free apps, just log the uninstallation
  // In a paid app, you would:
  // - Revoke access
  // - Archive user data
  // - Send cancellation confirmation
}

/**
 * Handle plan change (upgrade/downgrade)
 */
async function handlePlanChange(payload) {
  const {
    marketplace_purchase: {
      account,
      plan,
    },
    previous_marketplace_purchase,
  } = payload;
  
  console.log('Plan changed:', {
    account: account.login,
    from: previous_marketplace_purchase?.plan?.name,
    to: plan.name,
  });
  
  // For free apps with multiple tiers, update access
  // For paid apps, adjust billing and features
}

/**
 * Handle pending plan change
 */
async function handlePendingChange(payload) {
  const {
    marketplace_purchase: {
      account,
    }
  } = payload;
  
  console.log('Pending change:', {
    account: account.login,
  });
  
  // User scheduled a plan change for next billing cycle
  // Update records but don't change access yet
}

/**
 * Handle cancelled pending change
 */
async function handlePendingChangeCancelled(payload) {
  const {
    marketplace_purchase: {
      account,
    }
  } = payload;
  
  console.log('Pending change cancelled:', {
    account: account.login,
  });
  
  // User cancelled their scheduled plan change
  // Revert pending change records
}

/**
 * Send welcome email to new users
 */
async function sendWelcomeEmail(email, username) {
  // Only send if email is available
  if (!email) return;
  
  try {
    // If using Resend API
    const RESEND_API_KEY = process.env.RESEND_API_KEY;
    if (!RESEND_API_KEY) {
      console.log('Resend API key not configured, skipping welcome email');
      return;
    }
    
    const response = await fetch('https://api.resend.com/emails', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${RESEND_API_KEY}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        from: 'Monday.com App <noreply@manageonsite.com>',
        to: email,
        subject: 'Welcome to Monday.com App Web Integration!',
        html: `
          <h1>Welcome, ${username}!</h1>
          <p>Thank you for installing Monday.com App Web Integration.</p>
          <h2>Getting Started</h2>
          <ul>
            <li><a href="https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration#readme">Read the Documentation</a></li>
            <li><a href="https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/blob/main/docs/GET_API_TOKEN.md">Get Your API Token</a></li>
            <li><a href="https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/blob/main/docs/SUPPORT.md">Get Support</a></li>
          </ul>
          <h2>Quick Start</h2>
          <pre><code>pip install -r requirements.txt
cp .env.example .env
# Add your Monday.com API token to .env
python python/scraper.py</code></pre>
          <p>Need help? Email us at <a href="mailto:info@manageonsite.com">info@manageonsite.com</a></p>
          <p>Happy automating!</p>
        `,
      }),
    });
    
    if (response.ok) {
      console.log('Welcome email sent to:', email);
    } else {
      console.error('Failed to send welcome email:', await response.text());
    }
  } catch (error) {
    console.error('Error sending welcome email:', error);
  }
}

/**
 * Verify webhook signature (recommended for production)
 */
function verifySignature(payload, signature, secret) {
  const crypto = require('crypto');
  const hmac = crypto.createHmac('sha256', secret);
  const digest = 'sha256=' + hmac.update(JSON.stringify(payload)).digest('hex');
  return crypto.timingSafeEqual(Buffer.from(signature), Buffer.from(digest));
}

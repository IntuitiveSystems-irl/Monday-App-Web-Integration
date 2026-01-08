/**
 * GitHub App Logic for Monday.com App Web Integration
 * 
 * This app responds to pull request events and adds helpful comments
 * about Monday.com integration capabilities.
 */

module.exports = (app) => {
  // Log when the app is loaded
  app.log.info("Monday.com App Web Integration loaded!");

  // Listen for pull request opened events
  app.on("pull_request.opened", async (context) => {
    app.log.info("Pull request opened event received");
    
    try {
      // Get pull request information
      const pullRequest = context.payload.pull_request;
      const repo = context.payload.repository;
      
      app.log.info(`Processing PR #${pullRequest.number} in ${repo.full_name}`);
      
      // Create a comment on the pull request
      const comment = context.issue({
        body: `## 🎉 Monday.com App Web Integration

Thank you for opening this pull request!

This repository is integrated with **Monday.com App Web Integration**, which helps automate workflows between GitHub and Monday.com.

### 🚀 What this app can do:
- ✅ Sync pull requests with Monday.com boards
- ✅ Export GitHub data to Excel templates
- ✅ Automate project tracking and reporting
- ✅ Schedule operations and manage workflows

### 📚 Resources:
- [Documentation](https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration#readme)
- [Get API Token](https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/blob/main/docs/GET_API_TOKEN.md)
- [Support](https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/blob/main/docs/SUPPORT.md)

---
*Powered by Monday.com App Web Integration* 📅`,
      });

      await context.octokit.issues.createComment(comment);
      app.log.info(`Comment added to PR #${pullRequest.number}`);
      
    } catch (error) {
      app.log.error("Error handling pull request:", error);
    }
  });

  // Listen for marketplace purchase events
  app.on("marketplace_purchase.purchased", async (context) => {
    app.log.info("New marketplace purchase!");
    
    const purchase = context.payload.marketplace_purchase;
    app.log.info(`Account: ${purchase.account.login}`);
    app.log.info(`Plan: ${purchase.plan.name}`);
    
    // For free apps, just log the installation
    // In production, you might want to:
    // - Send welcome email
    // - Create user record
    // - Grant access to features
  });

  // Listen for marketplace cancellation events
  app.on("marketplace_purchase.cancelled", async (context) => {
    app.log.info("Marketplace purchase cancelled");
    
    const purchase = context.payload.marketplace_purchase;
    app.log.info(`Account: ${purchase.account.login}`);
    
    // Handle uninstallation
    // - Revoke access
    // - Archive data
    // - Send confirmation
  });

  // Listen for issues being opened (optional)
  app.on("issues.opened", async (context) => {
    app.log.info("Issue opened event received");
    
    const issue = context.payload.issue;
    
    // Add a label to help categorize
    const issueComment = context.issue({
      body: `Thanks for opening this issue! We'll take a look soon. 

For faster support, check out our [documentation](https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/blob/main/docs/SUPPORT.md).`,
    });

    await context.octokit.issues.createComment(issueComment);
  });

  // Health check endpoint
  app.on("ping", async (context) => {
    app.log.info("Ping event received - app is healthy!");
  });
};

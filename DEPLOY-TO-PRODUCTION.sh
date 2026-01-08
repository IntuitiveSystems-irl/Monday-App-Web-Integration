#!/bin/bash
# Deployment script for Smart Systems 3D Landing Page
# Run this from your LOCAL machine

echo "🚀 Deploying Smart Systems Landing Page to Production..."

# 1. Upload the HTML file to the server
echo "📤 Uploading index-3d-v2.html..."
scp -P 2222 /Users/lindsay/CascadeProjects/OFFICEOPS/index-3d-v2.html root@148.230.83.122:/var/www/manageonsite-production/public/

# 2. SSH into server and make changes
echo "🔧 Configuring Next.js to serve the 3D landing page..."
ssh -p 2222 root@148.230.83.122 << 'ENDSSH'

# Navigate to app directory
cd /var/www/manageonsite-production

# Create public directory if it doesn't exist
mkdir -p public

# Backup the current homepage
cp app/page.tsx app/page.tsx.backup.$(date +%Y%m%d_%H%M%S)

# Create new homepage that serves the HTML
cat > app/page.tsx << 'EOF'
'use client';

import { useEffect } from 'react';

export default function Home() {
  useEffect(() => {
    // Redirect to the static HTML page
    window.location.href = '/index-3d-v2.html';
  }, []);

  return (
    <div className="min-h-screen bg-white flex items-center justify-center">
      <div className="text-center">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
        <p className="text-lg font-medium text-gray-600">Loading Smart Systems...</p>
      </div>
    </div>
  );
}
EOF

# Restart PM2
echo "🔄 Restarting application..."
pm2 restart manageonsite-prod

echo "✅ Deployment complete!"
echo "🌐 Visit https://manageonsite.com to see your new landing page"

ENDSSH

echo "✨ Done! Your Smart Systems 3D landing page is now live!"

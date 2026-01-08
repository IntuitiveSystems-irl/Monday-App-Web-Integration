# BackOffice Systems

**Operational Cleanup & Automation Platform**

A modern landing page and contact system for BackOffice Systems, featuring immersive 3D visualizations and smart systems implementation services. Built for operational efficiency consultants helping businesses streamline their workflows and automate processes.

## 🎯 Overview

BackOffice Systems provides operational cleanup and automation services for businesses looking to optimize their workflows, implement smart systems, and improve team efficiency. This project includes:

- **3D Interactive Landing Page**: Immersive WebGL-based landing experience
- **Mobile-Optimized Views**: Responsive design for all devices
- **Contact Form Integration**: Automated email notifications via Resend API
- **WordPress Integration**: PHP templates for WordPress deployment
- **Production Deployment**: Automated deployment scripts for live servers

## ✨ Features

- **Immersive 3D Experience**: Interactive WebGL landing page with smooth animations
- **Multiple Page Variants**:
  - `index.html` - Standard landing page
  - `index-3d.html` - 3D interactive version
  - `index-3d-v2.html` - Enhanced 3D experience
  - `mobile.html` - Mobile-optimized view
  - `mobile-pitch.html` - Mobile pitch presentation
- **Smart Contact Forms**: Capture company info, team size, location, and engagement preferences
- **Email Automation**: Resend API integration for instant notifications
- **WordPress Templates**: Ready-to-use PHP templates for WordPress sites
- **Production Ready**: Deployment scripts for seamless updates

## 🛠 Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **3D Graphics**: WebGL / Three.js
- **Backend**: PHP, Node.js (Serverless Functions)
- **Email Service**: Resend API
- **Deployment**: Vercel, Custom Server (PM2)
- **CMS Integration**: WordPress compatible

## 📋 Prerequisites

- Node.js 18.x or higher
- PHP 7.4+ (for WordPress integration)
- Resend API account and API key
- Production server with PM2 (optional)

## 🚀 Quick Start

### Local Development

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd OFFICEOPS
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Set up environment variables**
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` and add your Resend API key:
   ```
   RESEND_API_KEY=your_resend_api_key_here
   ```

4. **Run development server**
   ```bash
   npm run dev
   ```

5. **Open in browser**
   - Main page: `http://localhost:3000`
   - 3D version: `http://localhost:3000/index-3d-v2.html`
   - Mobile view: `http://localhost:3000/mobile.html`

### WordPress Integration

1. **Upload PHP templates** to your WordPress theme directory:
   ```
   wp-content/themes/your-theme/
   ├── page-smart-systems.php
   └── functions-smart-systems.php
   ```

2. **Add functions** to your theme's `functions.php`:
   ```php
   require_once get_template_directory() . '/functions-smart-systems.php';
   ```

3. **Create a new page** in WordPress and select "Smart Systems Landing Page" template

## 📧 Contact Form Setup

The contact form captures:
- **Company Name**
- **Email Address**
- **Team Size**
- **Location**
- **Engagement Type** (On-site, Remote, Flexible)
- **Current Tools & Systems**
- **Improvement Goals**

### Email Configuration

Emails are sent via Resend API to: `info@manageonsite.com`

Configure in `api/contact.js`:
```javascript
from: 'BackOffice Systems <noreply@manageonsite.com>',
to: ['info@manageonsite.com'],
```

## 🌐 Production Deployment

### Automated Deployment

Use the included deployment script:

```bash
./DEPLOY-TO-PRODUCTION.sh
```

This script:
1. Uploads the 3D landing page to production server
2. Configures Next.js routing
3. Restarts the PM2 process
4. Makes the site live at `https://manageonsite.com`

### Manual Deployment

**Via Vercel:**
```bash
npm run deploy
```

**Via SCP (Custom Server):**
```bash
scp -P 2222 index-3d-v2.html root@148.230.83.122:/var/www/manageonsite-production/public/
```

## 📁 Project Structure

```
OFFICEOPS/
├── api/
│   └── contact.js              # Serverless contact form handler
├── index.html                  # Main landing page
├── index-3d.html              # 3D interactive version
├── index-3d-v2.html           # Enhanced 3D experience
├── mobile.html                # Mobile-optimized view
├── mobile-pitch.html          # Mobile pitch presentation
├── page-smart-systems.php     # WordPress template
├── page-smart-systems-standalone.php  # Standalone PHP version
├── functions-smart-systems.php # WordPress functions
├── send-email.php             # PHP email handler
├── test-resend.php            # Email testing script
├── DEPLOY-TO-PRODUCTION.sh    # Deployment automation
├── package.json               # Node.js dependencies
├── .env.example               # Environment variables template
└── README.md                  # This file
```

## 🎨 Customization

### Branding

Update colors and branding in the HTML/CSS:
- **Primary Color**: `#1B365D` (Navy Blue)
- **Accent Color**: `#C1403D` (Red)
- **Background**: `#fff` (White)

### Contact Form Fields

Modify form fields in `api/contact.js` and corresponding HTML files.

### 3D Scene

Customize the 3D experience by editing the WebGL/Three.js code in `index-3d-v2.html`.

## 🔒 Security

- Environment variables are gitignored (`.env`)
- API keys never committed to repository
- Form validation on both client and server
- CORS protection enabled
- Input sanitization for email content

## 📊 Analytics & Monitoring

The production deployment includes:
- PM2 process monitoring
- Server health checks
- Email delivery tracking via Resend dashboard

## 🧪 Testing

**Test email functionality:**
```bash
php test-resend.php
```

**Test contact form locally:**
1. Start dev server: `npm run dev`
2. Fill out contact form
3. Check console for API responses

## 🚨 Troubleshooting

### Email not sending
- Verify `RESEND_API_KEY` in `.env`
- Check Resend dashboard for delivery status
- Ensure sender domain is verified

### 3D page not loading
- Check browser WebGL support
- Clear browser cache
- Verify all assets are uploaded

### WordPress template not appearing
- Ensure PHP files are in correct theme directory
- Check file permissions (644 for files, 755 for directories)
- Verify WordPress version compatibility

## 📝 Environment Variables

Required environment variables:

```bash
RESEND_API_KEY=re_xxxxxxxxxxxxx  # Your Resend API key
```

## 🤝 Contributing

1. Create a feature branch
2. Make your changes
3. Test thoroughly (especially contact forms)
4. Submit for review

## 📄 License

Proprietary - BackOffice Systems

## 🔗 Links

- **Production Site**: https://manageonsite.com
- **Email Service**: [Resend](https://resend.com)
- **Deployment Platform**: [Vercel](https://vercel.com)

## 📞 Support

For technical support or questions:
- **Email**: info@manageonsite.com
- **Website**: https://manageonsite.com

---

**Built for operational excellence** 🚀

# Contributing to OFFICEOPS

Thank you for your interest in contributing to OFFICEOPS! This document provides guidelines for contributing to our scheduling system.

## 🤝 How to Contribute

We welcome contributions! Here's how you can help:

- **Report Bugs**: Submit detailed bug reports
- **Suggest Features**: Propose new scheduling features
- **Submit Pull Requests**: Fix bugs or add features
- **Improve Documentation**: Help us improve our docs
- **Share Integration Ideas**: Suggest Monday.com or Excel improvements

## 📋 Getting Started

1. **Fork the Repository**
   ```bash
   # Click the "Fork" button on GitHub
   ```

2. **Clone Your Fork**
   ```bash
   git clone git@github.com:YOUR_USERNAME/OFFICEOPS.git
   cd OFFICEOPS
   ```

3. **Create a Branch**
   ```bash
   git checkout -b feature/your-feature-name
   # or
   git checkout -b fix/your-bug-fix
   ```

4. **Set Up Development Environment**
   ```bash
   npm install
   cp .env.example .env
   # Add your Monday.com and Resend API keys
   npm run dev
   ```

## 🔧 Development Guidelines

### Code Style

- **HTML/CSS**: Follow existing formatting and structure
- **JavaScript**: Use modern ES6+ syntax
- **File Naming**: Use kebab-case for files
- **Comments**: Document complex logic and integrations

### Monday.com Integration

When working with Monday.com features:

- Test with a development board first
- Document API endpoints used
- Handle rate limits gracefully
- Validate data before syncing

### Excel Integration

When working with Excel features:

- Support common Excel formats (.xlsx, .csv)
- Validate data structure before import
- Provide clear error messages
- Test with various Excel versions

### Commit Messages

Follow conventional commit format:

```
type(scope): subject
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation
- `style`: Formatting
- `refactor`: Code refactoring
- `test`: Tests

**Examples:**
```bash
git commit -m "feat(monday): add board synchronization"
git commit -m "fix(excel): resolve import date format issue"
git commit -m "docs(readme): update API configuration"
```

## 📝 Pull Request Process

1. **Update Documentation**
   - Update README.md if needed
   - Document new features
   - Update environment variable examples

2. **Test Your Changes**
   - Test Monday.com integration
   - Test Excel import/export
   - Verify email notifications
   - Check mobile responsiveness

3. **Create Pull Request**
   - Clear, descriptive title
   - Reference related issues
   - Describe changes and reasoning
   - Include screenshots for UI changes

4. **Code Review**
   - Address feedback professionally
   - Make requested changes
   - Keep discussion constructive

## 🐛 Bug Reports

Include in bug reports:

- **Description**: Clear bug description
- **Steps to Reproduce**: Detailed reproduction steps
- **Expected vs Actual**: What should vs does happen
- **Environment**: Browser, OS, Monday.com board setup
- **Screenshots**: If applicable
- **Error Messages**: Console logs or error messages

**Template:**
```markdown
**Bug Description**
Clear description of the issue.

**Steps to Reproduce**
1. Configure Monday.com board with...
2. Import Excel file with...
3. See error

**Expected Behavior**
Data should sync correctly.

**Actual Behavior**
Error occurs during sync.

**Environment**
- Browser: Chrome 120
- OS: macOS 14
- Monday.com Board: [Board type]
- Excel Version: Microsoft 365

**Screenshots**
[Attach screenshots]

**Error Logs**
[Paste error messages]
```

## 💡 Feature Requests

When suggesting features:

- **Use Case**: Why is this needed?
- **Description**: Detailed feature description
- **Monday.com Integration**: How it integrates with Monday.com
- **Excel Impact**: How it affects Excel import/export
- **Mockups**: Visual examples if applicable

## 🏗 Project Structure

```
OFFICEOPS/
├── api/
│   └── contact.js         # Contact form API
├── index.html             # Main dashboard
├── index-3d.html          # 3D visualization
├── index-3d-v2.html       # Enhanced 3D view
├── mobile.html            # Mobile interface
├── page-smart-systems.php # WordPress template
├── send-email.php         # Email handler
├── package.json
└── README.md
```

## 🔑 Environment Variables

Required for development:

```bash
# Monday.com
MONDAY_API_KEY=your_monday_api_key
MONDAY_BOARD_ID=your_board_id

# Email
RESEND_API_KEY=your_resend_api_key
```

## 🧪 Testing

Before submitting:

- Test Monday.com synchronization
- Test Excel import with sample files
- Test Excel export functionality
- Verify email notifications
- Check mobile responsiveness
- Test in multiple browsers

## 📚 Resources

- **Monday.com API Docs**: https://developer.monday.com
- **Resend API Docs**: https://resend.com/docs
- **Project README**: See README.md
- **Issue Tracker**: GitHub Issues

## ⚖️ Code of Conduct

- Be respectful and professional
- Welcome all contributors
- Provide constructive feedback
- Maintain a positive environment

## 📄 License

By contributing, you agree that your contributions will be licensed under the MIT License.

## 🙏 Thank You!

Your contributions help make OFFICEOPS better for everyone!

---

**Questions?** Open an issue or contact the maintainers at info@manageonsite.com

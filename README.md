# GreenPressWP

A sustainable WordPress theme is designed to minimize its environmental impact by being lightweight, efficient, and optimized to reduce energy consumption.

Here are some of the coolest features of the GreenPressWP Theme:

- Truly sustainable and super lightweight.
- Performance features like assets minification, critical css and assets lazy loading.
- Well commented OOP based code with WordPress and WordPress VIP coding standards.
- Organized Files and Folder structure.
- Minimal responsive styling with SASS framework.
- All the necessary default template files like single.php, archive.php, page.php, search.php etc.
- Basic theme components like Header, Footer, Menu, Sidebar/Widget, Comments etc.
- Pagination and restricted media file types for security.

## Installation

1. Download the theme ZIP file from GitHub.
2. In your WordPress dashboard, go to **Appearance → Themes → Add New → Upload Theme**.
3. Choose `greenpresswp.zip` and click **Install Now**.
4. Once installed, click **Activate**.

## Theme Preview

To set up your homepage to match the theme layout, follow these steps:

1. Create a new page titled **Home** and add some content to it.
2. Navigate to **Settings → Reading**, choose **"A static page"** under "Your homepage displays", and set the **Home** page as your **Homepage**.
3. Visit your site’s frontend — you should now see your custom homepage content displayed.
4. Go to **Appearance → Menus**, create menu for the **Header** and assign it to the  **Primary Menu**.
5. Your homepage should now reflect the theme’s intended layout and design.

## Theme Features

### Color Options
- Navigate to **Appearance → Customize → Colors**.
- Customize various theme color settings directly from the Customizer.

### Font Settings
- Go to **Appearance → Customize → Theme Options → Font Settings**.
- Choose between **System Fonts**, **Custom Fonts**, or **Google Fonts**.

### General Settings
- Head to **Appearance → Customize → Theme Options → General Settings**.
- Set a default **OG Image** for social sharing.
- Add multiple **social media icons** to be displayed in the footer.

### Third-Party Integration
- Also found under **Appearance → Customize → Theme Options → Third Party Integration**.
- Add custom **header and footer scripts** for analytics, tracking, or other third-party tools.

### Footer
- Go to **Appearance → Customize → Theme Options → Footer Settings**.
- You can add here any text or HTML.

## Build Process

#### If you plan to modify the theme’s CSS or JavaScript, you’ll need to build the assets. Follow the steps below to get started:

Check for Proper node version

```bash
cd assets
nvm use
```

Install Dependency

```bash
npm install
```

**During development**

```bash
npm run start
```

**Production**

```bash
npm run build
```

## Get In Touch

<p align="center">
<a href="https://www.multidots.com/contact-us/"><img src="https://www.multidots.com/wp-content/uploads/2025/06/01-GitHub-Footer.png" width="850"></a>
</p>
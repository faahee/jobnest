# College Logo Setup Instructions

## How to Add Your College Logo

Your JobNest portal is now ready to display your college logo at the top center of the page!

### Step 1: Save Your Logo File

1. Save your college logo image in the project folder
2. Name it exactly: **`logo.png`**
3. Place it in the same directory as `index.html`:
   ```
   jobnest/
   ├── index.html
   ├── style.css
   ├── logo.png  ← Place your logo here
   └── README.md
   ```

### Step 2: Supported Image Formats

The project supports these image formats:
- ✅ PNG (recommended) - `.png`
- ✅ JPG/JPEG - `.jpg` or `.jpeg`
- ✅ SVG - `.svg`
- ✅ WebP - `.webp`

If your logo is in a different format:
1. **PNG Format**: Save as `logo.png`
2. **Other Format**: Rename to `logo.png` or update the `src` in `index.html` line 19

### Step 3: (Optional) Customize Logo Size

If you want to adjust the logo size, edit `style.css` and find the `.college-logo` class (around line 33):

```css
.college-logo {
    width: 80px;      /* Change this value */
    height: 80px;     /* Change this value */
    /* ... rest of styles ... */
}
```

Common sizes:
- **Small**: `60px × 60px`
- **Medium**: `80px × 80px` (current)
- **Large**: `100px × 100px`

### Step 4: Customize College Info (Optional)

To change the college name or motto displayed next to the logo, edit `index.html` (around line 19):

```html
<div class="college-info">
    <h2 class="college-name">LUCEAT LUX VESTRA</h2>  <!-- Change this -->
    <p class="college-motto">Let Light Shine Forth</p>  <!-- Change this -->
</div>
```

### Step 5: Test the Setup

1. Refresh your browser (Ctrl+Shift+R for hard refresh)
2. You should see your college logo centered at the top of the page
3. The logo will float up and down gently (CSS animation)
4. Motto text will display below/next to the logo

## Logo Styling Features

Your logo now includes:
- ✨ **Floating Animation** - Gently floats up and down
- 🌟 **Drop Shadow** - Blue glow effect around the logo
- 📱 **Responsive Design** - Automatically adjusts on mobile devices
- 🎨 **Color Theme** - Matches the portal's modern design

## Responsive Behavior

### Desktop (1200px+)
- Logo: 80×80 pixels
- Displayed horizontally with college info text

### Tablet (768px - 1199px)
- Logo: 70×70 pixels
- Still displayed horizontally

### Mobile (<768px)
- Logo: 60×60 pixels  
- Displayed vertically (stacked layout)
- Better mobile experience

## Troubleshooting

### Logo Not Showing?
1. ✅ Check that logo file is named exactly: `logo.png`
2. ✅ Check that logo file is in the same folder as `index.html`
3. ✅ Hard refresh browser: `Ctrl+Shift+R` (Windows/Linux) or `Cmd+Shift+R` (Mac)
4. ✅ Check browser console (F12) for error messages
5. ✅ If logo is a different format, rename it to `.png` or update the `src` in HTML

### Logo Looks Distorted?
- The logo expects a square image (same width and height)
- If your logo is rectangular, edit the CSS width/height values to match your logo's aspect ratio

### Want a Different Image Format?
Update the image source in `index.html` (line 19):
```html
<!-- Change from: -->
<img src="logo.png" alt="College Logo" class="college-logo">

<!-- To: -->
<img src="logo.jpg" alt="College Logo" class="college-logo">
<!-- or -->
<img src="logo.svg" alt="College Logo" class="college-logo">
```

## CSS Animation Classes

Professional animations are automatically applied:

### `.college-logo`
- Drop shadow glow effect
- Floating animation (3 seconds, repeating)
- Smooth scaling on hover

### `.college-name`
- Cyan color (#46c8ff)
- Large bold text
- Letter spacing for elegance

### `.college-motto`
- White semi-transparent text
- Italic styling
- Small font size for subtlety

## More Help?

If you need further customization:
1. Check the `style.css` file for the `.college-logo-banner` section
2. Check the `index.html` file header section
3. Refer to the main README.md for project structure

---

**Your college logo is now integrated into JobNest! 🎓**

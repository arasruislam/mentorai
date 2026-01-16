# MentorAI – Elementor Widgets Plugin

A scalable, future‑proof Elementor widget library for WordPress.

---

## 1. Overview

**MentorAI** is a custom WordPress plugin designed to host multiple Elementor widgets under a single, clean architecture. You start with one widget and continuously add more without touching core plugin logic.

**Design goals:**

* Scalable folder structure
* Clean separation of concerns
* Easy future widget additions
* Performance‑friendly asset loading

---

## 2. Plugin Architecture (Big Picture)

MentorAI works as follows:

1. WordPress loads `mentorai.php`
2. Core bootstrap verifies Elementor availability
3. Plugin initializes managers (widgets, assets, categories)
4. Widgets Manager registers all widgets with Elementor
5. Each widget handles its own controls & rendering

---

## 3. Folder Structure

```
mentorai/
├─ mentorai.php
├─ assets/
│  ├─ css/
│  │  ├─ frontend/
│  │  └─ editor/
│  └─ js/
│     ├─ frontend/
│     └─ editor/
├─ includes/
│  ├─ bootstrap.php
│  ├─ plugin.php
│  ├─ helpers/
│  │  └─ utils.php
│  ├─ managers/
│  │  ├─ widgets-manager.php
│  │  ├─ assets-manager.php
│  │  └─ categories-manager.php
│  └─ widgets/
│     ├─ hello/
│     │  ├─ widget.php
│     │  ├─ controls.php
│     │  └─ view.php
│     └─ _shared/
│        └─ base-widget.php
└─ languages/
   └─ mentorai.pot
```

---

## 4. File Responsibilities

### Root

* **mentorai.php**
  Plugin entry point. Defines constants and loads bootstrap.

### includes/

* **bootstrap.php**
  Checks Elementor availability and initializes the plugin.

* **plugin.php**
  Main plugin class. Boots managers.

### helpers/

* **utils.php**
  Reusable helper functions (sanitization, debugging, formatting).

### managers/

* **widgets-manager.php**
  Registers all widgets with Elementor. This is the only file you touch when adding a new widget.

* **assets-manager.php**
  Centralized CSS/JS enqueue logic.

* **categories-manager.php**
  Adds custom Elementor category (e.g., “MentorAI Widgets”).

### widgets/

* **_shared/base-widget.php**
  Base widget class for shared behavior (category, icon, helpers).

* **hello/**
  Example widget folder.

  * widget.php → Widget class
  * controls.php → Controls definition (optional)
  * view.php → HTML markup (optional)

### assets/

* `frontend/` → Public‑facing widget assets
* `editor/` → Elementor editor‑only assets

---

## 5. How Widgets Are Loaded

1. Widgets Manager hooks into Elementor:

   * `elementor/widgets/register`
2. Widget PHP files are required
3. Widget classes are registered with Elementor

This ensures a single, predictable registry point.

---

## 6. Creating Your First Widget

Minimum requirements:

* Widget folder: `includes/widgets/hello/`
* Widget class extending Elementor widget base
* `get_name()`, `get_title()`, `get_icon()`, `get_categories()`
* At least one control
* `render()` method

Once registered, the widget appears in Elementor panel.

---

## 7. Adding a New Widget (Future Workflow)

Example: **Pricing Table Widget**

### Step 1: Create Folder

```
includes/widgets/pricing-table/
```

### Step 2: Create Files

* widget.php (required)
* controls.php (optional)
* view.php (optional)

### Step 3: Define Widget

* `get_name()` → `pricing-table`
* `get_title()` → Pricing Table
* `get_icon()` → Elementor icon slug
* `get_categories()` → MentorAI category

### Step 4: Add Controls

* Text, Repeater, Color, Typography, etc.

### Step 5: Render Output

* Clean HTML
* Escape all output (`esc_html`, `esc_attr`, `wp_kses_post`)

### Step 6: Register Widget

Update **widgets-manager.php**:

* require widget file
* register widget class

### Step 7 (Optional): Add Assets

* CSS: `assets/css/frontend/widget-pricing-table.css`
* JS: `assets/js/frontend/widget-pricing-table.js`
* Enqueue via Assets Manager

---

## 8. Best Practices

* One widget per folder
* Centralized widget registration
* Conditional asset loading
* Use base widget for shared logic
* Consistent naming (slug, class, handles)
* Sanitize input, escape output

---

## 9. Scaling Strategy

MentorAI is designed to grow into a full widget library:

* Add unlimited widgets without refactoring
* Maintain performance with scoped assets
* Keep widgets independent and maintainable

---

## 10. Recommended Next Steps

1. Implement plugin bootstrap & managers
2. Finalize Hello widget
3. Add MentorAI Elementor category
4. Create base widget class
5. Start building real widgets (Hero, Pricing, CTA, Testimonial)

---

**MentorAI** is now ready to scale from a single widget to a professional Elementor widget ecosystem.

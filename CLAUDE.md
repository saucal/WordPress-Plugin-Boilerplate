# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

WordPress Plugin Boilerplate by Saucal. A modern, PSR-4 based WordPress plugin scaffold with strict code quality tooling. The actual plugin code lives inside the `plugin-name/` subdirectory.

This repository is a **template**, not a standalone plugin. The [saucal/scaffold](https://github.com/saucal/scaffold) tool (`sc-scaffold`) generates a real plugin from this boilerplate by replacing placeholders throughout the codebase.

## Scaffold Placeholders

When editing this boilerplate, use the following placeholders consistently — they are replaced by `sc-scaffold plugin --name="My Plugin"`:

| Placeholder | Becomes (example for "My Awesome Plugin") |
|---|---|
| `plugin-name` | `my-awesome-plugin` (slug, used in directory/file names) |
| `plugin_name` | `my_awesome_plugin` (instance/function prefix) |
| `Plugin_Name` | `MyAwesomePlugin` (PHP namespace) |
| `PNAME` | `MAP` (uppercase acronym, for constants) |
| `pname` | `map` (lowercase acronym) |
| `PName` / `PNameSingleton` | `MAP` (short class name) |
| `WordPress Plugin Boilerplate` | `My Awesome Plugin` (human-readable name) |
| `http://example.com/plugin-name-uri/` | Plugin URI |
| `author-slug` | `saucal` |
| `Your Name or Your Company` | `SAU/CAL` |

File and directory names containing `plugin-name` or `pname` are also renamed to the slug/short name.

## Build Commands

All npm commands run from `plugin-name/`:

```bash
cd "plugin-name" && npm run build      # Full build: SCSS, JS, i18n, composer
cd "plugin-name" && npm run watch      # Watch SCSS + JS for changes
cd "plugin-name" && npm run sass       # Compile SCSS only
cd "plugin-name" && npm run js         # Build JS only
cd "plugin-name" && npm run translate  # Generate .pot file
cd "plugin-name" && npm run php        # composer install --no-dev --optimize-autoloader
```

## Linting & Static Analysis

```bash
# PHPCS (from plugin-name/ or root)
cd "plugin-name" && composer phpcs     # Run PHP_CodeSniffer
cd "plugin-name" && composer phpcbf    # Auto-fix PHPCS issues

# PHPStan (from root, uses phpstan.neon)
vendor/bin/phpstan analyse

# JS/CSS linting configured via package.json (eslint: @wordpress/eslint-plugin, stylelint: @wordpress/stylelint-config/scss)
```

## Architecture

### Namespace & Autoloading

- Root namespace: `Plugin_Name\` mapped to `plugin-name/includes/` via PSR-4 (Composer)
- All main classes are `final` with static methods (no instantiation)

### Plugin Lifecycle

1. `plugin-name.php` — Entry point, loads Composer autoloader, calls `Main::bootstrap()`
2. `Main::bootstrap()` — Registers activation hook → `Install::install()`, hooks `plugins_loaded` → `Main::load()`, hooks `init` → `Main::init()`
3. `Main::load()` — Loads textdomain, fires `plugin_name_loaded`
4. `Main::init()` — Initializes Admin/Front modules based on context, fires `plugin_name_init`

### Module Structure

- `Plugin_Name\Admin\` — Admin-only hooks and assets (loaded on `is_admin()`)
- `Plugin_Name\Front\` — Frontend-only hooks and assets
- `Plugin_Name\Assets` — Abstract base class; `Admin\Assets` and `Front\Assets` extend it
- `Plugin_Name\Template` — Theme-overridable template loading (checks theme directory first, falls back to `plugin-name/templates/`)
- `Plugin_Name\Block` — Gutenberg block registration via `block.json`
- `Plugin_Name\Customizations\` — Optional integration modules (e.g., ACF)

### Asset Pipeline

Source files in `plugin-name/assets/source/{sass,js}/{admin,frontend}/` compile to `plugin-name/assets/{css,js}/{admin,frontend}/`. Both minified and unminified versions are generated; the plugin loads minified unless `SCRIPT_DEBUG` is true.

## Code Standards

- **PHPCS:** WooCommerce-Core standard, WordPress 5.6+, PHP 7.3+
- **PHPStan:** Level 8 (strictest)
- **Text domain:** `plugin-name` — all translatable strings must use this domain
- **Minimum versions:** PHP 7.3, WordPress 5.6, WooCommerce 5.3 (optional dependency)

## Conventions

- Hook/filter names are prefixed with `plugin_name_` (e.g., `plugin_name_loaded`, `plugin_name_enqueue_styles`)
- PSR-4 class filenames (e.g., `Main.php`, not `class-main.php`); PHPCS `InvalidClassFileName` sniff is excluded
- No tests directory exists; quality assurance relies on PHPCS + PHPStan

# Auriel Vite WordPress Theme

![](logo.png)

Auriel is a production-ready WordPress theme scaffold that blends modern front-end tooling with an author-friendly admin experience. The starter delivers a Tailwind-compatible asset pipeline, partial-based page composition, and a streamlined workflow for switching between development and production assets.

## 1. System Requirements
- Node.js 18 or newer (LTS recommended)
- WordPress 6.0 or newer
- PHP 8.0 or newer
- Modern browser with ES module support for authoring and QA

## 2. Solution Architecture
- `assets/src/js` — main entry (`main.js`) and modular partial scripts
- `assets/src/scss` — global styles (`main.scss`) plus optional scoped bundles
- `assets/dist` — compiled assets consumed when the theme runs in build mode
- `partials/` — render-ready PHP partials invoked by page templates
- `inc/` — supporting services (Vite bridge, options panel, partial field registry)
- `env.php` — single source of truth for the current Vite mode (`dev` or `build`)

## 3. Initial Setup
1. Copy the repository into `wp-content/themes/auriel-theme`.
2. Install front-end dependencies from the theme root:
   ```bash
   npm install
   ```
3. Activate **Auriel Vite WordPress Theme** in the WordPress admin panel.

## 4. Development Lifecycle
1. Set `env.php` to development mode:
   ```php
   return array(
     'vite_mode' => 'dev',
   );
   ```
2. Run the Vite dev server:
   ```bash
   npm run dev
   ```
3. Browse the site on your local WordPress host. JavaScript and CSS load from `http://localhost:5173`, providing hot module replacement and automatic template reloads.
4. Stop the dev server (`Ctrl+C`) when development is complete.

## 5. Production Build Lifecycle
1. Generate production assets:
   ```bash
   npm run build
   ```
   This refreshes `assets/dist` with fingerprint-free bundles (`js/main.js`, `css/main.css`, and chunked dependencies).
2. Update `env.php` to build mode:
   ```php
   return array(
     'vite_mode' => 'build',
   );
   ```
3. Deploy the WordPress theme along with `assets/dist`. No additional build steps are required on the target environment.

> `index.php` exposes a constant override (`AURIEL_VITE_MODE`). Define it in `wp-config.php` if you need to force `dev` or `build` globally (for example, on staging).

## 6. NPM Command Reference
- `npm run dev` — launch the Vite development server with HMR.
- `npm run build` — compile and minify production assets.
- `npm run preview` — optional local preview of the compiled build.

## 7. Asset and Code Conventions
- SCSS partials prefixed with `_` are ignored as standalone entries. Create additional public bundles by adding new non-prefixed files in `assets/src/scss`.
- JavaScript partials should be lazy-loaded via dynamic `import()` calls to keep the primary bundle lean.
- Use the Tailwind-compatible CSS variables (exposed through the design token settings page) to maintain consistent theming.

## 8. Theme Options and Extensibility
- `inc/theme-options.php` registers the Auriel Theme settings screen. Colours defined there are converted into CSS variables and surfaced to Tailwind utilities.
- `inc/partial-fields.php` provides a lightweight field framework for partial-specific content. Fields are saved as post meta without plugin dependencies.
- Extend `auriel_enqueue_vite_assets()` to incorporate additional bundles or third-party scripts.

## 9. Admin-to-Frontend Content Flow
1. **Create pages and assign templates.** Within WordPress, create pages such as “Home” or “About” and choose the relevant template (e.g. `Home Page`). The template determines which partials render on the front end.
2. **Populate template-specific fields.** After a template is selected, the editor reveals the associated meta boxes (hero sliders, feature grids, contact blocks, etc.). Each field maps directly to markup in the matching partial.
3. **Adjust global design tokens.** Navigate to **Appearance → Auriel Theme** to refine the colour palette. Saved values feed into CSS variables and cascade through the Tailwind layer.
4. **Preview during development.** With `vite_mode` set to `dev` and `npm run dev` active, reload the page. Vite serves the latest compiled assets while WordPress surfaces current content.
5. **Switch to production delivery.** Run `npm run build`, toggle `vite_mode` to `build`, and deploy. Production pages load the compiled bundles while continuing to consume CMS-managed content.

> Need to extend a page? Create a PHP partial in `partials/`, register its fields in `inc/partials/`, and include it from the desired template. WordPress persists the content; Vite delivers the presentation assets.

## 10. Adding an Integrated Partial
Follow this process to introduce a reusable partial with editor-managed content.

1. **Define the field group** in `inc/partials/your-partial-name.php`:
   ```php
   auriel_define_partial_fields(
     'partials/your-partial-name.php',
     array(
       'templates' => auriel_theme_discover_partial_templates('partials/your-partial-name.php'),
       'fields'    => array(
         'your_variable_name' => array(
           'type'             => 'text',
           'label'            => __('Your Variable Name', AURIEL_THEME_TEXT_DOMAIN),
           'instructions'     => __('Instructions for your variable name.', AURIEL_THEME_TEXT_DOMAIN),
           'default_callback' => 'auriel_your_partial_name_default_value',
         ),
       ),
     )
   );
   ```
   Replace the discovery helper with a fixed array of template slugs if you prefer to manage visibility manually.

2. **Retrieve values inside the partial** (`partials/your-partial-name.php`):
   ```php
   $your_partial_fields = auriel_theme_get_fields(
     array(
       'your_variable_name',
     )
   );
   ```

3. **Prepare render-safe variables** prior to output:
   ```php
   $your_variable = (string) ($your_partial_fields['your_variable_name'] ?? '');
   ```

4. **Render with appropriate escaping** in the markup:
   ```php
   <span><?php echo esc_html($your_variable); ?></span>
   ```
   Switch to `wp_kses_post`, `esc_url`, or other escaping helpers depending on the expected content.

## 11. Troubleshooting
- **Dev server unavailable.** Confirm `vite_mode` is set to `dev` and `npm run dev` is running. The theme falls back to compiled assets if the server cannot be reached.
- **Missing CSS/JS in production.** Ensure `npm run build` has been executed and the resulting `assets/dist` directory is present on the server.
- **Module syntax warnings.** Scripts are delivered as ES modules. Verify that target browsers are modern or provide the necessary polyfills.

## 12. Operational Recommendations
- Introduce regression or visual tests before deploying significant UI changes.
- Incorporate `npm ci && npm run build` into CI/CD pipelines to guarantee consistent builds.
- Maintain partial field definitions alongside their render templates to keep the editing experience predictable.

For further assistance or to report issues, please contact the Auriel Theme maintainers or open a ticket in the project tracker.

## NativePHP Mobile Starter Kit

A Laravel 12 starter kit configured for building native iOS and Android applications using NativePHP Mobile, with Vue 3 + Inertia, TypeScript, Ziggy route helpers, axios, and SCSS via Vite.

### Stack
- **Backend**: Laravel 12, Inertia Laravel adapter v2
- **Mobile**: NativePHP Mobile v3.0
- **Frontend**: Vue 3 with **script setup** and **TypeScript**
- **Bundler**: Vite 7 + `laravel-vite-plugin` + `nativephpMobile` plugin
- **Dev tools**: `vite-plugin-vue-devtools`
- **Routing helpers**: Ziggy v2 (`@routes` in Blade, `ZiggyVue` in Vue)
- **HTTP**: Axios pre-configured in `bootstrap.ts`
- **Styles**: SCSS (global styles only; no styles inside SFCs)
- **Testing**: Pest v4
- **DX**: Laravel Pail (pretty app logs), Laravel Boost, and a queue worker wired in the dev script

### Project layout (key files)
- `resources/js/app.ts`: Inertia + Vue app bootstrap, imports `../scss/index.scss`, registers `ZiggyVue`
- `resources/js/bootstrap.ts`: axios on `window`, sets `X-Requested-With`
- `resources/js/Pages/*.vue`: Inertia pages (TypeScript SFCs)
- `resources/js/Layouts/BasicLayout.vue`: Base layout with `<Head />`
- `resources/scss/index.scss`: global styles (uses `_variables.scss`)
- `resources/views/app.blade.php`: Inertia root, includes `@routes` + `@vite`
- `vite.config.js`: Laravel + Vue + Vue DevTools + NativePHP Mobile plugins
- `tsconfig.json`: strict TS, path aliases (`@/*`, `ziggy-js`)
- `config/nativephp.php`: NativePHP Mobile configuration
- `native`: Custom wrapper script for NativePHP commands (use `./native` instead of `php artisan native`)

### Conventions
- **Vue SFCs**: Always `script setup lang="ts"` at the top, then `template`. No `<style>` blocks in SFCs.
- **Styles**: Put styles in `resources/scss/` and import from `app.ts`.
- **Aliases**: Use `@/` for `resources/js` (configured in `tsconfig.json`).
- **Routes**: Use Ziggy's `route()` in Vue (via `ZiggyVue`) and in Blade via `@routes`.
- **Page titles**: Set by Inertia using `VITE_APP_NAME` for suffix.
- **Package manager**: Use Yarn (not npm) for all Node.js operations.

### Prerequisites
- PHP 8.3+
- Composer
- Node 18+
- Yarn
- **For iOS development**: macOS with Xcode installed
- **For Android development**: Android Studio with Android SDK installed

### Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
yarn install
```

#### NativePHP Setup

Before running your app, configure NativePHP in `.env`:

```env
NATIVEPHP_APP_ID=com.yourcompany.yourapp
NATIVEPHP_APP_VERSION=DEBUG
NATIVEPHP_APP_VERSION_CODE=1
NATIVEPHP_DEVELOPMENT_TEAM=YOUR_TEAM_ID  # iOS only, optional
```

Then install NativePHP dependencies:

```bash
php artisan native:install
```

Or use the custom wrapper:

```bash
./native install
```

### Development Commands

#### Web Development (Browser)

**Start development server** (runs Laravel server, queue worker, Pail logs, and Vite):
```bash
composer run dev
```

**Or run separately**:
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
yarn dev
```

#### Mobile Development (Native Apps)

**Build for iOS**:
```bash
yarn build:ios
# or
yarn run:ios  # Builds and runs in one command
```

**Build for Android**:
```bash
yarn build:android
# or
yarn run:android  # Builds and runs in one command
```

**Run on device/emulator** (builds first):
```bash
php artisan native:run ios
php artisan native:run android
# or use the wrapper
./native run ios
./native run android
```

**Hot reloading** (watches for changes and auto-reloads):
```bash
yarn watch
# or specify platform
yarn watch:ios
yarn watch:android
# or use artisan directly
php artisan native:watch
php artisan native:watch ios
php artisan native:watch android
```

**Run with watch** (build, deploy, then watch):
```bash
yarn run:watch:ios
yarn run:watch:android
# or use artisan directly
php artisan native:run --watch ios
php artisan native:run --watch android
```

**Open in Xcode/Android Studio**:
```bash
php artisan native:open ios
php artisan native:open android
```

**View logs**:
```bash
php artisan native:tail
```

#### Build Commands

**Web build**:
```bash
yarn build
```

**Mobile builds** (run before `native:run`):
```bash
yarn build:ios      # Build assets for iOS
yarn build:android  # Build assets for Android
```

#### Testing

```bash
composer test
# or
php artisan test
```

#### Type Checking

**Vue SFC-aware type-check**:
```bash
yarn dlx vue-tsc --noEmit
```

**Plain TypeScript** (non-SFC):
```bash
yarn tsc --noEmit
```

### Using Ziggy route helpers
- In Blade (already included): `@routes`
- In Vue (globally via `ZiggyVue`):
```ts
route('index')
route('posts.show', { post: 1 })
```

### NativePHP Mobile Features

This starter kit includes NativePHP Mobile v3.0 configured with:

- **Hot reloading**: Changes to PHP, Vue, and assets are automatically pushed to the device
- **Vite HMR**: Full hot module replacement support for Vue components
- **Platform detection**: Use `System::isIos()` and `System::isAndroid()` in PHP
- **Native APIs**: Access to Camera, Biometrics, Scanner, Dialog, SecureStorage, and more
- **EDGE Components**: Native UI components via Blade (`native:bottom-nav`, `native:top-bar`, etc.)

See the [NativePHP Mobile documentation](https://nativephp.com/docs/mobile/2/) for full API reference.

### Development Tips

1. **Keep `NATIVEPHP_APP_VERSION=DEBUG`** during development to ensure Laravel always refreshes
2. **Use hot reloading** (`native:watch`) for faster iteration - no need to rebuild after every change
3. **Build assets first**: Always run `yarn build:ios` or `yarn build:android` before `native:run`
4. **Real devices**: Hot reloading works on real devices if they're on the same Wi-Fi network
5. **iOS limitations**: Full hot reloading on real iOS devices has some limitations (works best on simulators)

### Notes
- Axios is available as `window.axios` with `X-Requested-With` set.
- The Inertia progress bar is enabled with a gray color.
- `assetsInclude: ['**/*.glsl']` is enabled in Vite if you import GLSL assets.
- The `native` wrapper script allows shorter commands: `./native run ios` instead of `php artisan native:run ios`
- Composer `dev` script uses Yarn internally (not npm)

### What's included vs. not
- **Included**: Vue 3 + TS, Inertia v2, Ziggy v2, SCSS, Axios, Vite, Vue DevTools, Pest v4, Pail, queue worker in dev, NativePHP Mobile v3.0, Laravel Boost
- **Not included**: SSR, authentication scaffolding, ESLint/Prettier config

### Resources
- [NativePHP Mobile Documentation](https://nativephp.com/docs/mobile/2/)
- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Vue 3 Documentation](https://vuejs.org/)

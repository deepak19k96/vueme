const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const VuetifyLoaderPlugin = require("vuetify-loader/lib/plugin");
//const CompressionPlugin = require("compression-webpack-plugin");
const SWPrecacheWebpackPlugin = require("sw-precache-webpack-plugin");

mix
  .webpackConfig({
    plugins: [
      // new CompressionPlugin({
      //   filename: "[path].br[query]",
      //   algorithm: "brotliCompress",
      //   test: /\.(js|css|html|svg)$/,
      //   compressionOptions: { level: 11 },
      //   minRatio: 1,
      //   threshold: 10240,
      //   deleteOriginalAssets: false,
      // }),
      new VuetifyLoaderPlugin(),
      new SWPrecacheWebpackPlugin({
        cacheId: "local.psychics1on1",
        filename: "service-worker.js",
        staticFileGlobs: ["public/**/*.{css,eot,svg,ttf,woff,woff2,js,html}"],
        minify: true,
        stripPrefix: "public/",
        handleFetch: true,
        // dynamicUrlToDependencies: ["resources/views/*"],
        // dynamicUrlToDependencies: {
        //   "/": ["resources/views/home.blade.php"],
        //   "/apply": ["resources/views/home.blade.php"],
        //   "/about": ["resources/views/welcome.blade.php"],
        //   "/specialties'": ["resources/views/frontend/specialties.blade.php"],
        //   "/terms'": ["resources/views/frontend/terms.blade.php"],
        //   "/privacy-policy": ["resources/views/frontend/privacy.blade.php"],
        //   "/dmca-policy": ["resources/views/frontend/dmca_policy.blade.php"],
        //   "/payment-terms": [
        //     "resources/views/frontend/payment-terms.blade.php",
        //   ],
        //   "/dashboard": ["resources/views/backend/dashboard.blade.php"],
        //   "/dashboard/menu": [
        //     "resources/views/backend/dashboard_menu.blade.php",
        //   ],
        //   "/dashboard/user/menu": [
        //     "resources/views/backend/user_dashboard.blade.php",
        //   ],
        //   "/dashboard/profile": [
        //     "resources/views/backend/psychic_profile.blade.php",
        //   ],
        //   "/dashboard/user/profile": [
        //     "resources/views/backend/user_profile.blade.php",
        //   ],
        //   "/dashboard/services": [
        //     "resources/views/backend/dashboard_services.blade.php",
        //   ],
        //   "/dashboard/reviews": [
        //     "resources/views/backend/psychic_reviews.blade.php",
        //   ],
        //   "/dashboard/payout": [
        //     "resources/views/backend/payout_method.blade.php",
        //   ],
        //   "/dashboard/analytics": [
        //     "resources/views/backend/psychic/psychic_analytics.blade.php",
        //   ],
        //   "/dashboard/user/reviews": [
        //     "resources/views/backend/dashboard_reviews.blade.php",
        //   ],
        //   "/dashboard/transaction": [
        //     "resources/views/backend/dashboard_transaction.blade.php",
        //   ],
        //   "/dashboard/favorites": [
        //     "resources/views/backend/dashboard_favorites.blade.php",
        //   ],
        //   "/dashboard/appointments": [
        //     "resources/views/backend/user_dashboard.blade.php",
        //   ],
        //   "/dashboard/payment": [
        //     "resources/views/backend/user/payment.blade.php",
        //   ],
        //   "/dashboard/notifications": [
        //     "resources/views/backend/notifications.blade.php",
        //   ],
        //   "/press": ["resources/views/frontend/press.blade.php"],
        //   "/chat": ["resources/views/frontend/chat.blade.php"],
        //   "/search": ["resources/views/frontend/search.blade.php"],
        //   "/search": ["resources/views/frontend/search.blade.php"],
        // },
        staticFileGlobsIgnorePatterns: [
          /\.map$/,
          /mix-manifest\.json$/,
          /manifest\.json$/,
          /service-worker\.js$/,
        ],
        navigateFallback: "/",
        runtimeCaching: [
          {
            urlPattern: /^https:\/\/fonts\.googleapis\.com\//,
            handler: "cacheFirst",
          },
          {
            urlPattern: /^https:\/\/use\.fontawesome\.com\//,
            handler: "cacheFirst",
          },
          {
            urlPattern: /^https:\/\/cdn\.jsdelivr\.net\//,
            handler: "cacheFirst",
          },
          {
            urlPattern: /^https:\/\/psychics1on1\.com\/images\/pwa\/(\w+)\.png/,
            handler: "cacheFirst",
          },
          {
            urlPattern: /^https:\/\/dev\.psychics1on1\.com\/images\/pwa\/(\w+)\.png/,
            handler: "cacheFirst",
          },
          {
            urlPattern: /\/psychics1on1\//,
            handler: "fastest",
            options: {
              cache: {
                name: "pages-cache",
                maxEntries: 50,
                maxAgeSeconds: 60 * 60 * 48,
              },
            },
            // options: {
            //   cacheName: "pages-cache",
            //   expiration: {
            //     maxEntries: 50,
            //     maxAgeSeconds: 60 * 60 * 48,
            //   },
            // },
          },
        ],
        // importScripts: ['./js/push_message.js']
      }),
    ],
  })
  .js("resources/admin/main.js", "public/admin-backend")
  .js("resources/backend/js/app.js", "public/backend/js")
  .sass("resources/backend/sass/app.scss", "public/backend/css")
  .js("resources/frontend/js/app.js", "public/frontend/js")
  .sass("resources/frontend/sass/app.scss", "public/frontend/css")
  .options({
    hmrOptions: {
      host: "local.psychics1on1",
      port: 8080,
    },
    extractVueStyles: false,
    processCssUrls: true,
    purifyCss: false,
    /*terser: {
      terserOptions: {
        compress: {
          pure_funcs: ["console.log"],
          drop_console: true,
          warnings: false,
          drop_debugger: true,
        },
      },
  },*/
  });

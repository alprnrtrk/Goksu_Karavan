import { defineConfig } from 'vite';
import { resolve } from 'path';
import { glob } from 'glob';
import { fileURLToPath } from 'node:url';

const themeRoot = fileURLToPath(new URL('.', import.meta.url));
const distRoot = resolve(themeRoot, 'assets/dist');
const scssGlob = 'assets/src/scss/[!_]*.scss';

// ✅ Add file types to watch (expand as needed)
const hmrWatchGlobs = [
  '**/*.php',
  '**/*.twig',
  '**/*.json',
  '**/*.html',
  '**/*.md'
];

export default defineConfig({
  base: '/',

  plugins: [
    {
      name: 'auriel-hmr-full-reload',
      handleHotUpdate({ file, server }) {
        // Full reload for any file matching the globs above
        for (const ext of hmrWatchGlobs) {
          if (file.includes(ext.replace('**/', ''))) {
            server.ws.send({ type: 'full-reload', path: '*' });
            console.log(`🔁 Full reload triggered by: ${file}`);
            return;
          }
        }
      }
    },
  ],

  css: { devSourcemap: true },

  build: {
    manifest: true,
    outDir: distRoot,
    assetsInlineLimit: 0,
    rollupOptions: {
      input: {
        'js/main': resolve(themeRoot, 'assets/src/js/main.js'),
        ...(() => {
          const scssFiles = glob.sync(scssGlob, {
            cwd: themeRoot,
            windowsPathsNoEscape: true,
          });
          return scssFiles.reduce((entries, relativePath) => {
            const normalized = relativePath.replace(/\\/g, '/');
            const match = normalized.match(/([^/]+)\.scss$/);
            if (!match) return entries;
            const [, name] = match;
            return { ...entries, [name]: resolve(themeRoot, relativePath) };
          }, {});
        })(),
      },
    },
  },

  server: {
    cors: true,
    port: 5173,
    strictPort: true,
    hmr: {
      host: 'localhost',
    },
    watch: {
      // ✅ Watch these files even if they're outside regular input
      ignored: ['!**/*.php', '!**/*.twig', '!**/*.json', '!**/*.html', '!**/*.md'],
    }
  },
});

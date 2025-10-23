/**
 * View your website at your own local server.
 * Example: if you're using WP-CLI then the common URL is: http://localhost:8080.
 *
 * http://localhost:5173 is serving Vite on development. Access this URL will show empty page.
 *
 */

import { defineConfig } from 'vite';
import { resolve } from 'path';
import { glob } from 'glob';
import { fileURLToPath } from 'node:url';

const themeRoot = fileURLToPath(new URL('.', import.meta.url));
const distRoot = resolve(themeRoot, 'assets/dist');
const scssGlob = 'assets/src/scss/[!_]*.scss';

export default defineConfig({
	base: './',

	plugins: [
		{
			handleHotUpdate({ file, server }) {
				if (file.endsWith('.php')) {
					server.ws.send({ type: 'full-reload', path: '*' });
				}
			},
		},
	],

	css: {
		devSourcemap: true,
	},

	build: {
		// emit manifest so PHP can find the hashed files
		manifest: true,

		outDir: distRoot,

		// don't base64 images
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

						if (!match) {
							return entries;
						}

						const [, name] = match;

						return {
							...entries,
							[name]: resolve(themeRoot, relativePath),
						};
					}, {});
				})(),
			},
			output: {
				entryFileNames: ({ name }) => {
					const normalizedName = name.replace(/^js\//, '');
					return `js/${normalizedName}.js`;
				},
				chunkFileNames: ({ name }) => {
					const normalizedName = name.replace(/^js\//, '');
					return `js/${normalizedName}.js`;
				},
				assetFileNames: (assetInfo) => {
					const extSegments = assetInfo.name.split('.');

					if (extSegments.length < 2) {
						return '[name].[ext]';
					}

					const ext = extSegments.pop()?.toLowerCase();

					if (!ext) {
						return '[name].[ext]';
					}

					if (['woff', 'woff2', 'ttf', 'otf', 'eot'].includes(ext)) {
						return 'fonts/[name].[ext]';
					}

					if (['gif', 'jpg', 'jpeg', 'png', 'svg', 'webp', 'avif'].includes(ext)) {
						return 'img/[name].[ext]';
					}

					if (ext === 'css') {
						return 'css/[name].[ext]';
					}

					return `${ext}/[name].[ext]`;
				},
			},
		},
	},

	server: {
		// required to load scripts from custom host
		cors: {
			origin: '*',
		},

		// We need a strict port to match on PHP side.
		strictPort: true,
		port: 5173,
	},
});

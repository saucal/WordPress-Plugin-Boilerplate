const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const TerserPlugin = require('terser-webpack-plugin');
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );
const path = require('path');
const { fromProjectRoot } = require('@wordpress/scripts/utils/file');
const fs = require('fs');

function getWebpackEntryPoints() {
	let entryPoints = {};

    // Get path from entries fron package.json config file
	const entryPaths = {
		js: fromProjectRoot(process.env.npm_package_config_webpack_js),
		css: fromProjectRoot(process.env.npm_package_config_webpack_css),
	};

	for ( const entryPath in entryPaths ) {
		// For each path of entries, find its subdirectories.
		const dirs = fs
				.readdirSync(entryPaths[entryPath], {
					withFileTypes: true,
				})
				.filter((item) => item.isDirectory())
				.map((item) => item.name);
		
		// Foreach subdirectory find files that are either .js or .scss
		dirs.forEach((dir) => {
			fs.readdirSync(path.resolve(
				entryPaths[entryPath],
				dir
			), {
				withFileTypes: true,
			})
			.filter((item) => ! item.isDirectory())
			.map((item) => {
				// Don't add as entries files that are not .js or .scss
				if ( 'js' !== item.name.split('.').pop() && 'scss' !== item.name.split('.').pop() ) {
					return item.name;
				}

				// Don't add as entries files that their names start with _ or .
				if ( '_' === item.name.charAt( 0 ) || '.' === item.name.charAt( 0 ) ) {
					return item.name;
				}

				const itemName = item.name.replace( '.js', '' ).replace('.scss', '' );
				entryPoints[entryPath + '/' + dir + '/' + itemName] = path.resolve( entryPaths[entryPath], dir, item.name );

				// If the files are JS include a minified version as well.
				if ( 'js' === entryPath ) {
					entryPoints[entryPath + '/' + dir + '/' + itemName + '.min'] = path.resolve( entryPaths[entryPath], dir, item.name );
				}

				return item.name;
			});
		});
	}

	return entryPoints;
}

module.exports = {
	...defaultConfig,
	entry: getWebpackEntryPoints(),
	output: {
		path: fromProjectRoot('assets' + path.sep),
		filename: '[name].js',
	},
	optimization: {
		...defaultConfig.optimization,
		minimize: true,
		minimizer: [
			new TerserPlugin({
				parallel: true,
				include: [ /\.min\.js$/ ],
			}),
		],
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.(bmp|png|jpe?g|gif)$/i,
				type: 'asset/resource',
				generator: {
					filename: 'images/[name][ext]',
				},
			},
		],
	},
	plugins: [
		...defaultConfig.plugins,
		new CopyWebpackPlugin({
			patterns: [
				{ from: 'src/images', to: './images/' }
			]
		})
	],
};
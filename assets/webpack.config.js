/**
 * Webpack configuration.
 */
 const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
 const path = require('path');
 
 // JS Directory path.
 const JS_DIR = path.resolve(__dirname, 'src/js');
 
 const entry = {
	 ...defaultConfig.entry(),
	 main: JS_DIR + '/main.js',
	inline: JS_DIR + '/inline.js',
 };
 
 const rules = [
	 ...defaultConfig.module.rules,
	 {
		 test: /\.(bmp|png|jpe?g|gif|webp)$/i,
		 type: 'asset/resource',
		 generator: {
			 filename: 'images/[name].[hash:8][ext]',
			 publicPath: '/wp-content/themes/green-press-wp/assets/build/',
		 },
	 },
	 {
		 test: /\.(woff|woff2|eot|ttf|otf)$/i,
		 type: 'asset/resource',
		 generator: {
			 filename: 'fonts/[name].[hash:8][ext]',
			 publicPath: '/wp-content/themes/green-press-wp/assets/build/',
		 },
	 },
	 {
		 test: /\.svg$/,
		 issuer: /\.(sc|sa|c)ss$/,
		 type: 'asset/resource',
		 generator: {
			 filename: 'images/[name].[hash:8][ext]',
		 },
	 },
 ];
 
 /**
  * Since you may have to disambiguate in your webpack.config.js between development and production builds,
  * you can export a function from your webpack configuration instead of exporting an object
  *
  * @param {string} env environment ( See the environment options CLI documentation for syntax examples. https://webpack.js.org/api/cli/#environment-options )
  * @param argv options map ( This describes the options passed to webpack, with keys such as output-filename and optimize-minimize )
  * @return {{output: *, devtool: string, entry: *, optimization: {minimizer: [*, *]}, plugins: *, module: {rules: *}, externals: {jquery: string}}}
  *
  * @see https://webpack.js.org/configuration/configuration-types/#exporting-a-function
  */
 module.exports = (env, argv) => ({
	 ...defaultConfig,
	 entry,
 
	 module: {
		 ...defaultConfig.module,
		 rules,
	 },
 
	 externals: {
		 jquery: 'jQuery',
	 },
 
	 output: {
		 path: path.resolve( __dirname, 'build' ),
		 publicPath: '/wp-content/themes/green-press-wp/assets/build/',
	 },
 });
 
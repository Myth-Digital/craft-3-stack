const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.disableNotifications();
 
if (mix.inProduction()){
	mix.webpackConfig({
		module: {
			rules: [
				{
					test: /\.jsx?$/,
					include: [/(src\/js)/],
					use: [
						{
							loader: 'babel-loader',
							options: Config.babel()
						}
					]
				}
			]
		}
	});
} else {
    mix.webpackConfig({ devtool: "source-map" });
		mix.sourceMaps();
}

mix
	.js('src/js/vue.js', 'public/dist/js')
	.js('src/js/app.js', 'public/dist/js')
	.extract([
		'axios', 'vue', 'vuex', 'alpinejs'
	])
	.sass('src/scss/app.scss', 'public/dist/css/app.css')
	.options({
		processCssUrls: false,
		postCss: [ tailwindcss('./tailwind.config.js') ]
	});
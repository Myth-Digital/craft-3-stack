const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.disableNotifications();
 
if (mix.inProduction()){
	mix.webpackConfig({
		module: {
			rules: [
				{
					test: /\.jsx?$/,
					include: [/(assets\/js)/],
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
	.js('src/js/app.js', '/public/dist/js/app.js')
	.extract([
		'axios', 'vue', 'vuex'
	])
	.sass('src/scss/style.scss', '/public/dist/js/app.css')
	.options({
		processCssUrls: false,
		postCss: [ tailwindcss('./tailwind.config.js') ]
	});
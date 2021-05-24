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
	.js('src/index.js', 'public/dist/js')
	.sass('src/scss/app.scss', 'public/dist/css/app.css')
	.extract([
		'axios', 'vue', 'vuex'
	])
	.options({
		processCssUrls: false,
		postCss: [ tailwindcss('./tailwind.config.js') ]
	});
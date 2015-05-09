var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.less('app.less', 'resources/css');

	mix.styles([
		'app.css',
		'libs/select2.min.css',
		'custom.css',
	])

	mix.scripts([
		'libs/jquery.min.js',
		'libs/bootstrap.min.js',
		'libs/bootbox.min.js',
		'libs/select2.min.js',
		'common.js',
		'custom.map.js',
		'custom.map.search.js',
		'trainings.page.js',
	],
	'public/js/main.min.js'
	)

	mix.scripts([
		'forform/jquery.ui.widget.js',
		'forform/jquery.iframe-transport.js',
		'forform/jquery.fileupload.js',
		'forform/custom.for.form.js',
		'forform/maps.form.js',
	],
	'public/js/forms.min.js'
	)
});

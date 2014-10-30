php-minify
==========

glue and minify css and js using php stdlib

minify.config.php
```sh
return [
	[
		'glue&minify',
		[
			'styles/css/reset.css',
			'styles/css/style.css',
			'styles/css/plugin/calendar.css'
		],
		'public/css/app.css'
	],
	[
		'glue&minify',
		[
			'js/jquery.js',
			'js/tracking.js',
			'js/helper.js'
		],
		'public/js/app.js'
	]
];
```

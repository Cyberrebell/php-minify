php-minify
==========

glue and minify css and js using only php stdlib

configuration example:

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

usage:
```sh
<?php
include 'vendor/autoload.php';

use PhpMinify\Launcher\MinifyLauncher;

$launcher = new MinifyLauncher(include 'minify.config.php');
$launcher->run();
```

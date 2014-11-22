<?php

namespace PhpMinify\Launcher;

use PhpMinify\Glue\GlueHandler;
use PhpMinify\Minify\MinifyHandler;

class MinifyLauncher
{
	protected $config = [];
	
	function __construct(array $config) {
		$this->config = $config;
	}
	
	function run() {
		foreach ($this->config as $task) {
			if (count($task) != 3) {
				throw new \Exception("tasks must consist of 3 segments");
			}
			switch($task[0]) {
				case 'glue':
					$this->glue($task[1], $task[2]);
					break;
				case 'minify':
					$this->minify($task[2]);
					break;
				case 'glue&minify':
					$this->glue($task[1], $task[2]);
					$this->minify($task[2]);
					break;
				default:
					throw new \Exception("unknown command '" . $task[0] . "'");
			}
		}
	}
	
	protected function glue(array $inputFiles, $outputFile) {
		$glueHandler = new GlueHandler($inputFiles, $outputFile);
		$glueHandler->glue();
	}
	
	protected function minify($fileName) {
		$minifyHandler = new MinifyHandler($fileName);
		$minifyHandler->minify();
	}
}

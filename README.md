# Ultimo MVC Phptpl
Template engine in PHP for Ultimo MVC

## Features
* Viewscript/helper inheritance of parent modules
* Viewscript/helper inheritance of parent themes
* Viewscript type based on Accept header

## Requirements
* Ultimo Phptpl
* Ultimo MVC

## Usage

### Register plugin
Ultimo MVC used a Viewrenderer based on Phptpl by default.

### module/views/scripts/read.phtml
	Hello <?php echo $this->escape($this->bar) ?>
	Output of custom helper: <?php echo $this->fib(6) ?>

### module/views/helpers/Fib.php
	<?php
	namespace \module\view\helpers;
	
	class Fib extends \ultimo\phptpl\Helper {
		public function __invoke($n) {
			if ($n <= 1) {
				return $n;
			} else {
				return $this->__invoke($n-1) + $this->__invoke($n-2);
			}
		}
	}

### Controller in module/controllers
Viewscripts are automatically rendered after controller actions.

	function actionRead() {
		$this->foo = 'bar';	
	}
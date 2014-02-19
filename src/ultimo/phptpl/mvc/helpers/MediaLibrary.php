<?php

namespace ultimo\phptpl\mvc\helpers;

class MediaLibrary extends \ultimo\phptpl\mvc\Helper {
  protected $wrapped;
  
  public function __invoke() {
    return $this;
  }
  
  public function __call($name, $args) {
    return call_user_func_array(array($this->wrapped, $name), $args);
  }
  
  public function __construct(\ultimo\phptpl\Engine $engine) {
    parent::__construct($engine);
    $this->wrapped = new \ultimo\phptpl\helpers\MediaLibrary($this->engine);
    $this->wrapped->setBaseUrl($this->application->getRequest()->getBaseUrl() . '/' . $this->wrapped->getBaseUrl());
  }
  
}
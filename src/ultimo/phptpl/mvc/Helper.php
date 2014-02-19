<?php

namespace ultimo\phptpl\mvc;

abstract class Helper extends \ultimo\phptpl\Helper {
  /**
   * The module the helper is for.
   * @var \ultimo\mvc\Module
   */
  protected $module = null;
  
  /**
   * The application the helper is for.
   * @var \ultimo\mvc\Application
   */
  protected $application = null;
  
  /**
   * Constructor.
   * @param \ultimo\phptpl\Engine $engine The engine the helper is for. For
   * mvc helpers this must be an instance of \ultimo\phptpl\mvc\View.
   */
  public function __construct(\ultimo\phptpl\Engine $engine) {
    if (!$engine instanceof \ultimo\phptpl\mvc\View) {
      throw new \InvalidArgumentException('Helpers for Ultimo MVC should be passed an instance of \ultimo\phptpl\mvc\View');
    }
    parent::__construct($engine);
    $this->module = $engine->getModule();
    $this->application = $this->module->getApplication();
  }
}
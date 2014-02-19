<?php

namespace ultimo\phptpl\mvc\helpers\widgets;

abstract class Widget extends \ultimo\phptpl\helpers\widgets\Widget {
  /**
   * The module the widget is for.
   * @var \ultimo\mvc\Module
   */
  protected $module = null;
  
  /**
   * The application the widget is for.
   * @var \ultimo\mvc\Application
   */
  protected $application = null;
  
  /**
   * Constructor.
   * @param \ultimo\phptpl\Engine $engine The engine the widget is for. For mvc
   * widgets this must be an instance of \ultimo\phptpl\mvc\View.
   * @param string $widgetId The id of the widget.
   * @param array $attrs The attributes of the widget.
   */
  public function __construct(\ultimo\phptpl\Engine $engine, $widgetId, array $attrs = array()) {
    if (!$engine instanceof \ultimo\phptpl\mvc\View) {
      throw new \InvalidArgumentException('Helpers for Ultimo MVC should be passed an instance of \ultimo\phptpl\mvc\View');
    }
    
    $this->module = $engine->getModule();
    $this->application = $this->module->getApplication();
    
    parent::__construct($engine, $widgetId, $attrs);
  } 
}
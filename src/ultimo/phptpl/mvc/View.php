<?php

namespace ultimo\phptpl\mvc;

class View extends \ultimo\phptpl\Engine implements \ultimo\mvc\View {
  /**
   * @var \ultimo\mvc\Module
   */
  protected $_module = null;
  /**
   * @var \ultimo\mvc\Application
   */
  protected $_application = null;
  
  protected $_theme = 'general';
  
  protected $_moduleScriptPaths = array();
  protected $_moduleHelperPaths = array();
  protected $_moduleBasePaths = array();
  protected $_customScriptPaths = array();
  protected $_customHelperPaths = array();
  protected $_customBasePaths = array();
  protected $_extension = 'phtml';
  
  public function __construct(\ultimo\mvc\Module $module, $theme=null) {
    $this->_module = $module;
    $this->_application = $module->getApplication();
    $this->_theme = $theme;
    parent::__construct();
    $this->addHelperPath(__DIR__ . DIRECTORY_SEPARATOR . 'helpers', 'ultimo\phptpl\mvc\helpers');
    $this->determineModulePaths();
  }
  
  protected function determineModulePaths() {
    $modules = array();
    $module = $this->_module;
    while($module !== null) {
      $modules[] = $module;
      foreach ($module->getPartials() as $partial) {
        $modules[] = $partial;
      }
      $module = $module->getParent();
    }
    $modules[] = $this->_application->getGeneralModule();
    $modules = array_reverse($modules);
    
    foreach ($modules as $module) {
      $this->addModuleBasePath($module->getBasePath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general', $module->getNamespace() . '\\views\general');
      
      if ($this->_theme !== null) {
        $this->addModuleBasePath($module->getBasePath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->_theme, $module->getNamespace() . '\\views\\' . $this->_theme);
      }
    }
  }
  
  public function addBasePath($path, $namespace='ultimo\phptpl') {
    $path = rtrim($path, '\\/');
    $this->addPath(array('path' => $path, 'namespace' => $namespace), $this->__customBasePaths);
    $this->_basePaths = array_merge($this->_moduleBasePaths, $this->_customBasePaths);
    
    $path .= DIRECTORY_SEPARATOR;
    $this->addScriptPath($path . 'scripts');
    $this->addHelperPath($path . 'helpers', $namespace . '\helpers');
  }
  
  protected function addModuleBasePath($path, $namespace) {
    $path = rtrim($path, '\\/');
    
    $this->addPath(rtrim($path . DIRECTORY_SEPARATOR . 'scripts'), $this->_moduleScriptPaths);
    $this->addPath(array('path' => $path . DIRECTORY_SEPARATOR . 'helpers', 'namespace' => $namespace . '\helpers'), $this->_moduleHelperPaths);
    $this->addPath(array('path' => $path, 'namespace' => $namespace), $this->_moduleBasePaths);
    
    $this->_scriptPaths = array_merge($this->_moduleScriptPaths, $this->_customScriptPaths);
    $this->_helperPaths = array_merge($this->_moduleHelperPaths, $this->_customHelperPaths);
    $this->_basePaths = array_merge($this->_moduleBasePaths, $this->_customBasePaths);
  }
  
  public function addScriptPath($path) {
    $this->addPath(rtrim($path, '\\/'), $this->_customScriptPaths);
    $this->_scriptPaths = array_merge($this->_moduleScriptPaths, $this->_customScriptPaths);
  }
  
  public function addHelperPath($path, $namespace='ultimo\phptpl\helpers') {
    $this->addPath(array('path' => rtrim($path, '\\/'), 'namespace' => $namespace), $this->_customHelperPaths);
    $this->_helperPaths = array_merge($this->_moduleHelperPaths, $this->_customHelperPaths);
  }
  
  public function setTheme($theme) {
    $this->_theme = $theme;
    $this->determineModulePaths();
  }
  
  public function getTheme() {
    return $this->_theme;
  }
  
  public function getModule() {
    return $this->_module;
  }
  
  public function getApplication() {
    return $this->_application;
  }
  
  public function partial($templateName, array $vars = array()) {
    $prevVars = array();
    foreach ($vars as $name => $value) {
      if (isset($this->$name)) {
        $prevVars[$name] = $this->$name;
      } else {
        $prevVars[$name] = null;
      }
      $this->$name = $value;
    }

    $rendered = parent::render($templateName);
    
    foreach ($prevVars as $name => $value) {
      $this->$name = $value;
    }
    
    return $rendered;
  }
  
  public function setExtension($extension) {
    $this->_extension = ltrim($extension, '.');
  }
  
  public function getExtension() {
    return $this->_extension;
  }
  
  public function render($templateFileName, $disableLayout=false) {
    return parent::render($templateFileName . '.' . $this->_extension);
  }
}
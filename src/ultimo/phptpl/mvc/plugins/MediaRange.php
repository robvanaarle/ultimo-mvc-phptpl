<?php

namespace ultimo\phptpl\mvc\plugins;

class MediaRange implements \ultimo\mvc\plugins\ApplicationPlugin, \ultimo\mvc\plugins\ModulePlugin, \ultimo\mvc\plugins\ControllerPlugin {
  
  protected $mediaRanges = array();
  
  protected $selectedMediaRange = null;
  
  public function add($mediaRange, $viewScriptExtension, $master=null) {
    $viewScriptExtension = ltrim($viewScriptExtension, '.');
    
    $this->mediaRanges[$mediaRange] = array('mediaRange' => $mediaRange, 'viewScriptExtension' => $viewScriptExtension, 'master' => $master);
    
    return $this;
  }
  
  public function selectMediaRange($mediaRange) {
    if (!isset($this->mediaRanges[$mediaRange])) {
      throw new Exception("MediaRange '{$mediaRange}' does not exist.");
    }
    
    $this->selectedMediaRange = $mediaRange;
  }
  
  public function onRoute(\ultimo\mvc\Application $application, \ultimo\mvc\Request $request) {
    $acceptValue = $request->getHeaderValue('Accept');
    if ($acceptValue === null) {
      return;
    }
    
    $matchedMediaRange = null;
    try {
      $acceptHeader = \ultimo\net\http\headers\Accept::fromHeaderValue($acceptValue);
      $matchedMediaRange = $acceptHeader->getBestMediaRangeMatch(array_keys($this->mediaRanges));
    } catch (\ultimo\net\http\RFCParseException $e) { }
    
    if ($matchedMediaRange !== null) {
      $this->selectedMediaRange = $matchedMediaRange;
    } else {
      // TODO respond with 406?
    }
    
  }
  
  /**
   * Called before a controller action is called.
   * @param \ultimo\mvc\Controller $controller The controller the action is
   * being called on.
   * @param string $actionName The name of the action.
   */
  public function onActionCall(\ultimo\mvc\Controller $controller, &$actionName) {
    $mediaRangeData = $this->mediaRanges[$this->selectedMediaRange];
    
    $contentType = $controller->getApplication()->getResponse()->getHeader('Content-Type');
    if (!$contentType instanceof \ultimo\net\http\headers\ContentType) {
      $contentType = \ultimo\net\http\headers\ContentType::fromBasicHeader($contentType);
      $controller->getApplication()->getResponse()->setHeader($contentType);
    }
    
    $contentType->setHeaderValue($mediaRangeData['mediaRange']);
    
    $controller->getView()->setExtension($mediaRangeData['viewScriptExtension']);
    $controller->getPlugin('viewRenderer')->setMaster($mediaRangeData['master']);
  }

  public function onModuleCreated(\ultimo\mvc\Module $module) {
    $module->addPlugin($this);
  }
  
  public function onControllerCreated(\ultimo\mvc\Controller $controller) {
    $controller->addPlugin($this);
  }
  
  public function onActionCalled(\ultimo\mvc\Controller $controller, $actionName) { }
  
  public function onPluginAdded(\ultimo\mvc\Application $application) { }
  
  public function onRouted(\ultimo\mvc\Application $application, \ultimo\mvc\Request $request=null) { }
  
  public function onDispatch(\ultimo\mvc\Application $application) { }
  
  public function onDispatched(\ultimo\mvc\Application $application) { }
}
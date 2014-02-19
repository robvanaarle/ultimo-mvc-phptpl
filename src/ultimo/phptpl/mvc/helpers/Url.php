<?php

namespace ultimo\phptpl\mvc\helpers;

class Url extends \ultimo\phptpl\mvc\Helper {

  /**
   * Helper initial function. Created a url using the application router.
   * @param array $params The parameters for the url, including the name of the
   * module, controller and action. If one of those is missing, their value in
   * the current request is used.
   * @param mixed $metadata Metadata for unrouting.
   * @param boolean $resetUserParams Whether to reset the parameters from the
   * current request. If set the false, all user paramters from the current
   * request are appended to the url.
   * @param boolean $escape Whether to escape the url.
   * @return string The constructed url.
   */
  public function __invoke(array $params = array(), $metadata = null, $resetUserParams=true, $escape=true) {
    // construct request to unroute
    $request = new \ultimo\mvc\Request();
    $request->setBasePath($this->application->getRequest()->getBasePath());
    $request->setUrl($this->application->getRequest()->getUrl(false));
    
    $currentRequest = $this->application->getRequest();
    
    if ($resetUserParams) {
      $defaultGetParams = array();
    } else {
      $defaultGetParams = $currentRequest->getGetParams();
    }
    
    // module, controller and action could be part of params list. Use those
    // from current request as default
    $defaultGetParams['module'] = $currentRequest->getModule();
    $defaultGetParams['controller'] = $currentRequest->getController();
    $defaultGetParams['action'] = $currentRequest->getAction();
    
    $getParams = array_merge($defaultGetParams, $params);
    
    
    $request->setModule($getParams['module']);
    unset($getParams['module']);
    
    $request->setController($getParams['controller']);
    unset($getParams['controller']);
    
    $request->setAction($getParams['action']);
    unset($getParams['action']);
    
    // add cleaned get Params
    $request->clearGetParams();
    $request->setGetParams($getParams);
    

    $router = $this->application->getRouter();
    
    if ($router instanceof \ultimo\mvc\routers\RuleBasedRouter && $metadata === null) {
      $metadata = 'default';
    }
    
    // unroute and return the resulting url
    $request = $router->unroute($this->application, $request, $metadata);
    $url = $request->getUrl();
    
    if ($escape) {
      $url = str_replace('&', '&amp;', $url);
    }
    
    return $url;
  }
}
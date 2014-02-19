<?php

namespace ultimo\phptpl\mvc\helpers\widgets;

class Paginator extends \ultimo\phptpl\mvc\helpers\widgets\Widget {
  
  /**
   * Returns the default attributes of the widget.
   * @return array The default attrubutes of the widget.
   */
  public function getDefaultAttrs() {
    $request = $this->application->getRequest();
    $defaultParams = $request->getParams();
    $defaultParams['module'] = $request->getModule();
    $defaultParams['controller'] = $request->getController();
    $defaultParams['action'] = $request->getAction();
    return array(
        'pageKey' => 'page',
        'countKey' => 'count',
        'countLocked' => false,
        'totalCount' => 10,
        'defaultCount' => 10,
        'urlParams' => $defaultParams
    );
  }
  
  /**
   * Renders the widget.
   * @return string The rendered widget.
   */
  public function render() {
    $config = $this->attrs;
    $urlParams = $config['urlParams'];
    
    $countKey = $config['countKey'];
    $count = $config['defaultCount'];
    if (!$config['countLocked']) {
      if (isset($urlParams[$countKey])) {
        $count = $urlParams[$countKey];
      }
      $urlParams[$countKey] = $count;
    }
    
    $pageCount = ceil($config['totalCount'] / $count);
    
    $pageKey = $config['pageKey'];
    $page = 1;
    if (isset($urlParams[$pageKey])) {
      $page = $urlParams[$pageKey];
    }
    
    if ($page == 'last') {
      $page = $pageCount;
    }
    
    $html = '';
    
    if ($pageCount == 0) {
      return $html;
    }
    
    if ($page > 1) {
      $prevParams = $urlParams;
      $prevParams[$pageKey] = $page-1;
      $html .= '<a href="'.$this->engine->url($prevParams).'">Previous page</a> ';
    }
    
    $html .= 'Page ' . $page . ' / ' . $pageCount;
    
    if ($page < $pageCount) {
      $nextParams = $urlParams;
      $nextParams[$pageKey] = $page+1;
      $html .= ' <a href="'.$this->engine->url($nextParams).'">Next page</a>';
    }
    
    return $html;
  }
}
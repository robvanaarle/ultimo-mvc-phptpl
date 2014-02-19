<?php

namespace ultimo\phptpl\mvc\helpers;

class BaseUrl extends \ultimo\phptpl\mvc\Helper {
  
  /**
   * Helper initial function. Converts a uri to an url.
   * @param string $uri The uri to convert to url.
   * @return string The url.
   */
  function __invoke($uri='') {
    return $this->application->getRequest()->getBaseUrl() . '/' . ltrim($uri, '\\/');
  }
}
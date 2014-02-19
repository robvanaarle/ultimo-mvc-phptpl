<?php

namespace ultimo\phptpl\mvc\helpers;

class Redirector extends \ultimo\phptpl\mvc\Helper {
  
  function __invoke() {
    return $this->application->getPlugin('redirector');
  }
}
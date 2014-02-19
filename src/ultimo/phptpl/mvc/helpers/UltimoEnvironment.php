<?php

namespace ultimo\phptpl\mvc\helpers;

class UltimoEnvironment extends \ultimo\phptpl\mvc\Helper {
  function __invoke() {
    return $this->application->getEnvironment();
  }
}
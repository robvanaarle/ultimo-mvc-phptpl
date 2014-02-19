<?php

namespace ultimo\phptpl\mvc\helpers\decorators;

class HeadScriptTheme extends \ultimo\phptpl\HelperDecorator {
  /**
   * Helper initial function.
   * @return HeadLink This class.
   */
  public function __invoke() {
    return $this;
  }
  
  /**
   * Appends a javascript file.
   * @param string $src The url to the javascript file.
   * @param string $dup What to do with duplicates.
   * @return HeadScript This instance for fluid design.
   */
  public function appendThemeJavascriptFile($src, $theme=null, $dup=\ultimo\phptpl\helpers\support\HeadTag::DUP_DISALLOWED) {
    if ($theme === null) {
      $theme = $this->engine->getTheme();
    }
    
    parent::appendJavascriptFile($theme . '/' . ltrim($src, '\\/'), $dup);
    return $this;
  }
  
  /**
   * Appends a javascript file.
   * @param string $src The url to the javascript file.
   * @param string $dup What to do with duplicates.
   * @return HeadScript This instance for fluid design.
   */
  public function prependThemeJavascriptFile($src, $theme=null, $dup=\ultimo\phptpl\helpers\support\HeadTag::DUP_DISALLOWED) {
    if ($theme === null) {
      $theme = $this->engine->getTheme();
    }
    
    parent::prependJavascriptFile($theme . '/' . ltrim($src, '\\/'), $dup);
    return $this;
  }
}
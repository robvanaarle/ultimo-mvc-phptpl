<?php

namespace ultimo\phptpl\mvc\helpers\decorators;

class HeadLinkTheme extends \ultimo\phptpl\HelperDecorator {
  /**
   * Helper initial function.
   * @return HeadLink This class.
   */
  public function __invoke() {
    return $this;
  }
  
  /**
   * Appends stylesheet from the public theme directory.
   * @param string $href The url to the stylesheet.
   * @param string $theme The name of the theme, or null to use the current
   * theme.
   * @param string $media The medis type of the stylesheet.
   * @param string $dup What to do with duplicates.
   * @return HeadLink This instance for fluid design.
   */
  public function appendThemeStylesheet($href, $theme=null, $media='', $dup=\ultimo\phptpl\helpers\support\HeadTag::DUP_DISALLOWED) {
    if ($theme === null) {
      $theme = $this->engine->getTheme();
    }
  
    parent::appendStylesheet($theme . '/' . ltrim($href, '\\/'), $media, $dup);
    return $this;
  }
  
  /**
   * Prepend stylesheet from the public theme directory.
   * @param string $href The url to the stylesheet.
   * @param string $theme The name of the theme, or null to use the current
   * theme.
   * @param string $media The medis type of the stylesheet.
   * @param string $dup What to do with duplicates.
   * @return HeadLink This instance for fluid design.
   */
  public function prependThemeStylesheet($href, $theme=null, $media='', $dup=\ultimo\phptpl\helpers\support\HeadTag::DUP_DISALLOWED) {
    if ($theme === null) {
      $theme = $this->engine->getTheme();
    }
  
    parent::prependStylesheet($theme . '/' . ltrim($href, '\\/'), $media, $dup);
    return $this;
  }
}
<?php
namespace Lcn\IncludeAssetsBundle\Service;

use Lcn\TemplateBlockBundle\Service\TemplateBlock;

class IncludeAssets {

    /**
     * @var array
     */
    protected $positions = array(
        'first',
        'middle',
        'last',
    );

    /**
     * @var array
     */
    protected $assetTypes = array(
        'stylesheet',
        'javascript',
    );

    /**
     * @var array
     */
    protected $stylesheet = array(
        'first' => array(),
        'middle' => array(),
        'last' => array(),
    );

    /**
     * @var array
     */
    protected $javascript = array(
      'first' => array(),
      'middle' => array(),
      'last' => array(),
    );

    /**
     * @var String
     */
    protected $stylesheetLoaderScriptUrl;

    protected $hasAsyncStylesheets = false;

    public function __construct($stylesheetLoaderScriptUrl) {
        $this->stylesheetLoaderScriptUrl = $stylesheetLoaderScriptUrl;
    }

    public function useJavascript($url, $position = 'middle', $async = false) {
        $this->validatePosition($position);

        $this->javascript[$position][] = '<script src="'.$url.'"'.($async ? ' async' : '').'></script>';
    }

    public function useInlineJavascript($code, $position = 'middle') {
        $this->validatePosition($position);

        $this->javascript[$position][] = '<script>'.$code.'</script>';
    }

    /**
     * @deprecated
     * @param $url
     * @param string $position
     * @throws \Exception
     */
    public function useStylesheetAsync($url, $position = 'middle') {
        $this->useStylesheet($url, $position, true);
    }

    public function useStylesheet($url, $position = 'middle', $async = false) {
        $this->validatePosition($position);
        if ($async) {
            $this->hasAsyncStylesheets = true;
            $tag = '<script>lcn_load_stylesheet("'.$url.'");</script>';
        }
        else {
            $tag = '<link rel="stylesheet" href="' . $url . '">';
        }

        $this->stylesheet[$position][] = $tag;
    }

    public function includeAsyncStylesheetLoaderJavascript() {
        if ($this->hasAsyncStylesheets) {
            return '<script src="'.$this->stylesheetLoaderScriptUrl.'"></script>';
        }
    }

    public function includeJavascripts($position = null) {
        return $this->includeAssets('javascript', $position);
    }

    public function includeStylesheets($position = null) {
        return $this->includeAssets('stylesheet', $position);
    }

    protected function includeAssets($assetType, $position = null) {
        $this->validateAssetType($assetType);
        $result = array();

        if ($position) {
            $this->validatePosition($position);

            $positions = array($position);
        }
        else {
            $positions = $this->positions;
        }

        foreach ($positions as $position) {
            $tagsForType = $this->$assetType;
            $tagsForTypeAndPosition = $tagsForType[$position];
            if (!empty($tagsForTypeAndPosition)) {
                $result = array_merge($result, $tagsForTypeAndPosition);
            }
        }

        return implode(PHP_EOL, $result);
    }

    protected function validatePosition($position) {
        if (!in_array($position, $this->positions)) {
            throw new \Exception('Invalid position: '.$position);
        }
    }

    protected function validateAssetType($assetType) {
        if (!in_array($assetType, $this->assetTypes)) {
            throw new \Exception('Invalid asset type: '.$assetType);
        }
    }

}
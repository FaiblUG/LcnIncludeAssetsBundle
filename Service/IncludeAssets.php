<?php
namespace Lcn\IncludeAssetsBundle\Service;

use Lcn\TemplateBlockBundle\Service\TemplateBlock;

class IncludeAssets {

    protected $positions = array(
        'first',
        'middle',
        'last',
    );

    /**
     * @var TemplateBlock
     */
    protected $templateBlock;

    /**
     * @var String
     */
    protected $stylesheetLoaderScriptUrl;

    protected $stylesheetLoaderAdded = false;

    public function __construct(TemplateBlock $templateBlock, $stylesheetLoaderScriptUrl) {
        $this->templateBlock = $templateBlock;
        $this->stylesheetLoaderScriptUrl = $stylesheetLoaderScriptUrl;
    }

    public function useJavascript($url, $position = 'middle') {
        $this->validatePosition($position);
        $blockName = $this->getBlockName('javascript', $position);

        $this->templateBlock->add($blockName, '<script src="'.$url.'"></script>');
    }

    public function useInlineJavascript($code, $position = 'middle') {
        $this->validatePosition($position);
        $blockName = $this->getBlockName('javascript', $position);

        $this->templateBlock->add($blockName, '<script>'.$code.'</script>', false);
    }

    public function useStylesheetAsync($url, $position = 'middle') {
        $this->validatePosition($position);
        $blockName = $this->getBlockName('stylesheet', $position);
        $this->templateBlock->add($blockName, '<script>lcn_load_stylesheet("'.$url.'");</script>');
    }

    protected function getStylesheetLoaderScriptOnce() {
        if (!$this->stylesheetLoaderAdded) {
            $this->stylesheetLoaderAdded = true;

            return '<script src="'.$this->stylesheetLoaderScriptUrl.'"></script>';
        }
    }

    public function includeJavascripts($position = null) {
        return $this->includeAssets('javascript', $position);
    }

    public function includeStylesheets($position = null) {
        return $this->includeAssets('stylesheet', $position);
    }

    protected function includeAssets($type, $position = null) {
        $result = array();

        if ($type === 'stylesheet') {
            $result[] = $this->getStylesheetLoaderScriptOnce();
        }

        if ($position) {
            $this->validatePosition($position);

            $positions = array($position);
        }
        else {
            $positions = $this->positions;
        }

        foreach ($positions as $position) {
            $blockName = $this->getBlockName($type, $position);
            $result[] = $this->templateBlock->get($blockName);
        }

        return implode(PHP_EOL, $result);
    }

    protected function validatePosition($position) {
        if (!in_array($position, $this->positions)) {
            throw new \Exception('Invalid position: '.$position);
        }
    }

    protected function getBlockName($type, $position) {
        return 'lcn_include_assets_'.$type.'_'.$position;
    }

}
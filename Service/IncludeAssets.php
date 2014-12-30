<?php
namespace Lcn\IncludeAssetsBundle\Service;

use Lcn\TemplateBlockBundle\Service\TemplateBlock;

class IncludeAssets {

    private $positions = array(
        'first',
        'middle',
        'last',
    );

    /**
     * @var TemplateBlock
     */
    private $templateBlock;

    public function __construct(TemplateBlock $templateBlock) {
        $this->templateBlock = $templateBlock;
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

    public function useStylesheet($url, $position = 'middle') {
        $this->validatePosition($position);
        $blockName = $this->getBlockName('stylesheet', $position);

        $this->templateBlock->add($blockName, '<link rel="stylesheet" href="'.$url.'" />');
    }

    public function includeJavascripts($position = null) {
        return $this->includeAssets('javascript', $position);
    }

    public function includeStylesheets($position = null) {
        return $this->includeAssets('stylesheet', $position);
    }

    private function includeAssets($type, $position = null) {
        $result = array();
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

    private function validatePosition($position) {
        if (!in_array($position, $this->positions)) {
            throw new \Exception('Invalid position: '.$position);
        }
    }

    private function getBlockName($type, $position) {
        return 'lcn_include_assets_'.$type.'_'.$position;
    }

}
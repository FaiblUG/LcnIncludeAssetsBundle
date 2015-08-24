<?php
namespace Lcn\IncludeAssetsBundle\Twig;

use Lcn\IncludeAssetsBundle\Service\IncludeAssets;

class IncludeAssetsExtension extends \Twig_Extension {

    /**
     * @var IncludeAssets
     */
    private $includeAssets;

    public function __construct(IncludeAssets $includeAssets) {
        $this->includeAssets = $includeAssets;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            'lcn_use_javascript' => new \Twig_Function_Method($this, 'useJavascriptFunction'),
            'lcn_use_inline_javascript' => new \Twig_Function_Method($this, 'useInlineJavascriptFunction'),
            'lcn_use_stylesheet_async' => new \Twig_Function_Method($this, 'useStylesheetAsyncFunction'),
            'lcn_use_stylesheet' => new \Twig_Function_Method($this, 'useStylesheetFunction'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array(
          "lcn_include_assets_available" => true,
        );
    }

    public function useJavascriptFunction($url, $position = 'middle', $async = false) {
        $this->includeAssets->useJavascript($url, $position, $async);
    }

    public function useInlineJavascriptFunction($code, $position = 'middle') {
        $this->includeAssets->useInlineJavascript($code, $position);
    }

    /**
     * @deprecated
     *
     * @param $url
     * @param string $position
     */
    public function useStylesheetAsyncFunction($url, $position = 'middle') {
        $this->includeAssets->useStylesheetAsync($url, $position, true);
    }

    public function useStylesheetFunction($url, $position = 'middle', $async = false) {
        $this->includeAssets->useStylesheet($url, $position, $async);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'lcn_include_assets';
    }
}
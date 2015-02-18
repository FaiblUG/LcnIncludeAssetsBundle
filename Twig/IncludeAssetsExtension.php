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
            'lcn_include_javascripts' => new \Twig_Function_Method($this, 'includeJavascriptsFunction', array('is_safe' => array('html'))),
            'lcn_include_stylesheets' => new \Twig_Function_Method($this, 'includeStylesheetsFunction', array('is_safe' => array('html'))),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array(
          "lcn_include_stylesheets_available" => true,
        );
    }

    public function useJavascriptFunction($url, $position = 'middle') {
        $this->includeAssets->useJavascript($url, $position);
    }

    public function useInlineJavascriptFunction($code, $position = 'middle') {
        $this->includeAssets->useInlineJavascript($code, $position);
    }

    public function useStylesheetAsyncFunction($url, $position = 'middle') {
        $this->includeAssets->useStylesheetAsync($url, $position);
    }

    public function includeJavascriptsFunction($position = null) {
        return $this->includeAssets->includeJavascripts($position);
    }

    public function includeStylesheetsFunction($position = null) {
        return $this->includeAssets->includeStylesheets($position);
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
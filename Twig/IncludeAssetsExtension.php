<?php

namespace Lcn\IncludeAssetsBundle\Twig;

use Lcn\IncludeAssetsBundle\Service\IncludeAssets;

class IncludeAssetsExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var IncludeAssets
     */
    private $includeAssets;

    /**
     * IncludeAssetsExtension constructor.
     *
     * @param IncludeAssets $includeAssets
     */
    public function __construct(IncludeAssets $includeAssets)
    {
        $this->includeAssets = $includeAssets;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('lcn_use_javascript', array($this, 'useJavascriptFunction')),
            new \Twig_SimpleFunction('lcn_use_inline_javascript', array($this, 'useInlineJavascriptFunction')),
            new \Twig_SimpleFunction('lcn_use_stylesheet_async', array($this, 'useStylesheetAsyncFunction')),
            new \Twig_SimpleFunction('lcn_use_stylesheet', array($this, 'useStylesheetFunction')),
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

    /**
     * @param        $url
     * @param string $position
     * @param bool   $async
     */
    public function useJavascriptFunction($url, $position = 'middle', $async = false)
    {
        $this->includeAssets->useJavascript($url, $position, $async);
    }

    /**
     * @param        $code
     * @param string $position
     */
    public function useInlineJavascriptFunction($code, $position = 'middle')
    {
        $this->includeAssets->useInlineJavascript($code, $position);
    }

    /**
     * @deprecated
     *
     * @param $url
     * @param string $position
     */
    public function useStylesheetAsyncFunction($url, $position = 'middle')
    {
        $this->includeAssets->useStylesheetAsync($url, $position, true);
    }

    /**
     * @param        $url
     * @param string $position
     * @param bool   $async
     */
    public function useStylesheetFunction($url, $position = 'middle', $async = false)
    {
        $this->includeAssets->useStylesheet($url, $position, $async);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'lcn_include_assets';
    }
}
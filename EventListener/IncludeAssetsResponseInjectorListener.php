<?php
namespace Lcn\IncludeAssetsBundle\EventListener;

use Lcn\IncludeAssetsBundle\Service\IncludeAssets;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class IncludeAssetsResponseInjectorListener
{

    /**
     * @var IncludeAssets
     */
    private $includeAssets;

    public function __construct(IncludeAssets $includeAssets) {
        $this->includeAssets = $includeAssets;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        if (!$event->isMasterRequest()) {
            return;
        }

        if (!$response->headers->has('Content-Type') || $response->headers->get('Content-Type') === 'text/html') {
            $this->injectAssets($response);
        }
    }

    protected function injectAssets(Response $response) {
        $content = $response->getContent();


        $content = $this->injectAsyncStylesheetLoaderJavascript($content);

        $content = $this->injectStylesheets($content, 'first');

        $content = $this->injectStylesheets($content, 'middle');
        $content = $this->injectStylesheets($content, 'last');
        $content = $this->injectStylesheets($content, null);

        $content = $this->injectJavascripts($content, 'first');
        $content = $this->injectJavascripts($content, 'middle');
        $content = $this->injectJavascripts($content, 'last');
        $content = $this->injectJavascripts($content, null);

        $content = str_replace('###lcn_include_assets_demo#', '###', $content);

        $response->setContent($content);
    }

    protected function injectAsyncStylesheetLoaderJavascript($content) {
        $position = strpos($content, '###lcn_include_stylesheets');

        if ($position !== false) {
            $content = substr_replace($content, $this->includeAssets->includeAsyncStylesheetLoaderJavascript(), $position, 0);
        }

        return $content;
    }

    protected function injectStylesheets($content, $position) {
        if ($position) {
            $pattern = '###lcn_include_stylesheets:' . $position . '###';
        }
        else {
            $pattern = '###lcn_include_stylesheets###';
        }

        if (false !== strpos($content, $pattern)) {
            $content = str_replace($pattern, $this->includeAssets->includeStylesheets($position), $content);
        }

        return $content;
    }

    protected function injectJavascripts($content, $position) {
        if ($position) {
            $pattern = '###lcn_include_javascripts:' . $position . '###';
        }
        else {
            $pattern = '###lcn_include_javascripts###';
        }

        if (false !== strpos($content, $pattern)) {
            $content = str_replace($pattern, $this->includeAssets->includeJavascripts($position), $content);
        }

        return $content;
    }
}
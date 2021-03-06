<?php

namespace Lcn\IncludeAssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DemoController extends Controller
{
    public function indexAction()
    {
        //add stylesheet
        $this->container->get('lcn.include_assets')->useStylesheet('//asset-test.jonasfischer.net/test.css.php?name=test_php.css');

        //add stylesheet with optional position (default = middle)
        $this->container->get('lcn.include_assets')->useStylesheet('//asset-test.jonasfischer.net/test.css.php?name=test_php_last.css', 'last');
        $this->container->get('lcn.include_assets')->useStylesheet('//asset-test.jonasfischer.net/test.css.php?name=test_php_first.css', 'first');
        $this->container->get('lcn.include_assets')->useStylesheet('//asset-test.jonasfischer.net/test.css.php?name=test_php_middle.css', 'middle');

        //add stylesheet async
        $this->container->get('lcn.include_assets')->useStylesheet('//asset-test.jonasfischer.net/test.css.php?name=test_php_last_async.css', 'last', true);



        //add javascript
        $this->container->get('lcn.include_assets')->useJavascript('//asset-test.jonasfischer.net/test.js.php?message=test_php.js');

        //add javascript with optional position (default = middle)
        $this->container->get('lcn.include_assets')->useJavascript('//asset-test.jonasfischer.net/test.js.php?message=test_php_last.js', 'last');
        $this->container->get('lcn.include_assets')->useJavascript('//asset-test.jonasfischer.net/test.js.php?message=test_php_first.js', 'first');
        $this->container->get('lcn.include_assets')->useJavascript('//asset-test.jonasfischer.net/test.js.php?message=test_php_middle.js', 'middle');

        //add javascript async
        $this->container->get('lcn.include_assets')->useJavascript('//asset-test.jonasfischer.net/test.js.php?message=test_php_last_async.js', 'last', true);

        return $this->render('LcnIncludeAssetsBundle:Demo:index.html.twig');
    }
}

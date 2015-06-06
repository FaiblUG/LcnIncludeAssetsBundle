Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require locaine/lcn-include-assets-bundle "~1.1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Lcn\IncludeAssetsBundle\LcnIncludeAssetsBundle(),
        );

        // ...
    }

    // ...
}
```


Step 2: Install Assets
----------------------

    app/console assets:install


Usage
============

layout.html.twig
----------------
In order to be able to add CSS and JS files from within any twig template file, you have to include the assets in your layout.html.twig file:
```tiwg
<html>
<head>
###lcn_include_stylesheets###
...
</head>


###lcn_include_javascripts###
</body>
```

This would include the assets for all positions (first, middle and last).
If you need to include them at different positions within your layout, you can include them seperately:

```tiwg
###lcn_include_stylesheets:first###
###lcn_include_stylesheets:middle###
###lcn_include_stylesheets:last###

###lcn_include_javascripts:first###
###lcn_include_javascripts:middle###
###lcn_include_javascripts:last###
```

PHP
---

Example controller code:

```php
//add stylesheet
$this->container->get('lcn.include_assets')->useStylesheet('/test_php.css');

//add stylesheet with optional position (default = middle)
$this->container->get('lcn.include_assets')->useStylesheet('/test_php_last.css', 'last');
$this->container->get('lcn.include_assets')->useStylesheet('/test_php_first.css', 'first');
$this->container->get('lcn.include_assets')->useStylesheet('/test_php_middle.css', 'middle');

//add stylesheet async
$this->container->get('lcn.include_assets')->useStylesheet('/test_php_last_async.css', 'last', true);


//add javascript
$this->container->get('lcn.include_assets')->useJavascript('/test_php.js');

//add javascript with optional position (default = middle)
$this->container->get('lcn.include_assets')->useJavascript('/test_php_last.js', 'last');
$this->container->get('lcn.include_assets')->useJavascript('/test_php_first.js', 'first');
$this->container->get('lcn.include_assets')->useJavascript('/test_php_middle.js', 'middle');

//add javascript async
$this->container->get('lcn.include_assets')->useJavascript('/test_php_last_async.js', 'last', true);
```

TWIG
----

Example Twig template code:

```tiwg
{# add stylesheet #}
{{ lcn_use_stylesheet('/test_twig.css') }}

{# add stylesheet with asset helper #}
{{ lcn_use_stylesheet(asset('test_twig_asset.css')) }}

{# add stylesheet with optional position (default = middle) #}
{{ lcn_use_stylesheet('/test_twig_first.css', 'first') }}
{{ lcn_use_stylesheet('/test_twig_middle.css', 'middle') }}
{{ lcn_use_stylesheet('/test_twig_last.css', 'last') }}

{# add stylesheet async #}
{{ lcn_use_stylesheet('/test_twig_last_async.css', 'last', true) }}

{# include stylesheets for all positions #}
###lcn_include_stylesheets###

{# include stylesheets for single position #}
###lcn_include_stylesheets:first###


{# add javascript #}
{{ lcn_use_javascript('/test_twig.js') }}

{# add javascript with asset helper #}
{{ lcn_use_javascript(asset('test_twig_asset.js')) }}

{# add javascript with optional position (default = middle) #}
{{ lcn_use_javascript('/test_twig_first.js', 'first') }}
{{ lcn_use_javascript('/test_twig_middle.js', 'middle') }}
{{ lcn_use_javascript('/test_twig_last.js', 'last') }}

{{ lcn_use_inline_javascript("console.log('lcn_use_inline_javascript - last');", 'last') }}

{# include javascripts for all positions #}
###lcn_include_javascripts###

{# include javascripts for single position #}
###lcn_include_javascripts:first###

```

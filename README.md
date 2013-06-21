jQueryMobileMenu
================

zf2 module overrides \Zend\View\Helper\Navigation\Menu to match jQuery mobile navigation



-----
Set up


Install using composer.
---

``` xml
    "require": {
        "wormhit/jQueryMobileMenu": "*"
    },
    "repositories": [
        {
            "type": "git",
            "url":  "https://github.com/wormhit/jQueryMobileMenu.git"
        }
    ]
```

```sh
php composer.phar update
```


application.config
---

``` php

return array(
    'modules' => array(
        //'...',
        'jQueryMobileMenu',
    ),
    //...
);

```



Navigation configuration
---

must be prepared in router config


module/Application/config/

``` php
<?php

return array(
    'navigation' => array(
        'default' => array(
             array(
                 'label' => 'New',
                 'route' => 'transaction',
                 'a_params' => array(
                    'data-transition' => 'slide',
                    'data-icon'       => 'plus',
                 )
             ),
             array(
                 'label' => 'Chart',
                 'route' => 'chart',
                 'data-transition' => 'slide',
                 'a_params' => array(
                    'data-transition' => 'slide',
                    'data-icon'       => 'arrow-u',
                 )
             ),
        )
    )
);
```


Navigation
---

Tell application to use Zend\Navigation.

``` php

return array(
    'service_manager' => array(
        'factories' => array(
            'Navigation'  => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
);

```


Show navigation
---

layout

``` php

<div data-theme="b" data-role="footer" data-position="fixed">
    <div data-role="navbar" data-iconpos="top">
        <?php echo $this->navigation('navigation')->menu() ?>
    </div>
</div>

```


Html output
---

``` html

<ul class="navigation">
    <li class="active">
        <a href="/transaction" data-transition="slide" data-icon="plus">New</a>
    </li>
    <li>
        <a href="/chart" data-transition="slide" data-icon="arrow-u">Chart</a>
    </li>
</ul>

```

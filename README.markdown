Все вопросы в http://zendframework.ru/forum/index.php?topic=4313.msg29127
ЭТОТ БАНДЛ ЯВЛЯЕТЬСЯ ЭКСПЕРЕМЕНТАЛЬНЫМ
======================================================================

JQueryHelperBundle: Added jQuery support to Symfony2
======================================================================

## Installation

### Add JQueryHelperBundle to your src/Bundle dir

    git submodule add git://github.com/naydav/JQueryHelperBundle.git src/WC/JQueryHelperBundle

### Add JQueryHelperBundle to your application kernel

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new WC\JQueryHelperBundle\JQueryHelperBundle(),
            // ...
        );
    }

### Register the WC namespace

    // app/autoload.php
    $loader->registerNamespaces(array(
        'WC'       => __DIR__.'/../src',
        // your other namespaces
    ));

### Update your config

#### Default config

    // \WC\JQueryHelperBundle\JQueryHelperBundle\Resources\config\default.yaml
    enable:             false

    jquery:
      version:          1.5.1
      ssl:              false
      localpath:        false

    jqueryui:
      version:          1.8.11
      ssl:              false
      localpath:        false

    noconflictmode:
      enable:                true
      noConflictModeHandler: '$j'

## Using

### Twig

    {% jquery 'render' %} for generate all javascripts with libraries
    or {% jquery 'renderOnLoad' %} for generate only javascripts without libraries

    OnLoad script capture
    {% block onload %}
        {% jquery 'addOnLoad' %} onLoad javascript {% jquery 'addOnLoadEnd' %}
    {% endblock %}

### Examples

Example 1:
    Config:
        // app/config/config.yml
        j_query_helper:
          enable:             true

          jquery:
            version:          1.5.1

          jqueryui:
            version:          1.8.11

          noconflictmode:
            enable:           true

    Generate:
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
        <script type="text/javascript">var $j = jQuery.noConflict();</script>


Example 2:
    Config:
    // app/config/config.yml
        j_query_helper:
          enable:             true

          jquery:
            version:          1.5.1
            ssl:              true

          jqueryui:
          localpath:          'mypath/jquery.ui.v11.2.js'

          noconflictmode:
            enable:           true
            noConflictModeHandler: '$jq'

    Generate:
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="mypath/jquery.ui.v11.2.js"></script>
        <script type="text/javascript">var $jq = jQuery.noConflict();</script>

Example 3:
    // twig action template
    {% block onload %}
        {% jquery 'addOnLoad' %} $j.wcDashboard(); {% jquery 'addOnLoadEnd' %}
    {% endblock %}

    // twig layout
    {% block onload %}{% endblock %}
    {% jquery 'render' %}

    Generate:
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
        <script type="text/javascript">var $j = jQuery.noConflict();</script>
        <script type="text/javascript">
        //<![CDATA[
        $j(document).ready(function() {
             $j.wcDashboard();
        });
        //]]>
        </script>

### TODO

 -) протестировать

 -) метод __toString для {% jquery %}

 -) разные уровни генерации (генерирует только либы, генерирует только джаваскрипт, генерирует все)

 -) глобальный рефакторинг

-) передачу переменной isXhtml


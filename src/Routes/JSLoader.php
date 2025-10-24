<?php

namespace Tualo\Office\ExtJsDynamic\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\RouteSecurityHelper;
use Tualo\Office\Basic\Route as BasicRoute;
use Tualo\Office\Basic\IRoute;

class JsLoader implements IRoute
{
    public static function register()
    {
        BasicRoute::add('/js-extjs-dynamic/(?P<file>[\w.\/\-]+).js', function ($matches) {
            App::contentType('application/javascript');
            App::resetResult();
            $session = App::get('session');
            $db = $session->getDB();
            if ($matches['file'] . '.js' == 'preload.js') {
                $js = $db->singleValue('select group_concat(sourcecode separator "\n") sourcecode from tualo_dynamic_javascript where preload=1 and active=1', [], 'sourcecode');
                App::body($js);
            } else {
                $matches['file'] .= '.js';
                $js = $db->singleValue('select group_concat(sourcecode separator "\n") sourcecode from tualo_dynamic_javascript where preload=0 and active=1 and id = {file}', $matches, 'sourcecode');
                App::body($js);
            }

            /*
            RouteSecurityHelper::serveSecureStaticFile(
                $matches['file'] . '.js',
                dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'lazy',
                ['js'],
                [
                    'js' => 'application/javascript',

                ]
            );
            */
        }, ['get'], true);
    }
}

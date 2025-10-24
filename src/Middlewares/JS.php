<?php

namespace Tualo\Office\DS\ExtJsDynamic;

use Tualo\Office\Basic\TualoApplication;
use Tualo\Office\Basic\IMiddleware;

class JS implements IMiddleware
{
    public static function register()
    {
        TualoApplication::use('dynamic_javascript', function () {
            try {
                TualoApplication::javascript('dynamic_javascript', './js-extjs-dynamic/preload.js', [], 100000);
            } catch (\Exception $e) {
                TualoApplication::set('maintanceMode', 'on');
                TualoApplication::addError($e->getMessage());
            }
        }, -100); // should be one of the last
    }
}

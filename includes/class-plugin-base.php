<?php

namespace plugin_name\includes;

abstract class Plugin_Base
{
    const DOMAIN = '';

    const NAME = '';

    const SLUG = 'plugin-name';

    const VERSION = '0.1.1'; 

    const ROOT = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . self::SLUG;

    abstract static function onPluginActivation();

    abstract static function onPluginDeactivation();

    abstract public function init();
}
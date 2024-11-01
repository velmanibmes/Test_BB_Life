<?php
/**
 * @license MIT
 *
 * Modified by gravityview on 16-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

spl_autoload_register(function ($class) {
    if (strpos($class, 'GravityKit\\GravityView\\Foundation\\ThirdParty\\Gettext\\') !== 0) {
        return;
    }

    $file = __DIR__.str_replace('\\', DIRECTORY_SEPARATOR, substr($class, strlen('GravityKit\GravityView\Foundation\ThirdParty\Gettext'))).'.php';

    if (is_file($file)) {
        require_once $file;
    }
});

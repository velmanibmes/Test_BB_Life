<?php
/**
 * @license MIT
 *
 * Modified by gravityview on 16-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

use GravityKit\GravityView\Symfony\Component\HttpFoundation\Cookie;

$r = require __DIR__.'/common.inc';

try {
    $r->headers->setCookie(new Cookie('Hello + world', 'hodor', 0, null, null, null, false, true));
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage();
}

<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by gravityview on 16-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace GravityKit\GravityView\Foundation\ThirdParty\Monolog\Handler;

/**
 * Exception can be thrown if an extension for an handler is missing
 *
 * @author  Christian Bergau <cbergau86@gmail.com>
 */
class MissingExtensionException extends \Exception
{
}

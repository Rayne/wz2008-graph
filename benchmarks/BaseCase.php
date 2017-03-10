<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark;

use RuntimeException;

abstract class BaseCase
{
    /**
     * @param $expected
     * @param $actual
     * @throws RuntimeException
     */
    protected function assertSame($expected, $actual)
    {
        if ($expected !== $actual) {
            throw new RuntimeException(sprintf('Expected `%s` but got `%s`.', $expected, $actual));
        }
    }

    /**
     * @param string $file
     * @return string
     */
    protected function getAssetFile($file)
    {
        return dirname(__DIR__) . '/assets/' . $file;
    }
}

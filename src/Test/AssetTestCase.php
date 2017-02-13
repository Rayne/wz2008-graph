<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Test;

use PHPUnit\Framework\TestCase;

/**
 * Don't use this class except when writing unit tests depending on assets.
 *
 * @codeCoverageIgnore
 */
abstract class AssetTestCase extends TestCase
{
    /**
     * @return string
     */
    protected function getAssetDirectory()
    {
        return dirname(dirname(__DIR__)) . '/assets';
    }

    /**
     * @param string $file
     * @return string
     */
    protected function getAssetFile($file)
    {
        return $this->getAssetDirectory() . '/' . $file;
    }
}

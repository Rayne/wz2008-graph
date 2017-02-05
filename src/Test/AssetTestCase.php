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
 */
class AssetTestCase extends TestCase
{
    protected function getAssetFile($file)
    {
        return dirname(dirname(__DIR__)) . '/assets/' . $file;
    }
}

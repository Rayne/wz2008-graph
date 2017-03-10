<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark\Graph;

use Rayne\wz2008\Graph\Benchmark\InitializationCase;

class SimpleXmlInitializationBench extends InitializationCase
{
    /**
     * @inheritdoc
     */
    public function benchInitialization()
    {
        simplexml_load_file($this->getAssetFile('WZ2008-2016-07-29-Classification_(complete).xml'));
    }
}

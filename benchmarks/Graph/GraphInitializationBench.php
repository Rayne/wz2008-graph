<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark\Graph;

use Rayne\wz2008\Graph\Benchmark\InitializationCase;
use Rayne\wz2008\Graph\Factory\WzClassificationFactory;

class GraphInitializationBench extends InitializationCase
{
    /**
     * @inheritdoc
     */
    public function benchInitialization()
    {
        WzClassificationFactory::build();
    }
}

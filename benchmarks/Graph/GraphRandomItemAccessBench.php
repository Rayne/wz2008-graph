<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark\Graph;

use Rayne\wz2008\Graph\Benchmark\RandomItemAccessCase;
use Rayne\wz2008\Graph\Factory\WzClassificationFactory;
use Rayne\wz2008\Graph\WzClassificationInterface;

class GraphRandomItemAccessBench extends RandomItemAccessCase
{
    /**
     * @var WzClassificationInterface
     */
    public $graph;

    /**
     *
     */
    public function __construct()
    {
        $this->graph = WzClassificationFactory::build();
    }

    /**
     * @inheritdoc
     */
    public function benchRandomItemAccess($params)
    {
        $this->assertSame($params['child'], $this->graph->get('id'));
    }
}

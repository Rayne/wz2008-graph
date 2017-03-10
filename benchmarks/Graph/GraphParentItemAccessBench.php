<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark\Graph;

use Rayne\wz2008\Graph\Benchmark\ParentItemAccessCase;
use Rayne\wz2008\Graph\Factory\WzClassificationFactory;
use Rayne\wz2008\Graph\WzClassificationInterface;
use Rayne\wz2008\Graph\WzItemInterface;

class GraphParentItemAccessBench extends ParentItemAccessCase
{
    /**
     * @var null|WzItemInterface
     */
    private $child;

    /**
     * @var WzClassificationInterface
     */
    private $graph;

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
    public function benchColdParentItemAccess(array $params)
    {
        $this->assertSame(
            $params['parent'],
            $this->graph->get($params['child'])->getParent()->getId());
    }

    /**
     * @inheritdoc
     */
    public function beforeWarmParentItemAccess(array $params)
    {
        $this->child = $this->graph->get($params['child']);
    }

    /**
     * @inheritdoc
     */
    public function benchWarmParentItemAccess(array $params)
    {
        $this->assertSame(
            $params['parent'],
            $this->child->getParent()->getId());
    }

    /**
     * @inheritdoc
     */
    public function afterWarmParentItemAccess(array $params)
    {
        $this->child = null;
    }
}

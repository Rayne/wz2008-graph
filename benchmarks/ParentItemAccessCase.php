<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark;

use PhpBench\Benchmark\Metadata\Annotations\AfterMethods;
use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\Groups;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\ParamProviders;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\Warmup;

abstract class ParentItemAccessCase extends BaseCase
{
    /**
     * @return array[]
     */
    public function provideChildAndParentIds()
    {
        return [
            ['child' => '74.10.2', 'parent' => '74.10'],
            ['child' => '74.10', 'parent' => '74.1'],
            ['child' => '74.1', 'parent' => '74'],
            ['child' => '74', 'parent' => 'M'],
        ];
    }

    /**
     * @Groups({"Parent Access"})
     * @ParamProviders({"provideChildAndParentIds"})
     *
     * @Warmup(1)
     * @Revs(33)
     * @Iterations(3)
     *
     * @param array $params
     */
    abstract public function benchColdParentItemAccess(array $params);

    /**
     * @param array $params
     */
    abstract public function beforeWarmParentItemAccess(array $params);

    /**
     * @Groups({"Parent Access"})
     * @ParamProviders({"provideChildAndParentIds"})
     * @BeforeMethods({"beforeWarmParentItemAccess"})
     * @AfterMethods({"afterWarmParentItemAccess"})
     *
     * @Warmup(1)
     * @Revs(33)
     * @Iterations(3)
     *
     * @param array $params
     */
    abstract public function benchWarmParentItemAccess(array $params);

    /**
     * @param array $params
     */
    abstract public function afterWarmParentItemAccess(array $params);
}

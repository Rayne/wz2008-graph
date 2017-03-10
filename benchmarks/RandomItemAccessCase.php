<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark;

use PhpBench\Benchmark\Metadata\Annotations\Groups;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\ParamProviders;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\Warmup;

abstract class RandomItemAccessCase extends BaseCase
{
    /**
     * @Groups({"Random Access"})
     * @ParamProviders({"provideRandomItemAccessIds"})
     *
     * @Warmup(1)
     * @Revs(33)
     * @Iterations(3)
     *
     * @param $params
     */
    abstract public function benchRandomItemAccess($params);

    /**
     * @return array[]
     */
    public function provideRandomItemAccessIds()
    {
        $result = [];

        foreach (range('A', 'U') as $levelOneId) {
            $result[] = ['id' => $levelOneId];
        }

        return $result;
    }
}

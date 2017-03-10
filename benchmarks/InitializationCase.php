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
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\Warmup;

abstract class InitializationCase extends BaseCase
{
    /**
     * @Groups({"Initialization"})
     *
     * @Warmup(1)
     * @Revs(33)
     * @Iterations(3)
     */
    abstract public function benchInitialization();
}

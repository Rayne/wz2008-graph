<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph;

use Countable;

interface WzClassificationInterface extends Countable
{
    /**
     * @param string $id
     * @return null|WzItemInterface The item with ID `$id`.
     */
    public function get($id);

    /**
     * @param int $level
     * @return WzItemInterface[]
     */
    public function getItemsByLevel($level);

    /**
     * @param string $id
     * @return bool
     */
    public function has($id);
}

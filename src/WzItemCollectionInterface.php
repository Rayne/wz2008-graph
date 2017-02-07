<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph;

use ArrayAccess;
use Countable;
use InvalidArgumentException;

/**
 * This `ArrayAccess` implementation only allows `WzItemInterface` values.
 * The keys have to match their item value IDs (`WzItemInterface->getId()`).
 */
interface WzItemCollectionInterface extends ArrayAccess, Countable
{
    /**
     * @param WzItemInterface $item
     * @return $this
     */
    public function add(WzItemInterface $item);

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

    /**
     * @inheritdoc
     * @throws InvalidArgumentException On non-`WzItemInterface` values or mismatching indices.
     */
    public function offsetSet($index, $newval);
}

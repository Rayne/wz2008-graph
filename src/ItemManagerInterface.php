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
 * This `ArrayAccess` implementation only allows `ItemInterface` values.
 * The keys have to match their item value IDs (`ItemInterface->getId()`).
 */
interface ItemManagerInterface extends ArrayAccess, Countable
{
    /**
     * @param ItemInterface $item
     * @return $this
     */
    public function add(ItemInterface $item);

    /**
     * @param string $id
     * @return null|ItemInterface The item with ID `$id`.
     */
    public function get($id);

    /**
     * @param int $level
     * @return ItemInterface[]
     */
    public function getItemsByLevel($level);

    /**
     * @param string $id
     * @return bool
     */
    public function has($id);

    /**
     * @inheritdoc
     * @throws InvalidArgumentException On non `ItemInterface` values or mismatching indices.
     */
    public function offsetSet($index, $newval);
}

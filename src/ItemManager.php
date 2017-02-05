<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph;

use ArrayObject;
use InvalidArgumentException;

class ItemManager extends ArrayObject implements ItemManagerInterface
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public function add(ItemInterface $item)
    {
        $this[$item->getId()] = $item;
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        return $this->has($id) ? $this[$id] : null;
    }

    /**
     * @inheritdoc
     */
    public function getItemsByLevel($level)
    {
        return array_merge(
            array_filter(
                $this->getArrayCopy(),
                function (ItemInterface $item) use ($level) {
                    return $item->getLevel() == $level;
                }));
    }

    /**
     * @inheritdoc
     */
    public function has($id)
    {
        return isset($this[$id]);
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($index, $newval)
    {
        if (!$newval instanceof ItemInterface) {
            throw new InvalidArgumentException(sprintf('Only `%s` objects allowed.', ItemInterface::class));
        }

        if ($index !== $newval->getId()) {
            throw new InvalidArgumentException(sprintf(
                "Key `%s` doesn't match `%s->getId()`: `%s`.",
                $index,
                ItemInterface::class,
                $newval->getId()));
        }

        parent::offsetSet($index, $newval);
    }
}

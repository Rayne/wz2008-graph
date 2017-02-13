<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph;

use InvalidArgumentException;

class WzClassification implements WzClassificationInterface
{
    /**
     * @var WzItemInterface[]
     */
    public $items = [];

    /**
     * @param WzItemInterface[] $items Unordered list of `WzItemInterface` objects.
     * @throws InvalidArgumentException On `$items` which aren't `WzItemInterface` objects.
     */
    public function __construct(array $items)
    {
        foreach ($items as $item) {
            if (!$item instanceof WzItemInterface) {
                throw new InvalidArgumentException(sprintf(
                    'Only `%s` objects are allowed.',
                    WzItemInterface::class));
            }

            $this->items[$item->getId()] = $item;
        }
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        return $this->has($id) ? $this->items[$id] : null;
    }

    /**
     * @param int $level
     * @return WzItemInterface[]
     */
    public function getItemsByLevel($level)
    {
        return array_merge(
            array_filter(
                $this->items,
                function (WzItemInterface $item) use ($level) {
                    return $item->getLevel() == $level;
                }));
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return isset($this->items[$id]);
    }
}

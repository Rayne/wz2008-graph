<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph;

use InvalidArgumentException;
use OutOfBoundsException;
use Rayne\wz2008\Graph\Exception\InvalidParentException;
use SplQueue;

class Item implements ItemInterface
{
    /**
     * @var ItemInterface[]
     */
    private $children = [];

    /**
     * @var string
     */
    private $id;

    /**
     * @var string[]
     */
    private $labels;

    /**
     * @var int
     */
    private $level;

    /**
     * @var ItemInterface|null
     */
    private $parent;

    /**
     * @param string $id
     * @param string[] $labels `Language Code => Translated Label` map.
     * @param int $level
     * @param ItemInterface|null $parent
     */
    public function __construct($id, array $labels, $level, ItemInterface $parent = null)
    {
        $this->id = $id;
        $this->labels = $labels;
        $this->level = (int) $level;
        $this->parent = $parent;

        if ($parent) {
            $parent->addChild($this);
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getLabel($langCode)
    {
        $code = strtolower($langCode);

        if (isset($this->labels[$code])) {
            return $this->labels[$code];
        }

        throw new InvalidArgumentException(sprintf(
            'Unsupported language code `%s`. Supported codes: `%s`.',
            $langCode,
            implode(',', array_keys($this->labels))));
    }

    /**
     * @inheritdoc
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @inheritdoc
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function getParentByLevel($level)
    {
        if (!$this->isInLevelBounds($level)) {
            throw $this->buildLevelOutOfBounds($level);
        }

        if ($level >= $this->getLevel()) {
            return null;
        }

        $parent = $this;

        for ($i = $this->getLevel(); $i > $level; $i--) {
            $parent = $parent->getParent();
        }

        return $parent;
    }

    /**
     * @inheritdoc
     */
    public function addChild(ItemInterface $child)
    {
        if ($child->getParent() !== $this) {
            throw new InvalidParentException(sprintf(
                "The parent of `%s` is invalid. Expected `%s` but got `%s`.",
                $child->getId(),
                $this->getId(),
                $child->getParent() ? $child->getParent()->getId() : ''));
        }

        $this->children[] = $child;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @inheritdoc
     */
    public function getChildrenByLevel($level)
    {
        if (!$this->isInLevelBounds($level)) {
            throw $this->buildLevelOutOfBounds($level);
        }

        if ($this->getLevel() >= $level) {
            return [];
        }

        $result = [];

        $queue = new SplQueue();
        $queue->enqueue($this);

        while (!$queue->isEmpty()) {
            /* @var ItemInterface $item */
            $item = $queue->dequeue();

            if ($item->getLevel() == $level) {
                $result[] = $item;
                continue;
            }

            foreach ($item->getChildren() as $child) {
                $queue->enqueue($child);
            }
        }

        return $result;
    }

    /**
     * @param int $level
     * @return OutOfBoundsException
     */
    private function buildLevelOutOfBounds($level)
    {
        return new OutOfBoundsException(sprintf('Unknown level `%s`.', $level));
    }

    /**
     * @param int $level
     * @return bool
     */
    private function isInLevelBounds($level)
    {
        return self::LEVEL_SECTION <= $level && $level <= self::LEVEL_SUBCLASS;
    }
}

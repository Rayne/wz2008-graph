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

interface WzItemInterface
{
    /**
     * Code for german labels and messages.
     */
    const LANG_DE = 'de';

    /**
     * Code for english labels and messages.
     */
    const LANG_EN = 'en';

    /**
     * Level "Abschnitt".
     */
    const LEVEL_SECTION = 1;

    /**
     * Level "Abteilung".
     */
    const LEVEL_DIVISION = 2;

    /**
     * Level "Gruppe".
     */
    const LEVEL_GROUP = 3;

    /**
     * Level "Klasse".
     */
    const LEVEL_CLASS = 4;

    /**
     * Level "Unterklasse".
     */
    const LEVEL_SUBCLASS = 5;

    /**
     * @param WzItemInterface $child
     * @return $this
     * @throws InvalidParentException When the child's parent isn't the current object.
     */
    public function addChild(WzItemInterface $child);

    /**
     * @return WzItemInterface[]
     */
    public function getChildren();

    /**
     * @param int $level
     * @return WzItemInterface[]
     */
    public function getChildrenByLevel($level);

    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $langCode
     * @return string
     * @throws InvalidArgumentException When `$langCode` isn't supported.
     */
    public function getLabel($langCode);

    /**
     * @return string[] Language code to label mapping.
     */
    public function getLabels();

    /**
     * @return int
     */
    public function getLevel();

    /**
     * @return null|WzItemInterface
     */
    public function getParent();

    /**
     * @param int $level
     * @return null|WzItemInterface
     * @throws OutOfBoundsException
     */
    public function getParentByLevel($level);
}

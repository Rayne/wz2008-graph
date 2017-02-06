<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Parser;

use Rayne\wz2008\Graph\Item;
use Rayne\wz2008\Graph\ItemInterface;
use Rayne\wz2008\Graph\ItemManager;
use Rayne\wz2008\Graph\ItemManagerInterface;
use SimpleXMLElement;

class CompleteClassificationXml
{
    /**
     * @var ItemManagerInterface
     */
    private $records;

    /**
     * @param SimpleXMLElement $xml
     */
    public function __construct(SimpleXMLElement $xml)
    {
        $this->records = new ItemManager;

        /**
         * @var Item[]|null[] $levels
         */
        $levels = [
            0 => null,
            Item::LEVEL_SECTION => null,
            Item::LEVEL_DIVISION => null,
            Item::LEVEL_GROUP => null,
            Item::LEVEL_CLASS => null,
            Item::LEVEL_SUBCLASS => null,
        ];

        foreach ($xml->xpath('//Item') as $xmlItem) {
            $itemId = (string) $xmlItem['id'];
            $itemLevel = (int) $xmlItem['idLevel'];

            $parent = $levels[$itemLevel - 1];
            $current = new Item(
                $itemId,
                $this->buildLabels($xmlItem),
                $itemLevel,
                $parent);

            $this->records->add($current);
            $levels[$itemLevel] = $current;
        }
    }

    /**
     * @param SimpleXMLElement $xmlItem
     * @return string[]
     */
    private function buildLabels(SimpleXMLElement $xmlItem)
    {
        $labels = [];

        foreach ($xmlItem->xpath('Label[@qualifier="Usual"]/LabelText') as $label) {
            $labels[strtolower($label['language'])] = (string) $label;
        }

        return $labels;
    }

    /**
     * @return ItemManagerInterface|ItemInterface[] `ID` to `Item` map.
     */
    public function getRecords()
    {
        return $this->records;
    }
}

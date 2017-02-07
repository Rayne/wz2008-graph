<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Parser;

use Rayne\wz2008\Graph\WzItem;
use Rayne\wz2008\Graph\WzItemInterface;
use Rayne\wz2008\Graph\WzItemCollection;
use Rayne\wz2008\Graph\WzItemCollectionInterface;
use SimpleXMLElement;

class WzClassification
{
    /**
     * @var WzItemCollectionInterface
     */
    private $records;

    /**
     * @param SimpleXMLElement $xml
     */
    public function __construct(SimpleXMLElement $xml)
    {
        $this->records = new WzItemCollection;

        /**
         * @var WzItem[]|null[] $levels
         */
        $levels = [
            0 => null,
            WzItem::LEVEL_SECTION => null,
            WzItem::LEVEL_DIVISION => null,
            WzItem::LEVEL_GROUP => null,
            WzItem::LEVEL_CLASS => null,
            WzItem::LEVEL_SUBCLASS => null,
        ];

        foreach ($xml->xpath('//Item') as $xmlItem) {
            $itemId = (string) $xmlItem['id'];
            $itemLevel = (int) $xmlItem['idLevel'];

            $parent = $levels[$itemLevel - 1];
            $current = new WzItem(
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
     * @return WzItemCollectionInterface|WzItemInterface[] `ID` to `WzItem` map.
     */
    public function getRecords()
    {
        return $this->records;
    }
}

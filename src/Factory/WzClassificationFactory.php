<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Factory;

use InvalidArgumentException;
use Rayne\wz2008\Graph\WzClassification;
use Rayne\wz2008\Graph\WzClassificationInterface;
use Rayne\wz2008\Graph\WzItem;
use Rayne\wz2008\Graph\WzItemInterface;
use SimpleXMLElement;

class WzClassificationFactory
{
    /**
     * The supplied and default classification file.
     */
    const SUPPLIED_CLASSIFICATION_FILE = 'WZ2008-2019-07-31-Classification_(complete).xml';

    /**
     * @return WzClassificationInterface The classification based upon the included `/assets/WZ2008*xml` file.
     * @throws InvalidArgumentException Unreadable or invalid file.
     */
    public static function build()
    {
        return self::buildFromFile(__DIR__ . '/../../assets/' . self::SUPPLIED_CLASSIFICATION_FILE);
    }

    /**
     * @param string $xmlFile
     * @return WzClassificationInterface
     * @throws InvalidArgumentException Unreadable or invalid file.
     */
    public static function buildFromFile($xmlFile)
    {
        $xml = @simplexml_load_file($xmlFile);

        if (!$xml) {
            throw new InvalidArgumentException(
                sprintf("Invalid XML file `%s`.", $xmlFile)
            );
        }

        return self::buildFromXml($xml);
    }

    /**
     * @param SimpleXMLElement $xml
     * @return WzClassificationInterface
     */
    public static function buildFromXml(SimpleXMLElement $xml)
    {
        return new WzClassification(self::buildItems($xml));
    }

    /**
     * @param SimpleXMLElement $xml
     * @return WzItemInterface[]
     */
    private static function buildItems(SimpleXMLElement $xml)
    {
        $items = [];

        /**
         * @var WzItemInterface[]|null[] $levels
         */
        $levels = [
            0 => null,
            WzItemInterface::LEVEL_SECTION => null,
            WzItemInterface::LEVEL_DIVISION => null,
            WzItemInterface::LEVEL_GROUP => null,
            WzItemInterface::LEVEL_CLASS => null,
            WzItemInterface::LEVEL_SUBCLASS => null,
        ];

        foreach ($xml->xpath('//Item') as $xmlItem) {
            $itemId = (string)$xmlItem['id'];
            $itemLevel = (int)$xmlItem['idLevel'];

            $parent = $levels[$itemLevel - 1];
            $current = new WzItem(
                $itemId,
                self::buildLabels($xmlItem),
                $itemLevel,
                $parent
            );

            $items[] = $current;
            $levels[$itemLevel] = $current;
        }

        return $items;
    }

    /**
     * @param SimpleXMLElement $xmlItem
     * @return string[]
     */
    private static function buildLabels(SimpleXMLElement $xmlItem)
    {
        $labels = [];

        foreach ($xmlItem->xpath('Label[@qualifier="Usual"]/LabelText') as $label) {
            $labels[strtolower($label['language'])] = (string)$label;
        }

        return $labels;
    }
}

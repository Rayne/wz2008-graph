<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Factory;

use InvalidArgumentException;
use Rayne\wz2008\Graph\Test\AssetTestCase;
use Rayne\wz2008\Graph\WzItemInterface;

class WzClassificationFactoryTest extends AssetTestCase
{
    public function provideInvalidXmlFile()
    {
        return [
            [$this->getAssetDirectory()],
            [$this->getAssetFile('invalid.xml')],
            [$this->getAssetFile('cover-image.png')],
        ];
    }

    /**
     * @dataProvider provideInvalidXmlFile
     * @param string $file
     */
    public function testInvalidXmlFile($file)
    {
        try {
            WzClassificationFactory::buildFromFile($file);
            $this->fail();
        } catch (InvalidArgumentException $e) {
            $this->assertSame(sprintf('Invalid XML file `%s`.', $file), $e->getMessage());
        }
    }

    public function testDefaultClassification()
    {
        WzClassificationFactory::build();
    }

    public function testDefaultClassification_Count()
    {
        $classification = WzClassificationFactory::build();
        $this->assertSame(1835, $classification->count());
    }

    public function testDefaultClassification_ItemWithoutChildren()
    {
        $classification = WzClassificationFactory::build();
        $id = '74.10.2';

        $this->assertTrue($classification->has($id));
        $item = $classification->get($id);
        $this->assertInstanceOf(WzItemInterface::class, $item);

        $this->assertSame($id, $item->getId());
        $this->assertSame('Grafik- und Kommunikationsdesign', $item->getLabel('de'));
        $this->assertSame(5, $item->getLevel());

        $this->assertCount(0, $item->getChildren());
        $this->assertCount(0, $item->getChildrenByLevel($item::LEVEL_SECTION));
        $this->assertCount(0, $item->getChildrenByLevel($item::LEVEL_SUBCLASS));
    }

    public function testDefaultClassification_Children()
    {
        $classification = WzClassificationFactory::build();
        $id = '74.10';

        $this->assertTrue($classification->has($id));
        $item = $classification->get($id);
        $this->assertInstanceOf(WzItemInterface::class, $item);

        $this->assertSame($id, $item->getId());
        $this->assertSame('Ateliers für Textil-, Schmuck-, Grafik- u. ä. Design', $item->getLabel('de'));
        $this->assertSame($item::LEVEL_CLASS, $item->getLevel());
        $this->assertCount(3, $item->getChildren());

        $this->assertCount(0, $item->getChildrenByLevel($item::LEVEL_SECTION));
        $this->assertCount(0, $item->getChildrenByLevel($item::LEVEL_DIVISION));
        $this->assertCount(0, $item->getChildrenByLevel($item::LEVEL_GROUP));
        $this->assertCount(0, $item->getChildrenByLevel($item::LEVEL_CLASS));
        $this->assertCount(3, $item->getChildrenByLevel($item::LEVEL_SUBCLASS));

        $this->assertSame(
            $item->getChildren(),
            $item->getChildrenByLevel($item::LEVEL_SUBCLASS));

        $this->assertSame('74.10.1', $item->getChildren()[0]->getId());
        $this->assertSame('74.10.2', $item->getChildren()[1]->getId());
        $this->assertSame('74.10.3', $item->getChildren()[2]->getId());

        foreach ($item->getChildren() as $child) {
            $this->assertSame($item::LEVEL_SUBCLASS, $child->getLevel());
            $this->assertSame($item, $child->getParent());
        }
    }

    public function testDefaultClassification_Parents()
    {
        $classification = WzClassificationFactory::build();
        $id = '74.10.2';

        $this->assertTrue($classification->has($id));
        $item = $classification->get($id);
        $this->assertInstanceOf(WzItemInterface::class, $item);

        $this->assertSame($id, $item->getId());
        $this->assertSame(5, $item->getLevel());
        $this->assertSame('Grafik- und Kommunikationsdesign', $item->getLabel('de'));

        $this->assertNull($item->getParentByLevel(WzItemInterface::LEVEL_SUBCLASS));

        $parent = $item->getParentByLevel(WzItemInterface::LEVEL_CLASS);

        $this->assertSame('74.10', $parent->getId());
        $this->assertSame(4, $parent->getLevel());
        $this->assertSame(
            'Ateliers für Textil-, Schmuck-, Grafik- u. ä. Design',
            $parent->getLabel('de'));

        $parent = $item->getParentByLevel(WzItemInterface::LEVEL_GROUP);

        $this->assertSame('74.1', $parent->getId());
        $this->assertSame(3, $parent->getLevel());
        $this->assertSame(
            'Ateliers für Textil-, Schmuck-, Grafik- u. ä. Design',
            $parent->getLabel('de'));

        $parent = $item->getParentByLevel(WzItemInterface::LEVEL_DIVISION);

        $this->assertSame('74', $parent->getId());
        $this->assertSame(2, $parent->getLevel());
        $this->assertSame(
            'Sonstige freiberufliche, wissenschaftliche und technische Tätigkeiten',
            $parent->getLabel('de'));

        $parent = $item->getParentByLevel(WzItemInterface::LEVEL_SECTION);

        $this->assertSame('M', $parent->getId());
        $this->assertSame(1, $parent->getLevel());
        $this->assertSame(
            'Erbringung von freiberuflichen, wissenschaftlichen und technischen Dienstleistungen',
            $parent->getLabel('de'));
    }
}

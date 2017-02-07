<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Parser;

use InvalidArgumentException;
use Rayne\wz2008\Graph\WzItemInterface;
use Rayne\wz2008\Graph\Test\AssetTestCase;

class WzClassificationFileTest extends AssetTestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidFile()
    {
        new WzClassificationFile(__DIR__);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidFileFormat()
    {
        new WzClassificationFile($this->getAssetFile('invalid.xml'));
    }

    public function testSize()
    {
        $file = $this->getAssetFile('WZ2008-2016-07-29-Classification_(complete).xml');

        $parser = new WzClassificationFile($file);

        $this->assertCount(1835, $parser->getRecords());
    }

    public function testItemWithoutChildren()
    {
        $file = $this->getAssetFile('WZ2008-2016-07-29-Classification_(complete).xml');

        $parser = new WzClassificationFile($file);

        $t = $parser->getRecords()['74.10.2'];

        $this->assertSame('Grafik- und Kommunikationsdesign', $t->getLabel('de'));
        $this->assertSame(5, $t->getLevel());

        $this->assertCount(0, $t->getChildren());
        $this->assertCount(0, $t->getChildrenByLevel($t::LEVEL_SECTION));
        $this->assertCount(0, $t->getChildrenByLevel($t::LEVEL_SUBCLASS));
    }

    public function testChildren()
    {
        $file = $this->getAssetFile('WZ2008-2016-07-29-Classification_(complete).xml');

        $parser = new WzClassificationFile($file);

        $current = $parser->getRecords()['74.10'];

        $this->assertSame('Ateliers für Textil-, Schmuck-, Grafik- u. ä. Design', $current->getLabel('de'));
        $this->assertSame($current::LEVEL_CLASS, $current->getLevel());
        $this->assertCount(3, $current->getChildren());

        $this->assertCount(0, $current->getChildrenByLevel($current::LEVEL_SECTION));
        $this->assertCount(0, $current->getChildrenByLevel($current::LEVEL_DIVISION));
        $this->assertCount(0, $current->getChildrenByLevel($current::LEVEL_GROUP));
        $this->assertCount(0, $current->getChildrenByLevel($current::LEVEL_CLASS));
        $this->assertCount(3, $current->getChildrenByLevel($current::LEVEL_SUBCLASS));

        $this->assertSame(
            $current->getChildren(),
            $current->getChildrenByLevel($current::LEVEL_SUBCLASS));

        $this->assertSame('74.10.1', $current->getChildren()[0]->getId());
        $this->assertSame('74.10.2', $current->getChildren()[1]->getId());
        $this->assertSame('74.10.3', $current->getChildren()[2]->getId());

        foreach ($current->getChildren() as $child) {
            $this->assertSame($current::LEVEL_SUBCLASS, $child->getLevel());
            $this->assertSame($current, $child->getParent());
        }
    }

    public function testParents()
    {
        $file = $this->getAssetFile('WZ2008-2016-07-29-Classification_(complete).xml');

        $parser = new WzClassificationFile($file);

        $t = $parser->getRecords()['74.10.2'];

        $this->assertSame('Grafik- und Kommunikationsdesign', $t->getLabel('de'));
        $this->assertSame(5, $t->getLevel());

        $this->assertNull($t->getParentByLevel(WzItemInterface::LEVEL_SUBCLASS));

        $p = $t->getParentByLevel(WzItemInterface::LEVEL_CLASS);

        $this->assertSame('74.10', $p->getId());
        $this->assertSame(4, $p->getLevel());
        $this->assertSame('Ateliers für Textil-, Schmuck-, Grafik- u. ä. Design', $p->getLabel('de'));

        $p = $t->getParentByLevel(WzItemInterface::LEVEL_GROUP);

        $this->assertSame('74.1', $p->getId());
        $this->assertSame(3, $p->getLevel());
        $this->assertSame('Ateliers für Textil-, Schmuck-, Grafik- u. ä. Design', $p->getLabel('de'));

        $p = $t->getParentByLevel(WzItemInterface::LEVEL_DIVISION);

        $this->assertSame('74', $p->getId());
        $this->assertSame(2, $p->getLevel());
        $this->assertSame('Sonstige freiberufliche, wissenschaftliche und technische Tätigkeiten', $p->getLabel('de'));

        $p = $t->getParentByLevel(WzItemInterface::LEVEL_SECTION);

        $this->assertSame('M', $p->getId());
        $this->assertSame(1, $p->getLevel());
        $this->assertSame('Erbringung von freiberuflichen, wissenschaftlichen und technischen Dienstleistungen', $p->getLabel('de'));
    }
}

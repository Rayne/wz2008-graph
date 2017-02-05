<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ItemManagerTest extends TestCase
{
    public function test()
    {
        $manager = new ItemManager;
        $item = new Item('item', [], 1, null);

        $this->assertFalse($manager->has($item->getId()));
        $this->assertNull($manager->get($item->getId()));

        $manager->add($item);

        $this->assertTrue($manager->has($item->getId()));
        $this->assertSame($item, $manager->get($item->getId()));
        $this->assertSame($item, $manager[$item->getId()]);
    }

    public function testInvalidValue()
    {
        try {
            $manager = new ItemManager;
            $manager['A'] = 'INVALID';
            $this->fail();
        } catch (InvalidArgumentException $e) {
            $this->assertSame(
                'Only `Rayne\wz2008\Graph\ItemInterface` objects allowed.',
                $e->getMessage());
        }
    }

    public function testInvalidKey()
    {
        try {
            $manager = new ItemManager;
            $manager['Z'] = (new Item('A', [], 1, null));
            $this->fail();
        } catch (InvalidArgumentException $e) {
            $this->assertSame(
                'Key `Z` doesn\'t match `Rayne\wz2008\Graph\ItemInterface->getId()`: `A`.',
                $e->getMessage());
        }
    }

    public function testGetItemsByLevel()
    {
        $manager = new ItemManager;

        $manager->add(new Item('1', [], 1, null));
        $manager->add(new Item('11', [], 2, $manager['1']));
        $manager->add(new Item('12', [], 2, $manager['1']));
        $manager->add(new Item('121', [], 3, $manager['12']));
        $manager->add(new Item('13', [], 2, $manager['1']));

        $this->assertSame([
            $manager['1'],
        ], $manager->getItemsByLevel(1));

        $this->assertEquals([
            $manager['11'],
            $manager['12'],
            $manager['13'],
        ], $manager->getItemsByLevel(2));

        $this->assertSame([
            $manager['121'],
        ], $manager->getItemsByLevel(3));

        $this->assertCount(0, $manager->getItemsByLevel(4));
    }
}

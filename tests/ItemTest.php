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
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    /**
     * Provides the following map:
     *
     * ```
     * LEVEL 1: "A", "Land- und Forstwirtschaft, Fischerei"
     * LEVEL 2: → "01", "Landwirtschaft, Jagd und damit verbundene Tätigkeiten"
     * LEVEL 3: → → "01.1", "Anbau einjähriger Pflanzen"
     * LEVEL 4: → → → "01.11", "Anbau von Getreide (ohne Reis), Hülsenfrüchten und Ölsaaten"
     * LEVEL 5: → → → → "01.11.0", "Anbau von Getreide (ohne Reis), Hülsenfrüchten und Ölsaaten"
     * LEVEL 4: → → → "01.12", "Anbau von Reis"
     * LEVEL 5: → → → → "01.12.0", "Anbau von Reis"
     * ```
     *
     * @return array[]
     */
    public function provideMap()
    {
        $map = [];

        $map['A'] = new Item(
            'A',
            ['de' => 'Land- und Forstwirtschaft, Fischerei'],
            1,
            null
        );

        $map['01'] = new Item(
            '01',
            ['de' => 'Landwirtschaft, Jagd und damit verbundene Tätigkeiten'],
            2,
            $map['A']
        );

        $map['01.1'] = new Item(
            '01.1',
            ['de' => 'Anbau einjähriger Pflanzen'],
            3,
            $map['01']
        );

        $map['01.11'] = new Item(
            '01.11',
            ['de' => 'Anbau von Getreide (ohne Reis), Hülsenfrüchten und Ölsaaten'],
            4,
            $map['01.1']
        );

        $map['01.11.0'] = new Item(
            '01.11.0',
            ['de' => 'Anbau von Getreide (ohne Reis), Hülsenfrüchten und Ölsaaten'],
            5,
            $map['01.11']
        );

        $map['01.12'] = new Item(
            '01.12',
            ['de' => 'Anbau von Reis'],
            4,
            $map['01.1']
        );

        $map['01.12.0'] = new Item(
            '01.12.0',
            ['de' => 'Anbau von Reis'],
            5,
            $map['01.12']
        );

        $map['A']->addChild($map['01']);
        $map['01']->addChild($map['01.1']);
        $map['01.1']->addChild($map['01.11']);
        $map['01.1']->addChild($map['01.12']);
        $map['01.11']->addChild($map['01.11.0']);
        $map['01.12']->addChild($map['01.12.0']);

        return [[$map]];
    }

    /**
     * @dataProvider provideMap
     * @param Item[] $map
     */
    public function testParentFunctions(array $map)
    {
        $this->assertNull($map['A']->getParent());
        $this->assertNull($map['A']->getParentByLevel(1));
        $this->assertNull($map['A']->getParentByLevel(2));
        $this->assertNull($map['A']->getParentByLevel(3));
        $this->assertNull($map['A']->getParentByLevel(4));
        $this->assertNull($map['A']->getParentByLevel(5));

        $this->assertSame($map['A'], $map['01.11.0']->getParentByLevel(1));
        $this->assertSame($map['01'], $map['01.11.0']->getParentByLevel(2));
        $this->assertSame($map['01.1'], $map['01.11.0']->getParentByLevel(3));
        $this->assertSame($map['01.11'], $map['01.11.0']->getParentByLevel(4));
        $this->assertSame(null, $map['01.11.0']->getParentByLevel(5));

        $this->assertSame(
            $map['01.11'],
            $map['01.11.0']
                ->getParent());

        $this->assertSame(
            $map['01.1'],
            $map['01.11.0']
                ->getParent()
                ->getParent());

        $this->assertSame(
            $map['01'],
            $map['01.11.0']
                ->getParent()
                ->getParent()
                ->getParent());

        $this->assertSame(
            $map['A'],
            $map['01.11.0']
                ->getParent()
                ->getParent()
                ->getParent()
                ->getParent());
    }

    /**
     * @dataProvider provideMap
     * @param Item[] $map
     */
    public function testChildrenFunctions(array $map)
    {
        $this->assertCount(1, $map['A']->getChildren());
        $this->assertCount(1, $map['01']->getChildren());
        $this->assertCount(2, $map['01.1']->getChildren());
        $this->assertCount(1, $map['01.11']->getChildren());
        $this->assertCount(1, $map['01.12']->getChildren());

        $this->assertSame([$map['01']], $map['A']->getChildren());

        $this->assertSame([], $map['A']->getChildrenByLevel(1));

        $this->assertSame(
            [
                $map['01'],
            ],
            $map['A']->getChildrenByLevel(2));

        $this->assertSame(
            [
                $map['01.1'],
            ],
            $map['A']->getChildrenByLevel(3));

        $this->assertSame(
            [
                $map['01.11'],
                $map['01.12'],
            ],
            $map['A']->getChildrenByLevel(4));

        $this->assertSame(
            [
                $map['01.11.0'],
                $map['01.12.0'],
            ],
            $map['A']->getChildrenByLevel(5));
    }

    public function testChildrenOutOfBounds()
    {
        $item = new Item(
            'A',
            [],
            1,
            null
        );

        try {
            $item->getChildrenByLevel(0);
            $this->fail();
        } catch (OutOfBoundsException $e) {
            $this->assertSame('Unknown level `0`.', $e->getMessage());
        }

        try {
            $item->getChildrenByLevel(6);
            $this->fail();
        } catch (OutOfBoundsException $e) {
            $this->assertSame('Unknown level `6`.', $e->getMessage());
        }
    }

    public function testParentOutOfBounds()
    {
        $item = new Item(
            'A',
            [],
            1,
            null
        );

        try {
            $item->getParentByLevel(0);
            $this->fail();
        } catch (OutOfBoundsException $e) {
            $this->assertSame('Unknown level `0`.', $e->getMessage());
        }

        try {
            $item->getParentByLevel(6);
            $this->fail();
        } catch (OutOfBoundsException $e) {
            $this->assertSame('Unknown level `6`.', $e->getMessage());
        }
    }

    public function testId()
    {
        $this->assertSame('A', (new Item(
            'A',
            [],
            1,
            null
        ))->getId());
    }

    public function testLabel()
    {
        $item = new Item(
            'A',
            [
                'de' => 'Hallo Welt',
                'en' => 'Hello World'
            ],
            1,
            null
        );

        $this->assertSame('Hallo Welt', $item->getLabel('DE'));
        $this->assertSame('Hallo Welt', $item->getLabel('de'));

        $this->assertSame('Hello World', $item->getLabel('EN'));
        $this->assertSame('Hello World', $item->getLabel('en'));

        $this->assertSame([
            'de' => 'Hallo Welt',
            'en' => 'Hello World',
        ], $item->getLabels());

        try {
            $item->getLabel('fr');
            $this->fail();
        } catch (InvalidArgumentException $e) {
            $this->assertSame(
                'Unsupported language code `fr`. Supported codes: `de,en`.',
                $e->getMessage());
        }
    }

    public function testAddChild()
    {
        $parent = new Item(
            'P',
            [],
            1,
            null
        );

        $childA = new Item(
            'A',
            [],
            2,
            $parent
        );

        $childB = new Item(
            'B',
            [],
            2,
            $parent
        );

        $parent->addChild($childA);
        $this->assertSame([$childA], $parent->getChildren());

        $parent->addChild($childB);
        $this->assertSame([$childA, $childB], $parent->getChildren());
    }
}

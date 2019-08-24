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

class WzClassificationTest extends TestCase
{
    public function testHasAndGetAndCount()
    {
        $item = new WzItem('A', [], 1, null);

        $classification = new WzClassification([
            $item,
        ]);

        $this->assertTrue($classification->has('A'));
        $this->assertSame($item, $classification->get('A'));

        $this->assertFalse($classification->has('a'));
        $this->assertSame(1, $classification->count());
    }

    public function testGetItemsByLevel()
    {
        $items = [];
        $items['1'] = new WzItem('1', [], 1, null);
        $items['11'] = new WzItem('11', [], 2, $items['1']);
        $items['12'] = new WzItem('12', [], 2, $items['1']);
        $items['121'] = new WzItem('121', [], 3, $items['12']);
        $items['13'] = new WzItem('13', [], 2, $items['1']);

        $classification = new WzClassification($items);

        $this->assertSame([
            $items['1'],
        ], $classification->getItemsByLevel(1));

        $this->assertEquals([
            $items['11'],
            $items['12'],
            $items['13'],
        ], $classification->getItemsByLevel(2));

        $this->assertSame([
            $items['121'],
        ], $classification->getItemsByLevel(3));

        $this->assertCount(0, $classification->getItemsByLevel(4));
    }

    public function testInvalidInput()
    {
        try {
            new WzClassification([
                'Hello World',
            ]);

            $this->fail();
        } catch (InvalidArgumentException $e) {
            $this->assertSame(
                sprintf('Only `%s` objects are allowed.', WzItemInterface::class),
                $e->getMessage()
            );
        }
    }
}

<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark\Graph;

use Rayne\wz2008\Graph\Benchmark\RandomItemAccessCase;
use SimpleXMLElement;

class SimpleXmlRandomItemAccessBench extends RandomItemAccessCase
{
    /**
     * @var SimpleXMLElement
     */
    public $xml;

    /**
     *
     */
    public function __construct()
    {
        $this->xml = simplexml_load_file($this->getAssetFile('WZ2008-2016-07-29-Classification_(complete).xml'));
    }

    /**
     * @inheritdoc
     */
    public function benchRandomItemAccess($params)
    {
        $child = $this->xml->xpath('//Item[@id="' . $params['id'] . '"][1]')[0];

        $this->assertSame($params['id'], (string) $child['id']);
    }
}

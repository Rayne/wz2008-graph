<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Benchmark\Graph;

use Rayne\wz2008\Graph\Benchmark\ParentItemAccessCase;
use Rayne\wz2008\Graph\Factory\WzClassificationFactory;
use SimpleXMLElement;

class SimpleXmlParentItemAccessBench extends ParentItemAccessCase
{
    /**
     * @var null|SimpleXMLElement
     */
    private $child;

    /**
     * @var SimpleXMLElement
     */
    private $xml;

    /**
     *
     */
    public function __construct()
    {
        $this->xml = simplexml_load_file($this->getAssetFile(WzClassificationFactory::SUPPLIED_CLASSIFICATION_FILE));
    }

    /**
     * @inheritdoc
     */
    public function benchColdParentItemAccess(array $params)
    {
        $child = $this->xml->xpath('//Item[@id="' . $params['child'] . '"][1]')[0];
        $parentLevel = $child['idLevel'] - 1;
        $parent = $child->xpath('preceding-sibling::Item[@idLevel="' . $parentLevel . '"][1]')[0];

        $this->assertSame($params['parent'], (string)$parent['id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeWarmParentItemAccess(array $params)
    {
        $this->child = $this->xml->xpath('//Item[@id="' . $params['child'] . '"][1]')[0];
    }

    /**
     * @inheritdoc
     */
    public function benchWarmParentItemAccess(array $params)
    {
        $child = $this->child;
        $parentLevel = $child['idLevel'] - 1;
        $parent = $child->xpath('preceding-sibling::Item[@idLevel="' . $parentLevel . '"][1]')[0];

        $this->assertSame($params['parent'], (string)$parent['id']);
    }

    /**
     * @inheritdoc
     */
    public function afterWarmParentItemAccess(array $params)
    {
        $this->child = null;
    }
}

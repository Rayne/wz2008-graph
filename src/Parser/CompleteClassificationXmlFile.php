<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\wz2008\Graph\Parser;

use InvalidArgumentException;

class CompleteClassificationXmlFile extends CompleteClassificationXml
{
    /**
     * @param string $xmlFile
     * @throws InvalidArgumentException Unreadable or invalid file.
     */
    public function __construct($xmlFile)
    {
        if (!is_file($xmlFile) || !is_readable($xmlFile)) {
            throw new InvalidArgumentException(
                sprintf("Can't read file `%s`.", $xmlFile));
        }

        $xml = @simplexml_load_file($xmlFile);

        if (!$xml) {
            throw new InvalidArgumentException(
                sprintf("Invalid XML file `%s`.", $xmlFile));
        }

        parent::__construct($xml);
    }
}

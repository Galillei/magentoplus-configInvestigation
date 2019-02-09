<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 2019-02-04
 * Time: 10:20
 */

namespace MagentoPlus\ConfigInvestigation\Test\Unit\Model\Config;

use Magento\Framework\Config\ValidationStateInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class MergeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ValidationStateInterface
     */
    protected $validationStateMock;
    /**
     * @var array
     */
    protected $idAttributes;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->validationStateMock = $this->getMockBuilder(
            '\Magento\Framework\Config\ValidationStateInterface'
                                     )->disableOriginalConstructor()
                                      ->getMock();
        
        $this->validationStateMock->method('isValidationRequired')
            ->willReturn(true);
        $this->idAttributes = [
            '/config/map' => 'name',
            '/config/map/item' => 'name'
        ];
    }

    public function testMerge()
    {
        $xml = file_get_contents(__DIR__ . '/_files/ro_import_map.xml');
        $xml_merge = file_get_contents(__DIR__ . '/_files/ro_import_map_merge.xml');
        $config = new \Magento\Framework\Config\Dom($xml, $this->validationStateMock, $this->idAttributes);
        $config->merge($xml_merge);
    }
}

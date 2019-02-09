<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 2019-01-31
 * Time: 18:45
 */
declare(strict_types=1);
namespace MagentoPlus\ConfigInvestigation\Test\Unit\Model\Config;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use MagentoPlus\ConfigInvestigation\Model\Config\Converter;

class ConverterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    private $validationStateMock;
    private $idAttributes = [];

    public function testConvert()
    {
        $xml = file_get_contents(__DIR__ . '/_files/ro_import_map.xml');
        $xml_merge = file_get_contents(__DIR__ . '/_files/ro_import_map_merge.xml');
        $expectResult = require __DIR__ . '/_files/result.php';
        $config = new \Magento\Framework\Config\Dom($xml, $this->validationStateMock, $this->idAttributes);
        $config->merge($xml_merge);
        /**
         * @var Converter $converter
         */
        $converter = $this->objectManager->getObject(Converter::class);
        $result = $converter->convert($config->getDom());
        $this->assertEquals($expectResult, $result);
    }

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->validationStateMock  = $this->getMockBuilder(\Magento\Framework\Config\ValidationStateInterface::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $this->idAttributes = [
            '/config/map' => 'name',
            '/config/map/item' => 'name'
        ];
    }
}

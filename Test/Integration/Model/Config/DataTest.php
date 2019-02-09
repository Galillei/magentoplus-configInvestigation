<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 2019-02-05
 * Time: 10:04
 */

namespace MagentoPlus\ConfigInvestigation\Test\Integration\Model\Config;

use Magento\TestFramework\ObjectManager;
use MagentoPlus\ConfigInvestigation\Model\Config\Data;


/**
 * @magentoCache config disabled
 */
class DataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var  ObjectManager
     */
    private $objectManager;
    /**
     * @var Data
     */
    private $model;

    protected function setUp()
    {
        /**
        * @var ObjectManager
        **/
        $this->objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $this->model = $this->objectManager->create(Data::class);
    }

    /**
     * @magentoCache config disabled
     */
    public function testConfig()
    {
       $additionalAttributes = $this->model->get('additionalAttributes');
       $this->assertEquals(1, \count($additionalAttributes));
       $this->assertTrue(is_array($additionalAttributes));
       $this->assertEquals('ro_sku', \array_pop($additionalAttributes));
    }
}

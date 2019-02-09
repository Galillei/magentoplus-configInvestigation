<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 2019-01-30
 * Time: 10:01
 */

namespace MagentoPlus\ConfigInvestigation\Model\Config;

class SchemaLocator implements \Magento\Framework\Config\SchemaLocatorInterface
{
    const CONFIG_FILE_SCHEMA = 'ro_import_map.xsd';
    private $schema = null;
    private $perFileSchema = null;

    /**
     * Get path to merged config schema
     *
     * @return string|null
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * SchemaLocator constructor.
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     */
    public function __construct(\Magento\Framework\Module\Dir\Reader $moduleReader)
    {
       $configDir = $moduleReader->getModuleDir(\Magento\Framework\Module\Dir::MODULE_ETC_DIR, 'MagentoPlus_ConfigInvestigation') ;
       $this->schema = $configDir.DIRECTORY_SEPARATOR.self::CONFIG_FILE_SCHEMA;
       $this->perFileSchema = $configDir . DIRECTORY_SEPARATOR. self::CONFIG_FILE_SCHEMA;
    }

    /**
     * Get path to per file validation schema
     *
     * @return string|null
     */
    public function getPerFileSchema()
    {
        return $this->perFileSchema;
    }
}

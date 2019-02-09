<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 2019-01-30
 * Time: 10:09
 */

namespace MagentoPlus\ConfigInvestigation\Model\Config;

use Magento\Framework\Config\ConverterInterface;

class Converter implements ConverterInterface
{
    protected $renderConfig = null;

    protected $removeItems = [];

    /**
     * Convert config
     *
     * @param \DOMDocument $source
     * @return array
     */
    public function convert($source)
    {
        $maps = $source->getElementsByTagName('map');
        $renderConfig = [];
        foreach ($maps as $map) {
            $name = $map->getAttribute('name');
            $items = [];
            $this->setItems($map, $items);
            $renderConfig[$name] = $items;
        }
        return $renderConfig;
    }

    protected function setItems($map, &$items)
    {
        $mapName = $map->getAttribute('name');
        for ($item = $map->firstChild; $item !== null; $item = $item->nextSibling) {
            if ($item instanceof \DOMElement && $item->tagName == 'item') {
                $nameItem = $item->getAttribute('name');
                $isRemoveItem = $item->getAttribute('remove');
                $path = $mapName.'_'.$nameItem;
                if($isRemoveItem){
                    $this->removeItems[$path] = 1;
                }
                if(\array_key_exists($path, $this->removeItems)){
                    continue;
                }
                if (0 < $item->getElementsByTagName('item')->length) {
                    $curItems = [];
                    $this->setItems($item, $curItems);
                    if (null === $nameItem || empty($nameItem)) {
                        $items[] = $curItems;
                    } else {
                        $items[$nameItem] = $curItems;
                    }
                } else {
                    $text = $item->nodeValue;
                    if (null === $nameItem || empty($nameItem)) {
                        $items[] = $text;
                    } else {
                        $items[$nameItem] = $text;
                    }
                }
            }
        }
    }
}

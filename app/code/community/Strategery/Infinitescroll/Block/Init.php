<?php

/**
 * InfiniteScroll - Magento Integration
 * NOTICE OF LICENSE
 * This source file is subject to the Academic Free License (AFL 3.0),
 * available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @category   Strategery
 * @package    Strategery_Infinitescroll
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @copyright  Copyright (c) 2011 Strategery Inc. (http://usestrategery.com)
 * @author     Enrique Piatti
 */
class Strategery_Infinitescroll_Block_Init extends Mage_Core_Block_Template
{

    public function isEnabled()
    {
        return $this->isEnabledInCurrentPage();
    }

    public function getCurrentPageType()
    {
        /** @var $currentCategory Mage_Catalog_Model_Category  */
        if ($currentCategory = Mage::registry('current_category')) {
            $where = "grid";
            if ($currentCategory->getIsAnchor()) {
                $where = "layer";
            }
            return $where;
        }

        $controller = $this->getRequest()->getControllerName();
        if ($controller === "result") {
            return "search";
        } elseif ($controller === "advanced") {
            return "advanced";
        }

        // default behaviour
        return "grid";

    }

    /**
     * check general and instance enable
     *
     * @return bool
     */
    public function isEnabledInCurrentPage()
    {
        return $this->getConfigData('general/enabled') && $this->getConfigData('instances/' . $this->getCurrentPageType());
    }

    public function getLoaderImage()
    {
        $url = $this->getConfigData('design/loading_img');

        return strpos($url, 'http') === 0 ? $url : $this->getSkinUrl($url);
    }

    public function getProductListMode()
    {
        // user mode
        if ($currentMode = $this->getRequest()->getParam('mode')) {
            switch ($currentMode) {
                case 'grid':
                    $productListMode = 'grid';
                    break;
                case 'list':
                    $productListMode = 'list';
                    break;
                default:
                    $productListMode = 'grid';
            }
        } else {
            $defaultMode = Mage::getStoreConfig('catalog/frontend/list_mode');
            switch ($defaultMode) {
                case 'grid-list':
                    $productListMode = 'grid';
                    break;
                case 'list-grid':
                    $productListMode = 'list';
                    break;
                default:
                    $productListMode = 'grid';
            }
        }

        return $productListMode;
    }

    public function getConfigData($node, $jsQuoteEscape = false)
    {
        $config = Mage::getStoreConfig('infinitescroll/' . $node);

        if (!$jsQuoteEscape) {
            return $config;
        }

        return $this->helper('infinitescroll')->jsQuoteEscape($config);
    }

    public function isMemoryActive()
    {
        return $this->getConfigData('memory/enabled');
    }

}

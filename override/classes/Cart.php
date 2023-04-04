<?php
/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * You must not modify, adapt or create derivative works of this source code
 *
 * @author    Musaffar Patel
 * @copyright 2016-2017 Musaffar Patel
 * @license   LICENSE.txt
 */

class Cart extends CartCore
{
    /**
     * Return cart products.
     *
     * @param bool $refresh
     * @param bool $id_product
     * @param int $id_country
     * @param bool $fullInfos
     * @param bool $keepOrderPrices When true use the Order saved prices instead of the most recent ones from catalog (if Order exists)
     *
     * @return array Products
     */
    public function getProducts($refresh = false, $id_product = false, $id_country = null, $fullInfos = true, bool $keepOrderPrices = false)
    {
        $this->_products = parent::getProducts($refresh, $id_product, $id_country, $fullInfos, $keepOrderPrices);
        include_once(_PS_MODULE_DIR_ . '/productareapacks/lib/bootstrap.php');
        $null = null;
        $pap_front_cart_controller = new PAPFrontCartController($null);
        $this->_products = $pap_front_cart_controller->getProducts($this->_products, $refresh, $id_product, $id_country, $fullInfos, $this);
        return $this->_products;
    }
}

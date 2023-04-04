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
     * If product price is calculated dynamically, make sure price per unit in the cart remains unaffected
     * @param bool $refresh
     * @param bool $id_product
     * @param null $id_country
     * @return array|null|void
     */
    public function getProducts($refresh = false, $id_product = false, $id_country = null, $fullInfos = true)
    {
        $this->_products = parent::getProducts($refresh, $id_product, $id_country);
        include_once(_PS_MODULE_DIR_ . '/productareapacks/lib/bootstrap.php');
        $null = null;
        $pap_front_cart_controller = new PAPFrontCartController($null);
        $this->_products = $pap_front_cart_controller->getProducts($this->_products, $refresh, $id_product, $id_country, $fullInfos, $this);
        return $this->_products;
    }
}

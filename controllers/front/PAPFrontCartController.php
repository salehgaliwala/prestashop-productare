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

class PAPFrontCartController extends Module {

	protected $sibling;

	public function __construct(&$sibling)
	{
		parent::__construct();

		if ($sibling !== null)
			$this->sibling = &$sibling;
	}

    /**
     * If product price is calculated dynamically, make sure price per unit in the cart remains unaffected
     * @param bool $refresh
     * @param bool $id_product
     * @param null $id_country
     */
    public function getProducts($products, $refresh = false, $id_product = false, $id_country = NULL, $fullInfos = true, $objCart)
    {
        $qty = 1;
        $cart_shop_context = Context::getContext()->cloneContext();

        foreach ($products as &$product) {
            if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_invoice') {
                $address_id = (int)$objCart->id_address_invoice;
            } else {
                $address_id = (int)$product['id_address_delivery'];
            }
            if (!Address::addressExists($address_id)) {
                $address_id = null;
            }

            if ($cart_shop_context->shop->id != $product['id_shop']) {
                $cart_shop_context->shop = new Shop((int)$product['id_shop']);
            }

            $price = Product::getPriceStatic(
                (int)$product['id_product'],
                true,
                isset($product['id_product_attribute']) ? (int)$product['id_product_attribute'] : null,
                6,
                null,
                false,
                false,
                $qty,
                false,
                (int)$objCart->id_customer ? (int)$objCart->id_customer : null,
                (int)$objCart->id,
                $address_id,
                $specific_price_output,
                true,
                true,
				$cart_shop_context,
                true,
                $product['id_customization']				
            );

            //print $price."<br>";


            $product['price_without_reduction'] = Product::getPriceStatic(
                (int)$product['id_product'],
                true,
                isset($product['id_product_attribute']) ? (int)$product['id_product_attribute'] : null,
                6,
                null,
                false,
                false,
                $qty,
                false,
                (int)$objCart->id_customer ? (int)$objCart->id_customer : null,
                (int)$objCart->id,
                $address_id,
                $specific_price_output,
                true,
                true,
				$cart_shop_context,
                true,
                $product['id_customization']				
            );

            $product['price_with_reduction'] = Product::getPriceStatic(
                (int)$product['id_product'],
                true,
                isset($product['id_product_attribute']) ? (int)$product['id_product_attribute'] : null,
                6,
                null,
                false,
                true,
                $qty,
                false,
                (int)$objCart->id_customer ? (int)$objCart->id_customer : null,
                (int)$objCart->id,
                $address_id,
                $specific_price_output,
                true,
                true,
				$cart_shop_context,
                true,
                $product['id_customization']				
            );

            $product['price'] = $product['price_with_reduction_without_tax'] = Product::getPriceStatic(
                (int)$product['id_product'],
                false,
                isset($product['id_product_attribute']) ? (int)$product['id_product_attribute'] : null,
                6,
                null,
                false,
                true,
                $qty,
                false,
                (int)$objCart->id_customer ? (int)$objCart->id_customer : null,
                (int)$objCart->id,
                $address_id,
                $specific_price_output,
                true,
                true,
				$cart_shop_context,
                true,
                $product['id_customization']				
            );
            $product['price_wt'] = $product['price_with_reduction'];
        }

        return $products;
    }

    /**
     * Calculate dynamic price
     * @param $params
     * @return float|int
     */
	public function priceCalculation($params)
    {
        // calculates price in the following way: Number of boxes x (Area In Box x Price Per Box)
        $stack = debug_backtrace();
        $render = false;
        if (count($stack) > 20) $loop_max = 20;
        else $loop_max = count($stack) - 1;
        for ($x = 0; $x <= $loop_max; $x++) {
            if (!empty($stack[$x]['file'])) {
                $filename = basename($stack[$x]['file']);
                if (Tools::strtolower($filename) == 'cart.php' || Tools::strtolower($filename) == 'cartcontroller.php') {
                    $render = true;
                }
            }
        }
        if ($render == false) {
            return $params['price'];
        }

        $pap_product = new PAPProductModel();
        $pap_product->loadByProduct($params['id_product']);
        $pack_info = PAPProductAttributeHelper::getPackInfo($params['id_product'], $params['id_product_attribute']);

        if ($pack_info['pack_area'] == 0 || $pap_product->dynamic_price == 0 || empty($pap_product->id_pap_product)) {
            return $params['price'];
        }

        $total_area_in_boxes = $params['quantity'] * $pack_info['pack_area'];
        $price = $total_area_in_boxes * $params['price'];
        $price = $price / $params['quantity'];
        return $price;
    }
}

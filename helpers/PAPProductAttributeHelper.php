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

class PAPProductAttributeHelper
{
    /**
     * get pack info either for product or product combination
     * @param $id_product
     * @param $id_product_attribute
     * @return array
     */
    public static function getPackInfo($id_product, $id_product_attribute = 0)
    {
        $pap_product = new PAPProductModel();
        $pap_product->loadByProduct($id_product);
        $pack_info = array(
            'pack_area' => 0
        );

        $pap_product_attribute_model = new PAPProductAttributeModel();
        $pack_area = $pap_product->pack_area;

        if ($id_product_attribute > 0) {
            $pap_product_attribute_model->loadAttributeByProduct($id_product, $id_product_attribute);
            if (!empty($pap_product_attribute_model->id_papattribute)) {
                if ($pap_product_attribute_model->pack_area > 0) {
                    $pack_area = $pap_product_attribute_model->pack_area;
                }
            }
        }

        $pack_info['pack_area'] = $pack_area;
        return $pack_info;
    }
}

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
 * @copyright 2016-2021 Musaffar Patel
 * @license   LICENSE.txt
 */

class PAPProductUnitConversionHelper
{
    /**
     * @param $id_pap_unit
     * @param $id_product
     * @return array|bool|mysqli_result|PDOStatement|resource|null
     * @throws PrestaShopDatabaseException
     */
    public static function get($id_pap_unit, $id_product)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from(PAPProductUnitConversionModel::$definition['table'], 'puc');
        $sql->where('id_product = ' . (int)$id_product);
        $sql->where('id_pap_unit = ' . (int)$id_pap_unit);
        $result = Db::getInstance()->getRow($sql);
        return $result;
    }

    /**
     * @param $id_product
     * @return array|bool|mysqli_result|PDOStatement|resource|null
     * @throws PrestaShopDatabaseException
     */
    public static function getByProduct($id_product)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from(PAPProductUnitConversionModel::$definition['table']);
        $sql->where('id_product = ' . (int)$id_product);
        $result = Db::getInstance()->executeS($sql);
        return $result;
    }

    /**
     * @param $id_product
     * @param $id_lang
     * @return array
     */
    public static function getOptionsByProduct($id_product, $id_lang)
    {
        $sql = new DbQuery();
        $sql->select('puc.*, ul.symbol, u.conversion_factor');
        $sql->from(PAPProductUnitConversionModel::$definition['table'], 'puc');
        $sql->where('puc.id_product = ' . (int)$id_product);
        $sql->innerJoin('pap_unit_lang', 'ul', 'ul.id_pap_unit = puc.id_pap_unit AND ul.id_lang = ' . (int)$id_lang);
        $sql->innerJoin('pap_unit', 'u', 'u.id_pap_unit = puc.id_pap_unit');
        $sql->orderBy('u.position');
        $result = Db::getInstance()->executeS($sql);
        return $result;
    }

    /**
     * delete all unit conversion options associated with a product
     * @param $id_product
     */
    public static function deleteByProduct($id_product)
    {
        DB::getInstance()->delete(PAPProductUnitConversionModel::$definition['table'], 'id_product = ' . (int)$id_product);
    }
}

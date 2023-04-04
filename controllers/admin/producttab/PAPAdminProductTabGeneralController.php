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

class PAPAdminProductTabGeneralController extends PAPControllerCore
{

	public function __construct($sibling, $params = array())
	{
		parent::__construct($sibling, $params);
		$this->sibling = $sibling;
		$this->base_url = Tools::getShopProtocol().Tools::getShopDomain().__PS_BASE_URI__;
	}

	public function setMedia()
	{
	}

	public function render()
	{
		$pap_product = new PAPProductModel();
		$pap_product->loadByProduct($this->params['id_product']);

		$dimensions = PAPDimensionModel::getDimensions(Configuration::get('PS_LANG_DEFAULT'));
		$product_fields = PAPProductFieldModel::getByProduct($this->params['id_product']);

		foreach ($dimensions as &$dimension)
		{
			$visible = false;
			foreach ($product_fields as $field)
			{
				if ($field->id_pap_dimension == $dimension->id_pap_dimension && $field->visible == 1)
				{
					$visible = true;
					break;
				}
				else
					$visible = false;
			}
			$dimension->visible = $visible;
		}

        $units = PAPUnit::getUnits();
        foreach ($units as &$unit) {
            $product_conversion_unit = PAPProductUnitConversionHelper::get($unit['id_pap_unit'], $this->params['id_product']);
            if (!empty($product_conversion_unit['id_pap_product_unit_conversion'])) {
                $unit['checked'] = 1;
            } else {
                $unit['checked'] = 0;
            }
        }

        Context::getContext()->smarty->assign(array(
			'id_product' => $this->params['id_product'],
			'pap_product' => $pap_product,
			'pap_dimensions' => $dimensions,
            'pap_units' => $units
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/producttab/general.tpl');
	}

	/**
	 * Save the general settings for the product
	 */
	public function processForm()
	{
        $unit_conversions = Tools::getValue('unit_conversions');
		$pap_product_model = new PAPProductModel();
		$pap_product_model->loadByProduct((int)Tools::getValue('id_product'), Context::getContext()->shop->id);
		$pap_product_model->id_product = (int)Tools::getValue('id_product');
		$pap_product_model->id_shop = (int)Context::getContext()->shop->id;
		$pap_product_model->enabled = (int)Tools::getValue('pap_enabled');
		$pap_product_model->calculation_type = pSQL(Tools::getValue('calculation_type'));
		$pap_product_model->dynamic_price = (int)Tools::getValue('dynamic_price');
		$pap_product_model->unit_conversion_enabled = (int)Tools::getValue('unit_conversion_enabled');
		$pap_product_model->unit_conversion_operator = pSQL(Tools::getValue('unit_conversion_operator'));
		$pap_product_model->unit_conversion_value = (float)Tools::getValue('unit_conversion_value');
		$pap_product_model->pack_area = (float)Tools::getValue('pack_area');
		$pap_product_model->area_price = (float)Tools::getValue('area_price');
		$pap_product_model->roll_height = (float)Tools::getValue('roll_height');
		$pap_product_model->roll_width = (float)Tools::getValue('roll_width');
		$pap_product_model->pattern_repeat = (float)Tools::getValue('pattern_repeat');
        $pap_product_model->coverage = (float)Tools::getValue('coverage');
		$pap_product_model->wastage_options = pSQL(Tools::getValue('wastage_options'));
        if (!empty($unit_conversions)) {
            $pap_product_model->unit_conversion_enabled = 0;
        }
        $pap_product_model->save();

		PAPProductFieldModel::deleteByProduct(Tools::getValue('id_product'));

		if (Tools::getValue('pap_field_enabled') != '') {
			foreach (Tools::getValue('pap_field_enabled') as $id_pap_dimension => $visible) {
				$pap_product_field = new PAPProductFieldModel();
				$pap_product_field->id_product = (int)Tools::getValue('id_product');
				$pap_product_field->id_pap_dimension = (int)$id_pap_dimension;
				$pap_product_field->visible = (int)$visible;
				$pap_product_field->add();
			}
		}

        // Save unit conversion options
        PAPProductUnitConversionHelper::deleteByProduct(Tools::getValue('id_product'));
        if (!empty($unit_conversions)) {
            foreach ($unit_conversions as $id_pap_unit) {
                $pap_product_unit_conversion_model = new PAPProductUnitConversionModel();
                $pap_product_unit_conversion_model->id_product = (int)Tools::getValue('id_product');
                $pap_product_unit_conversion_model->id_pap_unit = (int)$id_pap_unit;
                $pap_product_unit_conversion_model->save();
            }
        }
    }

	public function route()
	{
		switch (Tools::getValue('action'))
		{
			case 'processform' :
				die ($this->processForm());

			default:
				return $this->render();
		}
	}

}
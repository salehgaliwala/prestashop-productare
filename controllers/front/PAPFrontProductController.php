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

use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;

class PAPFrontProductController extends PAPControllerCore {

	protected $sibling;

	public function __construct(&$sibling)
	{
		parent::__construct($sibling);

		if ($sibling !== null)
			$this->sibling = &$sibling;
	}

	public function setMedia()
	{
		if (Context::getContext()->controller->php_self == 'product')
		{
            $this->sibling->context->controller->addJquery();
            $this->sibling->context->controller->addJqueryPlugin('typewatch');
			$this->context->controller->registerStylesheet('pap_front', 'modules/'.$this->sibling->name.'/views/css/front/pap.css');
            $this->context->controller->registerJavascript('pap_tools', 'modules/' . $this->sibling->name . '/views/js/lib/Tools.js');
			$this->context->controller->registerJavascript('typewatch', Media::getJqueryPluginPath('typewatch', null)['js']);
			$this->context->controller->registerJavascript('pap_front_product_core_controller', 'modules/'.$this->sibling->name.'/views/js/front/PAPFrontProductCoreController.js');
			$this->context->controller->registerJavascript('pap_front_product_normal_controller', 'modules/'.$this->sibling->name.'/views/js/front/PAPFrontProductNormalController.js');
			$this->context->controller->registerJavascript('pap_front_product_paints_controller', 'modules/'.$this->sibling->name.'/views/js/front/PAPFrontProductPaintsController.js');
			$this->context->controller->registerJavascript('pap_front_product_rolls_controller', 'modules/'.$this->sibling->name.'/views/js/front/PAPFrontProductRollsController.js');
		}
	}

	/**
	 * Add script initialisation vars for the PPBS widgt which will be loaded via ajax
	 * @param $params
	 * @return bool
	 */
	public function hookDisplayFooter($params)
	{
		if (Context::getContext()->controller->php_self != 'product') return false;

		$pap_product = new PAPProductModel();
        $pap_product->loadByProduct(Tools::getValue('id_product'), Context::getContext()->shop->id);

        if (empty($pap_product->id_pap_product)) {
            return false;
        }

		$this->sibling->smarty->assign(array(
			'baseDir' => __PS_BASE_URI__,
			'action' => Tools::getValue('action'),
            'pap_product' => $pap_product
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/front/hook_productfooter.tpl');
	}

	/**
	 * Displ;ay the module on the product page
	 * @param $module_file
	 * @return string
	 */
	public function renderWidget()
	{
		$translations = array();
		$group_reduction = 0;

		$product = new Product(Tools::getValue('id_product'), true);

		if (!empty(Context::getContext()->customer->id_default_group))
		{
			$id_group = Context::getContext()->customer->id_default_group;
			$customer_group = new Group($id_group);
			$group_reduction = $customer_group->reduction;
		}

		$pap_product_field_model = new PAPProductFieldModel();
		$product_fields = $pap_product_field_model->getByProduct(Tools::getValue('id_product'));

		foreach ($product_fields as &$product_field)
			$product_field->dimension = new PAPDimensionModel($product_field->id_pap_dimension, Context::getContext()->language->id);

		$pap_product = new PAPProductModel();
		$pap_product->loadByProduct(Tools::getValue('id_product'), Context::getContext()->shop->id);

		if (empty($pap_product->enabled) || $pap_product->enabled == false)
			return false;


		$translations = PAPTranslationHelper::getProductTranslations(Tools::getValue('id_product'), Context::getContext()->language->id);
		$this->assignTranslations($translations, Context::getContext()->language->id);

		if ($pap_product->wastage_options != '')
			$pap_product->wastage_options = explode(',', $pap_product->wastage_options);
		else
			$pap_product->wastage_options = array();

		// currency conversion for pack area price
		$pap_product->area_price = Tools::convertPriceFull($pap_product->area_price, null, Context::getContext()->currency);

		$pap_product_attribute = new PAPProductAttributeModel();
		$pap_attributes = $pap_product_attribute->getAttributesByProduct(Tools::getValue('id_product'));

		$pap_attr_array = array(); //re oprganised for front end json/javascript, key access by IPA
		if ($pap_attributes)
		{
			foreach ($pap_attributes as $pap_attr)
			{
				$pap_attr_array[$pap_attr{'id_product_attribute'}]['pack_area'] = $pap_attr['pack_area'];
				$pap_attr_array[$pap_attr{'id_product_attribute'}]['area_price'] = $pap_attr['area_price'];
			}
		}

        $conversion_options = PAPProductUnitConversionHelper::getOptionsByProduct(Tools::getValue('id_product'), Context::getContext()->language->id);
		$display_options = Configuration::get('pap_show_required_packs') || Configuration::get('pap_show_quote_inc_tax') || Configuration::get('pap_show_quote_ex_tax') || Configuration::get('pap_show_box_price') || Configuration::get('pap_show_quote_total_area');

		$this->sibling->smarty->assign(array(
			'product' => Tools::jsonEncode($product),
			'pap_product' => $pap_product,
			'pap_product_json' => Tools::jsonEncode($pap_product),
			'pap_product_fields' => $product_fields,
			'pap_product_attributes_json' => $pap_attr_array,
			'id_language' => Context::getContext()->language->id,
			'pap_wastage_options_render_type' => Configuration::get('pap_wastage_options_render_type'),
			'pap_show_required_packs' => Configuration::get('pap_show_required_packs'),
			'pap_show_quote_inc_tax' => Configuration::get('pap_show_quote_inc_tax'),
			'pap_show_quote_ex_tax' => Configuration::get('pap_show_quote_ex_tax'),
			'pap_show_box_price' => Configuration::get('pap_show_box_price'),
			'pap_show_quote_total_area' => Configuration::get('pap_show_quote_total_area'),
			'pap_display_options' => $display_options,
			'conversion_options' => $conversion_options,
			'group_reduction' => $group_reduction
		));
		return $this->sibling->display($this->sibling->module_file, 'widget_'.Tools::getValue('calculation_type').'.tpl');
		//return $this->sibling->display($this->sibling->module_file, 'views/templates/front/widget_'.Tools::getValue('calculation_type').'.tpl');
	}

	/**
	 * Get Pack Information for Product / Product Combination
	 */
	public function getPackInfo()
	{
		$json_return = array(
			'pack_area' => 0,
			'area_price' => 0,
			'price_extax' => 0.00,
			'price' => 0.00,
			'calculation_type' => 'normal',
			'dynamic_price' => 0,
			'roll_height' => 0.00,
			'roll_width' => 0.00,
            'pattern_repeat' => 0.00,
            'coverage' => 0.00
		);

        if (!empty(Tools::getValue('group'))) {
            $id_product_attribute = Product::getIdProductAttributesByIdAttributes((int)Tools::getValue('id_product'), Tools::getValue('group'));
        } else {
			$id_product_attribute = 0;
		}

		$json_return['price_extax'] = Product::getPriceStatic((int)Tools::getValue('id_product'), false, $id_product_attribute);
		$json_return['price'] = Product::getPriceStatic((int)Tools::getValue('id_product'), true, $id_product_attribute);

		$pap_product_attribute = new PAPProductAttributeModel();
		$pap_product_attribute->loadAttributeByProduct(Tools::getValue('id_product'), $id_product_attribute);

        $pap_product = new PAPProductModel();
        $pap_product->loadByProduct(Tools::getValue('id_product'));

        if ((int)$pap_product_attribute->pack_area == 0 && (int)$pap_product_attribute->area_price == 0) {
			$json_return['area_price'] = $pap_product->area_price;
			$json_return['pack_area'] = $pap_product->pack_area;
		}
		else {
			$json_return['area_price'] = $pap_product_attribute->area_price;
			$json_return['pack_area'] = $pap_product_attribute->pack_area;
		}

		if ((float)$pap_product_attribute->roll_width > 0) {
            $pap_product->roll_width = $pap_product_attribute->roll_width;
        }

		if ((float)$pap_product_attribute->roll_height > 0) {
            $pap_product->roll_height = $pap_product_attribute->roll_height;
        }

        if ((float)$pap_product_attribute->pattern_repeat > 0) {
            $pap_product->pattern_repeat = $pap_product_attribute->pattern_repeat;
        }

        if ((float)$pap_product_attribute->coverage > 0) {
            $pap_product->coverage = $pap_product_attribute->coverage;
        }

        $json_return['calculation_type'] = $pap_product->calculation_type;
		$json_return['roll_height'] = $pap_product->roll_height;
		$json_return['roll_width'] = $pap_product->roll_width;
		$json_return['pattern_repeat'] = $pap_product->pattern_repeat;
        $json_return['coverage'] = $pap_product->coverage;
        $json_return['dynamic_price'] = (int)$pap_product->dynamic_price;
		return (json_encode($json_return));
	}

	public function formatPrice()
	{
		$priceFormatter = new PriceFormatter();
		return $priceFormatter->convertAndFormat(Tools::getValue('price'));
	}

	/**
	 * Add area price to product lists
	 */
	public function hookFilterProductSearch($params)
	{
		if (Configuration::get('pap_price_list_modify') == 0) return false;

		$id_lang = Context::getContext()->language->id;
        $priceFormatter = new PriceFormatter();

		foreach ($params['searchVariables']['products'] as &$product)
		{
			$pap_product = new PAPProductModel();
			$pap_product->loadByProduct($product['id_product'], Context::getContext()->shop->id);

			if (isset($pap_product->enabled) && $pap_product->enabled) {
				if ($pap_product->area_price > 0) {
					$total_price_suffix = PAPTranslationHelper::getProductTranslation($product['id_product'], 'total_price_suffix', $id_lang);
					$pap_product->area_price = Tools::convertPriceFull($pap_product->area_price, null, Context::getContext()->currency);
                    $product['price'] = $priceFormatter->convertAndFormat($pap_product->area_price).' '. $total_price_suffix;
					$product['pap'] = true;
				}
			}
		}
	}

    /**
     * Determine if the dynamically calculated price or static product price should be displayed
     * @return bool
     */
    public function shouldShowAreaPrice()
    {
        $allowed_callers = array(
            'blockcart.php' => array(
                'file' => 'blockcart.php',
                'function' => ''
            ),
            'cart.php' => array(
                'PAPFrontCartController::getProducts' => array(
                    'dynamic' => 0
                ),
                'file' => 'cart.php',
                'function' => ''
            ),
            'paymentmodule.php' => array(
                'file' => 'paymentmodule.php',
                'function' => ''
            )
        );

        $stack = debug_backtrace();

        if (count($stack) > 10) $loop_max = 10;
        else $loop_max = count($stack) - 1;
        for ($x = 0; $x <= $loop_max; $x++) {
            if (!empty($stack[$x]['file'])) {
                $filename = basename($stack[$x]['file']);
                if (isset($allowed_callers[Tools::strtolower($filename)])) {
                    $key = $stack[$x]['class'] . '::' . $stack[$x]['function'];
                    if (!empty($allowed_callers[Tools::strtolower($filename)][$key])) {
                        if ($allowed_callers[Tools::strtolower($filename)][$key]['dynamic'] == 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $id_shop
     * @param $id_product
     * @param $id_product_attribute
     * @param $id_country
     * @param $id_state
     * @param $zipcode
     * @param $id_currency
     * @param $id_group
     * @param $quantity
     * @param $use_tax
     * @param $decimals
     * @param $only_reduc
     * @param $use_reduc
     * @param $with_ecotax
     * @param $specific_price
     * @param $use_group_reduction
     * @param int $id_customer
     * @param bool $use_customer_price
     * @param int $id_cart
     * @param int $real_quantity
     */
    public function priceCalculation($id_shop, $id_product, $id_product_attribute, $id_cart, $price_pre_calculated)
    {
        if ($this->shouldShowAreaPrice()) {
            $decimals = 6;
        }

        $pap_product = new PAPProductModel();
        $pap_product->loadByProduct($id_product, $id_shop);
        $pack_area = $pap_product->pack_area;
        $price = $price_pre_calculated;

        if ((!isset($pap_product->enabled) || $pap_product->enabled == 0) || !Module::isEnabled('ProductAreaPacks') || $pap_product->dynamic_price == 0) {
            return $price;
        }

        if (!$id_cart && isset(Context::getContext()->cart->id)) {
            $id_cart = Context::getContext()->cart->id;
        }

        if (!$id_cart) {
            return $price;
        }

        $pap_product_attribute = new PAPProductAttributeModel();
        $pap_product_attribute->loadAttributeByProduct($id_product, $id_product_attribute);

        if ($pap_product_attribute->id_papattribute > 0 && $pap_product_attribute->pack_area > 0) {
            $pack_area = $pap_product_attribute->pack_area;
        }

        if ($pack_area == 0) {
            return $price;
        }

        $compute_precision = Configuration::get('_PS_PRICE_COMPUTE_PRECISION_');
        return Tools::ps_round($price, $compute_precision) * $pack_area;
    }

	public function route()
	{
		switch (Tools::getValue('action'))
		{
			case 'renderwidget' :
				die ($this->renderWidget());

			case 'getpackinfo' :
				die ($this->getPackInfo());

			case 'formatprice' :
				die ($this->formatPrice());
		}
	}

}
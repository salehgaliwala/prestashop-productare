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

class PAPAdminProductTabTranslationsController extends PAPControllerCore
{

	private $route = 'papadminproducttabtranslationscontroller';

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
		$languages = Language::getLanguages();
		$translations = PAPTranslationHelper::getProductTranslationsUnpopulated();
		$translations_product = PAPTranslationHelper::getProductTranslations(Tools::getValue('id_product'), null, false);

		foreach ($translations as &$translation) {
			foreach ($translations_product as $translation_product) {
				if ($translation_product->name == $translation['name']) {
					$translation['text'] = $translation_product->text;
				}
			}
		}

		Context::getContext()->smarty->assign(array(
			'id_product' => $this->params['id_product'],
			'id_lang_default' => $this->id_lang_default,
			'languages' => $languages,
			'translations' => $translations
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/producttab/translations.tpl');
	}

	/**
	 * Save the product translations
	 */
	public function process()
	{
		if ((int)Tools::getValue('id_product') == 0) {
			return false;
		}

		PAPTranslationHelper::deleteProductTranslations(Tools::getValue('id_product'));
		$translations = PAPTranslationHelper::getProductTranslationsUnpopulated();

		foreach ($translations as $translation) {
			if (Tools::getIsset($translation['name'])) {
				$pap_translation_product = new PAPTranslationProductModel();
				$pap_translation_product->id_product = (int)Tools::getValue('id_product');
				$pap_translation_product->name = pSQL($translation['name']);

				foreach (Tools::getValue($translation['name']) as $id_lang => $text) {
					$pap_translation_product->text[$id_lang] = $text;
				}
				$pap_translation_product->save();
			}
		}
	}

	public function route()
	{
		switch (Tools::getValue('action'))
		{
			case 'process':
				return $this->process();

			default:
				return $this->render();
		}
	}

}
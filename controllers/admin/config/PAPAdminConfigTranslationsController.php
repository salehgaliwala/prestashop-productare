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

class PAPAdminConfigTranslationsController extends PAPControllerCore
{
	protected $sibling;

	public function __construct(&$sibling = null)
	{
		parent::__construct($sibling);
		$this->id_lang_default = Configuration::get('PS_LANG_DEFAULT', null, Context::getContext()->shop->id_shop_group, Context::getContext()->shop->id);

		if ($sibling !== null)
			$this->sibling = &$sibling;
	}

	public function setMedia()
	{
	}

	public function render()
	{
		$translations = PAPTranslationModel::getTranslations(null, Context::getContext()->shop->id);
		$languages = Language::getLanguages();

		Context::getContext()->smarty->assign(array(
			'translations' => $translations,
			'languages' => $languages,
			'id_lang_default' => $this->id_lang_default
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/config/translations.tpl');
	}

	/**
	 * Process and save the translations
	 */
	public function processForm()
	{
		$translations = PAPTranslationModel::getTranslations(null, Context::getContext()->shop->id);
		foreach ($translations as $translation) {
			foreach (Tools::getValue($translation->name) as $id_lang => $text) {
				$translation_model = new PAPTranslationModel();
				$translation_item = $translation_model->getTranslationByName($translation->name);
                if (empty($translation_item->text[$id_lang])) {
                    $translation_item->text[$id_lang] = $text;
                }
				$translation_model->updateTranslation($translation_item->id_translation, $text, $id_lang);
			}
		}
	}

	public function route()
	{
		switch (Tools::getValue('action'))
		{
			case 'render' :
				return $this->render();

			case 'processform' :
				return $this->processForm();
		}
	}

}
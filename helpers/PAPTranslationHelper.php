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

class PAPTranslationHelper
{
	public static function getProductTranslationsUnpopulated()
	{
		$languages = Language::getLanguages();

		$translations = array(
			array(
				'name' => 'total_price_suffix',
			),
			array(
				'name' => 'total_area_suffix',
			),
            array(
			    'name' => 'wastage_options',
            ),
            array(
                'name' => 'required_packs',
            ),
            array(
                'name' => 'pack_price',
            )
        );

		foreach ($translations as &$translation) {
			foreach ($languages as $language) {
				$translation['text'][$language['id_lang']] = '';
			}
		}
		return $translations;
	}

	/**
	 * Delete all translations belonging to a product
	 * @param $id_product
	 */
	public static function deleteProductTranslations($id_product)
	{
		$pap_translation_product_model = new PAPTranslationProductModel();
		$translations = $pap_translation_product_model->getByProduct($id_product);

		if (empty($translations)) {
			return false;
		}

		foreach ($translations as $translation) {
			DB::getInstance()->delete('pap_translation_product_lang', 'id_translation_product=' . (int)$translation->id_translation_product);
		}

		DB::getInstance()->delete('pap_translation_product', 'id_product='.(int)$id_product);
	}

	private static function _findTranslationInArray($name, $translations)
	{
		foreach ($translations as $translation) {
			if (is_object($translation)) {
				if ($translation->name == $name) {
					return $translation;
				}
			} else {
				if ($translation['name'] == $name) {
					return $translation;
				}
			}
		}
		return false;
	}

	/**
	 * Get all translations and override with product translations if available
	 * @param $id_product
	 * @param $id_lang
	 * @param $id_shop
	 * @return array
	 */
	public static function getProductTranslations($id_product, $id_lang, $populate_from_global = true)
	{
		$translations = PAPTranslationModel::getTranslations(null, Context::getContext()->shop->id);
		$translations_product_model = new PAPTranslationProductModel();
		$translations_product_index = PAPTranslationHelper::getProductTranslationsUnpopulated();
		$translations_product = $translations_product_model->getByProduct($id_product, $id_lang);

		$translations_new = array();

		foreach ($translations as &$translation) {
			$tmp = self::_findTranslationInArray($translation->name, $translations_product_index);

			if (!empty($tmp['name'])) {
				$tmp2 = self::_findTranslationInArray($translation->name, $translations_product);

				if (is_object($tmp2)) {
					$name_tmp = $tmp2->name;
					$text_tmp = $tmp2->text;
				} else {
					$name_tmp = $tmp2['name'];
					$text_tmp = $tmp2['text'];
				}

				if (empty($name_tmp) && !$populate_from_global) {
					foreach ($translation->text as &$text) {
						$text = '';
					}
				}

				if (!empty($name_tmp)) {
					$translation->text = $text_tmp;
				}

			}
		}
		return $translations;
	}

	public static function getProductTranslation($id_product, $name, $id_lang)
	{
		$product_translations = self::getProductTranslations($id_product, $id_lang);
		foreach ($product_translations as $product_translation) {
			if ($product_translation->name == $name) {
				return $product_translation->text[$id_lang];
			}
		}
	}

}
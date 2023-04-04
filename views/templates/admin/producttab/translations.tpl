{*
* 2007-2017 Musaffar
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author Musaffar Patel <musaffar.patel@gmail.com>
*  @copyright  2007-2017 Musaffar Patel
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Property of Musaffar Patel
*}

<div id="form-pap-translations" class="form-wrapper" style="padding: 20px;">
	<input type="hidden" name="id_product" value="{$id_product|escape:'htmlall':'UTF-8'}">

	{foreach from=$translations item=translation}
		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">
					{$translation.name|escape:'htmlall':'UTF-8'}
				</span>
			</label>

			<div class="col-lg-7">
				{foreach from=$languages item=language}
					<div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" style="{if $language.id_lang eq $id_lang_default}display: block;{else}display:none;{/if}">
						<div class="col-lg-7">
							<input name="{$translation.name|escape:'htmlall':'UTF-8'}[{$language.id_lang|escape:'htmlall':'UTF-8'}]" id="{$translation.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="form-control"
								   value="{if isset({$translation.text[$language.id_lang|escape:'htmlall':'UTF-8']})}{$translation.text[$language.id_lang]|escape:'htmlall':'UTF-8'}{/if}" />
						</div>
						<div class="col-lg-2">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
								{$language.iso_code|escape:'htmlall':'UTF-8'}
							</button>
							<ul class="dropdown-menu">
								{foreach from=$languages item=language_dropdown}
									<li>
										<a href="javascript:hideOtherLanguage({$language_dropdown.id_lang|escape:'htmlall':'UTF-8'});">{$language_dropdown.name|escape:'htmlall':'UTF-8'}</a>
									</li>
								{/foreach}
							</ul>
						</div>
					</div>
				{/foreach}
			</div>
		</div>
	{/foreach}

	<button type="button" id="btn-pap-translations-save" class="btn btn-primary">{l s='Save' mod='productareapacks'}</button>
</div>

<script>
	$(document).ready(function () {
		if (typeof prestaShopUiKit !== 'undefined')
			prestaShopUiKit.init();
	});
</script>
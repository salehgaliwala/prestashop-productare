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

<div id="pap-dimension-edit">

	<div id="form-pap-dimension-edit" class="form-wrapper pap-form-wrapper" style="padding-left: 15px;">
		<h3>{l s='Add / Edit Dimension' mod='productareapacks'}</h3>

		<input name="id_pap_dimension" value="{if !empty($pap_dimension->id_pap_dimension)}{$pap_dimension->id_pap_dimension|escape:'html':'UTF-8'}{/if}" type="hidden" />

		<div class="alert alert-danger" style="display: none"></div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">{l s='Internal Name' mod='productareapacks'}</span>
			</label>

			<div class="col-lg-7">
				<input type="text" id="name" class="form-control" name="name" value="{$pap_dimension->name|escape:'htmlall':'UTF-8'}" required="required">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="Display name of the dimension field (eg Height)">{l s='Display Name' mod='productareapacks'}</span>
			</label>

			<div class="col-lg-7">
				{foreach from=$languages item=language}
					<div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" style="{if $language.id_lang eq $id_lang_default}display: block;{else}display:none;{/if}">
						<div class="col-lg-7">
							<input name="display_name_{$language.id_lang|escape:'htmlall':'UTF-8'}" id="display_name_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="form-control"
								   value="{if !empty($pap_dimension->display_name[$language.id_lang])}{$pap_dimension->display_name[$language.id_lang]|escape:'html':'UTF-8'}{/if}" />
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

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="Suffix dimension field (eg mm)">{l s='Suffix' mod='productareapacks'}</span>
			</label>

			<div class="col-lg-7">
				{foreach from=$languages item=language}
					<div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" style="{if $language.id_lang eq $id_lang_default}display: block;{else}display:none;{/if}">
						<div class="col-lg-7">
							<input name="suffix_{$language.id_lang|escape:'htmlall':'UTF-8'}" id="suffix_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="form-control"
								   value="{if !empty($pap_dimension->suffix[$language.id_lang])}{$pap_dimension->suffix[$language.id_lang]|escape:'html':'UTF-8'}{/if}" />
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

		<button type="button" id="btn-pap-edit-dimension-save" class="btn btn-primary">{l s='Save' mod='productareapacks'}</button>
		<button type="button" id="btn-pap-edit-dimension-cancel" class="btn btn-primary-outline">{l s='Cancel' mod='productareapacks'}</button>
	</div>

</div>
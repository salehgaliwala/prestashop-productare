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

<div id="form-pap-combination-edit" class="form-wrapper pap-form-wrapper" style="padding: 20px;">

	<input type="hidden" name="id_papattribute" value="{$pap_product_attribute->id_papattribute|escape:'htmlall':'UTF-8'}">
	<input type="hidden" name="id_product" value="{$id_product|escape:'htmlall':'UTF-8'}">
	<input type="hidden" name="id_product_attribute" value="{$id_product_attribute|escape:'htmlall':'UTF-8'}">

	<div class="panel-heading">
		<i class="material-icons">settings</i> {l s='Combination Setup' mod='productareapacks'}
	</div>

	<div class="alert alert-danger mp-errors" style="display: none"></div>

	<div id="fields-calculation-normal-panel-combination" style="display: none">
		<div class="form-group row">
			<label class="control-label col-lg-2">
				{l s='Pack Area' mod='productareapacks'}
			</label>
			<div class="col-lg-10">
				<input name="pack_area" type="number" class="form-control" value="{$pap_product_attribute->pack_area|escape:'htmlall':'UTF-8'}"/>
			</div>
		</div>
	</div>

	<div id="fields-calculation-rolls-panel-combination" style="display: none">
		<div class="form-group row">
			<label class="control-label col-lg-2">
				{l s='Roll Height' mod='productareapacks'}
			</label>
			<div class="col-lg-10">
				<input name="roll_height" type="number" class="form-control" value="{$pap_product_attribute->roll_height|escape:'htmlall':'UTF-8'}" />
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2">
				{l s='Roll Width' mod='productareapacks'}
			</label>
			<div class="col-lg-10">
				<input name="roll_width" type="number" class="form-control" value="{$pap_product_attribute->roll_width|escape:'htmlall':'UTF-8'}" />
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2">
				{l s='Pattern Repeat' mod='productareapacks'}
			</label>
			<div class="col-lg-10">
				<input name="pattern_repeat" type="number" class="form-control" value="{$pap_product_attribute->pattern_repeat|escape:'htmlall':'UTF-8'}" />
			</div>
		</div>

	</div>

	<div id="fields-calculation-paints-panel-combination" style="display: none">
		<div class="form-group row">
			<label class="control-label col-lg-2">
				{l s='Coverage (m2)' mod='productareapacks'}
			</label>
			<div class="col-lg-10">
				<input name="coverage" type="number" class="form-control" value="{$pap_product_attribute->coverage|escape:'htmlall':'UTF-8'}"/>
			</div>
		</div>
	</div>


	<div class="form-group row">
		<label class="control-label col-lg-2">
			{l s='Area Price' mod='productareapacks'}
		</label>
		<div class="col-lg-10">
			<input name="area_price" type="number" class="form-control" value="{$pap_product_attribute->area_price|escape:'htmlall':'UTF-8'}"/>
		</div>
	</div>

	<button type="button" id="btn-pap-combination-save" class="btn btn-primary">{l s='Save' mod='productareapacks'}</button>
</div>



<script>
	$(document).ready(function () {
		if (typeof prestaShopUiKit !== 'undefined')
			prestaShopUiKit.init();
	});
</script>
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

<div id="form-ppat-generaL-edit" class="form-wrapper PPAT-form-wrapper" style="padding: 20px;">

	<input type="hidden" name="id_product" value="{$id_product|escape:'htmlall':'UTF-8'}">

	<div class="panel-heading" style="font-weight: bold">
		<i class="material-icons">settings</i> {l s='General Options' mod='productareapacks'}
	</div>

	<div class="alert alert-danger mp-errors" style="display: none"></div>

	<div class="form-group row">
		<label class="control-label col-lg-2">
			{l s='Enabled for this product?' mod='productareapacks'}
		</label>
		<div class="col-lg-10">
			<input data-toggle="switch" class="" id="pap_enabled" name="pap_enabled" data-inverse="true" type="checkbox" value="1" {if $pap_product->enabled eq 1}checked{/if} />
		</div>
	</div>

	<div class="form-group row" style="display: none">
		<label class="control-label col-lg-2">
			{l s='Front End Conversion Enabled?' mod='productareapacks'}
		</label>
		<div class="col-lg-10">
			<input data-toggle="switch" class="" id="unit_conversion_enabled" name="unit_conversion_enabled" data-inverse="true" type="checkbox" value="1" {if $pap_product->unit_conversion_enabled eq 1}checked{/if} />
		</div>
	</div>

	<div class="form-group row" style="display: none">
		<label class="control-label col-lg-2"></label>
		<div class="col-lg-10">
			<select name="unit_conversion_operator" style="width:150px; display: inline-block" class="form-control">
				<option value="">{l s='None' mod='productareapacks'}</option>
				<option value="*" {if $pap_product->unit_conversion_operator eq '*'}selected="selected"{/if}>{l s='Multiply' mod='productareapacks'}</option>
				<option value="/" {if $pap_product->unit_conversion_operator eq '/'}selected="selected"{/if}>{l s='Divide' mod='productareapacks'}</option>
			</select>
			<label>{l s='by' mod='productareapacks'}</label>
			<input type="text" name="unit_conversion_value" value="{$pap_product->unit_conversion_value|escape:'htmlall':'UTF-8'}" style="width:80px; display: inline-block" class="form-control" />
		</div>
	</div>

	<div class="panel-heading" style="font-weight: bold">
		<i class="material-icons">dns</i> {l s='Fields to display' mod='productareapacks'}
	</div>


	<table id="pap-product-fields-list" class="table">
		<tbody>
			<tr>
				<th><span class="title_box"><strong>{l s='Field' mod='productareapacks'}</strong></span></th>
				<th><span class="title_box"><strong>{l s='Visible' mod='productareapacks'}</strong></span></th>
			</tr>
            {foreach from=$pap_dimensions item=dimension}
                <tr>
                    <td>
                        {$dimension->display_name|escape:'htmlall':'UTF-8'}
                    </td>
                    <td>
                        <input data-toggle="switch" class="" id="pap_field_enabled[{$dimension->id_pap_dimension|escape:'htmlall':'UTF-8'}]" name="pap_field_enabled[{$dimension->id_pap_dimension|escape:'htmlall':'UTF-8'}]" data-inverse="true" type="checkbox" value="1" {if $dimension->visible eq "1"}checked{/if} />
                    </td>
                </tr>
            {/foreach}
		</tbody>
	</table>

	<div class="panel-heading" style="font-weight: bold">
		<i class="material-icons">layers</i> {l s='Pack Setup' mod='productareapacks'}
	</div>

	<div class="form-group row">
		<label class="control-label col-lg-2">
			{l s='Calculation Type' mod='productareapacks'}
		</label>
		<div class="col-lg-10">
			<select id="calculation_type" name="calculation_type" class="form-control">
				<option value="normal" {if $pap_product->calculation_type neq 'rolls'}selected{/if}>{l s='Normal Area Based' mod='productareapacks'}</option>
				<option value="rolls" {if $pap_product->calculation_type eq 'rolls'}selected{/if}>{l s='Roll / Wallpapers' mod='productareapacks'}</option>
				<option value="paints" {if $pap_product->calculation_type eq 'paints'}selected{/if}>{l s='Paints / Liquids' mod='productareapacks'}</option>
			</select>
		</div>
	</div>

		{* start: normal *}
        <div id="fields-calculation-normal-panel" class="fields-calculation-panel" {if $pap_product->calculation_type eq 'normal'}style="display: block;"{else}style="display: none"{/if}>
            <div class="form-group row">
                <label class="control-label col-lg-2">
                    {l s='Pack Area' mod='productareapacks'}
                </label>
                <div class="col-lg-10">
                    <div style="position:relative;">
                        <input id="pack_area" name="pack_area" class="form-control" type="number" value="{$pap_product->pack_area|escape:'htmlall':'UTF-8'}"/>
                        <span style="position: absolute; right: 10px; top: 10px;">m2</span>
                    </div>
                </div>
            </div>

			<div class="form-group row">
				<label class="control-label col-lg-2">
					{l s='Area Price' mod='productareapacks'}
				</label>
				<div class="col-lg-10">
					<input id="area_price" name="area_price" class="form-control" type="number" value="{$pap_product->area_price|escape:'htmlall':'UTF-8'}"/>
				</div>
			</div>

			<div class="form-group row">
				<label class="control-label col-lg-2">
					{l s='Dynamic Price based on Area in Cart?' mod='productareapacks'}
				</label>
				<div class="col-lg-10">
					<select name="dynamic_price" class="form-control">
						<option value="0" {if $pap_product->dynamic_price eq 1}selected{/if}>{l s='No' mod='productareapacks'}</option>
						<option value="1" {if $pap_product->dynamic_price eq 1}selected{/if}>{l s='Yes' mod='productareapacks'}</option>
					</select>
				</div>
			</div>
		</div>
		{* end: normal *}

		{* start: rolls *}
        <div id="fields-calculation-rolls-panel" class="fields-calculation-panel" {if $pap_product->calculation_type eq 'rolls'}style="display: block;"{else}style="display: none" {/if}>
            <div class="form-group row">
                <label class="control-label col-lg-2">
                    {l s='Roll Height' mod='productareapacks'}
                </label>
                <div class="col-lg-10">
                    <input id="roll_height" name="roll_height" class="form-control" type="number" value="{$pap_product->roll_height|escape:'htmlall':'UTF-8'}"/>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2">
                    {l s='Roll Width' mod='productareapacks'}
                </label>
                <div class="col-lg-10">
                    <input id="roll_width" name="roll_width" class="form-control" type="number" value="{$pap_product->roll_width|escape:'htmlall':'UTF-8'}"/>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-lg-2">
                    {l s='Pattern Repeat' mod='productareapacks'}
                </label>
                <div class="col-lg-10">
                    <input id="pattern_repeat" name="pattern_repeat" class="form-control" type="number" value="{$pap_product->pattern_repeat|escape:'htmlall':'UTF-8'}"/>
                </div>
            </div>
        </div>
		{* end: rolls *}

        <div id="fields-calculation-paints-panel" class="fields-calculation-panel" {if $pap_product->calculation_type eq 'paints'}style="display: block;"{else}style="display: none"{/if}>
            <div class="form-group row">
                <label class="control-label col-lg-2">
                    {l s='Coverage (m2)' mod='productareapacks'}
                </label>
                <div class="col-lg-10">
                    <input id="coverage" name="coverage" class="form-control" type="number" value="{$pap_product->coverage|escape:'htmlall':'UTF-8'}"/>
                </div>
            </div>
        </div>


	<div class="panel-heading" style="font-weight: bold">
		<i class="material-icons">delete</i> {l s='Wastage Options' mod='productareapacks'}
	</div>

	<div class="form-group row">
		<label class="control-label col-lg-2">
			{l s='Wastage Options' mod='productareapacks'}
		</label>
		<div class="col-lg-10">
			<input name="wastage_options" type="text" class="form-control" value="{$pap_product->wastage_options|escape:'htmlall':'UTF-8'}" />
            <div class="alert alert-info" style="margin-top: 10px;">
                {l s='Enter comma seperated values, eg: 0, 10, 15' mod='productareapacks'}
            </div>
		</div>
	</div>

    <div class="panel-heading" style="font-weight: bold">
        <i class="material-icons">square_foot</i> {l s='Unit conversions' mod='productareapacks'}
    </div>

    <div class="form-group row">
        <div class="col-lg-12">
            <table id="unit-conversion-list" class="table">
                <thead>
                <tr>
                    <th style="width: 50px"><span class="title_box"></span></th>
                    <th><span class="title_box">{l s='Unit' mod='productpricebysize'}</span></th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$pap_units item=unit}
                    <tr>
                        <td>
                            <input type="checkbox" name="unit_conversions[]" class="unit_conversions" value="{$unit.id_pap_unit|escape:'htmlall':'UTF-8'}"
                                   {if $unit.checked eq 1}checked{/if}
                            >
                        </td>
                        <td>{$unit.name|escape:'htmlall':'UTF-8'}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>

</div>

<button type="button" id="btn-pap-general-save" class="btn btn-primary">{l s='Save' mod='productareapacks'}</button>

<script>
	$(document).ready(function () {
		if (typeof prestaShopUiKit !== 'undefined')
			prestaShopUiKit.init();
	});
</script>
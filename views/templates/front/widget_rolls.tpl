{*
* 2007-2016 PrestaShop
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

<div id="pap_widget">
	<div id="pap-wall-template" class="row-units wall" style="display: none;">
		<div class="wall-label col-xs-12 col-sm-2">
			<div>
				{l s='wall' mod='productareapacks'} <span class="index">1</span>
			</div>
		</div>
		{foreach from=$pap_product_fields item=field}
			{if $field->visible eq 1}
				<div class="unit-entry col-xs-6 col-sm-6 col-md-5">
					<label>{$field->dimension->display_name|escape:'htmlall':'UTF-8'}</label>
					<input name="unit_{$field->id_pap_dimension|intval}" style="width:80px;"
						   class="{$field->dimension->name} unit unit-entry form-control" type="text"/>
					<span class="suffix">{$field->dimension->suffix|escape:'htmlall':'UTF-8'}</span>
				</div>
			{/if}
		{/foreach}
		<a class="lnk-remove-wall"><span class="material-icons">clear</span></a>
	</div>

	{assign var="display_walls" value="0"}
	{foreach from=$pap_product_fields item=field}
		{if $field->visible eq 1}
			{assign var="display_walls" value="1"}
		{/if}
	{/foreach}

	{if $display_walls eq 1}
		<div class="pap-walls">
			<div class="row-units wall">
				<div class="wall-label col-xs-12 col-sm-2">
					<div>
						{l s='wall' mod='productareapacks'} <span class="index">1</span>
					</div>
				</div>
				{foreach from=$pap_product_fields item=field}
					{if $field->visible eq 1}
						<div class="unit-entry col-xs-6 col-sm-6 col-md-5">
							<label>{$field->dimension->display_name|escape:'htmlall':'UTF-8'}</label>
							<input name="unit_{$field->id_pap_dimension|intval}" style="width:80px;"
								   class="{$field->dimension->name} unit unit-entry form-control" type="text"/>
							<span class="suffix">{$field->dimension->suffix|escape:'htmlall':'UTF-8'}</span>
						</div>
					{/if}
				{/foreach}
			</div>
		</div>
		<a href="" id="pap-link-add-wall"><i class="material-icons">add_circle</i>{l s='Add a wall' mod='productareapacks'}</a>
	{/if}

	{if $pap_wastage_options_render_type == 'radio_options'}
		{if !empty($pap_product->wastage_options)}
			<div class="pap-wastage">
				<div class="field">
					<label>{$text_wastage_options|escape:'html':'UTF-8'}</label>
					{foreach from=$pap_product->wastage_options item=wastage_option}
						<input type="radio" name="chk_wastage" value="{$wastage_option|escape:'html':'UTF-8'}" />{$wastage_option|escape:'html':'UTF-8'}
					{/foreach}
				</div>
			</div>
		{/if}
	{else}
		{if !empty($pap_product->wastage_options)}
			<div class="pap-wastage">
				<div class="field">
					<label>{$text_wastage_options|escape:'html':'UTF-8'}</label>
					<select name="chk_wastage" class="form-control">
						<option value="0">{l s='No' mod='productareapacks'}</option>
						{foreach from=$pap_product->wastage_options item=wastage_option}
							<option value="{$wastage_option|escape:'html':'UTF-8'}">{$wastage_option|escape:'html':'UTF-8'}</option>
						{/foreach}
					</select>
				</div>
			</div>
		{/if}
	{/if}

	<div class="total-area" style="display: none">
		<div class="field">
			<label>{$text_total_area|escape:'html':'UTF-8'}</label>
			<input type="text" name="pap_total_area" value="0.00" class="form-control" size="8" style="width: 100px" />
			{$text_total_area_suffix|escape:'html':'UTF-8'}
		</div>
	</div>

	{if $pap_display_options eq 1}
		<div class="pap-summary">
			<div class="content">
				{if $pap_show_required_packs == '1'}
					<div class="box-quote">
						<label>{$text_required_packs|escape:'html':'UTF-8'}</label>
						<span class="boxes"></span>
					</div>
				{/if}

				{if $pap_show_box_price == '1'}
					<div class="box-price">
						<label>{$text_pack_price|escape:'html':'UTF-8'}</label>
						<span class="price"></span>
					</div>
				{/if}

				<div class="quote">
					{if $pap_show_quote_inc_tax == '1'}
						<div class="incvat">
							<label>{$text_quote|escape:'html':'UTF-8'}</label>
							<span class="price"></span>
						</div>
					{/if}

					{if $pap_show_quote_ex_tax == '1'}
						<div class="exvat">
							<label>Ex Tax</label> <span class="price"></span>
						</div>
					{/if}
				</div>
			</div>
		</div>
	{/if}
</div>

<script>
	$(document).ready(function() {
		/* setup globals for js controller */
		product = {$product nofilter};
		pap_product = {$pap_product_json nofilter};
		text_total_price_suffix = '{$text_total_price_suffix|escape:'html':'UTF-8'}';
        wastage_render_type = '{$pap_wastage_options_render_type|escape:'html':'UTF-8'}';
		group_reduction = {$group_reduction|escape:'htmlall':'UTF-8'};
	});
</script>
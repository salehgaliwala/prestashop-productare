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

<div id="pap-options">

	<div id="form-pap-options" class="form-wrapper pap-form-wrapper" style="padding-left: 15px;">
		<h3>{l s='Options' mod='productareapacks'}</h3>

		<div class="alert alert-danger" style="display: none"></div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">
					{l s='Display location on Product Page' mod='productareapacks'}
				</span>
			</label>

			<div class="col-lg-7">
				<select name="pap_product_display_location" class="fixed-width-xs fixed-width-xl form-control" id="pap_product_display_location">
					<option value="right" {if $pap_product_display_location eq 'right'}selected{/if}>{l s='Right (Buy Block / Compact)' mod='productareapacks'}</option>
					<option value="center" {if $pap_product_display_location eq 'center'}selected{/if}>{l s='Center' mod='productareapacks'}</option>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">
					{l s='Show area price on product lists?' mod='productareapacks'}
				</span>
			</label>

			<div class="col-lg-7">
				<select name="pap_price_list_modify" class="fixed-width-xs fixed-width-xl form-control" id="pap_price_list_modify">
					<option value="1" {if $pap_price_list_modify eq 1}selected{/if}>{l s='Yes' mod='productareapacks'}</option>
					<option value="0" {if $pap_price_list_modify eq 0}selected{/if}>{l s='No' mod='productareapacks'}</option>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">
					{l s='Show wastage options as:' mod='productareapacks'}
				</span>
			</label>

			<div class="col-lg-7">
				<select name="pap_wastage_options_render_type" class="fixed-width-xs fixed-width-xl form-control" id="pap_price_list_modify">
					<option value="select" {if $pap_wastage_options_render_type neq 'radio_options'}selected{/if}>{l s='Dropdown Select' mod='productareapacks'}</option>
					<option value="radio_options" {if $pap_wastage_options_render_type eq 'radio_options'}selected{/if}>{l s='Radio Options' mod='productareapacks'}</option>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">
					{l s='Display "required packs" on product page?' mod='productareapacks'}
				</span>
			</label>

			<div class="col-lg-7">
				<select name="pap_show_required_packs" class="fixed-width-xs fixed-width-xl form-control" id="pap_price_list_modify">
					<option value="1" {if $pap_show_required_packs eq 1}selected{/if}>{l s='Yes' mod='productareapacks'}</option>
					<option value="0" {if $pap_show_required_packs eq 0}selected{/if}>{l s='No' mod='productareapacks'}</option>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">
					{l s='Display "Quote (Ex TAX)" on product page?' mod='productareapacks'}
				</span>
			</label>

			<div class="col-lg-7">
				<select name="pap_show_quote_ex_tax" class="fixed-width-xs fixed-width-xl form-control" id="pap_price_list_modify">
					<option value="1" {if $pap_show_quote_ex_tax eq 1}selected{/if}>{l s='Yes' mod='productareapacks'}</option>
					<option value="0" {if $pap_show_quote_ex_tax eq 0}selected{/if}>{l s='No' mod='productareapacks'}</option>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="Display " Quote (Inc TAX)" on product page?">
					{l s='Display "Quote (Inc TAX)" on product page?' mod='productareapacks'}
				</span>
			</label>

			<div class="col-lg-7">
				<select name="pap_show_quote_inc_tax" class="fixed-width-xs fixed-width-xl form-control" id="pap_price_list_modify">
					<option value="1" {if $pap_show_quote_inc_tax eq 1}selected{/if}>{l s='Yes' mod='productareapacks'}</option>
					<option value="0" {if $pap_show_quote_inc_tax eq 0}selected{/if}>{l s='No' mod='productareapacks'}</option>
				</select>
			</div>
		</div>


		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">
					{l s='Display "Box Price" on product page?' mod='productareapacks'}
				</span>
			</label>

			<div class="col-lg-7">
				<select name="pap_show_box_price" class="fixed-width-xs fixed-width-xl form-control" id="pap_price_list_modify">
					<option value="1" {if $pap_show_box_price eq 1}selected{/if}>{l s='Yes' mod='productareapacks'}</option>
					<option value="0" {if $pap_show_box_price eq 0}selected{/if}>{l s='No' mod='productareapacks'}</option>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-2" for="">
				<span class="label-tooltip" title="internal name of the dimension (e.g height)">
					{l s='Display the total area which will be supplied in the purchase?' mod='productareapacks'}
				</span>
			</label>

			<div class="col-lg-7">
				<select name="pap_show_quote_total_area" class="fixed-width-xs fixed-width-xl" id="pap_price_list_modify">
					<option value="1" {if $pap_show_quote_total_area eq 1}selected{/if}>{l s='Yes' mod='productareapacks'}</option>
					<option value="0" {if $pap_show_quote_total_area eq 0}selected{/if}>{l s='No' mod='productareapacks'}</option>
				</select>
			</div>
		</div>

		<button type="button" id="btn-pap-options-save" class="btn btn-primary">{l s='Save' mod='productareapacks'}</button>
	</div>

</div>
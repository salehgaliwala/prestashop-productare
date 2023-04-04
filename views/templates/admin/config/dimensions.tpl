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

<div class="row">
	<div id="pap-dimensions-list" class="col-sm-6">
		<table class="table">
			<thead>
			<tr>
				<th>{l s='Internal Name' mod='productareapacks'}</th>
				<th>{l s='Display Name' mod='productareapacks'}</th>
				<th>{l s='Suffix' mod='productareapacks'}</th>
				<th>{l s='Action' mod='productareapacks'}</th>
			</tr>
			</thead>
			<tbody>
				{foreach from=$dimensions item=dimension}
					<tr data-id="{$unit.id_ppat_unit|escape:'html':'UTF-8'}">
						<td>
							{$dimension->name|escape:'htmlall':'UTF-8'}
						</td>
						<td>
							{$dimension->display_name|escape:'htmlall':'UTF-8'}
						</td>
						<td>
							{$dimension->suffix|escape:'htmlall':'UTF-8'}
						</td>
						<td>
							<i class="pap-dimension-edit material-icons" data-id="{$dimension->id_pap_dimension|escape:'htmlall':'UTF-8'}" style="cursor: pointer;">edit</i>
							<i class="pap-dimension-delete material-icons" data-id="{$dimension->id_pap_dimension|escape:'htmlall':'UTF-8'}" style="cursor: pointer;">delete</i>
						</td>
					</td>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>
<button type="button" id="pap-btn-dimension-add" class="btn btn-primary">{l s='Add New Dimension' mod='productareapacks'}</button>
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
*  @copyright  2015-2017 Musaffar Patel
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Property of Musaffar Patel
*}

<div class="panel col-lg-12">
	<div class="table-responsive-row clearfix">
		<table class="table product">
			<thead>
			<tr class="nodrag nodrop">
				<th class="">
					<span class="title_box">
						{l s='Combination' mod='productareapacks'}
					</span>
				</th>
				<th class="">
					<span class="title_box">
						{l s='Reference' mod='productareapacks'}
					</span>
				</th>
				<th></th>
			</tr>
			</thead>

			<tbody>
			{foreach from=$combinations item=combination}
				<tr class="{if $combination['default_on']}highlighted{/if} odd">
					<td class="pointer">
						{$combination['attributes']|escape:'htmlall':'UTF-8'}
					</td>
					<td class="pointer">
						{$combination['reference']|escape:'htmlall':'UTF-8'}
					</td>
					<td class="text-right">
						<div class="btn-group pull-right">
							<a title="Edit" class="pap-edit-combination btn btn-default" data-id_product_attribute="{$combination['id_product_attribute']|escape:'htmlall':'UTF-8'}">
								<i class="icon-pencil"></i> Edit
							</a>
						</div>
					</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
	</div>
</div>
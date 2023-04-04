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
*  @copyright  2015-2016 Musaffar Patel
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Property of Musaffar Patel
*}

<script>
    pap_module_ajax_url = "{$link->getModuleLink('productareapacks', 'ajax', array())|escape:'quotes':'UTF-8' nofilter}";
	{if ($action eq 'quickview')}
		$(document).ready(function() {
			pap_front_product_controller = new PAPFrontProductController('#pap_widget', '');
		});
	{else}
		document.addEventListener("DOMContentLoaded", function(event) {
			$(function() {
				{if $pap_product->calculation_type eq 'normal'}
					pap_front_product_controller = new PAPFrontProductNormalController('#pap_widget', '');
				{/if}

				{if $pap_product->calculation_type eq 'paints'}
					pap_front_product_controller = new PAPFrontProductPaintsController('#pap_widget', '');
				{/if}

				{if $pap_product->calculation_type eq 'rolls'}
					pap_front_product_controller = new PAPFrontProductRollsController('#pap_widget', '');
				{/if}

			});
		});
	{/if}
</script>
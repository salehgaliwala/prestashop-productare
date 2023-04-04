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

<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item active">
		<a class="nav-link" data-toggle="tab" href="#pap-dimensions-tab" role="tab">{l s='Dimensions' mod='productareapacks'}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#pap-options-tab" role="tab">{l s='Options' mod='productareapacks'}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#pap-translations-tab" role="tab">{l s='Translations' mod='productareapacks'}</a>
	</li>
</ul>

<div class="tab-content">
	<div class="pap-breadcrumb"></div>
	<div class="tab-pane active pap-tab-pane" id="pap-dimensions-tab" role="tabpanel"></div>
	<div class="tab-pane pap-tab-pane" id="pap-options-tab" role="tabpanel"></div>
	<div class="tab-pane pap-tab-pane" id="pap-translations-tab" role="tabpanel"></div>
</div>

<script>
	$(document).ready(function () {
		breadcrumb = [];
		module_config_url = '{$module_config_url|escape:'quotes':'UTF-8'}';
		pap_dimensions_controller = new PAPAdminConfigDimensionsController('#pap-dimensions-tab');
		pap_options_controller = new PAPAdminConfigOptionsController('#pap-options-tab');
		pap_translations_controller = new PAPAdminConfigTranslationsController('#pap-translations-tab');
	});
</script>
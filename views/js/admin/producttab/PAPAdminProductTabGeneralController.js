/*
* 2007-2015 PrestaShop
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
*  @copyright  2015-2017 Musaffar
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Property of Musaffar Patel
*/

PAPAdminProductTabGeneralController = function(canvas) {

	var self = this;
	self.canvas = canvas;
	self.$canvas = $(canvas);

	self.render = function() {
		MPTools.waitStart();
		let url = pap_ajax_url + '&route=papadminproducttabgeneralcontroller&action=render&rand=' + new Date().getTime();

		let post_data = {
			'id_product': id_product
		};

		$.ajax({
			type: 'POST',
			url: url,
			async: true,
			cache: false,
			data: post_data,
			success: function (html_result) {
				self.$canvas.html(html_result);
				MPTools.waitEnd();
			}
		});
	};

	/**
	 * save the general options
	 */
	self.processForm = function() {
		MPTools.waitStart();

		var url = pap_ajax_url + '&route=papadminproducttabgeneralcontroller&action=processform&rand=' + new Date().getTime();

		$.ajax({
			type: 'POST',
			url: url,
			async: true,
			cache: false,
			data: self.$canvas.find(" :input, select").serialize(),
			success: function (result) {
				MPTools.waitEnd();
			}
		});
	};

	self.init = function() {
		self.render();
	};
	self.init();

	/**
	 * On calculation type change
	 */
	$("body").on("change", "#calculation_type", function() {
		$(".fields-calculation-panel").hide();

		switch ($(this).val()) {
			case 'normal':
				$("#fields-calculation-normal-panel").show();
				break;

			case 'rolls':
				console.log('go');
				$("#fields-calculation-rolls-panel").show();
				break;

			case 'paints':
				$("#fields-calculation-paints-panel").show();
				break;
		}
		return false;
	});


	/**
	 * Save general options
	 */
	$("body").on("click", "#btn-pap-general-save", function() {
		self.processForm();
		return false;
	});
};


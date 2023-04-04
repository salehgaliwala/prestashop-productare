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

PAPAdminProductTabCombinationsController = function(canvas) {

	var self = this;
	self.canvas = canvas;
	self.$canvas = $(canvas);

	self.popupEditFormId = 'pap-popup-editcombination';
	self.popup; //instance of modal popup

	self.render = function() {
		MPTools.waitStart();

		var url = pap_ajax_url + '&route=papadminproducttabcombinationscontroller&action=render&rand=' + new Date().getTime();

		var post_data = {
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
	 * Open the combination edit form / popup
 	 * @param id_bundle
	 * @returns {boolean}
	 */
	self.openForm = function(id_product_attribute) {
		MPTools.waitStart();
		var url = pap_ajax_url + '&route=papadminproducttabcombinationscontroller&action=rendereditform&rand=' + new Date().getTime();
		url = url + '&id_product_attribute=' + id_product_attribute + '&id_product=' + id_product;

		self.popup = new MPPopup(self.popupEditFormId, self.canvas);
		self.popup.showContent(url, null, function () {
			$popup = self.$canvas.find("#" + self.popupEditFormId);

			switch ($("select#calculation_type").val()) {
				case 'normal':
					$popup.find("#fields-calculation-normal-panel-combination").show();
					break;

				case 'rolls':
					$popup.find("#fields-calculation-rolls-panel-combination").show();
					break;

				case 'paints':
					$popup.find("#fields-calculation-paints-panel-combination").show();
					break;
			}

			MPTools.waitEnd();
		});
		return false;
	};


	/**
	 * Save the form
 	 */
	self.processEditForm = function() {
		var url = pap_ajax_url + '&route=papadminproducttabcombinationscontroller&action=processeditform&rand=' + new Date().getTime();
		var data = self.$canvas.find("#form-pap-combination-edit :input").serialize();

		MPTools.waitStart();

		$.ajax({
			type: 'POST',
			url: url,
			cache: false,
			data: data,
			success: function (result) {
				MPTools.waitEnd();
				self.popup.close();
			}
		});
	};

	self.init = function() {
		self.render();
	};
	self.init();

	/**
	 * Combination edit click
	 */
	$("body").on("click", self.canvas + " a.pap-edit-combination", function () {
		self.openForm($(this).attr("data-id_product_attribute"));
		return false;
	});

	/**
	 * Combination edit popup save button
	 */
	$("body").on("click", self.canvas + " #btn-pap-combination-save", function () {
		self.processEditForm();
		return false;
	});


};
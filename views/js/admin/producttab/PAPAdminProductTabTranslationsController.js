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

PAPAdminProductTabTranslationsController = function(canvas) {

	var self = this;
	self.canvas = canvas;
	self.$canvas = $(canvas);
	self.controller = 'papadminproducttabtranslationscontroller';

	self.render = function() {
		MPTools.waitStart();

		var url = pap_ajax_url + '&route='+ self.controller+'&action=render&rand=' + new Date().getTime();

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
	 * Save the translations form
 	 */
	self.processForm = function() {
		let url = pap_ajax_url + '&route=' + self.controller + '&action=process&rand=' + new Date().getTime();
		let data = self.$canvas.find("#form-pap-translations :input").serialize();

		MPTools.waitStart();
		$.ajax({
			type: 'POST',
			url: url,
			cache: false,
			data: data,
			success: function (result) {
				console.log(result);
				MPTools.waitEnd();
			}
		});
	};

	self.init = function() {
		self.render();
	};
	self.init();

	/**
	 * On save Button click
 	 */
	$("body").on("click", "#btn-pap-translations-save", function() {
		self.processForm();
		return false;
	});


};
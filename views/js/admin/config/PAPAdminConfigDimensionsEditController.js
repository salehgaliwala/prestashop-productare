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

PAPAdminConfigDimensionsEditController = function(wrapper) {
	var self = this;
	self.wrapper = wrapper;
	self.$wrapper = $(wrapper);

	/* function render main form into the tab canvas */
	self.render = function(id_pap_dimension) {
		var url = module_config_url + '&route=papadminconfigdimensionscontroller&action=renderedit';
		var post_data = {};
		breadcrumb.add('Add / Edit', url, post_data);

		MPTools.waitStart();

		if (typeof id_pap_dimension === 'undefined')
			id_pap_dimension = 0;

		$.ajax({
			type: 'POST',
			url: url,
			async: true,
			cache: false,
			data: {
				id_pap_dimension : id_pap_dimension
			},
			success: function (html_content) {
				self.$wrapper.html(html_content);
				MPTools.waitEnd();
			}
		});
	};

	/**
	 * Save the Add/Edit Dimension Form
 	 */
	self.processForm = function() {
		MPTools.waitStart();
		$.ajax({
			type: 'POST',
			url: module_config_url + '&route=papadminconfigdimensionscontroller&action=processform',
			async: true,
			cache: false,
			//dataType: "json",
			data: self.$wrapper.find("#form-pap-dimension-edit :input, select").serialize(),
			success: function (jsonData) {
				MPTools.waitEnd();
				breadcrumb.cancel();
			}
		});
	};

	/**
	 * Commit delete tab action
 	 */
	self.processDelete = function(id_tab) {
		MPTools.waitStart();
		$.ajax({
			type: 'POST',
			url: module_config_url + '&route=pbpadminconfigtabscontroller&action=processdelete',
			async: true,
			cache: false,
			data: {
				id_tab : id_tab
			},
			success: function (jsonData) {
				MPTools.waitEnd();
				self.renderList();
			}
		});
	};

	self.init = function() {
	};
	self.init();

	/* Events */

	/**
	 * Save edit unit button click
	 */
	$("body").on("click", self.wrapper + ' #btn-pap-edit-dimension-save', function () {
		self.processForm();
	});

	/**
	 * Cancel edit unit button click
	 */
	$("body").on("click", self.wrapper + ' #btn-pap-edit-dimension-cancel', function () {
		breadcrumb.cancel();
	});


};


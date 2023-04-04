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

PAPFrontProductPaintsController = function(wrapper, after_element) {
	var self = this;
	self.calculation_type = 'paints';
	PAPFrontProductControllerCore.call(this, wrapper, after_element);

	/**
	 * Get number of coats required selected by customer
 	 * @returns {number}
	 */
	self.getCoatsRequired = function() {
		return parseInt(self.$wrapper.find("select[name='coats']").val());
	};

	/* gets the the total area entered by the customer in the unit dimensions fields */
	self.getTotalAreaEntered = function (bln_add_wastage) {
		var total_area_entered = 0;
		var $walls = self.$wrapper.find(".pap-walls");

		if ($walls.length > 0) {
			$walls.find(".wall").each(function (i, obj) {
				var $wall = $(obj);
				total_area_entered = total_area_entered + self.getWallArea($wall);
			})
		}

		if (bln_add_wastage) {
			total_area_entered = self.addWastage(total_area_entered);
		}

		total_area_entered = total_area_entered * self.getCoatsRequired();
		return total_area_entered;
	};

	/**
	 * Get Qty Required based on entered value
	 * @returns {number}
	 */
	self.getQtyRequired = function () {
		qty_required = 0;
		total_area_entered = self.getTotalAreaEntered(true);

		if (total_area_entered > 0) {
			qty_required = Math.ceil(total_area_entered / self.pack_info.coverage);
			return qty_required;
		} else {
			return 1;
		}
	};

	/**
	 * Called when we need to update the quote and quantity
 	 */
	self.update = function() {
		console.log('update');
		var qty = self.getQtyRequired();
		self.updateQtyField(qty);
		self.updateTotalAreaField();
		self.refreshQuote(qty);
	};

	/**
	 * Event handler for wastage option change
	 * @param $sender
	 */
	self.onWastageChange = function ($sender) {
		self.update();
	};

	/**
	 * On input change
	 */
	self.inputFieldChanged = function () {
		console.log('changed');
		self.updatePrices();
	};

	/**
	 * On coats required change
 	 */
	$(document).on('change', self.wrapper + " select[name='coats']", function () {
		self.update();
	});

};
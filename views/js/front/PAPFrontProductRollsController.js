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

PAPFrontProductRollsController = function(wrapper, after_element) {
	var self = this;
	self.calculation_type = 'rolls';
	PAPFrontProductControllerCore.call(this, wrapper, after_element);

	self.round = function (value, precision) {
		var multiplier = Math.pow(10, precision || 0);
		return Math.round(value * multiplier) / multiplier;
	};

	/**
	 * Get number of coats required selected by customer
 	 * @returns {number}
	 */
	self.getCoatsRequired = function() {
		return parseInt(self.$wrapper.find("select[name='coats']").val());
	};

	/* gets the the total area entered by the customer in the unit dimensions fields */
	self.getTotalAreaEntered = function () {
		var total_area_entered = 0;
		var $walls = self.$wrapper.find(".pap-walls");

		if ($walls.length > 0) {
			$walls.find(".wall").each(function (i, obj) {
				var $wall = $(obj);
				total_area_entered = total_area_entered + self.getWallArea($wall);
			})
		}
		return total_area_entered;
	};

	/**
	 * Get the total width of all walls combined
	 * @returns {number}
	 */
	self.getTotalWidthEntered = function() {
		var total_width_entered = 0;
		var $walls = self.$wrapper.find(".pap-walls");

		if ($walls.length > 0) {
			$walls.find(".wall").each(function (i, obj) {
				var $wall = $(obj);
				total_width_entered = total_width_entered + parseFloat($wall.find("input.width").val());
			})
		}
		return total_width_entered;
	};

	/**
	 * Get the height wall from all walls
 	 */
	self.getHeighestWall = function() {
		var $walls = self.$wrapper.find(".pap-walls");
		var highest = -Infinity;
		$(".pap-walls input.height").each(function () {
			highest = Math.max(highest, parseFloat(this.value));
		});
		return highest;
	};

	/**
	 * Get Qty of Rolls required based on walls
	 * @returns {number}
	 */
	self.getQtyRequired = function () {
		var wall_width = self.getTotalWidthEntered();
		var wall_height = self.getHeighestWall();
		var roll_width = parseFloat(self.pack_info.roll_width);
        var roll_height = parseFloat(self.pack_info.roll_height);
		var pattern_repeat = parseFloat(self.pack_info.pattern_repeat);

        if (pap_product.unit_conversion_enabled == 1 && pap_product.unit_conversion_operator == "/") {
            wall_width = wall_width / pap_product.unit_conversion_value;
            wall_height = wall_height / pap_product.unit_conversion_value;
        }
        if (pap_product.unit_conversion_enabled == 1 && pap_product.unit_conversion_operator == "*") {
            wall_width = wall_width * pap_product.unit_conversion_value;
            wall_height = wall_height * pap_product.unit_conversion_value;
        }

        var pattern_repeats = Math.ceil(wall_height / pattern_repeat);
		var lane_height = pattern_repeats * pattern_repeat;
		var lanels_per_roll = Math.floor(roll_height / lane_height);

		var rolls_required = Math.ceil(wall_width / (lanels_per_roll * roll_width));
		return rolls_required;
	};

	/**
	 * Return extra number of rolls selected for wastage
 	 */
	self.getWastage = function() {
		var chk_wastage_value = 0;
		if (wastage_render_type != 'select') {
			$chk_wastage = self.$wrapper.find("input[name='chk_wastage']");
			chk_wastage_value = self.$wrapper.find("input[name='chk_wastage']:radio:checked").val();
			if ($chk_wastage.is(":checked") && typeof chk_wastage_value != 'undefined' && chk_wastage_value > 0) {
				return parseInt(chk_wastage_value);
			}
		} else {
			$chk_wastage = self.$wrapper.find("select[name='chk_wastage']");
			chk_wastage_value = $chk_wastage.val();
			if (typeof chk_wastage_value != 'undefined' && chk_wastage_value > 0) {
				return parseInt(chk_wastage_value);
			}
		}
		return parseInt(chk_wastage_value);
	};

	/**
	 * Called when we need to update the quote and quantity
 	 */
	self.update = function() {
		var qty = self.getQtyRequired();
		qty += self.getWastage();
		self.updateQtyField(qty);
		self.updateTotalAreaField();
		self.refreshQuote(qty);
	};

	/**
	 * On input change
 	 */
	self.inputFieldChanged = function () {
		self.updatePrices();
	};

	/**
	 * Event handler for wastage option change
	 * @param $sender
	 */
	self.onWastageChange = function ($sender) {
		self.update();
	};

};
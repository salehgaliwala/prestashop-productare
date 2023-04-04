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



PAPFrontProductNormalController = function(wrapper, after_element) {

	var self = this;

	self.calculation_type = 'normal';

	PAPFrontProductControllerCore.call(this, wrapper, after_element);



	/**

	 * Get Qty Required based on entered value

	 * @returns {number}

	 */

	self.getQtyRequired = function () {

		qty_required = 0;

		total_area_entered = self.getTotalAreaEntered();

        total_area_entered = self.convertToMeters(total_area_entered)



		if (total_area_entered > 0) {

			qty_required = Math.ceil((total_area_entered / self.pack_info.pack_area).toFixed(4));

			//return qty_required;
			return 1;

		} else return 1;

	};



	/* gets the the total area entered by the customer in the unit dimensions fields */

	self.getTotalAreaEntered = function (add_wastage = true) {

		var total_area_entered = 1;



		if (self.$wrapper.find("input.unit-entry").length > 0) {

			self.$wrapper.find("input.unit-entry").each(function (i, obj) {

				var name = $(obj).attr("name");

				var value = self.$wrapper.find("input[name='" + name + "']").val();

				value = self.removeFormatting(value.toString());

				if (isNaN(value)) value = 1;

				if (pap_product.unit_conversion_enabled == 1 && pap_product.unit_conversion_operator == "/") value = value / pap_product.unit_conversion_value;

				if (pap_product.unit_conversion_enabled == 1 && pap_product.unit_conversion_operator == "*") value = value * pap_product.unit_conversion_value;

				total_area_entered = total_area_entered * value;

			});

		} else {

			total_area_entered = parseFloat(self.$wrapper.find("input[name='pap_total_area']").val());

		}



		var $pap_total_area = self.$wrapper.find("input[name='pap_total_area']");

		if (total_area_entered == 0 && parseFloat($pap_total_area.val()) > 0) {

			total_area_entered = parseFloat($pap_total_area.val());

		}



		if (add_wastage) {

			total_area_entered = self.addWastage(total_area_entered);

		}



		return total_area_entered;

	};



	/**

	 * Update Prices and Qty and Refresh Quote

	 */

	self.updatePrices = function () {

        $qty = $("input[name='qty']");

		$qty.val(self.getQtyRequired());

        //$qty.trigger('change');

		$("input[name='pap_total_area']").val(self.getTotalAreaEntered(false).toFixed(2));

		self.refreshQuote($qty.val());

	};



};
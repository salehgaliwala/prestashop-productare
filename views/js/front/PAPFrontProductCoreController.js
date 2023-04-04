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



PAPFrontProductControllerCore = function(wrapper, after_element) {

	var self = this;

	self.wrapper = wrapper;

	self.$wrapper = $(wrapper);

	self.module_folder = 'productareapacks';



    self.div_conversion_unit = self.wrapper + ' .conversion-options';

	self.btn_conversion_unit = self.div_conversion_unit + ' .unit';



	self.pack_info = {

		area_price: 0.00,

		pack_area: 0.00,

		price_extax: 0.00,

		price: 0.00

	};



	/**

	 * normalise number

	 * @param number

	 * @returns {*}

	 */

	self.removeFormatting = function (number) {

		if (number.indexOf('.') > 0) {

			number = number.replace(",", "");

		}

		else {

			number = number.replace(",", ".");

		}

		return (number);

	};



	/**

	 * Display the widget via ajax

	 */

	self.renderWidget = function () {

        let url = MPTools.joinUrl(pap_module_ajax_url, 'section=front_ajax&route=papfrontproductcontroller&action=renderwidget&rand=' + new Date().getTime());

		return $.ajax({

			type: 'POST',

			url: url,

			async: true,

			cache: false,

			data: {

				'id_product': $("input[name='id_product']").val(),

				'calculation_type' : self.calculation_type

			},

			success: function (html) {

				if ($("div.product-variants").length) {

					$(html).insertBefore("div.product-variants");

				} else {

					$(html).insertBefore("div.product-add-to-cart:first");

				}

				self.bindWidgetEvents();

                self.setSufficesUnit(self.getSelectedConversionUnit());

			}

		});

	};



	/**

	 * Get info we need about the PAP Product based on selected attributes

	 */

	self.getPackInfo = function () {

		var query = $("#add-to-cart-or-refresh").serialize();

        let url = MPTools.joinUrl(pap_module_ajax_url, 'section=front_ajax&route=papfrontproductcontroller&action=getpackinfo&' + query);



		return $.ajax({

			type: 'POST',

			url: url,

			async: true,

			cache: false,

			data: {

				'id_product': $("input[name='id_product']").val()

			},

			dataType: 'json',

			success: function (resp) {

				self.pack_info.area_price = resp.area_price;

				self.pack_info.pack_area = resp.pack_area;

				self.pack_info.price_extax = resp.price_extax;

				self.pack_info.price = resp.price;

				self.pack_info.calculation_type = resp.calculation_type;

				self.pack_info.roll_height = resp.roll_height;

				self.pack_info.roll_width = resp.roll_width;

				self.pack_info.pattern_repeat = resp.pattern_repeat;

				self.pack_info.coverage = resp.coverage;

                self.pack_info.dynamic_price = resp.dynamic_price;

			}

		});

	};





	/**

	 * Bind widgets controls to any events (which need to be done after widget is rendered via ajax)

	 */

	self.bindWidgetEvents = function () {

		self.$wrapper = $(self.wrapper);

		$('input.unit, input[name="pap_total_area"]').typeWatch({

			callback: function () {

				self.inputFieldChanged();

			},

			wait: 500,

			highlight: false,

			captureLength: 0

		});

	};



	/**

	 * Get formatted version of price, async

	 * @param price

	 * @param callback

	 * @returns {*}

	 */

	self.formatPrice = function (price, callback) {

        let url = MPTools.joinUrl(pap_module_ajax_url, 'section=front_ajax&route=papfrontproductcontroller&action=formatprice');

		return $.ajax({

			type: 'POST',

			url: url,

			async: true,

			cache: false,

			data: {

				'price': price

			},

			//dataType: 'json',

			success: function (resp) {

				if (typeof callback === 'function')

					callback(resp);

			}

		});

	};



	/**

	 * Get the area entered for a wall

	 * @param $wall

	 */

	self.getWallArea = function($wall) {

		var wall_area = 1;

		$wall.find("input.unit-entry").each(function (i, obj) {

			var name = $(obj).attr("name");

			var value = $wall.find("input[name='" + name + "']").val();

			value = self.removeFormatting(value);

			if (isNaN(value)) value = 1;

			if (pap_product.unit_conversion_enabled == 1 && pap_product.unit_conversion_operator == "/") value = value / pap_product.unit_conversion_value;

			if (pap_product.unit_conversion_enabled == 1 && pap_product.unit_conversion_operator == "*") value = value * pap_product.unit_conversion_value;

			wall_area = wall_area * value;

		});

		return parseFloat(wall_area);

	};



    /**

     * Convert the value to meters

     * @returns {number}

     */

    self.convertToMeters = function(value) {

	    let mm_in_m = 1000;

	    let result = 0;

	    if ($(self.btn_conversion_unit + '.selected').length > 0) {

            let conversion_factor = parseFloat($(self.btn_conversion_unit + '.selected').attr('data-conversion-factor'));

            result = value / (mm_in_m / conversion_factor);

        } else {

	        result = value;

        }

	    return result;

    }



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



		total_area_entered = self.addWastage(total_area_entered);

		return total_area_entered;

	};



	/**

	 * Refresh all the quote related information

	 * @param quantity

	 */

	self.refreshQuote = function (quantity) {

		var quote = parseFloat(product.price).toFixed(10);

		var quote_incvat = 0.00;

		var quote_exvat = 0.00;

		var total_packs_area = parseFloat(self.pack_info.pack_area) * parseFloat(quantity);



		self.$wrapper.find(".box-quote .boxes").html(quantity);



		if (parseFloat(product.tax_rate) > 0) {

			quote_incvat = self.pack_info.price;

			quote_exvat = self.pack_info.price_extax;



            if (self.pack_info.dynamic_price == '0') {

                quote_incvat = parseFloat(quote_incvat * quantity).toFixed(2);

                quote_exvat = parseFloat(quote_exvat * quantity).toFixed(2);

            } else {

                quote_incvat = parseFloat(quote_incvat * self.pack_info.pack_area * quantity).toFixed(2);

                quote_exvat = parseFloat(quote_exvat * self.pack_info.pack_area * quantity).toFixed(2);

            }



			self.formatPrice(quote_incvat, function (formatted_price) {

				self.$wrapper.find(".quote .incvat span.price").html(formatted_price);

			});



			self.formatPrice(quote_exvat, function (formatted_price) {

				self.$wrapper.find(".quote .exvat span.price").html(formatted_price);

			});

		} else {

            if (self.pack_info.dynamic_price == '0') {

                quote = parseFloat(quote * quantity);

            } else {

                quote = parseFloat(quote * self.pack_info.pack_area * quantity).toFixed(2);

            }

			self.formatPrice(quote, function (formatted_price) {

				self.$wrapper.find(".quote .exvat span.price").html(formatted_price);

			});

		}



		self.formatPrice(self.pack_info.price, function (formatted_price) {

			self.$wrapper.find(".box-price .price").html(formatted_price);

		});



		self.$wrapper.find("span.total-area-packs").html(total_packs_area.toFixed(2));

		//self.refreshAreaPrice();

	};



	/**

	 * Update Prices and Qty and Refresh Quote

	 */

	self.updatePrices = function () {

		var qty = self.getQtyRequired();

		if (isNaN(qty)) {

			qty = 1;

		}

		$qty = $("input[name='qty']");

		$qty.val(qty);

		$("input[name='pap_total_area']").val(self.getTotalAreaEntered().toFixed(2));

		self.refreshQuote($qty.val());

	};



	self.updatePricesFromQty = function (qty) {

		total_area = parseFloat(qty * self.pack_info.pack_area).toFixed(2);

		$("input[name='pap_total_area']").val(total_area);

		self.refreshQuote(qty);

	};





	/**

	 * Update the product quantity field

 	 * @param qty

	 */

	self.updateQtyField = function(qty) {

		if (isNaN(qty)) {

			qty = 1;

		}

		$qty = $("input[name='qty']");

		//$qty.val(qty);

      //  $qty.trigger('change');

	};





	/**

	 * On field value changed due to customer input

	 * @param e

	 */

	self.inputFieldChanged = function () {

		displayValue = "";

		var form_json = new Object();



		self.$wrapper.find("input.unit-entry").each(function (i, obj) {

			var name = $(obj).attr("name");

			var value = self.$wrapper.find("input[name='" + name + "']").val();

			value = self.removeFormatting(value);



			if (isNaN(value)) value = 0;



			if (pap_product.unit_conversion_enabled == 1 && pap_product.unit_conversion_operator == "/") value = value / pap_product.unit_conversion_value;

			if (pap_product.unit_conversion_enabled == 1 && pap_product.unit_conversion_operator == "*") value = value * pap_product.unit_conversion_value;

			form_json["unit_" + name] = value;

		});



		self.updatePrices();

	};



	/**

	 * Add Wastage

	 * @param area

	 * @returns {*}

	 */

	self.addWastage = function (area) {

		if (wastage_render_type == 'radio_options') {

			$chk_wastage = self.$wrapper.find("input[name='chk_wastage']");

			chk_wastage_value = self.$wrapper.find("input[name='chk_wastage']:radio:checked").val();

			if ($chk_wastage.is(":checked") && typeof chk_wastage_value != 'undefined' && chk_wastage_value > 0)

				area = parseFloat(area) + (chk_wastage_value / 100) * parseFloat(area);

		} else {

			$chk_wastage = self.$wrapper.find("select[name='chk_wastage']");

			chk_wastage_value = $chk_wastage.val();

			if (typeof chk_wastage_value != 'undefined' && chk_wastage_value > 0)

				area = parseFloat(area) + (chk_wastage_value / 100) * parseFloat(area);

		}

		return area;

	};



	/**

	 * Add a new wall

 	 */

	self.addWall = function() {

		var wall_index = self.$wrapper.find(".pap-walls .wall").length + 1;

		var $wall = self.$wrapper.find("#pap-wall-template").clone();

		$wall.attr("id", '');

		$wall.show();

		$wall.find("span.index").html(wall_index);

		$wall.appendTo(self.$wrapper.find(".pap-walls"));

		self.bindWidgetEvents();

	};



	/**

	 * Remove wall

 	 * @param $sender

	 */

	self.removeWall = function($sender) {

		$sender.parents(".wall").remove();

		self.inputFieldChanged();

	};



	/**

	 * Update the total area field based on sum area of all walls

 	 */

	self.updateTotalAreaField = function() {

		$("input[name='pap_total_area']").val(self.getTotalAreaEntered(false).toFixed(2));

	};



	/**

	 * Event handler for wastage option change

 	 * @param $sender

	 */

	self.onWastageChange = function($sender) {

		$pap_total_area = $("input[name='pap_total_area']");

		if (!isNaN($pap_total_area.val()) && $pap_total_area.val() > 0) {

			qty_required = Math.ceil(parseFloat(self.addWastage($pap_total_area.val())) / self.pack_info.pack_area);

			$("input[name='qty']").val(qty_required);

			self.refreshQuote(qty_required);

		}

		else {

			self.updatePrices();

		}

	};



	self.resetAllFields = function() {

	    self.$wrapper.find("input[name='pap_total_area']").val('0.00');

    }



	self.setSufficesUnit = function(unit) {

        self.$wrapper.find('.suffix-unit').html(unit);

    }



    self.getSelectedConversionUnit = function() {

	    let $selected = $(self.btn_conversion_unit + '.selected');

        if ($selected.length > 0) {

            return $selected.attr('data-unit-symbol');

        } else {

            return 'm';

        }

    }



	self.onBtnConversionUnitClick = function($sender) {

        self.resetAllFields();

        $(self.btn_conversion_unit).removeClass('selected');

        $sender.addClass('selected');

        self.setSufficesUnit($sender.attr('data-unit-symbol'));

        self.updatePrices();

    };





	self.init = function () {

		$.when(self.renderWidget()).then(self.getPackInfo);

	};

	self.init();





	/** Events **/



	/**

	 * Wastage option changed

	 */

	$(document).on('change', self.wrapper + " input[name='chk_wastage'], select[name='chk_wastage']", function () {

		self.onWastageChange($(this));

	});



	/***

	 * On add new wall link click

 	 */

	$(document).on('click', self.wrapper + " a#pap-link-add-wall", function () {

		self.addWall();

		return false;

	});



	/***

	 * On remove wall link click

	 */

	$(document).on('click', self.wrapper + " a.lnk-remove-wall", function () {

		self.removeWall($(this));

		return false;

	});



    /***

     * On remove wall link click

     */

    $(document).on('click', self.btn_conversion_unit, function () {

        self.onBtnConversionUnitClick($(this));

        return false;

    });



    /**

	 * On Attributes changed

	 */

	prestashop.on('updatedProduct', function (event) {

		self.getPackInfo().then(function () {

			self.updatePrices();

		});

	});



	let quantityInput = $('#quantity_wanted');

	quantityInput.off('keyup change');

	quantityInput.on('keyup change', function (event) {

	//	const newQuantity = $(this).val();

		self.updatePricesFromQty(newQuantity);

	});



};
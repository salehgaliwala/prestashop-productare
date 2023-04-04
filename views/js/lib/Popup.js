/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * You must not modify, adapt or create derivative works of this source code
 *
 * @author    Musaffar Patel
 * @copyright 2016-2017 Musaffar Patel
 * @license   LICENSE.txt
 */

MPPopup = function (id, dom_parent) {
	var self = this;
	self.dom_parent = "body";
	self.id = id;

	self._createOverlay = function () {
		$(self.dom_parent).prepend("<div id='mp-popup-wrapper'><span id='mp-popup-close'><i class='material-icons'>clear</i></span><div class='mp-popup-content'></div></div>");
		$(self.dom_parent).prepend("<div id='mp-overlay'></div>");
	};

	self._positionSubPanels = function () {
		$("#mp-popup-wrapper .mp-popup-content .subpanel").each(function() {
			var x = $("#mp-popup-wrapper").width();
			var height = $("#mp-popup-wrapper").height();
			$(this).css("left", x + "px");
			$(this).css("width", x + "px");
			$(this).css("height", height + "px");
		});
	};

	self.showSubPanel = function(id) {
		$("#" + self.id).find("#" + id).animate({
			left: "0px",
		}, 250, function () {
		});
	};

	self.hideSubPanel = function (id) {
		var x = $("#mp-popup-wrapper").width();
		$("#" + self.id).find("#" + id).animate({
			left: x + "px",
			}, 250, function () {
			}
		);
	};


	self.loadContent = function(url, data) {
		$("#mp-popup-wrapper").load(url,
			function () {
				$("#mp-overlay").fadeIn();
				self._positionSubPanels();
			}
		);
	};

	self.show = function() {
		self._createOverlay();
	};

	self.showContent = function(url, data, callback_function) {
		self._createOverlay();
		$(".mp-popup-content").load(url,
			function () {
				$("#mp-overlay").fadeIn();
				$(".mp-popup-content").attr('id', self.id);
				self._positionSubPanels();

				if (typeof(callback_function) === 'function')
					callback_function();
			}
		);
	};

	self.close = function() {
		$("#mp-popup-wrapper").remove();
		$("#mp-overlay").remove();
	};

	/* events */
	$("body").on("click", "#mp-popup-close", function () {
		self.close();
	});

	self.init = function(dom_parent) {
		if (typeof dom_parent !== 'undefined')
			self.dom_parent = dom_parent;
	};
	self.init(dom_parent);
};
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

Breadcrumb = function(wrapper, canvas) {

	var self = this;

	self.wrapper = wrapper;
	self.$wrapper = $(wrapper);
	self.canvas = canvas;
	self.$canvas = $(canvas);

	self.breadcrumb_array = [];

	self.render = function() {
		self.$wrapper.html();
		var html = '';

		for (i=0; i<= self.breadcrumb_array.length-1; i++) {
			var obj_breadcrumb = self.breadcrumb_array[i];

			if (i == self.breadcrumb_array.length - 1)
				html += '<span data-url="' + obj_breadcrumb.url + '" data-index="' + i + '">' + obj_breadcrumb.title + '</span>';
			else
				html += '<a data-url="'+ obj_breadcrumb.url+'" data-index="'+i+'">' + obj_breadcrumb.title + '</a>';
		};
		self.$wrapper.html(html);
	};

	self.add = function(title, url, post_data) {
		var tmp = {
			'title' : title,
			'url' : url,
			'post_data' : post_data
		};
		self.breadcrumb_array.push(tmp);
		self.render();
	};

	self.pop = function() {
		self.breadcrumb_array.pop();
	};

	/**
	 * remove al breadcrumb items after a specified index
	 */
	self.popAfter = function(index) {
		self.breadcrumb_array = self.breadcrumb_array.slice(index, self.breadcrumb_array.length-1);
	};

	self.cancel = function() {
		this.pop();
		var post_data = self.breadcrumb_array[self.breadcrumb_array.length - 1]['post_data'];
		var prev_url = self.breadcrumb_array[self.breadcrumb_array.length - 1]['url'];

		$.ajax({
			type: 'POST',
			url: prev_url,
			async: true,
			cache: false,
			//dataType: "json",
			data: post_data,
			success: function (html_result) {
				self.$canvas.html(html_result);
				self.render();
			}
		});
	};

	/**
	 * Load content of specfied bread crumb index into main canvas
	 */
	self.load = function(index) {
		var obj_breadcrumb = self.breadcrumb_array[index];

		if (obj_breadcrumb.post_data != null)
			var post_data = obj_breadcrumb['post_data'];
		else
			post_data = [];

		$.ajax({
			type: 'POST',
			url: obj_breadcrumb.url,
			async: true,
			cache: false,
			//dataType: "json",
			data: post_data,
			success: function (html_result) {
				self.$canvas.html(html_result);
			}
		});
	};

	self.dump = function() {
		console.log(self.breadcrumb_array);
	};

	$(self.$wrapper).on("click", 'a', function () {
		self.load($(this).attr("data-index"));
		self.popAfter($(this).attr("data-index"));
		self.render();
	});

};
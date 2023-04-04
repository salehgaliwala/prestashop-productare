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

var MPTools = {

    errors: [],

	waitStart: function () {
		$("body").append("<div class='mp-wait-wrapper'><svg class='circular'><circle class='path' cx='50' cy='50' r='20' fill='none' stroke-width='2' stroke-miterlimit='10'/></svg></div>");
	},

	waitEnd: function () {
		$(".mp-wait-wrapper").remove();
	},

	handleAjaxResponse : function(json, $error_msg_wrapper) {
		var result = true;
		var error_msg = '';

		if (typeof json === 'undefined' || json == null || json == '') return true;

		if (typeof json.meta !== 'undefined') {
			if (typeof json.meta.error !== 'undefined') {
				if (json.meta.error == true) {
					result = false;
					if (typeof json.content !== 'undefined') {
						for (i=0; i<= json.content.length-1; i++) {
							$(json.content[i].dom_element).addClass("error");
							$(json.content[i].dom_element).parent().closest("div").addClass('has-danger');
							error_msg += json.content[i].message + "<br>";
						}
					}
					if (error_msg != '') {
						$error_msg_wrapper.html(error_msg);
						$error_msg_wrapper.show();
					}

				}
			}
		}
		return result;
	},

    /**
     * Merge a url wioth extra param string
     * @param url
     * @param param_string
     * @returns {string}
     */
    joinUrl: function (url, param_string) {
        var return_url = '';

        if (url.indexOf('?') > 0) {
            return_url = url + '&' + param_string;
        } else {
            return_url = url + '?' + param_string;
        }
        return return_url;
    },

    /***** Form Validation ******/

    highlightElement: function (element) {
        $(element).parent().closest('div').addClass("has-danger");
    },

    /**
     * remove all fields highlighted red and hied alert div
     */
    resetValidation: function (form) {
        $(form).find("div.has-danger").removeClass("has-danger");
        $(form).find(".mp-errors").hide();
    },

    addError: function (element, validation_message) {
        error = {
            'element': element,
            'validation_message': validation_message
        };
        MPTools.errors.push(error);
    },

    displayErrors: function (form) {
        var message = 'Please complete all fields marked in red below<br>';

        $(form).find(".mp-errors").fadeIn();

        if (MPTools.errors.length > 0) {
            for (i = 0; i <= MPTools.errors.length - 1; i++) {
                error = MPTools.errors[i];
                MPTools.highlightElement('#' + error.element);
                message = message + error.validation_message + '<br>';
            }
        }

        $(form).find(".mp-errors").html(message);

    },

    validateForm: function (form) {
        MPTools.resetValidation(form);

        var has_errors = false;

        $(form).find('input').each(function () {
            var tag = $(this).get(0).tagName;

            if (tag == 'INPUT' && $(this).attr("type") == 'text') {
                if ($(this).attr("data-required") == 'required' && $(this).val() == '') {
                    MPTools.highlightElement(this);
                    has_errors = true;
                }
            }

            if (tag == 'INPUT' && $(this).attr("type") == 'hidden') {
                if ($(this).attr("data-required") == 'required' && $(this).val() == '') {
                    MPTools.addError($(this).attr("id"), $(this).attr("data-validation-message"));
                    has_errors = true;
                }
            }

        });

        if (has_errors)
            MPTools.displayErrors(form);

        return !has_errors;
    }
};


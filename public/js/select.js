;(function($, document, window) {
	"use strict";

	// close dropdown on clicking anywhere
	$(document).on("click.selectX", function () {
		$(".select-x").find("ul").removeClass("open");
	});

	var Select = function (element, options) {

		// extend default options, apply custom options
		options = $.extend({
			selected: null,
			animate: false
		}, options);

		// adding jQuery wrapper
		element = $(element).addClass("select-x");

		// self referencing element
		element.data("SelectX", this);

		// catching elements from the template
		var input = element.find("input");
		var trigger = element.find("button");
		var list = element.find("ul");
		var text = trigger.children().first();
		var items = list.find("li");
		var selected = null;

		// adding animation class
		if (options.animate) {
			list.addClass("select-x-" + options.animate);
		}

		// adding to this
		this.items = items;
		this.text = text;
		this.selected = selected;

		// select selected option
		if (options.selected !== null) {
			this.selectOption(options.selected);
		}

		// binding events
		trigger.click(function (event) {
			event.stopPropagation();
			event.preventDefault();

			// closing every other dropdown
			$(".dropdown").each(function () {
				if ($(this).has(trigger).length === 0) {
					$(this).find("ul").removeClass("open");
				}
			});

			// toggle list
			list.toggleClass("open");
		});

		// select option on click
		list.on("click", "li", function () {
			selected = $(this);
			options.selected = selected.attr("value") || items.index(this);
			text.text(selected.text());
			selected.addClass("selected").siblings().removeClass("selected");
		});
	};

	Select.prototype.selectOption = function (value) {
		var items = this.items;
		var text = this.text;
		var selected = this.selected;

		// find selected option
		if (value === parseInt(value, 10)) {
			// find option by index
			selected = items.eq(value);
		} else {
			// find option by value
			items.each(function () {
				if ($(this).attr("value") === value) {
					selected = $(this);
				}
			});
		}
		text.text(selected.text());
		selected.addClass("selected").siblings().removeClass("selected");
	};

	$.fn.select = function () {
    var args = arguments;
    return this.each(function () {
      if ($(this).data("SelectX")) {
        if (typeof args[0] === "string") {
          try  {
            $(this).data("select")[args[0]](args[1]);
          }
          catch(err) {
            console.error("Select Extended has no method " + args[0]);
          }
        } else {
          console.error("Select Extended already initialized");
        }
      } else {
        if (typeof args[0] === "object" || args[0] === undefined) {
          new Select(this, args[0]);
        }
      }
    });
  };

}(jQuery || window.jQuery, document, window));

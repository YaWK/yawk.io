(function (factory) {
	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory);
	} else if (typeof module === 'object' && module.exports) {
		module.exports = factory(require('jquery'));
	} else {
		factory(window.jQuery);
	}
}(function ($) {
	var ui = $.summernote.ui;
	var dom = $.summernote.dom;
	var floatBSPlugin = function (context) {
		var self = this;
		var options = context.options;
		var lang = options.langInfo;
		var editable = context.layoutInfo.editable;

		context.memo('button.floatBSLeft', function () {
			return ui.button({
				contents: '<span class="note-icon-align-left"></span>',
				tooltip: lang.floatBS.floatLeft,
				click: function(event) {
					var $img=$(editable.data('target'));
					$img.removeClass('pull-right pull-left').addClass('pull-left');
					context.invoke('editor.afterCommand');
				}
			}).render();
		});
		context.memo('button.floatBSRight', function () {
			return ui.button({
				contents: '<span class="note-icon-align-right"></span>',
				tooltip: lang.floatBS.floatRight,
				click: function(event) {
					var $img=$(editable.data('target'));
					$img.removeClass('pull-right pull-left').addClass('pull-right');
					context.invoke('editor.afterCommand');
				}
			}).render();
		});
		context.memo('button.floatBSNone', function () {
			return ui.button({
				contents: '<span class="note-icon-align-justify"></span>',
				tooltip: lang.floatBS.floatNone,
				click: function(event) {
					var $img=$(editable.data('target'));
					$img.removeClass('pull-right pull-left');
					context.invoke('editor.afterCommand');
				}
			}).render();
		});
	};

	$.extend(true, $.summernote, {
		plugins: {
			floatBS: floatBSPlugin
		},
		options: {
			popover: {
				floatBS: [
				['floatBS', ['floatBSLeft', 'floatBSRight', 'floatBSNo']]
				]
			}
		},
		lang: {
			'en-US':{
				floatBS:{
					floatLeft:'Float Left',
					floatRight:'Float Right',
					floatNone:'Float None'
				}
			},
			'es-ES':{
				floatBS:{
					floatLeft:'Flotar a la izquierda',
					floatRight:'Flotar a la derecha',
					floatNone:'No flotar'
				}
			}
		}
	});
}));
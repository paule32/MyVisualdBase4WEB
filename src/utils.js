// ------------------------------------------------------
// File    : src/utils.js
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

function encode_utf8(s) {
return unescape(encodeURIComponent(s));	}

function decode_utf8(s) {
return decodeURIComponent(escape(s));	}

$.extend($.fn.window.methods, {
	hide: function(jq){
		return jq.each(function(){
			var w = $(this);
			var state = w.data('window');
			state.window.hide();
			if (state.shadow){state.shadow.hide();}
			if (state.mask){state.mask.hide();}
		})
	},
	show: function(jq){
		return jq.each(function(){
			var w = $(this);
			var state = w.data('window');
			state.window.show();
			if (state.shadow){state.shadow.show();}
			if (state.mask){state.mask.show();}
		})
	}
});

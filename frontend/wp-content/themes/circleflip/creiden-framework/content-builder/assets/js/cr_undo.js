var crdn = crdn || {};
var storageArray = new Array;
var storageArrayPointer = 0;
(function($, exports){
	var cr_undo = exports.undo = function(element, options) {
		this.$element = $(element);
		this.init();
		this.ready();
	};
	cr_undo.prototype.init = function() {
		var self = this;
		this.prepEventListeners();
	};
	cr_undo.prototype.prepEventListeners = function() {
		this.$element.on('click', ".cr_undo", jQuery.proxy(this.cr_undo_step, this));
		this.$element.on('click', ".cr_redo", jQuery.proxy(this.cr_redo_step, this));
	};
	cr_undo.prototype.ready = function() {
		
	};
	cr_undo.prototype.cr_undo_step = function(event) {
		event.preventDefault();
		var $this = $(event.currentTarget);
		if(!$this.hasClass('disabled')) {
			this.replaceStorage();
			storageArrayPointer = storageArrayPointer - 1;
			this.getStorage();
		}
		this.checkDisabled();
		this.$element.trigger('undo.crdn');
	};
	cr_undo.prototype.cr_redo_step = function(event) {
		event.preventDefault();
		var $this = $(event.currentTarget);
		if(!$this.hasClass('disabled')) {
			storageArrayPointer = storageArrayPointer + 1;
			this.getStorage();
		}
		this.checkDisabled();
		this.$element.trigger('redo.crdn');
	};
	cr_undo.prototype.replaceStorage = function() {
		storageArray[storageArrayPointer] = $("#blocks-to-edit").html();
	};
	cr_undo.prototype.setStorage = function() {
		var compare = this.compareStorage();
		console.log(compare);
		if(compare) {
			storageArray = storageArray.slice(0,storageArrayPointer);
			storageArray[storageArrayPointer] = $("#blocks-to-edit").html();
			storageArrayPointer++;
			this.checkDisabled();	
		}
	};
	cr_undo.prototype.getStorage = function() {
		$("#blocks-to-edit").html(storageArray[storageArrayPointer]);
		this.checkDisabled();
	};
	/*
	 * Compare this storage with previous one to check if no item is changed 
	 */
	cr_undo.prototype.compareStorage = function() {
		if($("#blocks-to-edit").html() == storageArray[storageArrayPointer-1]) {
			return false;
		} else {
			return true;
		}
	};
	cr_undo.prototype.checkDisabled = function() {
		$('.cr_redo, .cr_undo').removeClass('disabled');
		if(storageArrayPointer == storageArray.length || storageArrayPointer == storageArray.length -1) {
			$('.cr_redo').addClass('disabled');
		} else if(storageArrayPointer == 0) {
			$('.cr_undo').addClass('disabled');
		}
	};
	$.fn.cr_undo = function(option, args) {
		return this.each(function() {
			var $this = $(this), data = $this.data('cr_undo'), options = typeof option == 'object' && option;
			if (!data)
				$this.data('cr_undo', ( data = new cr_undo(this, options)));
			if ( typeof option == 'string')
				data[option](args);
		});
	};

	$.fn.cr_undo.Constructor = cr_undo;
}(jQuery, crdn));

/*
 * General Thoughts
 * 
var stack = {
	_data: [],
	_key: -1,
	next : function(){
		return this._data[this.key() + 1];
	},
	key: function(){
		return this._key;
	},
	prev: function(){
		return this._data[this.key() - 1];
	},
	current: function(){
		return this._data[this.key()];
	},
	clearAllNext: function(){
		this._data = this._data.slice(0, this.key() + 1);
	},
	push : function(val){
		this._data.push(val);
	}
};

stack.push(html);
el.replace(stack.prev());
el.replace(stack.next());
// el.replace(stack.current());
stack.clearAllNext();
stack;*/

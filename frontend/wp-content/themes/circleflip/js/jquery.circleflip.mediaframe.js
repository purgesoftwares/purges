(function( $, window, document, undefined ) {
    var frame = null,
		frames = [],
        mediaFrame = function( element, options ) {
            this.element = element;
            this.$element = $(element);
            this.options = options;
			this.args = _.omit( this.options, _.functions( this.options ) );
            this._bind();
        };
        
    mediaFrame.prototype = {
        constructor: mediaFrame,

        _bind: function() {
            this.$element.on( 'click', $.proxy( this._onClick, this ) );
            this._getFrame().on( 'select', $.proxy( this._onSelect, this ) );
        },
        _getFrame: function() {
			var self = this,
				_frame = _.find( frames, function( frame ) {
				return _.isEqual( frame.args, self.args )
			} );
			
			if ( ! _frame ) {
				_frame = {
					media: wp.media( self.args ),
					args: self.args
				}
				frames.push( _frame );
//				wp.media.frames['circleflipMediaFrame' + frames.length] = _frame.media;
			}
            return _frame.media;
        },
        _onClick: function() {
            this._getFrame().open();
        },
        _onSelect: function() {
            var attachments = this._getFrame().state().get('selection');
            attachments = attachments.map( function( attachment ) {
                return attachment.toJSON();
            } );
            this.options.onSelect.call( this.element, attachments );
        }
    };
    
    $.fn.circleflip_MediaFrame = function( option ) {
        return this.each( function() {
            var $this = $( this ),
                data = $this.data( 'circleflip.wpmediaframe' ),
                options = $.extend( {}, $.fn.circleflip_MediaFrame.defaults, $this.data(), typeof option == 'object' && option );

            if ( ! data )
                $this.data( 'circleflip.wpmediaframe', ( data = new mediaFrame( this, options ) ) );
        } );
    };
    
    $.fn.circleflip_MediaFrame.defaults = {
        title: 'Media Frame',
        multiple: false,
        onSelect: function( selection ) {
            console.log(selection);
        }
    };
}( jQuery, window, document ));
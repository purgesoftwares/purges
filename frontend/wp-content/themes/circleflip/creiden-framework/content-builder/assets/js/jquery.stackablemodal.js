( function( $, window, document, undefined ) {

    var ModalsStack = {
        stack: [],
        /**
         * adds the newly shown modal to the stack
         * @param jQuery element
         */
        push: function( element ) {
            this.stack.push( element );
        },
        pop: function() {
            this.stack.pop();
        },
        /**
         * 
         * @returns jQuery | null if the current modal is the only modal in the stack
         */
        prev: function() {
            var prev_modal = [];
            // is this a nested modal ?
            if ( this.stack.length > 1 ) {
                //get the next to last modal
                prev_modal = this.stack.slice( this.stack.length - 2, this.stack.length - 1);
            }
            return prev_modal.length ? prev_modal[0] : null;
        },
        current: function() {
            var current_modal = [];
            // do we have any modals in the stack
            if ( this.stack.length ) {
                // get the last modal
                current_modal = this.stack.slice( this.stack.length - 1 );
            }
            return current_modal.length ? current_modal[0] : null;
        }
    };
    
    var StackableModal = function( element, options ) {
        this.element = element;
        this.$element = $( element );
        
//        if ( ! this.$element.data('bs.modal') ) {
//            console.log("Can't call StackableModal on a non Modal element");
//            return;
//        }
        
        this.$element
                .on( 'show.bs.modal', $.proxy( this.add, this ) )
                .on( 'hide.bs.modal', $.proxy( this.maybeHide, this ) )
                .on( 'hidden.bs.modal', $.proxy( this.remove, this ) );
    };
    
    StackableModal.prototype = {
        
        constructor: StackableModal,
        
        add: function(e) {
            if ( e.target !== e.currentTarget ) return; //this is a bubbling event
            // add this modal to the stack
            ModalsStack.push( this.$element );
            this.$element
                    //set z-index to reflect proper nesting
                    .css( 'z-index', this.getZIndex() )
                    .find('.modal-dialog')
                        .css( this.getDialogCSS() );
            //is this is a nested modal
            if ( ModalsStack.prev() ) {
                //disable backdrop
                this.$element.data('bs.modal').options.backdrop = false;
            }
        },
        remove: function(e) {
            //this modal is now hidden , remove it from the stack
            ModalsStack.pop();
        },
        maybeHide: function(e) {
            // is the target modal a non active modal
            if ( e.target !== ModalsStack.current()[0] ) {
                e.preventDefault();
            }
        },
        getDialogCSS: function() {
            var prev = ModalsStack.prev(),
                stackableCSS = {};
            // is this a nested modal
            if ( prev ) {
                var prevDialog = prev.find('.modal-dialog');
                stackableCSS = {
                    width: prevDialog.width() * 0.9,
                    margin: '0 auto',
                    'margin-top': ModalsStack.stack.length * 3 + 52 // 22 is an arbitrary value
                };
            }
            // apply css provide in data-* formate if any
            return $.extend( {}, stackableCSS, this.getDataWidth() );
        },
        /**
         * get data-width if defined
         * @returns Object
         */
        getDataWidth: function() {
            if ( this.$element.data( 'width' ) ) {
                return {
                    width: this.$element.data( 'width' )
                };
            }
            return {};
        },
        getZIndex: function() {
            return 11000 + ModalsStack.stack.length * 10;
        }
    };

    $.fn.stackableModal = function( option ) {
        return this.each( function() {
            var $this = $( this ),
                data = $this.data( 'cr.stackablemodal' ),
                options = $.extend( {}, StackableModal.DEFAULTS, $this.data(), typeof option == 'object' && option );

            if ( ! data )
                $this.data( 'cr.stackablemodal', ( data = new StackableModal( this, options ) ) );
        } );
    };

}( jQuery, window, document ) );
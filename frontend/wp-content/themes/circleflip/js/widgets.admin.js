( function( $ ) {
    jQuery( function( $ ) {
        /*
         * Contact Information Widget
         */
        // only call wpColorPicker on widgets that are actually inside a sidebar
        $( '.widgets-holder-wrap .crdn-ci-color-field' ).wpColorPicker( );
        var contactInfoTmpl = _.template( $( '#crdn-tmpl-contact-info-social-icons' ).html( ), null, {variable: 'data'} );
        $( document )
                .on( 'click', '.crdn-ci-add-social-icon', function( ) {
                    var data = $( this ).data();
                    $( data.target )
                            .append( contactInfoTmpl( {
                                social_link_name: data.socialLink,
                                social_icon_name: data.socialIcon,
                                social_color_name: data.socialColor
                            } ) )
                            .find( '.crdn-ci-color-field' ).wpColorPicker();
                } )
                .on( 'click', '.crdn-remove-contact-social-item', function( ) {
                    $( this ).closest( '.crdn-contact-social-item' ).slideUp( 'fast', function( ) {
                        $( this ).remove( );
                    } );
                } );


        /*
         * Testmonials Widget
         */
        $( 'button.circleflip-media-uploader' ).circleflip_MediaFrame( {
            title: 'Select Image for widget',
            onSelect: function( attachment ) {
                $( this ).siblings( '.upload_input' ).val( attachment[0].url );
            }
        } );
        var testmonialTmpl = _.template( $( '#crdn-tmpl-testmonial-field' ).html(), null, {variable: 'data'} );
        $( document )
                .on( 'click', '.crdn-t-add-testmonial', function() {
                    var data = $( this ).data();
                    $( data.target ).append( testmonialTmpl( {name: data.name, job: data.job, text: data.text, image: data.image} ) );
                    //toggle_testimonial();
                    $( 'button.circleflip-media-uploader' ).circleflip_MediaFrame( {
                        title: 'Select Image for widget',
                        onSelect: function( attachment ) {
                            $( this ).siblings( '.upload_input' ).val( attachment[0].url );
                        }
                    } );
                } )
                .on( 'click', '.crdn-remove-testimonial-item', function() {
                    $( this ).closest( '.crdn-testimonial-item' ).removeClass( 'cssTrans' ).slideUp( 'fast', function() {
                        $( this ).remove();
                    } );
                } )
                .on( 'click', '.crdn-collapse-testimonial-item', function() {
                    var $this = $( this );
                    if ( $this.hasClass( 'minus' ) ) {
                        $this.removeClass( 'minus' ).addClass( 'plus' );
                        $this.parents( '.crdn-testimonial-item' ).removeClass( 'opened' ).addClass( 'closed' );
                    }
                    else {
                        $this.removeClass( 'plus' ).addClass( 'minus' );
                        $this.parents( '.crdn-testimonial-item' ).removeClass( 'closed' ).addClass( 'opened' );
                    }

                } );
                
                
                /*
         * Images Widget
         */
        var imagesTmpl = _.template( $( '#crdn-tmpl-image-field' ).html(), null, {variable: 'data'} );
        $( document )
                .on( 'click', '.crdn-t-add-image', function() {
                    var data = $( this ).data();
                    $( data.target ).append( imagesTmpl( {image: data.image, imgtarget: data.imgtarget} ) );
                    //toggle_testimonial();
                    $( 'button.circleflip-media-uploader' ).circleflip_MediaFrame( {
                        title: 'Select Image for widget',
                        onSelect: function( attachment ) {
                            $( this ).siblings( '.upload_input' ).val( attachment[0].url );
                        }
                    } );
                } )
                .on( 'click', '.crdn-remove-single-image', function() {
                    $( this ).closest( '.crdn-single-image' ).removeClass( 'cssTrans' ).slideUp( 'fast', function() {
                        $( this ).remove();
                    } );
                } );

        /*
         * Icon Selector
         */
        $( '#crdn-icon-selector-modal' )
                .on( 'show.bs.modal', function( e ) {
                    var _relatedTarget = $( e.relatedTarget ), that = $( this );
                    if ( _relatedTarget ) {
                        var container = _relatedTarget.closest( '.crdn-icon-selector' );
                        var oldIcon = container.find( '.crdn-selected-icon' ).val();
                        that.find( '.icons-box' )
                                .find( '.selectedIcon' ).removeClass( 'selectedIcon' ).end()
                                .find( '.' + ( oldIcon || 'iconfontello:first' ) ).addClass( 'selectedIcon' );
                        that.find( '.icon-preview' )
                                .find( '.iconfontello' ).removeClass().addClass( 'iconfontello ' + that.find( '.icons-box .selectedIcon' ).data( 'icon' ) )
                                .end().find( '.icon-name' ).text( that.find( '.icons-box .selectedIcon' ).data( 'icon' ) );
                        that.one( 'click.iconselector', '.crdn-icon-selector-done', function() {
                            var selectedIcon = that.find( '.selectedIcon' ).data( 'icon' );
                            container.find( '.crdn-selected-icon' )
                                    .val( selectedIcon )
                                    .end()
                                    .find( '.iconfontello.preview' )
                                    .toggleClass( selectedIcon + ' ' + oldIcon );
                            that.modal( 'hide' );
                        } )
                                .one( 'hide', function() {
                                    that.off( '.iconselector' );
                                } );
                    }
                    that.on( 'click', '.iconfontello', function() {
                        if ( $( this ).hasClass( 'selectedIcon' ) ) {
                            return;
                        }
                        that.find( '.icons-box' ).find( '.selectedIcon' ).removeClass( 'selectedIcon' );
                        $( this ).addClass( 'selectedIcon' );
                        that.find( '.icon-preview' ).find( '.iconfontello' ).removeClass().addClass( 'iconfontello ' + $( this ).data( 'icon' ) );
                        that.find( '.icon-preview' ).find( '.icon-name' ).text( $( this ).data( 'icon' ) );
                    } );
                } );
    } );
}( jQuery ) );
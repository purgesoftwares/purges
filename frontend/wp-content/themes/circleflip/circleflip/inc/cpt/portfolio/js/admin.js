(function( $, window, document, undefined ) {
    $( document ).ready( function() {
        console.log( 'Circleflip: protfolio admin script ==> READY' );
        var projectDetailsContainer = $( '#project-details' ),
            projectDetails = projectDetailsContainer.children( 'tbody' ),
            projectDetailTmpl = _.template( $( '#tmpl-project-detail' ).html(), null, {variable: 'data'} ),
            newProjectDetailKey = projectDetailsContainer.find('.circleflip-projectdetail-key'),
            newProjectDetailValue = projectDetailsContainer.find('.circleflip-projectdetail-value');
            
        projectDetailsContainer.on( 'click', '#circleflip-add', function() {
            projectDetails.append( projectDetailTmpl( {
                key: newProjectDetailKey.val(),
                value: newProjectDetailValue.val()
            } ) );
            newProjectDetailKey.val( '' );
            newProjectDetailValue.val( '' );
        } );

        projectDetails.on( 'click', '.circleflip-remove', function() {
            $( this ).closest( 'tr' ).fadeOut( 500, function() {
                $( this ).remove();
            } );
        } );
    } );
}( jQuery, window, document ));
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

        // Top Promotions.
	wp.customize( 'top_one_header', function( value ) {
		value.bind( function( to ) {
                    if( to == '') {
                        $( '.top-promotion1' ).hide();
                    } else {
                        $( '.top-promotion1' ).show();
                        $( '.top-promotion1' ).text( to );
                    } 
		} );
	} );
        
        wp.customize( 'top_one_text', function( value ) {
		value.bind( function( to ) {
                    if( to == '') {
                        $( '.top-promo1-text' ).hide();
                    } else {
                        $( '.top-promo1-text' ).show();
                        $( '.top-promo1-text' ).text( to );
                    } 
		} );
	} );
        
        wp.customize( 'top_two_header', function( value ) {
		value.bind( function( to ) {
                    if( to == '') {
                        $( '.top-promotion2' ).hide();
                    } else {
                        $( '.top-promotion2' ).show();
                        $( '.top-promotion2' ).text( to );
                    } 
		} );
	} );
        
        wp.customize( 'top_two_text', function( value ) {
		value.bind( function( to ) {
                    if( to == '') {
                        $( '.top-promo2-text' ).hide();
                    } else {
                        $( '.top-promo2-text' ).show();
                        $( '.top-promo2-text' ).text( to );
                    } 
		} );
	} );
        
         wp.customize( 'top_three_header', function( value ) {
		value.bind( function( to ) {
                    if( to == '') {
                        $( '.top-promotion3' ).hide();
                    } else {
                        $( '.top-promotion3' ).show();
                        $( '.top-promotion3' ).text( to );
                    } 
		} );
	} );
        
        wp.customize( 'top_three_text', function( value ) {
		value.bind( function( to ) {
                    if( to == '') {
                        $( '.top-promo3-text' ).hide();
                    } else {
                        $( '.top-promo3-text' ).show();
                        $( '.top-promo3-text' ).text( to );
                    } 
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );

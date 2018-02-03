jQuery( function ( $ ) {
	var $b = $( 'body' );
	getled = {
		removeMiniCartItem: function ( tis ) {
			if ( getled.$removeMiniCartItem ) {
				getled.$removeMiniCartItem.click();
				getled.$removeMiniCartItem = null;
			}
			$( tis ).closest( '.getled-dialog' ).fadeOut( 'fast' );
		}
	};

	$( 'figure.wp-caption.aligncenter' ).removeAttr( 'style' );
	$( 'img.aligncenter' ).wrap( '<figure class="centered-image" />' );

	function supportsInlineSVG() {
		var div = document.createElement( 'div' );
		div.innerHTML = '<svg/>';
		return 'http://www.w3.org/2000/svg' === (
			'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI
		);
	}

	if ( true === supportsInlineSVG() ) {
		document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
	}

	// Cart
	var
		$headerCart = $( '#site-header-cart' ), $cartList;
	if ( $headerCart.length ) {
		$headerCart
			.on( 'click', '.getled-remove-item', function () {
				getled.$removeMiniCartItem = $( this ).siblings( '.remove_from_cart_button' );
				$( '#remove-mini-cart-item' ).fadeIn( 'fast' );
			} )
			.on( 'click', '.scroll', function () {
				var
					$t = $( this ),
					scroll = 121;
				if ( $t.attr( 'class' ).indexOf( 'up' ) > - 1 ) {
					scroll = '-=' + scroll;
				} else {
					scroll = '+=' + scroll;
				}
				$( '#site-header-cart' ).find( '.woocommerce-mini-cart.cart_list' ).animate( {scrollTop: scroll}, 'fast' );
			} );
	}

	$b.on( 'click', '.getled-dialog a.close', function () {
		$( this ).closest( '.getled-dialog' ).fadeOut( 'fast' );
	} );

	$( document.body )
		.on( 'added_to_cart removed_from_cart', function( ev, a ) {
			var $html = $( a['div.widget_shopping_cart_content'] );
			$('#getled-header-cart-amount').html( $html.find( '#getled-min-cart-info' ).data( 'amount' ) )
			$('#getled-header-cart-count').html( $html.find( '#getled-min-cart-info' ).data( 'count' ) )
		} );
} );


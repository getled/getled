/**
 * Created by shramee on 23/10/15.
 * @package makesite
 */
jQuery( function ( $ ) {

	var getledFileFrame,
		$body = $( 'body' );

	$body.on( 'change', 'input[name*="menu-item-image"]', function ( event ) {
		$( this ).siblings( 'img' ).attr( 'src', this.value )
	} );

	$body.find( 'input[name*="menu-item-image"]' ).change();

	$body.on( 'click', '.getled-select-image', function ( event ) {
		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( getledFileFrame ) {
			getledFileFrame.open();
		} else {

			getledFileFrame = wp.media.frames.getledFileFrame = wp.media( {
				title: 'Choose menu item image',
				button: {text: 'Select Image'},
				multiple: false  // Set to true to allow multiple files to be selected
			} );

			getledFileFrame.on( 'select', function () {
				attachment = getledFileFrame.state().get( 'selection' ).first().toJSON();
				console.log( attachment );
				getledFileFrame.$textField.val( attachment.sizes.thumbnail.url ).change();
			} );

			getledFileFrame.open();
		}
		getledFileFrame.$textField = $( this ).siblings( 'input[name*="menu-item-image"]' );
	} );

	$( '.menu-item .field-css-classes' ).each( function () {
		var $t = $( this ),
			$input = $t.find('input'),
			$cb = $( '<input/>' ).attr( 'type', 'checkbox' ),
			$p = $( '<p/>' ).html( '<label> Hide label</label>' ).addClass( 'field-hide-label description description-wide' );

		// Hide Label
		$cb.addClass( 'enable-hide-label' );
		if ( -1 < $input.val().search('hide-label') ) {
			$cb.prop( 'checked', true );
		}
		$p.find( 'label' ).prepend( $cb );
		$t.before( $p );

		// Icon picker
		var $fa = $( '<span class="fa fa-preview"></span>' ),
			$lbl = $( '<label class="pick-fa-icon button button-primary"><input type="text" class="fa-icon-input">Choose icon</label>' ),
			$p = $( '<p><span class="fa-icon-remove button">Remove Icon</span></p>' ).addClass( 'field-fa-icon description description-wide' );
		$lbl.addClass( 'enable-fa-picker' );
		if ( -1 < $input.val().indexOf('fa-') ) {
			$.each( $input.val().split( ' ' ), function ( i, v ) {
				if ( -1 < v.indexOf( 'fa-' ) ) {
					$fa.addClass( v );
				}
			} );
		}
		$p.prepend( $lbl.prepend( $fa ) );
		$t.before( $p );
	} );

	$( '.fa-icon-input' ).iconpicker().on( 'iconpickerUpdated', function () {
		var $t = $( this ),
			$fa = $t.siblings( '.fa-preview' ),
			$remove = $t.closest( '.menu-item-settings' ).find('.fa-icon-remove' ),
			$class = $t.closest( '.menu-item-settings' ).find('.field-css-classes input' ),
			clss = [];
		$remove.click();

		clss = $class.val().split( ' ' )
		if ( $t.val() ) {
			clss.push( $t.val() );
			$fa.addClass( $t.val() );
		}
		$class.val( clss.join( ' ' ) );
	} );

	$( '.fa-icon-remove' ).click( function () {
		var $t = $( this ),
			$fa = $t.parent().find( '.fa-preview' ),
			$class = $t.closest( '.menu-item-settings' ).find('.field-css-classes input' ),
			clsA = $class.val().split( ' ' ),
			cls = [];

		$.each( clsA, function ( i, v ) {
			if ( v && -1 == v.indexOf( 'fa-' ) ) {
				cls.push( v );
			}
		} );
		$fa.attr( 'class', 'fa fa-preview' );
		$class.val( cls.join( ' ' ) );
	} );

} );
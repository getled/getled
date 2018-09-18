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

} );
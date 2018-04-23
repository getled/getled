<?php
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$accordions = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $accordions ) ) : ?>

	<div class="wc-accordions-wrapper">
		<ul class="accordions wc-accordions">
			<?php foreach ( $accordions as $key => $accordion ) : ?>
				<li class="wc-accordion <?php echo esc_attr( $key ); ?>_accordion">
					<a href="#<?php echo esc_attr( $key ); ?>">
						<?php echo apply_filters( "woocommerce_product_{$key}_accordion_title", $accordion['title'], $key ); ?>
						<span class="wc-accordion-icon wc-accordion-minus">
							<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208c114.9 0 208-93.1 208-208S370.9 48 256 48zM256 446.7c-105.1 0-190.7-85.5-190.7-190.7 0-105.1 85.5-190.7 190.7-190.7 105.1 0 190.7 85.5 190.7 190.7C446.7 361.1 361.1 446.7 256 446.7z"/><rect fill="currentColor" x="128" y="248" width="256" height="17"/></svg>
						</span>
						<span class="wc-accordion-icon wc-accordion-plus">
							<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208c114.9 0 208-93.1 208-208S370.9 48 256 48zM256 446.7c-105.1 0-190.7-85.5-190.7-190.7S150.9 65.3 256 65.3 446.7 150.9 446.7 256 361.1 446.7 256 446.7z"/><polygon fill="currentColor" points="264.1 128 247.3 128 247.3 247.9 128 247.9 128 264.7 247.3 264.7 247.3 384 264.1 384 264.1 264.7 384 264.7 384 247.9 264.1 247.9 "/></svg>
						</span>
					</a>
					<div class="wc-accordion-panel wc-accordion-panel-<?php echo esc_attr( $key ); ?> entry-content"
							 id="<?php echo esc_attr( $key ); ?>">
						<?php call_user_func( $accordion['callback'], $key, $accordion ); ?>
					</div>
				</li>
			<?php endforeach;?>
		</ul>
		<style>
			.wc-accordion,
			.wc-accordions {
				margin: 0;
				display: block;
				clear: both;
			}

			.wc-accordions {
				border-bottom: 1px solid rgba(0, 0, 0, 0.25);
				margin-bottom: 70px;
				padding: 0;
			}

			.wc-accordion > a,
			.wc-accordion-panel {
				border-top: 1px solid rgba(0, 0, 0, 0.25);
				padding: 0.7em 1em;
				margin: 0;
			}

			.wc-accordion > a,
			.wc-accordion > a:focus {
				display: block;
				line-height: 25px;
				color: rgba(0, 0, 0, 0.34);
				outline: none;
				text-align: center;
			}

			.wc-accordion-icon {
				float: right;
			}

			.wc-accordion-minus {
				display: none;
				line-height: 0.9;
			}

			.wc-accordion-active .wc-accordion-minus {
				display: block;
			}

			.wc-accordion-active .wc-accordion-plus {
				display: none;
			}
		</style>
	</div>
	<script>
		(
			function ( $ ) {
				var $lis = $( 'li.wc-accordion' );
				$lis.children( '.wc-accordion-panel' ).hide();
				$lis.children( 'a' ).click( function ( e ) {
					e.preventDefault();
					var $t = $( this );

					$lis.children( '.wc-accordion-panel' ).slideUp();

					if ( $t.hasClass( 'wc-accordion-active' ) ) {
						return $t.removeClass( 'wc-accordion-active' );
					}

					$lis.children( 'a.wc-accordion-active' ).removeClass( 'wc-accordion-active' );

					$t.addClass( 'wc-accordion-active' );
					$t.siblings( '.wc-accordion-panel' ).slideDown();
				} );

				// Reviews link in product info
				$( '.woocommerce-review-link' ).click( function ( e ) {
					e.preventDefault();
					var id = $( this ).attr( 'href' ),
						$a = $lis.children( 'a[href="' + id + '"]' );
					$a.click();
					$( 'html, body' ).animate( {
						scrollTop: $a.offset().top - 124
					}, 700 );

				} );

			}
		)( jQuery );
	</script>
<?php endif;

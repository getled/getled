<?php
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$accordions = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $accordions ) ) : ?>

	<div class="getled-accordions-wrapper product-tabs">
		<ul class="accordions getled-accordions">
			<?php foreach ( $accordions as $key => $accordion ) : ?>
				<li class="getled-accordion <?php echo esc_attr( $key ); ?>_accordion">
					<a href="#<?php echo esc_attr( $key ); ?>">
						<?php echo apply_filters( "woocommerce_product_{$key}_accordion_title", $accordion['title'], $key ); ?>
						<span class="getled-accordion-icon getled-accordion-minus">
							<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208c114.9 0 208-93.1 208-208S370.9 48 256 48zM256 446.7c-105.1 0-190.7-85.5-190.7-190.7 0-105.1 85.5-190.7 190.7-190.7 105.1 0 190.7 85.5 190.7 190.7C446.7 361.1 361.1 446.7 256 446.7z"/><rect fill="currentColor" x="128" y="248" width="256" height="17"/></svg>
						</span>
						<span class="getled-accordion-icon getled-accordion-plus">
							<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208c114.9 0 208-93.1 208-208S370.9 48 256 48zM256 446.7c-105.1 0-190.7-85.5-190.7-190.7S150.9 65.3 256 65.3 446.7 150.9 446.7 256 361.1 446.7 256 446.7z"/><polygon fill="currentColor" points="264.1 128 247.3 128 247.3 247.9 128 247.9 128 264.7 247.3 264.7 247.3 384 264.1 384 264.1 264.7 384 264.7 384 247.9 264.1 247.9 "/></svg>
						</span>
					</a>
					<div class="getled-accordion-panel getled-accordion-panel-<?php echo esc_attr( $key ); ?> entry-content"
							 id="<?php echo esc_attr( $key ); ?>">
						<?php call_user_func( $accordion['callback'], $key, $accordion ); ?>
					</div>
				</li>
			<?php endforeach;?>
		</ul>
	</div>
<?php endif;

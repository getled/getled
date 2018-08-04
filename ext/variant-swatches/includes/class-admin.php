<?php

/**
 * Class TA_WC_Variation_Swatches_Admin
 */
class TA_WC_Variation_Swatches_Admin {
	/**
	 * The single instance of the class
	 *
	 * @var TA_WC_Variation_Swatches_Admin
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return TA_WC_Variation_Swatches_Admin
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init_attribute_hooks' ) );
		add_action( 'admin_print_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'woocommerce_product_option_terms', array( $this, 'product_option_terms' ), 10, 2 );

		// Display attribute fields
		add_action( 'tawcvs_product_attribute_field', array( $this, 'attribute_fields' ), 10, 3 );

		// ajax add attribute
		add_action( 'wp_ajax_tawcvs_add_new_attribute', array( $this, 'add_new_attribute_ajax' ) );

		add_action( 'admin_footer', array( $this, 'add_attribute_term_template' ) );
	}

	/**
	 * Init hooks for adding fields to attribute screen
	 * Save new term meta
	 * Add thumbnail column for attribute term
	 */
	public function init_attribute_hooks() {
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( empty( $attribute_taxonomies ) ) {
			return;
		}

		foreach ( $attribute_taxonomies as $tax ) {
			add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', array( $this, 'add_attribute_fields' ) );
			add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields', array( $this, 'edit_attribute_fields' ), 10, 2 );

			add_filter( 'manage_edit-pa_' . $tax->attribute_name . '_columns', array( $this, 'add_attribute_columns' ) );
			add_filter( 'manage_pa_' . $tax->attribute_name . '_custom_column', array( $this, 'add_attribute_column_content' ), 10, 3 );
		}

		add_action( 'created_term', array( $this, 'save_term_meta' ), 10, 2 );
		add_action( 'edit_term', array( $this, 'save_term_meta' ), 10, 2 );
	}

	/**
	 * Load stylesheet and scripts in edit product attribute screen
	 */
	public function enqueue_scripts() {
		$screen = get_current_screen();
		if ( strpos( $screen->id, 'edit-pa_' ) === false && strpos( $screen->id, 'product' ) === false ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_style( 'tawcvs-admin', get_template_directory_uri() . '/ext/variant-swatches/assets/css/admin.css', array( 'wp-color-picker' ), '20160615' );
		wp_enqueue_script( 'tawcvs-admin', get_template_directory_uri() . '/ext/variant-swatches/assets/js/admin.js', array( 'jquery', 'wp-color-picker', 'wp-util' ), '20170113', true );

		wp_localize_script(
			'tawcvs-admin',
			'tawcvs',
			array(
				'i18n'        => array(
					'mediaTitle'  => esc_html__( 'Choose an image', 'wcvs' ),
					'mediaButton' => esc_html__( 'Use image', 'wcvs' ),
				),
				'placeholder' => WC()->plugin_url() . '/assets/images/placeholder.png'
			)
		);
	}

	/**
	 * Create hook to add fields to add attribute term screen
	 *
	 * @param string $taxonomy
	 */
	public function add_attribute_fields( $taxonomy ) {
		$attr = TA_WCVS()->get_tax_attribute( $taxonomy );
		do_action( 'tawcvs_product_attribute_field', $attr->attribute_type, '', 'add' );
	}

	/**
	 * Create hook to fields to edit attribute term screen
	 *
	 * @param object $term
	 * @param string $taxonomy
	 */
	public function edit_attribute_fields( $term, $taxonomy ) {

		$attr  = TA_WCVS()->get_tax_attribute( $taxonomy );
		$value = get_term_meta( $term->term_id, $attr->attribute_type, true );

		do_action( 'tawcvs_product_attribute_field', $attr->attribute_type, $value, 'edit' );
	}

	/**
	 * Print HTML of custom fields on attribute term screens
	 *
	 * @param $type
	 * @param $value
	 * @param $form
	 */
	public function attribute_fields( $type, $value, $form ) {

		// Return if this is a default attribute type
		if ( in_array( $type, array( 'select', 'text' ) ) ) {
			return;
		}

		// Print the open tag of field container
		printf(
			'<%s class="form-field">%s<label for="term-%s">%s</label>%s',
			'edit' == $form ? 'tr' : 'div',
			'edit' == $form ? '<th>' : '',
			esc_attr( $type ),
			TA_WCVS()->types[$type],
			'edit' == $form ? '</th><td>' : ''
		);

		switch ( $type ) {
			case 'image':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				?>
				<div class="tawcvs-term-image-thumbnail" style="float:left;margin-right:10px;">
					<img src="<?php echo esc_url( $image ) ?>" width="60px" height="60px" />
				</div>
				<div style="line-height:60px;">
					<input type="hidden" class="tawcvs-term-image" name="image" value="<?php echo esc_attr( $value ) ?>" />
					<button type="button" class="tawcvs-upload-image-button button"><?php esc_html_e( 'Upload/Add image', 'wcvs' ); ?></button>
					<button type="button" class="tawcvs-remove-image-button button <?php echo $value ? '' : 'hidden' ?>"><?php esc_html_e( 'Remove image', 'wcvs' ); ?></button>
				</div>
				<?php
				break;

			default:
				?>
				<input type="text" id="term-<?php echo esc_attr( $type ) ?>" name="<?php echo esc_attr( $type ) ?>" value="<?php echo esc_attr( $value ) ?>" />
				<?php
				break;
		}

		// Print the close tag of field container
		echo 'edit' == $form ? '</td></tr>' : '</div>';
	}

	/**
	 * Save term meta
	 *
	 * @param int $term_id
	 * @param int $tt_id
	 */
	public function save_term_meta( $term_id, $tt_id ) {
		foreach ( TA_WCVS()->types as $type => $label ) {
			if ( isset( $_POST[$type] ) ) {
				update_term_meta( $term_id, $type, $_POST[$type] );
			}
		}
	}

	/**
	 * Add selector for extra attribute types
	 *
	 * @param $taxonomy
	 * @param $index
	 */
	public function product_option_terms( $taxonomy, $index ) {
		if ( ! array_key_exists( $taxonomy->attribute_type, TA_WCVS()->types ) ) {
			return;
		}

		$taxonomy_name = wc_attribute_taxonomy_name( $taxonomy->attribute_name );
		global $thepostid;
		?>

		<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'wcvs' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo $index; ?>][]">
			<?php

			$all_terms = get_terms( $taxonomy_name, apply_filters( 'woocommerce_product_attribute_terms', array( 'orderby' => 'name', 'hide_empty' => false ) ) );
			if ( $all_terms ) {
				foreach ( $all_terms as $term ) {
					echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy_name, $thepostid ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
				}
			}
			?>
		</select>
		<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'wcvs' ); ?></button>
		<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'wcvs' ); ?></button>
		<button class="button fr plus tawcvs_add_new_attribute" data-type="<?php echo $taxonomy->attribute_type ?>"><?php esc_html_e( 'Add new', 'wcvs' ); ?></button>

		<?php
	}

	/**
	 * Add thumbnail column to column list
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_attribute_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = '';
		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Render thumbnail HTML depend on attribute type
	 *
	 * @param $columns
	 * @param $column
	 * @param $term_id
	 */
	public function add_attribute_column_content( $columns, $column, $term_id ) {
		$attr  = TA_WCVS()->get_tax_attribute( $_REQUEST['taxonomy'] );
		$value = get_term_meta( $term_id, $attr->attribute_type, true );

		switch ( $attr->attribute_type ) {
			case 'color':
				printf( '<div class="swatch-preview swatch-color" style="background-color:%s;"></div>', esc_attr( $value ) );
				break;

			case 'image':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				printf( '<img class="swatch-preview swatch-image" src="%s" width="44px" height="44px">', esc_url( $image ) );
				break;

			case 'label':
				printf( '<div class="swatch-preview swatch-label">%s</div>', esc_html( $value ) );
				break;
		}
	}

	/**
	 * Print HTML of modal at admin footer and add js templates
	 */
	public function add_attribute_term_template() {
		global $pagenow, $post;

		if ( $pagenow != 'post.php' || ( isset( $post ) && get_post_type( $post->ID ) != 'product' ) ) {
			return;
		}
		?>

		<div id="tawcvs-modal-container" class="tawcvs-modal-container">
			<div class="tawcvs-modal">
				<button type="button" class="button-link media-modal-close tawcvs-modal-close">
					<span class="media-modal-icon"></span></button>
				<div class="tawcvs-modal-header"><h2><?php esc_html_e( 'Add new term', 'wcvs' ) ?></h2></div>
				<div class="tawcvs-modal-content">
					<p class="tawcvs-term-name">
						<label>
							<?php esc_html_e( 'Name', 'wcvs' ) ?>
							<input type="text" class="widefat tawcvs-input" name="name">
						</label>
					</p>
					<p class="tawcvs-term-slug">
						<label>
							<?php esc_html_e( 'Slug', 'wcvs' ) ?>
							<input type="text" class="widefat tawcvs-input" name="slug">
						</label>
					</p>
					<div class="tawcvs-term-swatch">

					</div>
					<div class="hidden tawcvs-term-tax"></div>

					<input type="hidden" class="tawcvs-input" name="nonce" value="<?php echo wp_create_nonce( '_tawcvs_create_attribute' ) ?>">
				</div>
				<div class="tawcvs-modal-footer">
					<button class="button button-secondary tawcvs-modal-close"><?php esc_html_e( 'Cancel', 'wcvs' ) ?></button>
					<button class="button button-primary tawcvs-new-attribute-submit"><?php esc_html_e( 'Add New', 'wcvs' ) ?></button>
					<span class="message"></span>
					<span class="spinner"></span>
				</div>
			</div>
			<div class="tawcvs-modal-backdrop media-modal-backdrop"></div>
		</div>

		<script type="text/template" id="tmpl-tawcvs-input-color">

			<label><?php esc_html_e( 'Colour', 'wcvs' ) ?></label><br>
			<input type="text" class="tawcvs-input tawcvs-input-color" name="swatch">

		</script>

		<script type="text/template" id="tmpl-tawcvs-input-image">

			<label><?php esc_html_e( 'Image', 'wcvs' ) ?></label><br>
			<div class="tawcvs-term-image-thumbnail" style="float:left;margin-right:10px;">
				<img src="<?php echo esc_url( WC()->plugin_url() . '/assets/images/placeholder.png' ) ?>" width="60px" height="60px" />
			</div>
			<div style="line-height:60px;">
				<input type="hidden" class="tawcvs-input tawcvs-input-image tawcvs-term-image" name="swatch" value="" />
				<button type="button" class="tawcvs-upload-image-button button"><?php esc_html_e( 'Upload/Add image', 'wcvs' ); ?></button>
				<button type="button" class="tawcvs-remove-image-button button hidden"><?php esc_html_e( 'Remove image', 'wcvs' ); ?></button>
			</div>

		</script>

		<script type="text/template" id="tmpl-tawcvs-input-label">

			<label>
				<?php esc_html_e( 'Label', 'wcvs' ) ?>
				<input type="text" class="widefat tawcvs-input tawcvs-input-label" name="swatch">
			</label>

		</script>

		<script type="text/template" id="tmpl-tawcvs-input-tax">

			<input type="hidden" class="tawcvs-input" name="taxonomy" value="{{data.tax}}">
			<input type="hidden" class="tawcvs-input" name="type" value="{{data.type}}">

		</script>
		<?php
	}

	/**
	 * Ajax function to handle add new attribute term
	 */
	public function add_new_attribute_ajax() {
		$nonce  = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';
		$tax    = isset( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : '';
		$type   = isset( $_POST['type'] ) ? $_POST['type'] : '';
		$name   = isset( $_POST['name'] ) ? $_POST['name'] : '';
		$slug   = isset( $_POST['slug'] ) ? $_POST['slug'] : '';
		$swatch = isset( $_POST['swatch'] ) ? $_POST['swatch'] : '';

		if ( ! wp_verify_nonce( $nonce, '_tawcvs_create_attribute' ) ) {
			wp_send_json_error( esc_html__( 'Wrong request', 'wcvs' ) );
		}

		if ( empty( $name ) || empty( $swatch ) || empty( $tax ) || empty( $type ) ) {
			wp_send_json_error( esc_html__( 'Not enough data', 'wcvs' ) );
		}

		if ( ! taxonomy_exists( $tax ) ) {
			wp_send_json_error( esc_html__( 'Taxonomy is not exists', 'wcvs' ) );
		}

		if ( term_exists( $_POST['name'], $_POST['tax'] ) ) {
			wp_send_json_error( esc_html__( 'This term is exists', 'wcvs' ) );
		}

		$term = wp_insert_term( $name, $tax, array( 'slug' => $slug ) );

		if ( is_wp_error( $term ) ) {
			wp_send_json_error( $term->get_error_message() );
		} else {
			$term = get_term_by( 'id', $term['term_id'], $tax );
			update_term_meta( $term->term_id, $type, $swatch );
		}

		wp_send_json_success(
			array(
				'msg'  => esc_html__( 'Added successfully', 'wcvs' ),
				'id'   => $term->term_id,
				'slug' => $term->slug,
				'name' => $term->name,
			)
		);
	}
}

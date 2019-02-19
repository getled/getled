<?php
function getled_custom_search_widget()
{
    register_widget('custom_search_widget');
}
add_action('widgets_init', 'getled_custom_search_widget');
class custom_search_widget extends WP_Widget
{
    
    function __construct()
    {
        parent::__construct('getled_widget', __('Custom Product Search Widget', 'getled_widget_domain'), array(
            'description' => __('Custom Search widget for product search', 'getled_widget_domain')
        ));
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
    }
    public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'underscore' );
	}
	public function print_scripts() {
		?>
		<script>
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}
    
    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        echo __('<div id="site-header-search-custom"><i class="fa fa-search" ></i></div>', 'getled_widget_domain');
        echo $args['after_widget'];
    }
    
    public function form($instance)
    {    
    }
    public function update($new_instance, $old_instance)
    {   $instance = $old_instance;
        $instance = $new_instance;
        $instance  = array();
        $instance['size'] = (!empty($new_instance['size'])) ? strip_tags($new_instance['size']) : '30';
        $instance['color'] = (!empty($new_instance['color'])) ? strip_tags($new_instance['color']) : '#000000';
        return $instance;
    }
}
function custom_serach_box()
{
    echo '<div class="custom_serach_box" style="display:none;">
        <form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
            <label>
                <span class="screen-reader-text" for="s">' . __('Search for:', 'woocommerce') . '</span>
                <div class="search-box">
                    <div class="search-box--icon">
                        <i class="fa fa-search"></i>
                        <input type="text" class="search-field" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Search our store', 'woocommerce') . '" />
                    </div>
                    <div class="close-btn"><i class="fa fa-times"></i></div>
                </div>
                <input type="hidden" name="post_type" value="product" />
            </label>
        </form>
    </div>';
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#site-header-search-custom .fa').click(function(){
            jQuery('.custom_serach_box').fadeToggle();
        });
    });
    //close button js
    jQuery(".close-btn").click(function(){
       jQuery(".custom_serach_box").hide();
    });

    jQuery("#site-header-search-custom").click(function(){
        jQuery("custom_serach_box").show();
    });
</script>
 <?php
}

add_action('getled_under_header', 'custom_serach_box');

?>

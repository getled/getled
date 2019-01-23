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
    }
    
    
    public function widget($args, $instance)
    {
        
        
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        
        echo __('<div id="site-header-search">
        <i class="fa fa-search"></i>
       </div>', 'getled_widget_domain');
        echo $args['after_widget'];
    }
    
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'getled_widget_domain');
           }
        
?>
<?php
    }
    
    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance          = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}
function custom_serach_box()
{
    echo '<div class="custom_serach_box" style="display:none;">
             <form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
                  <label>  <span class="screen-reader-text" for="s">' . __('Search for:', 'woocommerce') . '</span>
                            <div class="search-box">
                                <div class="search-box--icon">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="search-field" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Search our store', 'woocommerce') . '" />
                                </div>
                            <div class="close-btn"><i class="fa fa-times"></i></div></div>
                            <input type="hidden" name="post_type" value="product" />
                   </label>

                </form></div>
                
                
                ';
?>
      <script type="text/javascript">
            jQuery(document).ready(function() {
            jQuery('#site-header-search .fa').click(function(){
            jQuery('.custom_serach_box').fadeToggle();
              });
            });
            //  close button js
            jQuery(".close-btn").click(function(){
               jQuery(".custom_serach_box").hide();
            });

            jQuery("#site-header-search").click(function(){
               jQuery("custom_serach_box").show();
            });
     </script>
 <?php
}

add_action('getled_under_header', 'custom_serach_box');
?>

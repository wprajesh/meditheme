<?php

function twentyfifteen_scripts() {


	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );

	//bootstrap
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );


function custom_theme_setup() {
	add_theme_support( 'menus' );
}
add_action( 'init', 'custom_theme_setup' );

function register_woomeds_menu() {
    register_nav_menu('primary','Primary');
}
add_action('init','register_woomeds_menu');



add_filter('nav_menu_css_class' , 'bootstrap_nav_class' , 10 , 2);
function bootstrap_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active';
     }
     return $classes;
}


add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents glyphicon glyphicon-shopping-cart" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">&nbsp;&nbsp;<?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a> 
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}


function add_cartbag_to_menu_items($items, $args) {
    if( $args->theme_location == 'primary' ){
        
        $cart_bag = '<li><a class="cart-contents glyphicon glyphicon-shopping-cart" href="'.WC()->cart->get_cart_url().'" title="View your shopping cart">&nbsp;&nbsp;'.WC()->cart->cart_contents_count.' - '.WC()->cart->get_cart_total().'</a></li>';
        
        $items = $items.$cart_bag;
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_cartbag_to_menu_items', 10, 2 );


function add_common_js_footer(){
    ?>
    <script type="text/javascript">
        var play_late = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();
        jQuery(document).ready(function(){
            
            //defining medicine search functions
            function call_ajax(){
                                    jQuery.ajax({
              url:"<?php echo admin_url('admin-ajax.php');?>",
              data:{action:'search_medi',
                    keyword: jQuery('#search_med').val(),
                },
               method:'POST'
               
               
              }).done(function(res){
                console.log(res);
            });
            }
            jQuery('#search_med').keyup(function() {
    play_late(function(){
      call_ajax();
    }, 900 );
});

            jQuery('#search_med').keyup(function(){


            });
                    });
        
    </script>
    <?php
}
add_action('wp_footer','add_common_js_footer');


function search_medicine_f_ajax(){
    $keyword = $_POST['keyword'];
    
    $json_data = json_encode($keyword);
    echo $json_data;
    exit();
}
add_action('wp_ajax_search_medi','search_medicine_f_ajax');
add_action('wp_ajax_nopriv_search_medi','search_medicine_f_ajax');
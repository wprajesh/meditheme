<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    <nav class="navbar navbar-default navbar-fixed-top">
             <div class="container">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand"><?php bloginfo( 'name' ); ?></a>
<?php wp_nav_menu( array( 'theme_location' => 'primary',
//                          'container' => 'nav',
//                          'container_id' => 'navbar',
//                          'container_class' => 'navbar navbar-default',
                          'menu_class' => 'nav-menu',
                          'menu_id' => 'primary-menu',
                          'items_wrap' => '<ul class="nav navbar-nav navbar-right">%3$s</ul>' ) ); ?>
            

</div>
    </nav>
    
    <div class="container">



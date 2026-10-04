<!DOCTYPE html>
<!--[if lt IE 7]>      
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>         
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>         
<html class="no-js lt-ie9">
<![endif]-->
<?php global $t_one_opt; ?>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
<title><?php wp_title( '|', true, 'right' ); ?> Unthunk </title>


<link href='http://fonts.googleapis.com/css?family=Prosto+One' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>

        <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,700,900' rel='stylesheet' type='text/css'>

    	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,300,600,700,800' rel='stylesheet' type='text/css'>



      	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
      	<?php if (!empty($t_one_opt['favicon_img']['url'])){	echo '<link rel="Shortcut Icon" type="image/png" href="' . $t_one_opt['favicon_img']['url'] . '" />';} ?>
      	<?php if (!empty($t_one_opt['iphone_icon_img']['url'])) {	echo '<link rel="apple-touch-icon" size="57x57" href="' . $t_one_opt['iphone_icon_img']['url'] . '" />';	} ?>
      	<?php if (!empty($t_one_opt['iphone_retina_icon_img']['url'])) { echo '<link rel="apple-touch-icon" size="114x114" href="' . $t_one_opt['iphone_retina_icon_img']['url'] . '" />';}?>
      	<?php if (!empty($t_one_opt['ipad_icon_img']['url'])) { echo '<link rel="apple-touch-icon" size="72x72" href="' . $t_one_opt['ipad_icon_img']['url'] . '" />';} ?>
      	<?php if (!empty($t_one_opt['ipad_retina_icon_img']['url'])) { echo '<link rel="apple-touch-icon" size="144x144" href="' . $t_one_opt['ipad_retina_icon_img']['url'] . '" />';}?>
    	<!--[if lt IE 9]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    	<![endif]-->
<!-- back button -->
<script>
function goBack() {
    window.history.back()
}
</script>
		<?php wp_head(); ?>
	</head>
   	<body <?php body_class(); ?> data-spy="scroll" data-target=".navbar-default">
    <?php if(is_page_template('templates/home-page.php')) { ?>
        <div id="home">
            <?php get_template_part( 'templates/slider' ); ?>
        </div>
    <?php } $adminbar = ( is_admin_bar_showing() ) ? 'adminbar' : 'no-adminbar';  ?>
        <div class='wrapper'>
            <div class="navbar-wrap" data-admin="<?php echo $adminbar ?>">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="logo-wrap">
                    <?php if (!empty($t_one_opt['logo_img']['url'])) { ?>
                    	<a href="<?php echo home_url() ?>" class="logo">
                    		<img src="<?php echo $t_one_opt['logo_img']['url'] ?>" class="img-responsive" alt="">
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo home_url() ?>" class="logo">
                            <span>T</span>
                        </a>
                    <?php } ?>
                    </div>
                    <div class="container-fluid no-height">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navigation">
                            <div class="left-side">
                                <?php wp_nav_menu( array(
                                    'theme_location'  => 'main-menu-left',
                                    'menu'            => '',
                                    'container'       => false,
                                    'menu_class'      => 'nav navbar-nav navbar-right first-nav',
                                    'menu_id'         => 'top-nav',
                                    'echo'            => true,
                                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                                ) ); ?> 
                                <!--MENU--> 
                            </div>
                            <div class="righ-side">
                                <?php wp_nav_menu( array(
                                    'theme_location'  => 'main-menu-right',
                                    'menu'            => '',
                                    'container'       => false,
                                    'menu_class'      => 'nav navbar-nav',
                                    'menu_id'         => 'top-nav-2',
                                    'echo'            => true,
                                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                                ) ); ?> 
                                <!--MENU--> 
                            </div>
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!-- /.container-fluid -->
                </nav>
            </div>
            <!-- /.Navigation -->
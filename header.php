<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.2/css/all.css" integrity="sha384-XxNLWSzCxOe/CFcHcAiJAZ7LarLmw3f4975gOO6QkxvULbGGNDoSOTzItGUG++Q+" crossorigin="anonymous">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<?php wp_head(); ?>

</head>
<?php
function theme_get_customizer_css() {
  ob_start();

  $primary_color = get_theme_mod( 'primary_color', '' );
  $secondary_color = get_theme_mod( 'secondary_color', '' );
  $dark_color = get_theme_mod( 'secondary_color', '' );
  $primary_dark = adjustBrightness($primary_color, -50);
  $primary_light = adjustBrightness($primary_color, 150);
  $secondary_dark = adjustBrightness($secondary_color, -50);
  if ( ! empty( $primary_color ) ) {
	?>
		h1:not(.page-title),h2,h3,h4,h5,h6, #main-menu > li > a, .breadcrumb a, .breadcrumb, .breadcrumb .row .col-md-12>span,
		.main-content .slideshow .swiper-container .swiper-button-next:after, .main-content .slideshow .swiper-container .swiper-button-prev:after,
		.slide-caption, .service-list a, .service-cta-wrap .service-cta-content, .subfooter, .single-sub-info, .home-major-points,
		.full-service-list a, .home-service-location .cert-wrap p, .home-intro .home-intro-left a.learn-more,
		.page-template-sub-front-page .home-testimonial .row .swiper-container .swiper-button-next:after,
	    .page-template-sub-front-page .home-testimonial .row .swiper-container .swiper-button-prev:after, .home-featured-projects .sfp-right span a,
		.related-projects .sfp-right span a, #left-sidebar aside a, #right-sidebar aside a, #page-wrapper a,
		.full-width.light-theme, .industry-card ul li, .location-list .single-location, .location-list .single-location a,
		.location-filter .searchandfilter select, .blog-archive article, .page-link, input[type=text], .header .navbar-toggler .navbar-toggler-icon,
		.home-career .hc-right .swiper-container .swiper-button-prev:after, .home-career .hc-right .swiper-container .swiper-button-next:after,
		.main-content .left-content, .card .card-body, .page-contractor a
		 {
		  color: <?php echo $primary_color; ?>!important;
		}

		.home-featured-projects .single-featured-project:hover .sfp-left h5, .related-projects:hover .sfp-left h5, .cta.dark-theme h3, .page-item.active .page-link,
		.home-banner .banner-content h1, .page-template-sub-front-page .home-cta .row h5, .footer h1, .footer h2, .footer h3, .footer h4, .footer h5,
		.footer h6 {
			color: white!important;
		}

		.single-sub-info, .home-featured-projects .single-featured-project:hover .sfp-left, .related-projects .single-featured-project:hover .sfp-left,
		.location-filter .searchandfilter select, input[type=text], form input, form textarea {
			border-color: <?php echo $primary_color; ?>!important;
		}

		.home-contractor .active-item:after, .page-contractor .active-item:after, .subsidiary-service .active-item:after {
			border-bottom-color: <?php echo $primary_color; ?>!important;
		}

		.footer-menu, .main-content .slideshow .swiper-container .swiper-pagination-bullet:not(.swiper-pagination-bullet-active),
		#main-menu>.menu-item-has-children>.dropdown-menu li a, .page-template-sub-front-page .home-cta,
		.page-template-sub-front-page .home-testimonial .row .swiper-container span.swiper-pagination-bullet.swiper-pagination-bullet-active,
		.home-featured-projects .single-featured-project:hover .sfp-left, .related-projects .single-featured-project:hover .sfp-left,
		.home-featured-projects .sfp-right, .related-projects .sfp-right, .no-banner, .cta.dark-theme, .page-header, .page-item.active .page-link,
	     #main-menu>.menu-item-has-children>.dropdown-menu li .dropdown-menu, .card .card-header button[aria-expanded=true], .home-career:after,
		 .short-header.solid-header, .home-banner, form .gform_button {
			background-color:  <?php echo $primary_color; ?>!important;
		}

		.slide-caption, .location-filter .searchandfilter select, input[type=text], .card:nth-child(odd) .card-header, .card .card-body, textarea {
			background-color: <?php echo $primary_light; ?>!important;
		}

		.card:nth-child(even) .card-header {
			background-color: <?php echo $primary_light; ?>!important;
		}

		.page-header:after, .short-header:after, .tall-header:after, .home-banner:after {
			background: <?php echo $primary_color; ?>;
		    background: -moz-linear-gradient(0deg, <?php echo $primary_color; ?> 0%, rgba(255, 255, 255, 0) 65%);
		    background: -webkit-linear-gradient(0deg, <?php echo $primary_color; ?> 0%, rgba(255, 255, 255, 0) 65%);
		    background: -webkit-gradient(linear, left bottom, left top, from(<?php echo $primary_color; ?>), color-stop(65%, rgba(255, 255, 255, 0)));
		    background: -webkit-linear-gradient(bottom, <?php echo $primary_color; ?> 0%, rgba(255, 255, 255, 0) 65%);
		    background: -o-linear-gradient(bottom, <?php echo $primary_color; ?> 0%, rgba(255, 255, 255, 0) 65%);
		    background: linear-gradient(0deg, <?php echo $primary_color; ?> 0%, rgba(255, 255, 255, 0) 65%);
		}

		@media (max-width: 768px) {
			#main-menu, #main-menu .menu-item-has-children .dropdown-menu {
				background-color:  <?php echo $primary_color; ?>!important;
			}
			#main-menu > li > a {
				color: white!important;
			}


		}

	<?php
  }

  if ( ! empty( $secondary_color ) ) {
	?>
		@media (min-width: 768px) {
			#navbarNavDropdown>ul>li:last-child a {
				background-color: <?php echo $secondary_color; ?>;
				color: white!important;
			}
		}

		.home-career .hc-right .swiper-container span.swiper-pagination-bullet.swiper-pagination-bullet-active {
			background-color:<?php echo $secondary_color; ?>!important;
		}

		.footer .footer-contact-info strong, .page-template-sub-front-page .home-cta h5 {
			color: <?php echo $secondary_color; ?>;
		}
		.btn-secondary, .footer-menu li:last-child a {
			background-color:  <?php echo $secondary_color; ?>;
			color: white!important;
		}
	<?php
  }

  if ( ! empty( $dark_color ) ) {
	?>
		@media (min-width: 768px) {
			#navbarNavDropdown>ul>li:last-child a {
				background-color: <?php echo $secondary_color; ?>;
				color: white!important;
			}
		}

		#main-menu>.menu-item-has-children>.dropdown-menu:before {
			background-color: <?php echo $secondary_color; ?>!important;
		}
		.footer .footer-contact-info strong {
			color: <?php echo $secondary_color; ?>!important;
		}


		#main-menu>.menu-item-has-children>.dropdown-menu {
			border-color: <?php echo $secondary_color; ?>!important;
		}


		.btn-secondary, .footer-menu li:last-child a {
			background-color: <?php echo $secondary_color; ?>!important;
			border-color: <?php echo $secondary_color; ?>!important;
			color: white!important;
		}
	<?php
  }

  $css = ob_get_clean();
  return $css;
} ?>
<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div class="header" id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

		<nav class="navbar navbar-expand-md navbar-primary bg-white">

		<?php if ( 'container' == $container ) : ?>
			<div class="container">
		<?php endif; ?>

					<!-- Your site title as branding in the menu -->
					<?php $logo = get_field('header_logo','options'); if ( $logo ) : ?>
						<a href="/" class="header-logo d-flex align-items-center"><img src="<?php echo $logo['url']; ?>" /></a>
					<?php endif; ?>

					<!-- Top Menu -->

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
					<span class="navbar-toggler-icon"><i class="fal fa-bars"></i></span>
				</button>


				<?php
					if (has_nav_menu('top-menu')) {
						wp_nav_menu( array(
							'menu' => 'Top Menu',
							'container_class' => 'top-menu-wrap',
						));
					}
				?>
				<!-- The WordPress Menu goes here -->
				<?php
					if ( has_nav_menu('primary') ) {
						wp_nav_menu(
							array(
								'theme_location'  => 'primary',
								'container_class' => 'collapse navbar-collapse',
								'container_id'    => 'navbarNavDropdown',
								'menu_class'      => 'navbar-nav ml-auto',
								'fallback_cb'     => '',
								'menu_id'         => 'main-menu',
								'depth'           => 4,
								'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
							)
						);
					}
				?>

			<?php if ( 'container' == $container ) : ?>
			</div><!-- .container -->
			<?php endif; ?>

		</nav><!-- .site-navigation -->

	</div><!-- #wrapper-navbar end -->

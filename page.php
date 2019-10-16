<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
$pID = get_the_ID();
?>
<?php
    $header = get_field('enable_banner');
    $headerType = get_field('enable_tall_banner');

    if ( $headerType == "true") {
        $headerType = 'tall-header';
    } else {
        $headerType = 'short-header';
    }
?>

<?php if ( $headerType == "tall-header") : ?>
	<div class="container-fluid <?php echo $headerType; ?>">
	    <?php if ( has_post_thumbnail($pID) ): ?>
	        <?php the_post_thumbnail('page-banner'); ?>
	    <?php else : ?>
	        <img src="<?php echo the_field('service_featured_image', 'options')?>">
	    <?php endif; ?>
	    <?php if ( $headerType == "tall-header") : ?>
	        <div class="row d-flex justify-content-center align-items-center">
	    <?php else : ?>
	        <div class="row">
	    <?php endif; ?>
	        <h1 class="page-title">
	            <?php the_title(); ?>
	        </h1>
	    </div>
	</div>
<?php endif; ?>

<?php if ( $headerType = "short-header" ) : ?>
	<div class="no-banner short-header"></div>
    <div class="container breadcrumb">
	    <div class="row">
	        <div class="col-md-12">
	            <?php bcn_display(); ?>
	        </div>
	    </div>
	</div>
<?php endif; ?>
<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">
			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'page' ); ?>


				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>

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

<?php if ( $header == "true") : ?>
<div class="container-fluid <?php echo $headerType; ?>">
    <?php if ( has_post_thumbnail() ): ?>
        <?php the_post_thumbnail('page-banner'); ?>
    <?php else : ?>
        <img src="<?php echo the_field('service_featured_image', 'options')?>">
    <?php endif; ?>
    <?php if ( $headerType == "tall-header") : ?>
        <div class="row d-flex justify-content-bottom align-items-end">
    <?php else : ?>
        <div class="row">
    <?php endif; ?>
        <h1 class="page-title">
            <?php the_title(); ?>
        </h1>
    </div>
</div>
<?php endif; ?>
<?php if ( $header ) : ?>
    <div class="container breadcrumb">
<?php else :  ?>
	<div class="no-banner"></div>
    <div class="container breadcrumb">
<?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <?php bcn_display(); ?>
        </div>
    </div>
</div>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<?php get_template_part( 'sidebar-templates/sidebar', 'left' ); ?>

			<div
				class="<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>col-md-8<?php else : ?>col-md-12<?php endif; ?> content-area"
				id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php if ( $header != "true") : ?>
                            <header class="entry-header">
                        		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        	</header><!-- .entry-header -->
                        <?php endif; ?>
						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>

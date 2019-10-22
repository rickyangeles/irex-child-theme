<?php
/**
 * Template Name: Partners Page
 *
 * Template for displaying a page with a list of partners
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() ) : ?>
  <?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

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

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row content-area d-flex align-items-center" id="primary">
            <?php if( have_rows('partners') ): ?>
                <?php while( have_rows('partners') ): the_row();

            		// vars
            		$logo = get_sub_field('partner_logo');
                    $name = get_sub_field('partner_name');
            		$desc = get_sub_field('partner_description');
            		$link = get_sub_field('partner_link');
            	?>
                <div class="col-md-4 single-partner">
                    <a href="<?php echo $link; ?>">
                        <img src="<?php echo $logo; ?>" alt="<?php echo $name; ?>">
                    </a>
                    <h5><?php echo $name; ?></h5>
                    <p><?php echo $desc; ?></p>
                </div>
            	<?php endwhile; ?>
            <?php endif; ?>

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php get_footer(); ?>

<?php
/**
 * Template Name: Contact Page
 *
 * Template for displaying the contact page
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
		<div class="row">
			<div class="col-md-12 content-area" id="primary">
				<main class="site-main" id="main" role="main">
					<?php while ( have_posts() ) : the_post(); ?>
                        <?php if ( $header != "True") : ?>
                            <header class="entry-header">
                        		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        	</header><!-- .entry-header -->
                        <?php endif; ?>
						<?php get_template_part( 'loop-templates/content', 'page' ); ?>
					<?php endwhile; // end of the loop. ?>
				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .row end -->
        <div class="row">
            <div class="col-md-6">
                <?php $formID = get_field('contact_form_id'); ?>
                <?php echo do_shortcode('[gravityform id=' . $formID . ']'); ?>
            </div>
            <div class="col-md-6">
                <h5>Branch Locations & Contact Information</h5>
                <div class="row">
                    <?php $locations = get_field('select_locations'); ?>
                    <?php if ( $locations ) : ?>
                        <?php foreach( $locations as $post): ?>
                            <?php setup_postdata($post); ?>
                            <?php
                                $branchName     = get_field('branch_name');
                                $address1       = get_field('address_1');
                                $address2       = get_field('address_2');
                                $city           = get_field('city');
                                $state          = get_field('state');
                                $zip            = get_field('zip_code');
                                $tel            = get_field('telephone');
                                $tollFree       = get_field('toll_free_number');
                                $fax            = get_field('fax');
                                $lat            = get_field('latitude');
                                $long           = get_field('longitude');
                                $show           = get_field('hide_in_location_page');
                                $meta           = get_post_meta($post->ID, 'dt_connection_map', false);

                                foreach ($meta as $k => $v) {
                                    foreach ($v as $kk => $vv) {
                                        if ($kk == 'external') {
                                            reset($vv);
                                            $t = key($vv);
                                        }
                                    }
                                }

                                $url = get_post_meta($t, 'dt_external_connection_url', true);
                                $services = $url . "/wp/v2/service?per_page=100";
                                $logo = $url . "/acf/v3/options/options/header_logo";
                                $subName = get_the_title($t);

                            ?>
                            <div class="col-md-4" data-sub="<?php echo $subName; ?>" data-state="<?php echo $state; ?>" <?php get_service_list($services); ?>>
                                <ul class="single-location contact-page-location">
                                    <?php if ( $branchName ) : ?>
                                        <li><?php echo $branchName; ?></li>
                                    <?php endif; ?>
                                    <?php if ( $address1 ) : ?>
                                        <li><?php echo $address1; ?></li>
                                    <?php endif; ?>
                                    <?php if ( $address2 ) : ?>
                                        <li><?php echo $address2; ?></li>
                                    <?php endif; ?>
                                    <?php if ( $city && $state && $zip ) : ?>
                                        <li><?php echo $city . ', ' . $state . ' ' . $zip; ?></li>
                                    <?php endif; ?>
                                    <?php if ( $tel ) : ?>
                                        <li>P: <?php echo $tel; ?></li>
                                    <?php endif; ?>
                                    <?php if ($tollFree) :?>
                                        <li>P: <?php echo $tollFree; ?></li>
                                    <?php endif; ?>
                                    <?php if ( $fax ) : ?>
                                        <li>F: <?php echo $fax; ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
	</div><!-- #content -->
</div><!-- #full-width-page-wrapper -->
<?php get_footer(); ?>

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
$secondaryContent = get_field('secondary_content');
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
        <div class="row justify-content-between">
            <div class="col-md-5">
                <?php $formID = get_field('contact_form_id'); ?>
                <?php echo do_shortcode('[gravityform id=' . $formID . ']'); ?>
            </div>
            <div class="col-md-7 contact-page-map">
                <h5>Branch Locations & Contact Information</h5>
                <h6 class="service-area-title"><strong>Services Area(s):</strong> <?php the_field('service_area'); ?></h6>
                <?php
                    $map = array(
                        'post_type' => 'location',
                        'posts_per_page' => -1,
                        'orderby'   => 'title',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                                'key'   => 'show_on_subsidiary_contact_page',
                                'value' => 'yes',
                            )
                        )
                    );
                    $mapQuery = new WP_Query($map);
                ?>
                <?php if ( $mapQuery->have_posts() ) : ?>
                    <div class="acf-map location-container" style="overflow: hidden; position: relative;">
                        <?php while ( $mapQuery->have_posts() ) : ?>
                            <?php
                                $mapQuery->the_post();
                                $lat            = get_field('latitude');
                                $long           = get_field('longitude');
                                $branchName     = get_field('branch_name');
                                $address1       = get_field('address_1');
                                $address2       = get_field('address_2');
                                $city           = get_field('city');
                                $state          = get_field('state');
                                $zip            = get_field('zip_code');
                                $tel            = get_field('telephone');
                                $tollFree       = get_field('toll_free_number');
                                $fax            = get_field('fax');
                            ?>

                            <div class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $long; ?>">
                                <div class="inside-marker">
                                    <ul class="single-location">
                                        <li>
                                            <strong><?php the_title(); ?></strong>
                                        </li>
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
                                        <?php if ( $url ) : ?>
                                            <li><a href="<?php echo $url; ?>">visit website ></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <?php if ( $mapQuery->have_posts() ) : ?>
                    <div class="row">
                    <?php while ( $mapQuery->have_posts() ) : ?>
                        <?php
                            $mapQuery->the_post();
                            $lat            = get_field('latitude');
                            $long           = get_field('longitude');
                            $branchName     = get_field('branch_name');
                            $address1       = get_field('address_1');
                            $address2       = get_field('address_2');
                            $city           = get_field('city');
                            $state          = get_field('state');
                            $zip            = get_field('zip_code');
                            $tel            = get_field('telephone');
                            $tollFree       = get_field('toll_free_number');
                            $fax            = get_field('fax');
                        ?>
                        <ul class="col-md-4 single-location">
                            <li>
                                <strong><?php the_title(); ?></strong>
                            </li>
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
                            <?php if ( $url ) : ?>
                                <li><a href="<?php echo $url; ?>">visit website ></a></li>
                            <?php endif; ?>
                        </ul>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $secondaryContent; ?>
            </div>
        </div>
	</div><!-- #content -->
</div><!-- #full-width-page-wrapper -->
<?php get_footer(); ?>

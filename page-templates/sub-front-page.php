<?php
/**
 * Template Name: Subsidiary Front Page
 *
 * Template for displaying the subsidiary front page
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
    //Fields
    $bannerImg = wp_get_attachment_url( get_field('banner_image') );
    $bannerImgPos = get_field('image_position_sub');
    $srcset = wp_get_attachment_image_srcset( get_field('banner_image') );
    $bannerContent = get_field('banner_content');
    $bannerPrimary = get_field('banner_primary_button');
    $bannerSecondary = get_field('banner_secondary_button');
    $introLeft = get_field('intro_content');
    $introRight = get_field('intro_image');
    $introBG = get_field('intro_bg');
    $introButton = get_field('intro_button');
    $pointTitle = get_field('point_title');
    $point = get_field('point');
    $serviceContent = get_field('service_content');
    $certLogo = get_field('cerification_logo');
    $certText = get_field('certification_content');
    $serviceCTAcontent = get_field('service_cta_content', 'options');
    $serviceCTAbtn     = get_field('service_cta_button', 'options');
    $testimonials = get_field('select_testimonials');
    $testimonialTitle = get_field('testimonial_title');
    $projectTitle = get_field('project_title');
    $featuredProjects = get_field('select_projects_to_feature');
    $p_count = count($featuredProjects);
    $projectButton = get_field('project_button');
    $careerTitle = get_field('career_title');
    $careerContent = get_field('career_content');
    $careerSlideshow = get_field('career_slideshow');
    $careerBG = get_field('career_background_image') ? 'style="background-image:url(' . get_field('career_background_image') . ');"' : '';
    $careerButton = get_field('career_button');

    if ( $introBG ) {
        $introBG = 'style="background-image:url(' . get_field('intro_bg') . ')";';
    } else {
        $introBG = '';
    }

    if ( $industryBG ) {
        $industryBG = 'style="background-image:url(' . get_field('industry_background_image') . ')";';
    } else {
        $industryBG = '';
    }

?>
<div class="wrapper home-page-wrapper" id="full-width-page-wrapper">

    <!-- Banner -->
    <div class="container-fluid banner home-banner px-0" style="background-image:url('<?php echo $bannerImg; ?>'); background-position-y:<?php echo $bannerImgPos; ?>%">
        <div class="banner-content">
            <?php echo $bannerContent; ?>
            <ul class="banner-buttons">
                <li><a href="<?php echo $bannerPrimary['url']; ?>" class="btn btn-primary"><?php echo $bannerPrimary['title']; ?></a></li>
            </ul>
        </div>
    </div>

    <!-- Intro -->
    <div class="container-fluid home-intro py-4" <?php echo $introBG; ?>>
        <div class="row">
            <div class="col-md-6 home-intro-left">
                <?php echo $introLeft; ?>
                <a class="learn-more" href="<?php echo $introButton['url']; ?>"><?php echo $introButton['title']; ?></a>
            </div>
            <div class="col-md-6 home-intro-right">
                <img src="<?php echo $introRight['url']; ?>" />
                <?php if ( $introRight['caption']) : ?>
                    <div class="slide-caption"><?php echo $introRight['caption']; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Major Points -->
    <div class="container home-major-points pt-4">
        <?php if ( $pointTitle ) : ?>
            <h4 class="title"><?php echo $pointTitle; ?></h4>
        <?php endif; ?>
        <div class="row d-flex justify-content-around">
            <?php if( have_rows('point') ): ?>
            	<?php while( have_rows('point') ): the_row();
            		// vars
            		$icon = get_sub_field('point_icon');
            		$title = get_sub_field('point_title');
            		$content = get_sub_field('point_content');
            	?>
                <div class="col-md-3 point">
                    <?php echo $icon; ?>
                    <h4><?php echo $title; ?></h4>
                    <?php echo $content; ?>
                </div>
            	<?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- Service and location -->
    <div class="container-fluid home-service-location">
        <div class="row">
            <div class="col-md-6">
                <h4>Services</h4>
                <?php echo $serviceContent; ?>

                <h5>Our Services</h5>
                <ul class="full-service-list">
                    <?php
                        wp_list_pages( array (
                            'post_type' => 'service',
                            'title_li' => ''
                        ));
                    ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h4>Locations</h4>
                <h5>Service Area(s): All United States</h5>
                <?php

                    $args = array(
                        'post_type' => 'location',
                        'posts_per_page' => -1,
                    );

                    $locations_query = new WP_QUERY($args);

                    if ( $locations_query->have_posts() ) : ?>

                <div class="acf-map" style="overflow: hidden; position: relative;">

                    <?php while ( $locations_query->have_posts() ) : ?>
                        <?php
                            $locations_query->the_post();
                            $pID            = get_the_ID();
                			$title 			= get_the_title();
                			$lat            = get_field('latitude', $pID);
                			$long           = get_field('longitude', $pID);
                            $branchName     = get_field('branch_name', $pID);
                            $address1       = get_field('address_1', $pID);
                            $address2       = get_field('address_2', $pID);
                            $city           = get_field('city', $pID);
                            $state          = get_field('state', $pID);
                            $zip            = get_field('zip_code', $pID);
                            $tel            = get_field('telephone', $pID);
                            $tollFree       = get_field('toll_free_number', $pID);
                            $fax            = get_field('fax', $pID);
                            $meta           = get_post_meta($pID, 'dt_connection_map', false);
                        ?>

                        <div class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $long; ?>" data-img="<?php echo $type_icon; ?>">
                            <div class="inside-marker">
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
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </div>
                <?php endif; ?>
                <h5>Branch Locations & Contact Information</h5>
                <div class="row full-location-list">
                    <?php
                        $args = array(
                            'post_type' => 'location',
                            'posts_per_page' => -1,
                        );
                        $locations = new WP_QUERY($args);
                    ?>
                    <?php if ( $locations->have_posts() ) : ?>
                        <?php while ($locations->have_posts() ) : $locations->the_post(); ?>
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

                                // $url = get_post_meta($t, 'dt_external_connection_url', true);
                                // $services = $url . "/wp/v2/service?per_page=100";
                                // $logo = $url . "/acf/v3/options/options/header_logo";
                                // $subName = get_the_title($t);

                            ?>
                            <div class="home-location">
                                <ul class="single-location">
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
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <div class="row cert-wrap">
            <div class="col-md-6 offset-md-3 d-flex align-items-center">
                <img src="<?php echo $certLogo['url']; ?>" alt="">
                <p><?php echo $certText; ?></p>
            </div>
        </div>
    </div>


    <!-- CTA -->
    <?php if ( $serviceCTAcontent ) : ?>
        <div class="container-fluid home-cta">
            <div class="row d-flex align-items-center">
                <div class="col-md-9">
                    <p><?php echo $serviceCTAcontent; ?></p>
                </div>
                <div class="col-md-3">
                    <?php if ( $serviceCTAbtn ) : ?>
                        <a href="<?php echo $serviceCTAbtn['url']; ?>" class="btn btn-secondary"><?php echo $serviceCTAbtn['title']; ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Testimonials -->
    <?php if ( $testimonials ) : ?>
        <?php $testCount = count($testimonials); ?>
        <div class="container-fluid home-testimonial">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="title"><?php echo $testimonialTitle; ?></h4>
                    <?php if( $testimonials ): ?>
                        <div class="swiper-container testimonial-slider">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper d-flex align-items-center">
                                <?php foreach( $testimonials as $testimonial ): // variable must be called $post (IMPORTANT) ?>
                                    <?php setup_postdata($testimonial); ?>
                                    <div class="swiper-slide">
                                        <?php
                                            $p = $testimonial->ID;
                                            $name = get_field('testimonial_name', $p);
                                            $job = get_field('testimonial_job_title', $p);
                                            $company = get_field('testimonial_company_name', $p);
                                        ?>
                                       <?php the_content($p); ?>
                                       <p class="testimonail-detail"><strong><?php echo $name; ?></strong>, <?php echo $job; ?>, <?php echo $company; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if ( $testCount > 1 ) : ?>
                                <div class="nav-wrap">
                                    <div class="swiper-pagination"></div>
                                    <!-- If we need navigation buttons -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Featured Projects -->
    <?php if( $featuredProjects ): ?>
        <div class="container home-featured-projects">
            <div class="row">
                <?php if ( $p_count > 1 ) : ?>
                    <h2 class="title">Featured Projects</h2>
                <?php else : ?>
                    <h2 class="title">Featured Project</h2>
                <?php endif; ?>
            </div>
            <?php if( $featuredProjects ): ?>
            <div class="row d-flex justify-content-center">
                <?php foreach( $featuredProjects as $post): // variable must be called $post (IMPORTANT) ?>
                    <?php setup_postdata($post); ?>
                        <div class="col-md-6 single-featured-project d-flex align-items-center">
                                <div class="sfp-left">
                                    <a href="<?php the_permalink(); ?>">
                                    <h5><?php the_title(); ?></h5>
                                    <p><?php echo project_excerpt(20, $post->ID); ?></p>
                                    </a>
                                </div>
                                <div class="sfp-right d-flex align-items-center">
                                    <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('featured-project'); ?>
                                    <?php else : ?>
                                        <img src="https://via.placeholder.com/300">
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-center align-items-center"><span class="read-more btn btn-sm">Read More</span></div>
                                </a>
                                </div>
                        </div>
                <?php endforeach; ?>
                <div class="fp-btn text-center">
                    <a href="<?php echo $projectButton['url']; ?>" class="view-all btn btn-primary"><?php echo $projectButton['title']; ?></a>
                </div>
            </div>
        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
        <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Career -->
    <div class="container-fluid home-career" <?php echo $careerBG; ?>>
        <div class="row d-flex align-items-center">
            <h2 class="title"><?php echo $careerTitle; ?></h2>
            <div class="col-md-6 hc-left">
                <?php echo $careerContent; ?>
                <?php if ( $careerButton ) : ?>
                    <a href="<?php echo $careerButton['url']; ?>" class="btn btn-primary"><?php echo $careerButton['title']; ?></a>
                <?php endif; ?>
            </div>
            <div class="col-md-6 hc-right">
                <?php $slideCount = 0; ?>
                <?php if( have_rows('career_slideshow') ): ?>
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                	<?php while( have_rows('career_slideshow') ): the_row();
                		// vars
                        $size = 'slideshow';
                		$image = get_sub_field('slide_image');
                		$content = get_sub_field('slide_caption');
                		?>
                        <div class="swiper-slide">
                          <img src="<?php echo $image; ?>" />
                           <?php if ( $content ) : ?>
                               <div class="slide-caption"><?php echo $content; ?></div>
                           <?php endif; ?>
                       </div>
                       <?php $slideCount++; ?>
                	<?php endwhile; ?>
                </div>
                    <!-- If we need pagination -->
                    <?php if ( $slideCount > 1 ) : ?>
                        <div class="nav-wrap">
                            <div class="swiper-pagination"></div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    <?php endif; ?>
                    </div>
                    <script type="text/javascript">
                    var mySwiper = new Swiper ('.swiper-container', {
                      // Optional parameters
                      direction: 'horizontal',
                      loop: true,

                      // If we need pagination
                      pagination: {
                        el: '.swiper-pagination',
                      },

                      // Navigation arrows
                      navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                      },
                    })
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</div><!-- #full-width-page-wrapper -->

<?php get_footer(); ?>

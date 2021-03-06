<?php
/**
 * Template Name: Front Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
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
    $bannerImg = get_field('banner_image');
    $srcset = wp_get_attachment_image_srcset( get_field('banner_image') );
    //$bannerContent = get_field('banner_content');
    $bannerPrimary = get_field('banner_primary_button');
    $bannerSecondary = get_field('banner_secondary_button');
    $sliderCount = count(get_field('slider'));
    $introLeft = get_field('intro_content');
    $introRight = get_field('intro_video');
    $introBG = get_field('intro_bg');
    $introButton = get_field('intro_button');
    $pointTitle = get_field('point_title');
    $point = get_field('point');
    $industyTitle = get_field('industry_title');
    $industryBG = get_field('industry_background_image');
    //$industry = get_field('select_industries');
    $contractorTitle = get_field('contractor_title', 'options');
    $contractorContent = get_field('contractor_content', 'options');
    $contractorBtn = get_field('contractor_button', 'options');
    $projectTitle = get_field('project_title');
    $featuredProjects = get_field('select_projects_to_feature');
    $projectButton = get_field('project_button');
    $careerTitle = get_field('career_title');
    $careerContent = get_field('career_content');
    $careerSlideshow = get_field('career_slideshow');
    $careerBG = get_field('career_background_image') ? 'style="background-image:url(' . get_field('career_background_image') . ');"' : '';
    $careerButton = get_field('career_button');

    if ( $sliderCount > 1 ) {
        $slideLoop = 'true';
        $autoplay = 'autoplay: { delay: 5000, disableOnInteraction: false, },';
    } else {
        $slideLoop = false;
    }


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
    <!-- <div class="container-fluid banner home-banner px-0" style="background-image:url('<?php echo $bannerImg['url']; ?>');">
        <div class="banner-content">
            <?php echo $bannerContent; ?>
            <ul class="banner-buttons">
                <li><a href="<?php echo $bannerPrimary['url']; ?>" class="btn btn-primary"><?php echo $bannerPrimary['title']; ?></a></li>
                <?php if ($bannerSecondary) : ?>
                    <li><a href="<?php echo $bannerSecondary['url']; ?>" class="btn btn-secondary"><?php echo $bannerSecondary['title']; ?></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div> -->
    <div class="container-fluid banner home-slider px-0">
        <div class="swiper-container slider-container h-slider">
            <div class="swiper-wrapper">
            <?php while( have_rows('slider') ): the_row();
                // vars
                $image = get_sub_field('slider_image');
                $content = get_sub_field('slider_content');
                $imagePosition = get_sub_field('slide_image_cover_postion');
                $url = $image['url'];
            ?>

                <div class="swiper-slide" style="background-size: cover; background-image:url('<?php echo $url; ?>'); background-position-y:<?php echo $bannerImgPos; ?>">
                    <div class="slide-content">
                        <div class="banner-content">
                            <p><?php echo $content; ?></p>
                            <ul class="banner-buttons">
                                <li><a href="<?php echo $bannerPrimary['url']; ?>" class="btn btn-primary"><?php echo $bannerPrimary['title']; ?></a></li>
                            <?php if ($bannerSecondary) : ?>
                                <li><a href="<?php echo $bannerSecondary['url']; ?>" class="btn btn-secondary"><?php echo $bannerSecondary['title']; ?></a></li>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
        </div>
        <?php if ( $sliderCount > 1 ) :?>
            <div class="swiper-button-next slide-button-next"></div>
            <div class="swiper-button-prev slide-button-prev"></div>
        <?php endif; ?>
    </div>

    <!-- Intro -->
    <div class="container-fluid home-intro py-4" <?php echo $introBG; ?>>
        <div class="row">
            <div class="col-md-6 home-intro-left">
                <?php echo $introLeft; ?>
                <a class="learn-more" href="<?php echo $introButton['url']; ?>"><?php echo $introButton['title']; ?></a>
            </div>
            <div class="col-md-6 home-intro-right embed-responsive embed-responsive-16by9">
                <?php echo $introRight; ?>
            </div>
        </div>
    </div>

    <!-- Major Points -->
    <div class="container home-major-points">
        <div class="row d-flex justify-content-around">
            <?php if( have_rows('point') ): ?>
            	<?php while( have_rows('point') ): the_row();
            		// vars
            		$icon = get_sub_field('point_icon');
            		$title = get_sub_field('point_title');
            		$content = get_sub_field('point_content');
            	?>
                <div class="col-md-5 point">
                    <?php echo $icon; ?>
                    <div class="point-content">
                        <h4><?php echo $title; ?></h4>
                        <p><?php echo $content; ?></p>
                    </div>
                </div>
            	<?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Industries -->
    <div class="container-fluid home-industries" <?php echo $industryBG; ?>>
        <div class="row">
            <h2 class="title"><?php echo $industyTitle; ?></h2>
        	<ul class="industry-list">
                <?php
                	// the query
                    $industry = new WP_Query( array(
                        'post_type' => 'industry',
                        'posts_per_page' => -1,
                        'order' => 'DESC',
                        'orderby' => 'date'
                    ));
                ?>
                <?php if ( $industry->have_posts() ) : ?>
                <?php while ( $industry->have_posts() ) : $industry->the_post(); ?>
                    <li><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                <?php endif; ?>
        	</ul>
        </div>
    </div>

    <!-- Contractor -->
    <div class="container home-contractor">
        <div class="row contractor-cta d-flex align-items-center">
            <div class="col-md-9">
                <h2><?php echo $contractorTitle; ?></h2>
                <p><?php echo $contractorContent; ?></p>
            </div>
            <div class="col-md-3">
                <a href="<?php echo $contractorBtn['url']; ?>" class="btn btn-primary"><?php echo $contractorBtn['title']; ?></a>
            </div>
        </div>

            <?php
        		$query = new WP_Query(array(
        		    'post_type' => 'dt_ext_connection',
        		    'post_status' => 'publish',
        			'posts_per_page' => -1,
                    'orderby'   => 'title',
                    'order'    => 'ASC'
        		));
        	?>
            <?php $counter = 0; ?>
                <div class="row folding-menu">
                <?php while ($query->have_posts()) : ?>
                    <?php $query->the_post(); ?>
                    <?php
                        // if ($counter % 4 == 0) :
                        //     echo $counter > 0 ? '</div></div>' : ''; // close div if it's not the first
                        //     echo '<div class="home-contractor-row container"><div class="row">';
                        // endif; ?>
                		<?php
                        $remove         = array("/wp-json", "http://");
                        $url            = get_post_meta(get_the_ID(), 'dt_external_connection_url', true);
                        $cleanUrl       = str_replace($remove,'', $url);
                        $siteURL        = str_replace('/wp-json', '', $url);
                        $title          = get_the_title(get_the_ID());
                        $ext_id         = get_the_ID();
                        $services       = $url . "/wp/v2/service/";
                        $locations      = $url . "/wp/v2/location/";
                        //$logo         = $url . "/acf/v3/options/options/header_logo";
                        $about          = $url . "/acf/v3/options/options/site_description";


                        $meta           = get_post_meta($post->ID, 'dt_connection_map', false);
                        $ext            = get_post_meta($post->ID, 'dt_connection_map', true);
                        $ext_id         = array_key_first($ext['external']);
                        $meta_s         = reset($meta);
                        $meta_t         = reset($meta_s);
                        $meta_f         = reset($meta_t);
                        $dist_post_id   = key($meta_t);
                        $logo           = get_field('sub_logo', $dist_post_id);
                    ?>
                    <div class="menu-item col-md-3 single-sub d-flex align-items-center">
                      <a href="#">
                        <img class="sub-title" data-url="<?php echo $cleanUrl;?>" src="<?php echo $logo; ?>"/>
                      </a>
                      <div class="folding-content single-sub-info container-fluid">
                          <div class="row">
                              <div class="col-md-6">
                                  <h2><?php echo $title; ?></h2>
                                  <!-- website: <?php echo $cleanUrl; ?> -->
                                  <p><?php echo get_about_rest($about); ?></p>
                                  <a href="<?php echo $siteURL; ?>" class="btn btn-primary">Visit Site</a>
                              </div>
                              <div class="col-md-3">
                                  <h4>Services</h4>
                                  <?php
                                      $args = array(
                                          'post_type' => 'service',
                                          'orderby' => 'title',
                                          'order' => 'ASC',
                                          'posts_per_page' => -1,
                                          'post_parent' => 0,
                                          'meta_query' => array(
                                              array(
                                                  'key' => 'dt_connection_map',
                                                  'value' => $post->ID ,
                                                  'compare' => 'LIKE',
                                              )
                                          )
                                      );
                                      $service_query = new WP_Query($args);
                                  ?>
                                  <?php if ( $service_query->have_posts() ) :?>
                                      <ul>
                                          <?php while ($service_query->have_posts()) : ?>
                                              <?php $service_query->the_post(); ?>

                                              <li>
                                                  <?php $link = str_replace(home_url(), '', get_permalink());  ?>
                                                 <a href="<?php echo $siteURL . $link ?>"><?php echo get_the_title(); ?></a>
                                              </li>
                                          <?php endwhile; wp_reset_postdata();?>
                                      </ul>
                                  <?php endif; ?>

                              </div>
                              <div class="col-md-3">
                                  <h4>Locations</h4>
                                  <?php echo get_locations_rest($locations, $title); ?>
                              </div>
                          </div>
                      </div>
                  </div>
            <?php $counter++; endwhile; ?>
        </div>
            <?php wp_reset_postdata(); ?>
    </div>

    <!-- Featured Projects -->
    <div class="container home-featured-projects">
        <div class="row">
            <h2 class="title">Featured Projects</h2>
        </div>
        <?php if( $featuredProjects ): ?>
        <div class="row">
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

    <!-- Career -->
    <div class="container-fluid home-career" <?php echo $careerBG; ?>>
        <div class="row d-flex align-items-center">
            <h2 class="title"><?php echo $careerTitle; ?></h2>
            <div class="col-md-6 hc-left">
                <?php echo $careerContent; ?>
                <?php
                $careerLink = get_field('career_link', 'options');
                $careerURL = $careerLink['url'];
                $careerText = $careerLink['title'];
                ?>
                <a href="<?php echo $careerURL; ?>" class="btn btn-primary"><?php echo $careerText; ?></a>
            </div>
            <div class="col-md-6 hc-right">
                <?php $count = count($careerSlideshow); ?>
                <?php if( have_rows('career_slideshow') ): ?>
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                	<?php while( have_rows('career_slideshow') ): the_row();
                		// vars
                		$image = get_sub_field('slide_image');
                		$content = get_sub_field('slide_caption');
                		?>
                         <div class="swiper-slide">
                    		<img src="<?php echo $image; ?>" />
                            <?php if ( $content ) : ?>
                                <div class="slide-caption"><?php echo $content; ?></div>
                            <?php endif; ?>
                        </div>
                	<?php endwhile; ?>
                </div>
                    <!-- If we need pagination -->
                    <?php if ( $count > 1) : ?>
                    <div class="nav-wrap">
                        <div class="swiper-pagination"></div>
                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                <?php endif; ?>
                    </div>
                    <script type="text/javascript">
                        var mySwiper = new Swiper ('.swiper-container.career-slider', {
                          // Optional parameters
                          //autoplay: { delay: 5000, disableOnInteraction: false, },
                          watchOverflow: true,
                          direction: 'horizontal',
                          //autoplay: $('.swiper-slide').length > 1 ? true : false,
                          // If we need pagination
                          pagination: {
                            el: '.swiper-pagination',
                          },

                          // Navigation arrows
                          navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                          },

                      });

                      var mySwiper = new Swiper ('.swiper-container.h-slider', {
                        // Optional parameters
                        //autoplay: { delay: 5000, disableOnInteraction: false, },
                        watchOverflow: true,
                        direction: 'horizontal',
                        loop: <?php echo $slideLoop; ?>,
                        <?php echo $autoplay; ?>
                        //autoplay: $('.swiper-slide').length > 1 ? true : false,
                        // If we need pagination
                        pagination: {
                          el: '.swiper-pagination',
                        },

                        // Navigation arrows
                        navigation: {
                          nextEl: '.swiper-button-next',
                          prevEl: '.swiper-button-prev',
                        },

                    });
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

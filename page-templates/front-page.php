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
    $contractorBtn = get_field('contractor_button');
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
    } else {
        $slideLoop = 'false';
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
        <div class="swiper-container slider-container">
            <div class="swiper-wrapper">
            <?php while( have_rows('slider') ): the_row();
                // vars
                $image = get_sub_field('slider_image');
                $content = get_sub_field('slider_content');
                $imagePosition = get_sub_field('slide_image_cover_postion');
                $url = $image['url'];
            ?>

                <div class="swiper-slide" style="background-image:url('<?php echo $url; ?>'); background-position-y:<?php echo $bannerImgPos; ?>">
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
                <a href="<?php echo $careerButton['url']; ?>" class="btn btn-primary"><?php echo $careerButton['title']; ?></a>
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
                    var mySwiper = new Swiper ('.swiper-container', {
                      // Optional parameters
                      direction: 'horizontal',
                        loop: <?php echo $slideLoop; ?>,
                      //autoplay: $('.swiper-slide').length > 1 ? true : false,

                      watchOverflow: true,

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

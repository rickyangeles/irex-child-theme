<?php
/**
 * Template Name: Single Service
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */


get_header(); ?>

<?php
    $serviceSlideshow = get_field('service_gallery');
    $serviceCTAcontent = get_field('service_cta_content', 'options');
    $serviceCTAbtn     = get_field('service_cta_button', 'options');
    $testimonials = get_field('testimonials');
    $relatedProjects = get_field('related_projects');
    $pID                = get_the_ID();
    $sub = get_field('subsidiary_site', 'options');
    $imgID = get_post_thumbnail_id($pID);
    $featuredImg = wp_get_attachment_image_src($imgID);
?>
<!-- Page Header -->
<div class="container-fluid page-header">
    <?php if ($featuredImg[0]) :?>
        <?php the_post_thumbnail(); ?>
    <?php else: ?>
        <img src="<?php echo get_field('service_featured_image', 'options'); ?>">
    <?php endif; ?>
    <div class="row">
        <h1 class="page-title">
            <?php the_title(); ?>
        </h1>
    </div>
</div>
<div class="container breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <?php bcn_display(); ?>
            <?php
                $myvals = get_post_meta($pID);
                foreach($myvals as $key=>$val)
                {
                    echo $key . ' : ' . $val[0] . '<br/>';
                }
            ?>
        </div>
    </div>
</div>
<div class="container main-content">
    <div class="row">
        <?php if ( $serviceSlideshow ): ?>
            <div class="col-md-6 service-content">
        <?php else : ?>
            <div class="col-md-12 service-content">
        <?php endif; ?>
            <?php the_content(); ?>
            </div>
        <?php
            $images = get_field('gallery');
            $size = 'service-slideshow'; // (thumbnail, medium, large, full or custom size)
            $count = count(get_field('service_gallery'));
            if( $serviceSlideshow ): ?>
                <div class="col-md-6 slideshow">
                    <div class="swiper-container service-slide slide-<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">
                    <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <?php foreach( $serviceSlideshow as $image ): ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo esc_url($image['sizes']['slideshow']); ?>" alt="">
                                    <?php echo wp_get_attachment_image( $image, 'slideshow' ); ?>
                                    <?php if ( $image['caption'] ) : ?>
                                    <div class="slide-caption"><?php echo $image['caption']; ?></div>
                                <?php endif; ?>
                                </div>

                            <?php endforeach; ?>
                        </div>
                        <?php if ( $count > 1) : ?>
                        <div class="nav-wrap">
                            <div class="swiper-pagination"></div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <!-- If we need pagination -->
        </div>

    <div class="row">
        <?php
            $subpages = new WP_Query( array(
                'post_type' => 'service',
                'post_parent' => $pID,
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order'     => 'ASC'
            ));
         ?>
        <?php if( $subpages->have_posts() ) : ?>
            <div class="col-md-6 service-sub-pages">
                <h4>Services:</h4>
                <ul class="service-list">
                <?php while( $subpages->have_posts() ) : $subpages->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
        <?php endif; ?>
        <?php if( $subpages->have_posts() ) : ?>
            <div class="col-md-6 service-cta-wrap">
        <?php else : ?>
            <div class="col-md-8 service-cta-wrap offset-md-2">
        <?php endif; ?>
            <div class="row service-cta d-flex align-items-center">
                <div class="col-md-8 service-cta-content">
                    <?php echo $serviceCTAcontent; ?>
                </div>
                <div class="col-md-4 service-cta-btn">
                    <a href="<?php echo $serviceCTAbtn['url']; ?>" class="btn btn-secondary"><?php echo $serviceCTAbtn['title']; ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- testimonial and related projects for subsidiary servicess -->
<?php if ( $sub ) : ?>
    <?php if ( $testimonials ) : ?>
        <?php $testCount = count($testimonials); ?>
        <div class="container-fluid home-testimonial">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="title">Testimonial</h4>
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
    <?php if( $relatedProjects ): ?>
        <div class="container home-featured-projects">
            <div class="row">
                <h2 class="title">Featured Projects</h2>
            </div>
            <div class="row">
                <?php foreach( $relatedProjects as $post): // variable must be called $post (IMPORTANT) ?>
                    <?php setup_postdata($post); ?>
                    <div class="col-md-6 single-featured-project d-flex align-items-center">
                        <div class="sfp-left">
                            <h5><?php the_title(); ?></h5>
                            <p><?php echo excerpt(20, $post->ID); ?></p>
                        </div>
                        <div class="sfp-right d-flex align-items-center">
                            <?php if ( has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('featured-project'); ?>
                            <?php else : ?>
                                <img src="https://via.placeholder.com/300">
                            <?php endif; ?>
                            <span><a class="read-more btn btn-sm" href="<?php the_permalink(); ?>">Read More</a></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if ( $projectButton ) : ?>
                    <div class="fp-btn text-center">
                        <a href="<?php echo $projectButton['url']; ?>" class="view-all btn btn-primary"><?php echo $projectButton['title']; ?></a>
                    </div>
                <?php endif; ?>
            </div>
        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>


<?php if ( !$sub ) : ?>
    <!-- Contractor -->
    <div class="container page-contractor">
        <h3 class="service-title"><?php the_title(); ?> Providers</h3>
        <?php
            $meta = get_post_meta($post->ID, 'dt_connection_map', false);
            $items = array();
            foreach($meta as $k => $v) {
                foreach ($v as $kk => $vv ) {
                    if ($kk == 'external') {
                        foreach($vv as $kkk => $vvv) {
                            $items[] = $kkk;
                        }
                    }
                }
            }
            $query = new WP_Query(array(
                'post_type' => 'dt_ext_connection',
                'post__in' => $items,
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
                    $remove = array("/wp-json", "http://");
                    $url = get_post_meta(get_the_ID(), 'dt_external_connection_url', true);
                    $cleanUrl = str_replace($remove,'', $url);
                    $siteURL = str_replace('/wp-json', '', $url);
                    $title = get_the_title(get_the_ID());
                    $services = $url . "/wp/v2/service/";
                    $locations = $url . "/wp/v2/location/";
                    $logo = $url . "/acf/v3/options/options/header_logo";
                ?>
                <div class="menu-item col-md-3 single-sub">
                  <a href="#">
                    <img class="sub-title" data-url="<?php echo $cleanUrl;?>" src="<?php echo get_logo_rest($logo); ?>"/>
                  </a>
                  <div class="folding-content single-sub-info container-fluid">
                      <div class="row">
                          <div class="col-md-6">
                              <h2><?php echo $title; ?></h2>
                              website: www.<?php echo $cleanUrl; ?>
                              <p class="description">description goes here</p>
                              <a href="<?php echo $siteURL; ?>" class="btn btn-primary">Visit Site</a>
                          </div>
                          <div class="col-md-3">
                              <h4>Services</h4>
                              <?php echo get_services_rest($services); ?>
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
<?php endif; ?>

</div>
<?php get_footer(); ?>

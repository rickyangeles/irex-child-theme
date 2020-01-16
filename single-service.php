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
    $musser = get_field('musser_park', 'options');
    $imgID = get_post_thumbnail_id($pID);
    $featuredImg = wp_get_attachment_image_src($imgID);
    $post_slug = $post->post_name;

    if ( $sub ) {
        $ogIndustries = get_post_meta(get_the_ID(), 'service_industries', true);
        $selectField = get_field('industry_select');
        $industryID = array();
        foreach ($ogIndustries as $industry => $value) {
            // code...
            $newIndustryID = get_page_by_title($value, OBJECT, 'industry');
            $newID = $newIndustryID->ID;
            array_push($industryID, $newID);
        }
        update_post_meta($pID, 'industry_select', $industryID);
    }

    $old_id = get_post_meta(get_the_ID(), 'service_gallery', true );
    $new_id = array();
    //print_r($old_id);

    foreach( $old_id as $mediaID ) {
        echo $mediaID;
        $args = array(
            'posts_per_page' => '1',
            'post_status' => 'any',
            'post_type'=> 'attachment',
            'meta_query'        => array(
                array(
                    'key'       => 'dt_original_media_id',
                    'value'     => $mediaID,
                    'type'      => 'numeric',
                )
            ),
        );
        $new_image = new WP_Query($args);
        //
        if ( $new_image->have_posts() ) {
            while ( $new_image->have_posts() ) {
                $new_image->the_post();
                $new_id[] = get_the_ID();
            }
            wp_reset_postdata();
        }
    }

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
        </div>
    </div>
</div>
<div class="container main-content">
    <div class="row">
        <?php if ( have_rows('service_gallery') || have_rows('new_gallery') ): ?>
            <div class="col-md-6 service-content">
        <?php else : ?>
            <div class="col-md-12 service-content">
        <?php endif; ?>
            <?php the_content(); ?>
            </div>
        <?php
            $images = get_field('service_gallery');
            $size = 'service-slideshow'; // (thumbnail, medium, large, full or custom size)
            $count = count(get_field('service_gallery'));

            ?>
            <?php if( have_rows('service_gallery') || have_rows('new_gallery') ): ?>
                <div class="col-md-6 slideshow">
                    <div class="swiper-container service-slide slide-<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">
                    <!-- Additional required wrapper -->
                        <?php if ( $sub && !$musser ) : ?>
                            <?php if ( empty($new_id) ) : ?>
                                <?php echo get_service_gallery($pID); ?>
                            <?php else:  ?>
                                <div class="swiper-wrapper">
                                    <?php foreach( $new_id as $id ): ?>
                                        <div class="swiper-slide">
                                            <?php $image = wp_get_attachment_url($id); ?>
                                            <img src="<?php echo $image; ?>" alt="">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if ( count($new_id) > 1) : ?>
                                    <div class="nav-wrap">
                                        <div class="swiper-pagination"></div>
                                        <!-- If we need navigation buttons -->
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="swiper-wrapper">
                                <?php
                                    $images = get_field('service_gallery');
                                    $size = 'full'; // (thumbnail, medium, large, full or custom size)
                                    if( $images ): ?>

                                            <?php foreach( $images as $image ): ?>
                                                <div class="swiper-slide">
                                                    <img src="<?php echo $image['url']; ?>" alt="">
                                                </div>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                            </div>
                            <?php if ( $count > 1) : ?>
                                <div class="nav-wrap">
                                    <div class="swiper-pagination"></div>
                                    <!-- If we need navigation buttons -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            <?php endif; ?>
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
    <?php
        //Get array of terms
    $terms = get_the_terms( $post->ID , 'industry_tax', 'string');
    //Pluck out the IDs to get an array of IDS
    $term_ids = wp_list_pluck($terms,'term_id');

    //Query posts with tax_query. Choose in 'IN' if want to query posts with any of the terms
    //Chose 'AND' if you want to query for posts with all terms
      $project_query = new WP_Query( array(
          'post_type' => 'project_gallery',
          'tax_query' => array(
                        array(
                            'taxonomy' => 'industry_tax',
                            'field' => 'id',
                            'terms' => $term_ids,
                            'operator'=> 'IN' //Or 'AND' or 'NOT IN'
                         )),
          'posts_per_page' => 3,
          'ignore_sticky_posts' => 1,
          'orderby' => 'rand',
          'post_not_in'=>array($post->ID)
       ) );
       $p_count = $project_query->found_posts;

    ?>
    <?php if ( $project_query->have_posts() ) : ?>
        <div class="container home-featured-projects">
            <div class="row">
                <?php if ( $p_count > 1 ) : ?>
                    <h2 class="title">Featured Projects</h2>
                <?php else : ?>
                    <h2 class="title">Featured Project</h2>
                <?php endif; ?>
            </div>
            <div class="row d-flex justify-content-center">
                <?php while ( $project_query->have_posts() ) : $project_query->the_post(); ?>
                    <?php setup_postdata($post); ?>
    			<?php if (has_term($term_ids, 'industry_tax')) :?>
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
    			<?php endif; ?>
                <?php endwhile; ?>
                <?php if ( $p_count > 1 ) : ?>
                    <div class="fp-btn text-center">
                        <a href="/project-gallery" class="view-all btn btn-primary">View All Projects</a>
                    </div>
                <?php else : ?>
                <?php endif; ?>
            </div>
        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php $total_connections = total_connections($pID); ?>
<?php if ( !$sub && $total_connections > 0 ) : ?>
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

            $post_count = $query->found_posts;
        ?>
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
                    $meta           = get_post_meta($post->ID, 'dt_connection_map', false);
                    $meta_s = reset($meta);
                    $meta_t = reset($meta_s);
                    $meta_f = reset($meta_t);
                    $dist_post_id = key($meta_t);
                    $logo = get_field('sub_logo', $dist_post_id);
                    $about = $url . "/acf/v3/options/options/site_description";
                    $total_connections = total_connections($pID);
                    $ext            = get_post_meta($post->ID, 'dt_connection_map', true);
                    $ext_id         = array_key_first($ext['external']);
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
                               <p>
                                   <?php echo get_about_rest($about); ?>
                               </p>
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
                                      <?php endwhile;?>
                                  </ul>
                              <?php endif; ?>
                              <?php wp_reset_postdata(); wp_reset_query(); ?>
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

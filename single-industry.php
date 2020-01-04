<?php
/**
 * Template Name: Single Industry
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */


get_header(); ?>

<?php
    $slideshow = get_field('industry_gallery');
    $industryCTAcontent = get_field('service_cta_content', 'options');
    $industryCTAbtn     = get_field('service_cta_button', 'options');
    $pID                = get_the_ID();
	$post_slug = $post->post_name;
    $sub = get_field('subsidiary_site', 'options');
?>
<!-- Page Header -->
<div class="container-fluid page-header">
    <?php if ( has_post_thumbnail() ): ?>
        <?php the_post_thumbnail('page-banner'); ?>
    <?php else : ?>
        <img src="<?php echo get_field('industry_featured_image', 'options'); ?>">
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
        <?php if ( $slideshow ): ?>
            <div class="col-md-6 service-content">
        <?php else : ?>
            <div class="col-md-12 service-content">
        <?php endif; ?>
            <?php the_content(); ?>
            </div>
        <?php
            $images = get_field('gallery');
            $size = 'service-slideshow'; // (thumbnail, medium, large, full or custom size)

            if( $slideshow ): ?>
                <div class="col-md-6 slideshow">
                    <div class="swiper-container service-slide slide-<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">
                    <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <?php foreach( $slideshow as $image ): ?>
                                <div class="swiper-slide">
                                    <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                                    <?php if ( $image['caption'] ) : ?>
                                        <div class="slide-caption"><?php echo $image['caption']; ?></div>
                                    <?php endif; ?>
                                </div>

                            <?php endforeach; ?>
                        </div>
                        <div class="nav-wrap">
                            <div class="swiper-pagination"></div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!-- If we need pagination -->
        </div>

    <div class="row">
		<?php wp_reset_postdata(); ?>
        <?php
			$title = get_the_title();
			$service_query = new WP_Query( array(
				'post_type' => 'service',          // name of post type.
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'public'   => true,
				'post_parent' => 0,
			));
        ?>
        <?php if( $service_query->have_posts() ) : ?>
            <div class="col-md-6 service-sub-pages">
                <h4>Services:</h4>
                <ul class="service-list">
					<?php while ( $service_query->have_posts() ) : $service_query->the_post(); ?>
						<?php if (has_term($post_slug, 'industry_tax')) :?>
							<li><a href="<?php the_permalink();?>"><?php the_title(); ?></a></li>
						<?php endif; ?>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</ul>
            </div>
        <?php endif; ?>
        <?php if( $service_query ) : ?>
            <div class="col-md-6 service-cta-wrap">
        <?php else : ?>
            <div class="col-md-8 service-cta-wrap offset-md-2">
        <?php endif; ?>
            <div class="row service-cta d-flex align-items-center">
                <div class="col-md-8 service-cta-content">
                    <?php echo $industryCTAcontent; ?>
                </div>
                <div class="col-md-4 service-cta-btn">
                    <a href="<?php echo $industryCTAbtn['url']; ?>" class="btn btn-secondary"><?php echo $industryCTAbtn['title']; ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Projects -->
<?php
    $project_query = new WP_Query( array(
        'post_type' => 'project_gallery',          // name of post type.
        'posts_per_page' => 4,
        'orderby' => 'title',
        'order' => 'ASC',
        'public'   => true,
        'post_parent' => 0,
		'tax_query' => array(
			array(
				'taxonomy' => 'industry_tax',
				'field'    => 'slug',
				'terms' => $post_slug,
			),
		)
    ) );
?>

<?php if ( $project_query->have_posts() ) : ?>
    <div class="container home-featured-projects">
        <div class="row">
            <h2 class="title">Featured Projects</h2>
        </div>
        <div class="row d-flex justify-content-center">
            <?php while ( $project_query->have_posts() ) : $project_query->the_post(); ?>
                <?php setup_postdata($post); ?>
			<?php if (has_term($post_slug, 'industry_tax')) :?>
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
            <div class="fp-btn text-center">
                <a href="/project-gallery" class="view-all btn btn-primary">View All Projects</a>
            </div>
        </div>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
        </div>
    </div>
<?php endif; ?>

<!-- Contractor -->
<?php if (!$sub) : ?>
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
                        $about = $url . "/acf/v3/options/options/about_text";
                    ?>
                    <div class="menu-item col-md-3 single-sub d-flex align-items-center">
                      <a href="#">
                        <img class="sub-title" data-url="<?php echo $cleanUrl;?>" src="<?php echo get_logo_rest($logo); ?>"/>
                      </a>
                      <div class="folding-content single-sub-info container-fluid">
                          <div class="row">
                              <div class="col-md-6">
                                  <h2><?php echo $title; ?></h2>
                                  website: www.<?php echo $cleanUrl; ?>
                                   <?php echo get_about_rest($about); ?>
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


<?php
/**
 * Template Name: Subsidiary
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
                        <?php if ( $header != "true") : ?>
                            <header class="entry-header">
                        		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        	</header><!-- .entry-header -->
                        <?php endif; ?>
						<?php get_template_part( 'loop-templates/content', 'page' ); ?>
					<?php endwhile; // end of the loop. ?>
				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .row end -->
	</div><!-- #content -->
</div><!-- #full-width-page-wrapper -->
<div class="container home-contractor">
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
                    $remove = array("/wp-json", "http://");
                    $url = get_post_meta(get_the_ID(), 'dt_external_connection_url', true);
                    $cleanUrl = str_replace($remove,'', $url);
                    $siteURL = str_replace('/wp-json', '', $url);
                    $title = get_the_title(get_the_ID());
                    $services = $url . "/wp/v2/service/";
                    $locations = $url . "/wp/v2/location/";
                    $logo = $url . "/acf/v3/options/options/header_logo";
					$about = $url . "/acf/v3/options/options/site_description";
                    $meta           = get_post_meta($post->ID, 'dt_connection_map', false);
                    $meta_s = reset($meta);
                    $meta_t = reset($meta_s);
                    $meta_f = reset($meta_t);
                    $dist_post_id = key($meta_t);
                    $logo = get_field('sub_logo', $dist_post_id);
                ?>
                <div class="menu-item col-md-3 single-sub">
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
</div>
<?php get_footer(); ?>

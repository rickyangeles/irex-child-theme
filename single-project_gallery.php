<?php
/**
 * Template Name: Single Project Gallery
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */


get_header(); ?>

<?php
    $projectSlideshow   = get_field('project_gallery');
    $projectCTAcontent  = get_field('service_cta_content', 'options');
    $projectCTAbtn      = get_field('service_cta_button', 'options');
    $relatedProjects    = get_field('related_projects');
    $projectDetails     = get_field('project_details');
    $pID                = get_the_ID();
    $sub = get_field('subsidiary_site', 'options');
    $musser = get_field('musser_park', 'options');
    $industries = get_terms()
?>
<!-- Page Header -->
<div class="no-banner"></div>
<div class="container breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <?php bcn_display(); ?>
        </div>
    </div>
</div>
<div class="container main-content">
    <h1 class="page-title">
        <?php the_title(); ?>
    </h1>
    <div class="row">
        <?php if ( have_rows('project_gallery') ) : ?>
        <div class="col-md-6 project-content">
        <?php else :  ?>
            <div class="col-md-12 project-content">
        <?php endif; ?>
            <?php echo $projectDetails; ?>
        </div>
        <?php if ( $sub && !$musser ) : ?>
            <div class="col-md-6 slideshow">
                <div class="swiper-container service-slide slide-<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">
                    <?php get_project_gallery($pID); ?>
                </div>
                <div class="row project-cta d-flex align-items-center">
                    <div class="col-md-8 project-cta-content">
                        <?php echo $projectCTAcontent; ?>
                    </div>
                    <div class="col-md-4 project-cta-btn">
                        <a href="<?php echo $projectCTAbtn['url']; ?>" class="btn btn-secondary"><?php echo $projectCTAbtn['title']; ?></a>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <?php if ( $projectSlideshow ) : ?>
                <?php $count = count($projectSlideshow); ?>
                <div class="col-md-6 slideshow">
                    <div class="swiper-container service-slide slide-<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">
                    <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <?php foreach( $projectSlideshow as $image ): ?>
                                <?php $caption = $image['caption']; ?>
                                <div class="swiper-slide">
                                    <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                                    <?php if ( $image['caption'] ): ?>
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
    				<div class="row project-cta d-flex align-items-center">
                        <div class="col-md-8 project-cta-content">
                            <?php echo $projectCTAcontent; ?>
                        </div>
                        <div class="col-md-4 project-cta-btn">
                            <a href="<?php echo $projectCTAbtn['url']; ?>" class="btn btn-secondary"><?php echo $projectCTAbtn['title']; ?></a>
                        </div>
                    </div>
                </div>
            <?php else:  ?>
                <div class="col-md-8 project-cta-wrap offset-md-2">
                    <div class="row project-cta d-flex align-items-center">
                        <div class="col-md-8 project-cta-content">
                            <?php echo $projectCTAcontent; ?>
                        </div>
                        <div class="col-md-4 project-cta-btn">
                            <a href="<?php echo $projectCTAbtn['url']; ?>" class="btn btn-secondary"><?php echo $projectCTAbtn['title']; ?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</div>
<div class="container secondary-content">
    <div class="row">
        <?php the_content(); ?>
    </div>
</div>
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
          'post__not_in'=>array($post->ID)
       ) );
       $p_count = $project_query->found_posts;

?>

<?php if ( $project_query->have_posts() ) : ?>
    <div class="container home-featured-projects">
        <div class="row">
            <?php if ( $p_count > 1 ) : ?>
                <h2 class="title">Related Projects</h2>
            <?php else : ?>
                <h2 class="title">Related Project</h2>
            <?php endif; ?>
        </div>
        <div class="row">
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
        </div>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
        </div>
    </div>
<?php endif; ?>


<?php get_footer(); ?>

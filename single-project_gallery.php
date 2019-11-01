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
    $projectCTAcontent  = get_field('project_cta_content', 'options');
    $projectCTAbtn      = get_field('project_cta_button', 'options');
    $relatedProjects    = get_field('related_projects');
    $projectDetails     = get_field('project_details');
    $pID                = get_the_ID();
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
        <div class="col-md-6 project-content">
            <?php echo $projectDetails; ?>
        </div>
        <div class="col-md-6 slideshow">
            <div class="swiper-container service-slide slide-<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">
            <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <?php foreach( $projectSlideshow as $image ): ?>
                        <?php $caption = $image['caption']; ?>
                        <div class="swiper-slide">
                            <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                            <?php if ( $caption ): ?>
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

            <div class="row service-cta d-flex align-items-center">
                <div class="col-md-8 service-cta-content">
                    <?php echo $projectCTAcontent; ?>
                </div>
                <div class="col-md-4 service-cta-btn">
                    <a href="<?php echo $projectCTAbtn['url']; ?>" class="btn btn-secondary"><?php echo $projectCTAbtn['title']; ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php the_content(); ?>
    </div>
</div>
<div class="container">
    <?php if( $relatedProjects ): ?>
    <div class="row related-projects">
        <h2 class="title">Related Projects</h2>
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
    </div>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>

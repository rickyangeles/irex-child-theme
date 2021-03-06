<?php
/**
 * Template Name: Project Gallery Archive
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */


get_header(); ?>

<div class="container-fluid solid-header short-header">
    <div class="row">
            <h1 class="page-title">Projects</h1>
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
        <div class="col-md-12">
            <?php the_field('industry_content', 'options') ?>
        </div>
    </div>
    <div class="row project-list">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="col-md-6 single-project d-flex align-items-center">
                <div class="sfp-left">
                    <a href="<?php the_permalink(); ?>">
                    <h5><?php the_title(); ?></h5>
                    <p><?php echo project_excerpt(15, $post->ID); ?></p>
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
        <?php endwhile; ?>
    </div>
    <?php understrap_pagination(); ?>
</div>

<?php get_footer(); ?>

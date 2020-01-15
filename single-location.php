<?php
/**
 * Template Name: Single Location
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
    $pID                = get_the_ID();
?>
<!-- Page Header -->
<div class="container-fluid page-header">
    <?php if (has_post_thumbnail()) :?>
        <?php the_post_thumbnail('page-banner'); ?>
    <?php else: ?>
        <img src="<?php echo the_field('service_featured_image', 'options')?>">
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
=
    </div>

</div>
<?php get_footer(); ?>

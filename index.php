<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>
<div class="no-banner"></div>
<div class="container breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <?php bcn_display(); ?>
        </div>
    </div>
</div>
<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main blog-archive" id="main">
				<header class="entry-header">
					<h1 class="entry-title">News</h1>
				</header><!-- .entry-header -->
				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
							<?php $pID = get_the_ID(); ?>
							<div class="row d-flex align-items-center">
								<div class="col-md-4">
									<?php if ( has_post_thumbnail($post->ID) ) :?>
										<?php echo get_the_post_thumbnail( $post->ID, 'post-archive-thumbnail' ); ?>
									<?php else : ?>
										<img src="https://via.placeholder.com/370x240" alt="">
									<?php endif; ?>
									<div class="thumb-overlay d-flex justify-content-center align-items-center">
										<a href="<?php echo get_the_permalink(); ?>" class="btn btn-light btn-sm">Read More</a>
									</div>
								</div>
								<div class="col-md-8">
									<header class="entry-header">
										<a href="<?php echo get_the_permalink(); ?>"><?php the_title( '<h5 class="entry-title">', '</h5>' ); ?></a>
										<div class="entry-meta">
											Published: <?php the_time('F, j, Y'); ?> | By: <?php the_author(); ?> | Categories: <?php the_category(', '); ?>
										</div><!-- .entry-meta -->
									</header><!-- .entry-header -->
									<div class="entry-content">
										<?php echo excerpt(25, $pID); ?>
									</div><!-- .entry-content -->
								</div>
							</div>
						</article><!-- #post-## -->

					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>

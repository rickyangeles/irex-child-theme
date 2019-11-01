<?php
/**
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

<div class="no-banner"></div>
<div class="container-fluid page-header d-flex align-items-center">
    <div class="row">
        <h1 class="page-title">
            Partners
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

<div class="wrapper" id="full-width-page-wrapper">
	<div class="<?php echo esc_attr( $container ); ?> partnerships" id="content">
        <h2>Partners & Memberships</h2>
		<div class="row content-area d-flex align-items-center sub-partnerships" id="primary">
            <?php while ( have_posts() ) : the_post();
                $id = get_the_ID();
        		// vars
        		$logo = get_the_post_thumbnail();
                $name = get_the_title();
        		$desc = get_the_content();
        		$link = get_field('parter_link');
                $global = get_field('global_partnership');
        	?>
            <?php if (!$global) : ?>
                <div class="col-md-4 single-partner">
                    <a href="<?php echo $link; ?>">
                        <?php echo $logo; ?>
                    </a>
                    <h5><?php echo $name; ?></h5>
                    <p><?php echo $desc; ?></p>
                </div>
            <?php endif; ?>
        	<?php endwhile; ?>
		</div><!-- #primary -->
        <div class="row global-partnerships">
            <div class="col-md-6">
                <h3><?php bloginfo('name'); ?> is a subsidiary of</h3>
                <div class="col-md-12 single-partner">
                    <img src="http://irex.local/wp-content/uploads/2019/08/irex_logo.png" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <h3>IREX is a member of:</h3>
                <?php while ( have_posts() ) : the_post();
                    $id = get_the_ID();
            		// vars
            		$logo = get_the_post_thumbnail();
                    $name = get_the_title();
            		$desc = get_the_content();
            		$link = get_field('parter_link', $id);
                    $global = get_field('global_partnership');
            	?>
                <?php if ($global) : ?>
                    <div class="col-md-12 single-partner">
                        <a href="<?php echo $link; ?>">
                            <?php echo $logo; ?>
                        </a>
                    </div>
                <?php endif; ?>
            	<?php endwhile; ?>
            </div>
        </div>
	</div><!-- .row end -->
</div><!-- #content -->


<?php get_footer(); ?>

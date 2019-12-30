<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

$footerCopy = get_field('about_text', 'options');
$footerLogo = get_field('footer_logo', 'options');
$corpAddress = get_field('corporate_address', 'options');
$corpPhone = get_field('c_phone_number', 'options');
$corpFax	= get_field('c_fax_number', 'options');
$customerPhone = get_field('customer_phone', 'options');
$supplyPhone = get_field('suppliers_phone', 'options');
$subFooter = get_field('subsidiary_site', 'options');

$siteLinks = get_field('footer_page_links', 'options');

$args = array(
	'post_type' => 'post',
	'posts_per_page' => 5,
);
$news = new WP_QUERY($args);

?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper footer-menu">
	<div class="row">
		<div class="col-md-12">
			<?php
				if ( has_nav_menu('footer-menu') ) {
					wp_nav_menu( array(
						'menu' => 'Footer Menu',
						'container_class' => 'footer-menu-wrap',
					));
				}
			?>
		</div>
	</div>
</div>
<div class="wrapper footer" id="wrapper-footer">
	<?php if ( $subFooter ) : ?>
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="row d-flex align-items-center">
				<div class="col-md-3">
					<img src="<?php echo $footerLogo['url']; ?>" alt="" class="footer-logo">
					<ul class="footer-social-media">
					<?php if( have_rows('social_icons','options') ): ?>
						<?php while( have_rows('social_icons','options') ): the_row();
							$socialIcon = get_sub_field('font_awesome_class');
							$socialURL = get_sub_field('social_media_url');
						?>
							<li><a href="<?php echo $socialURL;?>"><i class="<?php echo $socialIcon; ?>"></i></a></li>
						<?php endwhile; ?>
					<?php endif; ?>
					</ul>
				</div>
				<div class="col-md-9">
						<?php echo $footerCopy; ?>
				</div>
			</div>
			<div class="row">
				<?php if (!$news && !$siteLinks) :?>
					<div class="col-md-12 footer-locations">
				<?php else:  ?>
					<div class="col-md-6 footer-locations">
				<?php endif; ?>
					<h3>Locations</h3>
					<div class="row">
						<?php
	                        $args = array(
	                            'post_type' => 'location',
	                            'posts_per_page' => -1,
	                        );
	                        $locations = new WP_QUERY($args);
	                    ?>
	                    <?php if ( $locations->have_posts() ) : ?>
	                        <?php while ($locations->have_posts() ) : $locations->the_post(); ?>
	                            <?php
	                                $branchName     = get_field('branch_name');
	                                $address1       = get_field('address_1');
	                                $address2       = get_field('address_2');
	                                $city           = get_field('city');
	                                $state          = get_field('state');
	                                $zip            = get_field('zip_code');
	                                $tel            = get_field('telephone');
	                                $tollFree       = get_field('toll_free_number');
	                                $fax            = get_field('fax');
	                            ?>
								<?php if (!$news && !$siteLinks) :?>
									<div class="col-md-4 footer-locations">
								<?php else:  ?>
									<div class="col-md-6 footer-locations">
								<?php endif; ?>
	                                <ul class="single-location">
	                                    <?php if ( $branchName ) : ?>
	                                        <li><?php echo $branchName; ?></li>
	                                    <?php endif; ?>
	                                    <?php if ( $address1 ) : ?>
	                                        <li><?php echo $address1; ?></li>
	                                    <?php endif; ?>
	                                    <?php if ( $address2 ) : ?>
	                                        <li><?php echo $address2; ?></li>
	                                    <?php endif; ?>
	                                    <?php if ( $city && $state && $zip ) : ?>
	                                        <li><?php echo $city . ', ' . $state . ' ' . $zip; ?></li>
	                                    <?php endif; ?>
	                                    <?php if ( $tel ) : ?>
	                                        <li>P: <?php echo $tel; ?></li>
	                                    <?php endif; ?>
	                                    <?php if ($tollFree) :?>
	                                        <li>P: <?php echo $tollFree; ?></li>
	                                    <?php endif; ?>
	                                    <?php if ( $fax ) : ?>
	                                        <li>F: <?php echo $fax; ?></li>
	                                    <?php endif; ?>
	                                </ul>
	                            </div>
	                        <?php endwhile; ?>
							<?php wp_reset_postdata();?>
	                    <?php endif; ?>
					</div>
				</div>
				<div class="col-md-6">

					<?php if ( $news->have_posts() ) : ?>
						<h3>News</h3>
						<ul class="latest-news-footer">
						<?php while ($news->have_posts() ) : $news->the_post(); ?>
							<li><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
						<?php endwhile; ?>
						</ul>
					<?php endif; ?>

					<h3>Site Links</h3>
					    <ul class="site-links-footer">
							<?php
								if ( has_nav_menu('site-link-menu') ) {
									wp_nav_menu( array(
										'menu' => 'Site Link Menu',
										'container_class' => 'site-link-menu-wrap',
									));
								}
							?>
					    </ul>

				</div>
			</div>

		</div><!-- container end -->
	<?php else : ?>
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="row">
				<div class="col-md-3">
					<img src="<?php echo $footerLogo['url']; ?>" alt="" class="footer-logo">
					<ul class="footer-social-media">
					<?php if( have_rows('social_icons','options') ): ?>
						<?php while( have_rows('social_icons','options') ): the_row();
							$socialIcon = get_sub_field('font_awesome_class');
							$socialURL = get_sub_field('social_media_url');
						?>
							<li><a href="<?php echo $socialURL;?>"><i class="<?php echo $socialIcon; ?>"></i></a></li>
						<?php endwhile; ?>
					<?php endif; ?>
					</ul>
				</div>
				<div class="col-md-9">
						<?php echo $footerCopy; ?>
					<div class="row footer-contact-info">
						<div class="col-md-4">
							<strong>Corporate Office</strong>
							<ul class="corp-contact">
								<li><?php echo $corpAddress; ?></li>
								<li>P: <?php echo $corpPhone; ?></li>
								<li>F: <?php echo $corpFax; ?></li>
							</ul>
						</div>
						<div class="col-md-4">
							<strong>Customers:</strong>
							<ul class="customer-contact">
								<li>Toll Free 24/7 Service & Support</li>
								<li>P: <?php echo $customerPhone; ?></li>
							</ul>
						</div>
						<div class="col-md-4">
							<strong>Suppliers:</strong>
							<ul class="supply-contact">
								<li>P: <?php echo $supplyPhone; ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div><!-- container end -->
	<?php endif; ?>

</div><!-- wrapper end -->
<div class="subfooter container ">
	<div class="row">

		<div class="col-md-12">

			<footer class="site-footer" id="colophon">

				<div class="site-info">

					&copy; <?php echo date("Y"); echo " "; echo bloginfo('name'); ?>. All rights reserved.

				</div><!-- .site-info -->

			</footer><!-- #colophon -->

		</div><!--col end -->

	</div><!-- row end -->
</div>
</div><!-- #page we need this extra closing tag here -->
<?php wp_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</body>

</html>

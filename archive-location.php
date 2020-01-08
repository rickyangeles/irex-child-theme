<?php
/**
 * Template Name: Locations Page
 *
 * Template for displaying a page with all the locations and a map
 *
 * @package understrap
 */


get_header(); ?>

<div class="no-banner"></div>
<div class="container-fluid page-header d-flex align-items-center">
    <div class="row">
        <h1 class="page-title">
            Locations
        </h1>
    </div>
</div>
<?php
    $map = array('post_type' => 'location', 'posts_per_page' => -1);
    $map['search_filter_id'] = 5438; $mapQuery = new WP_Query($map);
?>
<div class="container-fluid map-wrapper">
    <?php if ( $mapQuery->have_posts() ) : ?>
        <div class="acf-map location-container" style="overflow: hidden; position: relative;">
            <?php while ($mapQuery->have_posts() ) : $mapQuery->the_post(); ?>
                <?php
                    $lat            = get_field('latitude');
                    $long           = get_field('longitude');
                    $branchName     = get_field('branch_name');
                    $address1       = get_field('address_1');
                    $address2       = get_field('address_2');
                    $city           = get_field('city');
                    $state          = get_field('state');
                    $zip            = get_field('zip_code');
                    $tel            = get_field('telephone');
                    $tollFree       = get_field('toll_free_number');
                    $fax            = get_field('fax');
                    $meta           = get_post_meta($post->ID, 'dt_connection_map', false);
                    $meta_s = reset($meta);
                    $meta_t = reset($meta_s);
                    $meta_f = reset($meta_t);
                    $dist_post_id = key($meta_t);
                    $logo = get_field('sub_logo', $dist_post_id);

                    // foreach ($meta as $k => $v) {
                    //     foreach ($v as $kk => $vv) {
                    //         if ($kk == 'external') {
                    //             reset($vv);
                    //             $t = key($vv);
                    //         }
                    //     }
                    // }
                    $url = get_post_meta($t, 'dt_external_connection_url', true);
                    //$logo = $url . "/acf/v3/options/options/header_logo";
                ?>

                <div class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $long; ?>">
                    <div class="inside-marker">
                        <ul class="single-location">
                            <li class="d-flex align-items-end">
                                <?php if ( $logo ) : ?>
                                    <img class="location-logo" src="<?php echo $logo; ?>"/>
                                <?php else : ?>
                                    <img src="https://via.placeholder.com/195x53" alt="">
                                <?php endif ?>
                            </li>
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
                            <?php if ( $url ) : ?>
                                <li><a href="<?php echo $url; ?>">visit website ></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<div class="container breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <?php bcn_display(); ?>
        </div>
    </div>
</div>
<div class="container map-content">
    <div class="row">
        <div class="col-md-3 location-filter">
            <?php echo do_shortcode('[searchandfilter id="5438"]'); ?>
        </div>
        <div class="col-md-9">
            <?php if ( $mapQuery->have_posts() ) : ?>
                <ul class="row location-list">
                <?php while ($mapQuery->have_posts() ) : $mapQuery->the_post(); ?>
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
                        $lat            = get_field('latitude');
                        $long           = get_field('longitude');
                        $show           = get_field('hide_in_location_page');
                        $meta           = get_post_meta($post->ID, 'dt_connection_map', false);

                        $meta_s = reset($meta);
                        $meta_t = reset($meta_s);
                        $meta_f = reset($meta_t);
                        $dist_post_id = key($meta_t);
                        $logo = get_field('sub_logo', $dist_post_id);

                        $url = get_post_meta($t, 'dt_external_connection_url', true);
                        //$services = $url . "/wp/v2/service?per_page=100";
                        //$logo = $url . "/acf/v3/options/options/header_logo";


                    ?>
                    <li class="col-md-3">

                    <ul class="single-location">
                        <li class="d-flex align-items-end">
                            <?php if ( $logo ) : ?>
                                <img class="location-logo" src="<?php echo $logo; ?>"/>
                            <?php else : ?>
                                <img src="https://via.placeholder.com/195x53" alt="">
                            <?php endif ?>
                        </li>
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
                        <?php if ( $url ) : ?>
                            <li><a href="<?php echo $url; ?>">visit website ></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endwhile; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>

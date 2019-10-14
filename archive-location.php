<?php
/**
 * Template Name: Locations Page
 *
 * Template for displaying a page with all the locations and a map
 *
 * @package understrap
 */


get_header(); ?>


<div class="container-fluid page-header">
    <div class="row">
        <h1 class="page-title">
            Locations
        </h1>
    </div>
</div>
<?php
    $map = array(
        'post_type' => 'location',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
              'key' => 'hide_in_location_page',
              'value' => '0',
              'compare' => '==' // not really needed, this is the default
            )
          )
    );

    $map['search_filter_id'] = 5438;

    $mapQuery = new WP_Query($map);
?>

<div class="container-fluid map-wrap">
    <!-- <img src="http://irex.local/wp-content/uploads/2019/10/Pasted-Image-2.png" alt=""> -->

</div>

<div class="container breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <?php bcn_display(); ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">

    </div>
</div>
<div class="container map-content">
    <div class="row">
        <div class="col-md-3">
            <select class="all-services" name="all-services">
                <label for="all-services">Services</label>
                <?php echo get_all_services_select(); ?>
            </select>
        </div>
        <div class="col-md-9 location-container">
            <?php if ( $mapQuery->have_posts() ) : ?>
                <ul class="row location-container">
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

                        foreach ($meta as $k => $v) {
                            foreach ($v as $kk => $vv) {
                                if ($kk == 'external') {
                                    reset($vv);
                                    $t = key($vv);
                                }
                            }
                        }

                        $url = get_post_meta($t, 'dt_external_connection_url', true);
                        $services = $url . "/wp/v2/service?per_page=100";
                        $logo = $url . "/acf/v3/options/options/header_logo";
                        $subName = get_the_title($t);

                    ?>
                    <li class="col-md-3" data-sub="<?php echo $subName; ?>" data-state="<?php echo $state; ?>" <?php get_service_list($services); ?>>

                    <ul class="single-location">
                        <li>
                            <?php if ( $logo ) : ?>
                                <img class="location-logo" src="<?php echo get_logo_rest($logo); ?>"/>
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
<script type="text/javascript">
$(document).on("sf:ajaxstart", ".searchandfilter", function(){
alert("ajax start");
});

</script>

<?php
/**
 * Block Name: Multi-Column
 *
 * This is the template that displays the Post Grid block.
 */

     $heading  = get_field('header');
     $columns = get_field('columns');
     $primaryBtn = get_field('primary_button');
     $secondaryBtn = get_field('secondary_button');
?>

<div class="container-fluid multi">
    <h2 class="post-grid-title"><?php echo $heading; ?></h2>
    <div class="row d-flex align-items-top">
        <?php if( have_rows('columns') ): ?>
        	<?php while( have_rows('columns') ): the_row();
        		// vars
        		$image = get_sub_field('image');
                $heading = get_sub_field('heading');
        		$content = get_sub_field('content');
        		$button = get_sub_field('button');
        		?>
                <div class="col-md-3 recent-post-single">
                    <a href="<?php echo $button['url']; ?>">
                    <?php if ( $image ): ?>
                        <img src="<?php echo $image; ?>" />
                    <?php else : ?>
                        <img src="https://via.placeholder.com/370x206">
                    <?php endif; ?>
                    <div class="post-content">
                        <h5><?php echo $heading; ?></h5>
                        <p><?php echo $content; ?></p>
                        <?php if ( $button ) : ?>
                            <a href="<?php echo $button['url']; ?>"><?php echo $button['title']; ?></a>
                        <?php endif; ?>
                    </div>
                    </a>
                </div>

        	<?php endwhile; ?>
        <?php endif; ?>

        <?php foreach( $columns as $post): // variable must be called $post (IMPORTANT) ?>
            <?php setup_postdata($post); ?>
            <?php $pID = get_the_ID(); ?>
            <div class="col-md-3 recent-post-single">
                <a href="<?php echo get_the_permalink(); ?>">
                <?php if ( has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('page-banner'); ?>
                <?php else : ?>
                    <img src="https://via.placeholder.com/370x206">
                <?php endif; ?>
                <div class="post-content">
                    <h5><?php echo get_the_title($pID); ?></h5>
                    <p><?php echo excerpt(20, $pID); ?></p>
                </div>
                </a>
            </div>
        <?php endforeach; ?>
        <div class="button-wrap">
            <?php if ( $primaryBtn ) : ?>
                <a href="<?php echo $primaryBtn['url'] ?>" class="btn primary-btn"><?php echo $primaryBtn['title']; ?></a>
            <?php endif; ?>
            <?php if ( $secondaryBtn ) : ?>
                <a href="<?php echo $secondaryBtn['url'] ?>" class="btn secondary-btn"><?php echo $secondaryBtn['title']; ?></a>
            <?php endif; ?>
        </div>
        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
    </div>
</div>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php get_template_part('templates/content', 'page'); ?>

  <? 
    $the_query = new WP_Query( array( 'post_type' => 'product' ) );
    // The Loop
    if ( $the_query->have_posts() ) {
      foreach ( $the_query as $query ) {
          echo '<pre>';
          print_r($query);
          echo '</pre>';
      }
    } else {
      // no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();
?>
<?php endwhile; ?>

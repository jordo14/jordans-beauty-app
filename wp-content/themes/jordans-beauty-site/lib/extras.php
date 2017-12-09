<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function json_to_product() {
  $json = 'wp-content/themes/jordans-beauty-site/lib/products.json';
  $response = file_get_contents($json, true);
  $mydecode = json_decode($response);

  for ($i = 0; $i < count($mydecode); $i++) {
    $title = str_replace("&amp;", "&", $mydecode[$i]->name);
    $description = str_replace("&amp;", "&", $mydecode[$i]->description);
    // Check if already exists
    $get_page = get_page_by_title( $title );
    if ($get_page == NULL){
      // Insert post
      $new_post = array(
        'post_title' => $title,
        'post_content' => $description,
        'post_type' => 'product'
      );
      // Insert post
      $post_id = wp_insert_post($new_post);
      // Insert post meta if available  
      // One for each custom field
      add_post_meta( $post_id, 'brand', $mydecode[$i]->brand );
      add_post_meta( $post_id, '_brand', 'field_5a136494d950f' );
      add_post_meta( $post_id, 'price', $mydecode[$i]->price );
      add_post_meta( $post_id, '_price', 'field_5a1364e0d9510' );
      add_post_meta( $post_id, 'product_link', $mydecode[$i]->product_link );
      add_post_meta( $post_id, '_product_link', 'field_5a1364fad9511' );
      add_post_meta( $post_id, 'product_type', $mydecode[$i]->product_type );
      add_post_meta( $post_id, '_product_type', 'field_5a13671cd9513' );

      // Uncomment to check if meta key is added
      // $get_meta_value = get_post_meta( $post_id, 'meta_key', true );        
      // echo "<pre>";
      // print_r($get_meta_value);
    }
  }
}
add_filter('json_to_product', __NAMESPACE__ . '\\json_to_product');

function product_post_query() {
  ob_start();

  $args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish'
  );

  // The Query
  $the_query = new \WP_Query( $args );

  // The Loop
  if ( $the_query->have_posts() ) : ?>


<div class="grid-container module module-white">

  <div class="grid">
  <div class="grid-sizer"></div>
    <?php while ( $the_query->have_posts() ) : ?>
    <?php $the_query->the_post(); ?>

      <a href="<?php the_permalink(); ?>" class="grid-item">
        <div class="grid-item-content" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 100%), url(<?php the_post_thumbnail_url(); ?>) center / cover no-repeat;">
          <div class="grid-item-text">
            <h1><?php echo wp_trim_words( get_the_title(), 7, '...' ); ?></h1>
          </div>
          <div class="link-container">
            <p class="link">Product Details &rarr;</p>
          </div>
        </div>
        </a>
    <?php endwhile; ?>
  </div>
</div>
  <?php
    /* Restore original Post Data */
    wp_reset_postdata();
  ?>
  <?php else: ?>
  <div> No posts! </div>
  <?php endif;
}

add_filter('product_post_query', __NAMESPACE__ . '\\product_post_query');

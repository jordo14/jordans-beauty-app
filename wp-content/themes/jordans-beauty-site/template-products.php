<?php
/**
 * Template Name: Products Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php Roots\Sage\Extras\product_post_query(); ?>
<?php endwhile; ?>

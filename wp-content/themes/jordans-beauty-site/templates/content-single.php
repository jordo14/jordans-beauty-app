<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <div>
      <?php the_post_thumbnail(); ?>
    </div>
    <div>
    <?php the_field("brand") ?>
    </div>
    <div>
    <?php the_field("price") ?>
    </div>
    <div>
    <?php the_field("product_link") ?>
    </div>
    <div>
    <?php the_field("product_type") ?>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>

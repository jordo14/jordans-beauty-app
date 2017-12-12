<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
  <?php $post_type = get_post_type(); ?>
    <?php if ($post_type == 'product'): ?>
    <div class="container">
      <div class="row">
        <div class="col">
          <header>
            <h1 class="entry-title my-title"><?php the_title(); ?></h1>
          </header>
          <div class="thumbnail">
            <?php the_post_thumbnail(); ?>
          </div>
        </div>
        <div class="col align-self-center">
          <h2>Description</h2>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
          <div>
          <p><b>Brand:</b> <?php the_field("brand") ?> </p>
          </div>
          <div>
          <p><b>Price:</b> $<?php the_field("price") ?> </p>
          </div>
          <div>
          <a href="<?php the_field("product_link") ?>"><?php the_field("product_link") ?></a>
          </div>
        </div>
      </div>  
    </div>
    <h2>Reviews</h2>
    <div>
    <?php $postID = get_the_ID(); ?>
    <?php echo do_shortcode( ' [RICH_REVIEWS_SNIPPET category="page" id="'. $postID .'"] ' ); ?>
    <?php echo do_shortcode( ' [RICH_REVIEWS_SHOW category="page" num="5" id="'. $postID .'"] ' ); ?>
    <?php echo do_shortcode( ' [RICH_REVIEWS_FORM] ' ); ?>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
    <?php else: ?>
    <header>
      <h1 class="entry-title my-title"><?php the_title(); ?></h1>
    </header>
    <div class="entry-content">
            <?php the_content(); ?>
          </div>
    <?php endif; ?>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>

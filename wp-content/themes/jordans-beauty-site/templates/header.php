<header class="banner">
    <h4 class="beauty-name"><?php bloginfo('name'); ?></h4>
    <nav class="nav-primary">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
</header>

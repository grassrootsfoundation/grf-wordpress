<?php

/**
 * Footer template for Blocksy Child Theme
 */
?>
<footer class="custom-footer">
  <div class="container">
    <!-- Logo -->
    <div class="footer-logo">
      <?php
      if (has_custom_logo()) {
        the_custom_logo();
      } else {
        echo '<a href="' . home_url() . '">' . get_bloginfo('name') . '</a>';
      }
      ?>
    </div>

    <!-- Footer Navigation Menu -->
    <nav class="footer-navigation">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'footer',
        'menu_class'     => 'footer-menu',
      ));
      ?>
    </nav>

    <!-- Social Media Links -->
    <div class="footer-social">
      <a href="https://facebook.com" target="_blank">Facebook</a>
      <a href="https://twitter.com" target="_blank">Twitter</a>
      <a href="https://instagram.com" target="_blank">Instagram</a>
    </div>

    <!-- Widget Area -->
    <?php if (is_active_sidebar('footer-widget-area')) : ?>
      <div class="footer-widget-area">
        <?php dynamic_sidebar('footer-widget-area'); ?>
      </div>
    <?php endif; ?>

    <!-- Copyright Text -->
    <div class="footer-copyright">
      <p>&copy; <?php echo date('Y'); ?> Your Nonprofit Name. All rights reserved.</p>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>
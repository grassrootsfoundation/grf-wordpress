<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header class="custom-header">
    <div class="container">
      <!-- Logo -->
      <div class="site-logo">
        <?php
        if (has_custom_logo()) {
          the_custom_logo();
        } else {
          echo '<a href="' . home_url() . '">' . get_bloginfo('name') . '</a>';
        }
        ?>
      </div>

      <!-- Navigation Menu -->
      <nav class="main-navigation">
        <?php
        wp_nav_menu(array(
          'theme_location' => 'primary',
          'menu_class'     => 'nav-menu',
        ));
        ?>
      </nav>

      <!-- Search Bar -->
      <div class="header-search">
        <?php get_search_form(); ?>
      </div>
    </div>
  </header>
  <?php wp_body_open(); ?>
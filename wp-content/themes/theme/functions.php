<?php

/**
 * Enqueue Styles
 */
function theme_enqueue_styles()
{
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


add_filter(
  'use_block_editor_for_post_type',
  function ($use_block_editor, $post_type) {
    if ($post_type === 'club') {
      return false; // Disable Gutenberg for 'club' post type
    }
    return $use_block_editor;
  },
  10,
  2
);

/**
 * Register custom navigation menus
 */

function theme_register_menus()
{
  // Register menu locations
  register_nav_menus(array(
    'primary' => __('Primary Menu', 'theme'),
    'secondary' => __('Secondary Menu', 'theme'),
    'community'  => __('Community Menu', 'theme'),
    'services'  => __('Services Menu', 'theme'),
    'contact'  => __('Contact Menu', 'theme'),
  ));

  // Add theme support for HTML5 and other features
  add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'theme_register_menus');

add_action('graphql_register_types', function () {
  register_graphql_field('Menu', 'menuLocation', [
    'type' => 'String',
    'description' => 'The location of the menu',
    'resolve' => function ($menu) {
      return get_theme_mod('nav_menu_locations')[$menu->term_id] ?? null;
    },
  ]);
});

/**
 * Custom Footer idgets
 */
function theme_widgets_init()
{
  register_sidebar(array(
    'name'          => __('Footer Widget Area', 'theme'),
    'id'            => 'footer-widget-area',
    'before_widget' => '<div class="footer-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-widget-title">',
    'after_title'   => '</h3>',
  ));
}
add_action('widgets_init', 'theme_widgets_init');

/**
 * Custom Landing Page
 */
function theme_redirect_non_logged_in_users()
{
  if (!is_user_logged_in() && !is_page('landing-page')) {
    wp_redirect(home_url('/landing-page'));
    exit;
  }
}
add_action('template_redirect', 'theme_redirect_non_logged_in_users');

/**
 * GraphQL Introspection
 */
add_filter('wpgraphql_enable_introspection', '__return_true');

function theme_register_sidebar()
{
  register_sidebar([
    'name'          => __('Post Sidebar', 'theme'),
    'id'            => 'post-sidebar',
    'description'   => __('Sidebar for single post pages', 'theme'),
    'before_widget' => '<div class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ]);
}
add_action('widgets_init', 'theme_register_sidebar');

/**
 * Image Thumbnails
 */
function theme_setup()
{
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'theme_setup');

/**
 * Custom Blocks
 */

/**
 * Enqueue block assets
 * */
function theme_register_blocks()
{
  register_block_type(__DIR__ . '/blocks/hero-block/block.json');
}
add_action('init', 'theme_register_blocks');

function theme_enqueue_block_assets()
{
  wp_enqueue_style(
    'theme-hero-block',
    get_stylesheet_directory_uri() . '/blocks/hero-block/style.css',
    array(),
    filemtime(get_stylesheet_directory() . '/blocks/hero-block/style.css')
  );

  wp_enqueue_style(
    'theme-hero-block-editor',
    get_stylesheet_directory_uri() . '/blocks/hero-block/editor.css',
    array(),
    filemtime(get_stylesheet_directory() . '/blocks/hero-block/editor.css')
  );
}
add_action('enqueue_block_assets', 'theme_enqueue_block_assets');

/**
 * Admin Function
 */
function custom_admin_styles()
{
  wp_enqueue_style('custom-admin-styles', get_template_directory_uri() . '/style-admin.css');
}
add_action('admin_enqueue_scripts', 'custom_admin_styles');

/**
 * Admin Login
 */
function custom_login_styles()
{
  wp_enqueue_style('custom-login-styles', get_template_directory_uri() . '/style-login.css');
}
add_action('login_enqueue_scripts', 'custom_login_styles');

/**
 * Admin Footer
 */
function custom_admin_footer()
{
  echo 'Customized by Your Company';
}
add_filter('admin_footer_text', 'custom_admin_footer');

/**
 * Editor Style
 */
function add_block_editor_styles()
{
  // Enqueue editor styles
  add_theme_support('editor-styles');
  add_editor_style('style-editor.css'); // Create this CSS file in your theme folder
}
add_action('after_setup_theme', 'add_block_editor_styles');

/**
 * Gutenburg Style
 */
function custom_gutenberg_styles()
{
  wp_enqueue_style(
    'custom-gutenberg-style',
    get_template_directory_uri() . '/style-gutenberg-editor.css',
    [],
    '1.0'
  );
}
add_action('enqueue_block_editor_assets', 'custom_gutenberg_styles');

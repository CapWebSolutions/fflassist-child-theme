<?php
/**
 * Build HTML Sitemap
 *
 * This file displays a HTML/visual sitemap on any post or page.
 *
 */

get_header();

// Add preferred internal Kadence block pattern page header to page template file
block_template_part( 'header-title-lj' );

$display_pbc = true;
$display_opt = false;
$display_authors = false;

echo '<div class="sitemap-container"><div class="page-container">';
  echo '<h2 class="sitemap-heading">Pages</h2>';
  echo '<ul>';
    // Display all pages as parent/child
    wp_list_pages( array( 
        'exclude' => '',
        'title_li' => '',
    ) );
  echo '</ul></div>';

  if ( $display_pbc )  { // Posts by category
    echo '<div class="category-container">';
      echo '<h2 class="sitemap-heading">Posts by Category</h2>';

      $args = array(
        'exclude' => '',
        'hide_empty' => true,
      );
      $cats = get_categories( $args );
      foreach ($cats as $cat) {
        echo '<h3 class="sitemap-heading3">' . $cat->cat_name . '</h3>';
        echo '<ul>';
        query_posts('posts_per_page=-1&cat=' . $cat->cat_ID);
        while(have_posts()) {
          the_post();
          $category = get_the_category();
          // Display post by category, excluding duplicates
          // if ($category[0]->cat_ID == $cat->cat_ID) {
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
          // }
        }
        echo '</ul>';
      }
    echo '</div>';
    }
  

    if ( $display_opt ) {
      echo '<div class="opt-container">
        <h2 class="sitemap-heading">Other Post Types</h2>';

        $excluded = array( 
          'post','page','attachment', 
          'kadence_element',    // Kadence element
          'kadence_adv_page',   // Kadence maintenance mode page
          'location',           // event manager post type
          'event',              // event manager post type
          'product'             // Woo Product
        );

        // Display all other post types not listed above
        foreach( get_post_types( array('public' => true) ) as $post_type ) {
          // var_dump($post_type);
          if ( in_array( $post_type, $excluded ) ) {
            continue;
          }
          
          $pt = get_post_type_object( $post_type );

          echo '<div class="opt-h3-container">';
            echo '<h3 class="sitemap-heading3">' . $pt->labels->name . '</h3>';
            echo '<ul>';
              query_posts('post_type=' . $post_type . '&posts_per_page=-1');
              while( have_posts() ) {
                the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
              }
            echo '</ul>';
          echo '</div>';
        }
    }

    if ( $display_authors ) { // Author Sitemap
      echo '<div class="author-container"><h2 class="sitemap-heading">Authors</h2>';
      echo '<ul>';
      wp_list_authors( 
        array(
          'exclude_admin' => true
          ) 
        );
      echo '</ul></div>';
    }

  echo '</div>';


echo '</div>';

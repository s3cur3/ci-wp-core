<?php
/**
 * Page titles
 * @return string The title to be printed on the page
 */
function roots_title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
      return __('Latest Posts', CI_TEXT_DOMAIN);
    }
  } elseif(is_post_type_archive(CI_STAFF_TYPE)) {
      return post_type_archive_title('All ', true);
  } elseif (is_archive()) {
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    if ($term) {
      return apply_filters('single_term_title', $term->name);
    } elseif (is_post_type_archive()) {
      return apply_filters('the_title', get_queried_object()->labels->name);
    } elseif (is_day()) {
      return sprintf(__('Daily Archives: %s', CI_TEXT_DOMAIN), get_the_date());
    } elseif (is_month()) {
      return sprintf(__('Monthly Archives: %s', CI_TEXT_DOMAIN), get_the_date('F Y'));
    } elseif (is_year()) {
      return sprintf(__('Yearly Archives: %s', CI_TEXT_DOMAIN), get_the_date('Y'));
    } elseif (is_author()) {
      $author = get_queried_object();
      return sprintf(__('Author Archives: %s', CI_TEXT_DOMAIN), $author->display_name);
    } else {
      return single_cat_title('', false);
    }
  } elseif (is_search()) {
    return sprintf(__('Search Results for %s', CI_TEXT_DOMAIN), get_search_query());
  } elseif (is_404()) {
    return __('Not Found', CI_TEXT_DOMAIN);
  } else {
    return get_the_title();
  }
}
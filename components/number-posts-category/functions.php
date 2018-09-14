<?php

function wp_get_cat_postnum($id) {
  $cat = get_category($id);
  $count = (int) $cat->count;
  $taxonomy = 'category';
  $args = array(
    'child_of' => $id,
  );
  $tax_terms = get_terms($taxonomy,$args);
  foreach ($tax_terms as $tax_term) {
    $count +=$tax_term->count;
  }
  return $count;
}

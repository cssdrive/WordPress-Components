<!-- Отображение похожих записей -->
<?php
  $tags = wp_get_post_tags($post->ID);
  if ($tags) {
    $tag_ids = array();
    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
    $args=array(
    'tag__in' => $tag_ids,
    'post__not_in' => array($post->ID),
    'showposts'=>5, // Number of related posts that will be shown.
    'caller_get_posts'=>1
  );
  $my_query = new wp_query($args);
    if( $my_query->have_posts() ) {
      echo '<h3>Related Posts</h3><ul class="uk-list">';
      while ($my_query->have_posts()) { $my_query->the_post(); ?>
        <li>
          <!-- Сюда выводится контент цикла поста -->
        </li>
    <?php } echo '</ul>'; }
  }
?>

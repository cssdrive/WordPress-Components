<!-- Вывод назания категории для WCK -->
<?php echo '<span class="">...</span>' . get_post_meta ($post->ID,'название-категории',true); ?>


<!-- Указывается непосредственно названгие кастомной таксономии в  котрой бцдет выводится рубрики -->
<!-- Taxonomy:* -->

<?php the_terms( $post->ID, 'rubrics', 'Meeting: ', ', ', ' ' ); ?>

<!-- Расширенные возможности -->

<?php
  $args = array(
    'post_type' => 'post',
    'tax_query' => array(
      array(
        'taxonomy' => 'meeting',
        'field'    => 'slug',
        'terms'    => 'monthly',
      ),
    ),
  );
  $query = new WP_Query( $args );
?>

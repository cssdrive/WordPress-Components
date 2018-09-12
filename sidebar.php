<!-- Создание своих собственных "популярных записей" в сайдбаре -->
<ul>
  <?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 5");
    foreach ($result as $post) {
    setup_postdata($post);
    $postid = $post->ID;
    $title = $post->post_title;
    $commentcount = $post->comment_count;
    if ($commentcount != 0) {
  ?>
    <li>
      <a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>">
      <?php echo $title ?></a> {<?php echo $commentcount ?>}
    </li>
  <?php } } ?>
</ul>


<!-- Выводим количество записей категорий -->
<?php
  $mycats = wp_list_categories('show_count=1&title_li=&echo=0');
  $mycats = str_replace(array('</a>','(',')'), array('<span class="test">','','</span></a>'), $mycats);
  echo $mycats;
?>

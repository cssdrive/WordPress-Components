<ul class="uk-list">
  <?php wp_list_categories( array(
    'taxonomy'     => 'rubrics', // название таксономии
    'orderby'      => 'name',  // сортируем по названиям
    'show_count'   => 1,       // не показываем количество записей
    'pad_counts'   => 0,       // не показываем количество записей у родителей
    'hierarchical' => 1,       // древовидное представление
    'title_li'     => 'test',  // список без заголовка
  )); ?>
</ul>

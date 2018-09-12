<!-- Выводим количество записей на странице категории -->
<?php
  $getcat = get_the_category();
  $cat = $getcat[0]->cat_ID; //  получаем ID активной категории
  echo 'Количество работ в категории: ', wp_get_cat_postnum($cat);
?>

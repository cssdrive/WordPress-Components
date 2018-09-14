<?php if (!dynamic_sidebar("left-sidebar") ) : ?>
  Левый сайдбар: этот текст отображается по умолчанию...
<?php endif; ?>

<?php if (!dynamic_sidebar("right-sidebar") ) : ?>
  Правый сайдбар: этот текст отображается по умолчанию...
<?php endif; ?>

<!-- Добавление виджета -->
<?php if ( is_active_sidebar('sidebar') ) { ?>
	<?php dynamic_sidebar( 'sidebar' ); ?>
<?php } else { ?>
	Добавьте виджет!
<?php }; ?>
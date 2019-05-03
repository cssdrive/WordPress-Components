<!-- Вывод заголовка и описания рубрики -->

<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>

<!-- Выводим количество всех записей на странице категории -->
<?php echo count(query_posts('cat=1,3,4,7'));?>


<!-- Вывод списка будущих записей -->
<?php query_posts('showposts=10&post_status=future'); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!-- Контент -->
  <?php endwhile; else: ?>
    <!-- Нет будущих записей -->
<?php endif; ?>


<!-- Выводим последних постов -->
<?php query_posts($query_string.'&cat=0&showposts=8'); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <!-- Контент цикла -->
<?php  endwhile; ?>
<?php wp_reset_query();?>


<!-- Меняем вид первого поста в выводе произвольных потов -->
<?php query_posts(array('orderby' => 'rand', 'cat' => '0,1,2,3', 'showposts' => 5)); ?>
<?php if (have_posts()) : ?>
<?php $count = 0; ?>
  <!-- Начало цикла -->
  <?php while (have_posts()) : the_post(); ?>
	<?php $count++; ?>
	<?php if ($count == 1) : ?>
    <!-- Первый пост -->
  <?php else : ?>
    <!-- Остальные посты -->
  <?php endif; ?>
	<?php endwhile; ?>
  <!-- Конец цикла -->
<?php endif; ?>
<?php wp_reset_query();?>

<!-- Пекламные вставки между постами в ленте новостей -->

<?php $counter = 0; ?>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php $counter = $counter + 1;?>
		
		<?php if(1 == $counter) : { ?>
			<li><?php get_template_part( 'content', 'large' ); ?></li>
		<?php } else : { ?>
			<li><?php get_template_part( 'content' ); ?></li>
		<?php } endif; ?>
	
		<?php if(2 == $counter) : { ?>
			<li>Реклама 1</li>
		<?php } endif; ?>
		
		<?php if(4 == $counter) : { ?>
			<li>Реклама 3</li>
		<?php } endif; ?>

		<?php endwhile; ?>
<?php else : ?>
	Постов нет!
<?php endif; ?>

<!-- Вывод постов с конца -->

<?php query_posts( $query_string.'&cat=0&order=DESC&posts_per_page=3'); //Значения (-9) отключают категорию (9) добавляют; C начала order=ASC; с конца order=DESC ?>
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <img src="<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>" uk-cover>
    <h1 class="uk-heading-primary" uk-slideshow-parallax="x: 200,-200"><?php the_title( '', '' ); ?></h1>
    <div class="uk-text-meta" uk-slideshow-parallax="x: 400,-400"><?php the_excerpt(); ?></div>
  <?php else : ?>
    Нет постовв
  <?php endif; ?>
<?php wp_reset_query(); ?>

<!-- Вывод постов через Switch -->
<?php $num = 0; ?>
<div class="row">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php
                $n = $num % 10 + 1;
                switch ($n) {
                case 1:
                case 2:
                case 3:
                case 6:
                case 7:
                case 10:
                    echo '<div class="col-md-4">';
                    break;
                case 4:
                case 5:
                    echo '<div class="col-md-6">';
                    break;
                case 9:
                    echo '<div class="col-md-8">';
                    break;
                }   
    $num++; 
            ?>
                <div class="icerik-post post-height">
                    <div class="post-image">
                        <div class="img-block">
                            <a href="<?php the_permalink() ?>"><?php echo get_the_post_thumbnail() ?></a>
                            <div class="post-etiket"><span class="etiket"><a href="<?php the_permalink() ?>"><?php the_tags() ?></a></span></div>
                        </div>
                    </div>
                    <div class="post-icerik">
                        <h5 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                        <p><?php excerpt_limit(200, '...'); ?></p>
                        <div class="info">
                            <p><span class="ago"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' önce '; ?></span><span class="okuma"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo getPostViews(get_the_ID()); ?></span><a href="" title="Paylaş" class="share"><i class="fa fa-share" aria-hidden="true"></i></a></p>
                        </div>
                    </div>
                </div>
            </div>
    <?php endwhile; ?>

    <?php else: ?>

    <?php endif; ?>



<!-- CUSTOM IMAGES -->

<section class="uk-section uk-section-xsmall">
	<div class="uk-container">
		<?php $num = 0; ?>
			<ul class="uk-grid-small" uk-grid>
			    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php 
				$n = $num % 6 + 1; 
				switch ($n) {
			    case 1:
				echo '<li class="uk-width-1-2 uk-width-1-1@s">'; ?>

				<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<img class="uk-width-1-1 uk-visible@s" data-src="<?php the_post_thumbnail('works-large'); ?>" alt="<?php the_title(); ?>" data-uk-img>
								<img class="uk-width-1-1 uk-hidden@s" data-src="<?php the_post_thumbnail('works-small'); ?>" alt="<?php the_title(); ?>" data-uk-img>
							</a>
						<?php endif; ?>

			    <?php break;
			    case 2:
			    case 3:
				echo '<li class="uk-width-1-2">'; ?>

				<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<img class="uk-width-1-1 uk-visible@s" data-src="<?php the_post_thumbnail('works-medium'); ?>" alt="<?php the_title(); ?>" data-uk-img>
								<img class="uk-width-1-1 uk-hidden@s" data-src="<?php the_post_thumbnail('works-small'); ?>" alt="<?php the_title(); ?>" data-uk-img>
							</a>
						<?php endif; ?>

					<?php break;   
			    case 4:
			    case 5:
			    case 6:
				echo '<li class="uk-width-1-2 uk-width-1-3@s">'; ?>

				<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<img class="uk-width-1-1 uk-visible@s" data-src="<?php the_post_thumbnail('works-small'); ?>" alt="<?php the_title(); ?>" data-uk-img>
								<img class="uk-width-1-1 uk-hidden@s" data-src="<?php the_post_thumbnail('works-small'); ?>" alt="<?php the_title(); ?>" data-uk-img>
							</a>
						<?php endif; ?>

			    <?php break;
			    }   
					$num++;
				?>

					<?php //Контент внутри <li></li> ?>

				</li>
			    <?php endwhile; ?>
			</ul>

				<?php fubon_pagenavi(); ?>

		    <?php else: ?>

		<?php endif; ?>
	</div>
</section>

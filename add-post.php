<?php acf_form_head(); ?>
<?php  /* Template Name: Добавить пост */ get_header(); ?>

	<div id="primary" class="content-area uk-section">
		<div id="content" class="site-content uk-container" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php acf_form(array(
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'post',
						'post_status'		=> 'publish'
						
						/*
					    publish — опубликованный пост,
					    pending — пост ожидает проверки модератором,
					    draft — черновик,
					    auto-draft — автоматически созданный чероновик для нового поста, не содержащий контента,
					    future — пост запланирован на публикацию,
					    private — невидим для незарегистрированных пользователей,
					    inherit — статус вложений и редакций постов,
					    trash — пост, находящийся в корзине (удаленный), статус добавлен в WordPress 2.8
						*/
						
					),
					'post_title' => true,
	        //'post_content' => true,
	        'html_updated_message'	=> '<div id="message" class="updated">Спасибо. Запись отправлена на проверку.</div>',
	        'html_submit_button'	=> '<input type="submit" class="acf-button uk-button uk-button-primary" value="%s" />',
	        'html_submit_spinner'	=> '<span class="acf-spinner"></span>',
	        'return' => '%post_url%', // %post_url% , %post_id%
					'submit_value'		=> 'Добавить новость'
				)); ?>

			<?php endwhile; ?>
			
			

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
if ( is_user_logged_in() ) {
		  $current_page = $_SERVER['REQUEST_URI'];
		  
        // LOGIN ON 
		    acf_form(array(
					'post_id'		=> 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'post',
						'post_status'		=> 'pending'
						
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
				  'post_content' => true,
				  'html_updated_message'	=> '<div id="message" class="updated">Спасибо. Запись отправлена на проверку.</div>',
				  'html_submit_button'	=> '<input type="submit" class="acf-button uk-button uk-button-primary" value="%s" />',
				  'html_submit_spinner'	=> '<span class="acf-spinner"></span>',
				  //'return' => '%post_id%', // %post_url% , %post_id%
					'submit_value'		=> 'Добавить новость'
				));
				
		  } else {
			  
		    // LOGIN -OFF
		    echo 'Вы должны <a href="#">зарегистрироваться</a> или <a href="#">войти</a>, чтобы добавить свою новость.';
		    
		  }

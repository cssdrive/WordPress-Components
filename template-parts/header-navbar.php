<nav class="mp-navbar-header uk-navbar-container uk-navbar-transparent" uk-navbar>  
    <div class="uk-navbar-left">
	    <a class="uk-navbar-item uk-logo uk-hidden@m" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		<ul class="uk-navbar-nav uk-visible@m">
            <li class="menu-console uk-visible@m">
                <a class="uk-active" href="#" title="<?php printf( esc_html__( 'Games', 'monopixel' ) ); ?>"><span><?php printf( esc_html__( 'Games', 'monopixel' ) ); ?></span></a>
                <div class="uk-navbar-dropdown uk-border-rounded" uk-drop="mode: click; boundary: !nav; boundary-align: true; pos: bottom-justify; animation: uk-animation-slide-top-small; offset: -20; duration: 200;">
	                <div class="up-arrow"></div>
                    <div class="uk-navbar-dropdown-grid uk-child-width-1-3@m" uk-grid>
                       <div>
	                       <h5 class="uk-text-uppercase uk-text-bold"><?php printf( esc_html__( 'Console', 'monopixel' ) ); ?></h5>
	                       <?php wp_nav_menu( array(
								'menu'            => 'console',
								'theme_location'  => 'console',
								'container'       => 'ul',
								'container_id'    => '',
								'container_class' => '',
								'menu_id'         => '',
								'menu_class'      => 'uk-nav uk-navbar-dropdown-nav',
								'before'          => '',
						    	'after'           => '',
						    	'link_before'     => '<span>',
						    	'link_after'      => '</span>',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'fallback_cb'     => 'monopixel_primary_menu::fallback',
								'depth'           => 2,
								'walker'          => new monopixel_primary_menu())
							); ?>
                       </div>
                       <div>
	                       <h5 class="uk-text-uppercase uk-text-bold"><?php printf( esc_html__( 'Genre', 'monopixel' ) ); ?></h5>
                           <?php wp_nav_menu( array(
								'menu'            => 'genre',
								'theme_location'  => 'genre',
								'container'       => 'ul',
								'container_id'    => '',
								'container_class' => '',
								'menu_id'         => '',
								'menu_class'      => 'uk-nav uk-navbar-dropdown-nav',
								'before'          => '',
						    	'after'           => '',
						    	'link_before'     => '<span># ',
						    	'link_after'      => '</span>',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'fallback_cb'     => 'monopixel_primary_menu::fallback',
								'depth'           => 2,
								'walker'          => new monopixel_primary_menu())
							); ?>
                       </div>
                       <div>
	                       <h5 class="uk-text-uppercase uk-text-bold"><?php printf( esc_html__( 'Emulators', 'monopixel' ) ); ?></h5>
                           <?php wp_nav_menu( array(
								'menu'            => 'emulators',
								'theme_location'  => 'emulators',
								'container'       => 'ul',
								'container_id'    => '',
								'container_class' => '',
								'menu_id'         => '',
								'menu_class'      => 'uk-nav uk-navbar-dropdown-nav',
								'before'          => '',
						    	'after'           => '',
						    	'link_before'     => '<span>',
						    	'link_after'      => '</span>',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'fallback_cb'     => 'monopixel_primary_menu::fallback',
								'depth'           => 2,
								'walker'          => new monopixel_primary_menu())
							); ?>
                       </div>
                   </div>
                </div>
            </li>
            <?php wp_nav_menu( array(
				'menu'            => 'primary',
				'theme_location'  => 'primary',
				'container'       => 'li',
				'container_id'    => '',
				'container_class' => '',
				'menu_id'         => '',
				'menu_class'      => 'uk-navbanr-nav',
				'before'          => '',
		    	'after'           => '',
		    	'link_before'     => '<span>',
		    	'link_after'      => '</span>',
				'items_wrap'      => '%3$s',
				'fallback_cb'     => 'monopixel_primary_menu::fallback',
				'depth'           => 2,
				'walker'          => new monopixel_primary_menu())
			); ?>
        </ul>
    </div>
    
    <div class="uk-navbar-center uk-visible@m">
		<?php monopixel_the_custom_logo(); ?> <a class="uk-navbar-item uk-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
    </div>
    
    <div class="uk-navbar-right">
	    
	    <div class="uk-navbar-item uk-hidden@m">
		    <a href="#"><img src="<?php echo get_template_directory_uri() ?>/assets/img/icon/menu_filled.svg" alt="<?php printf( esc_html__( 'Menu', 'monopixel' ) ); ?>" width="30"></a>
		</div>
		
	    <ul class="uk-navbar-nav uk-visible@m">		    
		    <?php wp_nav_menu( array(
				'menu'            => 'secondary',
				'theme_location'  => 'secondary',
				'container'       => 'li',
				'container_id'    => '',
				'container_class' => '',
				'menu_id'         => '',
				'menu_class'      => 'uk-navbar-nav',
				'before'          => '',
		    	'after'           => '',
		    	'link_before'     => '<span>',
		    	'link_after'      => '</span>',
				'items_wrap'      => '%3$s',
				'fallback_cb'     => 'monopixel_primary_menu::fallback',
				'depth'           => 2,
				'walker'          => new monopixel_primary_menu())
			); ?>
			<li class="menu-search">
            	<a href="#" title="<?php printf( esc_html__( 'Search', 'monopixel' ) ); ?>"><img src="<?php echo get_template_directory_uri() ?>/assets/img/icon/search_filled.svg" alt="<?php printf( esc_html__( 'Search', 'monopixel' ) ); ?>" width="30"></a>
                <div class="uk-navbar-dropdown uk-border-rounded" uk-drop="mode: click; boundary: !nav; boundary-align: true; pos: bottom-justify; animation: uk-animation-slide-top-small; offset: -20; duration: 200;" >
	                <div class="up-arrow"></div>
                    <div class="uk-navbar-dropdown-grid uk-child-width-1-1@m" uk-grid>
                       <div>
	                       <?php echo do_shortcode("[wpns_search_form]"); ?>
                       </div>
                    </div>
                </div>
            </li>
            <li class="menu-changelog">
            	<a href="#"><img class="uk-margin-small-right" src="<?php echo get_template_directory_uri() ?>/assets/img/icon/menu_filled.svg" alt="<?php printf( esc_html__( 'Menu', 'monopixel' ) ); ?>" width="30"></a>
				<div class="uk-navbar-dropdown uk-border-rounded" uk-drop="mode: click; boundary: !nav; boundary-align: true; pos: bottom-right; animation: uk-animation-slide-top-small; offset: -20; duration: 200;" >
	                <div class="up-arrow"></div>
	                <h3 class="uk-heading-divider"><?php printf( esc_html__( 'Changelog', 'monopixel' ) ); ?></h3>
                    <div class="uk-panel-scrollable">
	                    <h2 class="uk-h4">2.0.0 beta 1 <span class="uk-text-muted">(24 Марта 2018)</span></h2>
					    <ul class="uk-list">
						    <li><span class="uk-label uk-label-success uk-margin-small-right uk-text-center uk-border-rounded">New</span> Разработка нового шаблона</li>
						</ul>
					</div>
                </div>
            </li>
	    </ul>
    </div>
</nav>
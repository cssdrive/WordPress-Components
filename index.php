<?php
    if ( have_posts() ) :

        if ( is_home() && ! is_front_page() ) : ?>
            <header>
                <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
            </header>

        <?php
        endif;

        /* Start the Loop */
        while ( have_posts() ) : the_post();
            /*
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part( 'template-parts/content', get_post_format() );

        endwhile;

        the_posts_navigation();

    else :

        get_template_part( 'template-parts/content', 'none' );

    endif; ?>


// FUNCTIONS -------------------------------------------

add_filter( 'excerpt_length', 'change_excerpt_number_words_length' );
function change_excerpt_number_words_length() {
    return 200;
}

// FUNCTIONS -------------------------------------------

function truncate_text( $text, $words_limit = 55, $more_text = '&hellip;' ) {

    $separator = ' ';

    if ( strpos( _x( 'words', 'Word count type. Do not translate!' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
        $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
        preg_match_all( '/./u', $text, $words_array );
        $words_array = array_slice( $words_array[0], 0, $words_limit + 1 );
        $separator = '';
    } else {
        $words_array = preg_split( "/[\n\r\t ]+/", $text, $words_limit + 1, PREG_SPLIT_NO_EMPTY );
    }

    if ( ! count( $words_array ) > $words_limit ) {
        return implode( $separator, $words_array );
    }

    array_pop( $words_array );
    $text = implode( $separator, $words_array );
    return $text . $more_text;
}

// FUNCTIONS -------------------------------------------

add_filter('the_content', 'truncate_the_content', 99);
function truncate_the_content( $text ) {
    $text = strip_shortcodes( $text );

    return truncate_text( $text );
}

// FUNCTIONS -------------------------------------------

add_filter('the_content', 'truncate_the_content', 99);
function truncate_the_content( $text ) {
    if ( is_singular() ) {
        return $text;
    }

    $text = strip_shortcodes( $text );

    return truncate_text( $text );
}


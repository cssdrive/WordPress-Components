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
/**
 * Change the number of words for the excerpts.
 *
 * @since 1.0.0
 *
 * @return int
 */
function change_excerpt_number_words_length() {
    return 200;
}



We need to see the code from the template-parts/content.php file. I suspect it is using the_content() to render out the content to the browser. You can open it and check that out.

The WordPress function the_content will, by default, render out all of the content. To limit the content displayed, you have choices:

    Use the_excerpt() instead of the the_content().
    Or you'll need to write a truncate function.

Using Excerpts

The first option is to use the excerpts instead of grabbing all of the content. In WordPress, the excerpts are a snippet of the content with the HTML markup stripped out. By default, it gives you 55 words of content.

When to Use This Option

This option is the easiest as you are letting WordPress handle the truncating process. You would use this option when you don't care about preserving the HTML markup within the editor itself.

How to Change the Number of Words

To change the number of words, you register to the filter event and then return the number of words that you want. In this example, you are stating you want 200 words.

add_filter( 'excerpt_length', 'change_excerpt_number_words_length' );
/**
 * Change the number of words for the excerpts.
 *
 * @since 1.0.0
 *
 * @return int
 */
function change_excerpt_number_words_length() {
    return 200;
}

Truncate Content

The second option requires you to write a function that truncates "text" to a set number of words or characters.

When to Use This Option

You would use this option when you want to preserve the HTML markup. Excerpts strip out the line breaks, paragraphs, etc. With this option, you are using get_the_content() and then filtering the return by truncating it. The shortcodes and HTML markup as written in the editor are preserved.

How

Here is where you will need some PHP and WordPress Core knowledge and chops. Essentially, you want to register a callback to the the_content filter in order to grab all of the content. Then you'll strip out the shortcodes. Finally, you'll pass it to a truncating function.

This truncating function is adapted from WordPress Core:

/**
 * Truncate the incoming string of text to a set number of words.
 * It preserves the HTML markup.
 *
 * @since 1.0.0
 *
 * NOTE: This function is adapted from WordPress Core's `wp_trim_words()`
 * function.  It does the same functionality, except it does not strip out
 * the HTML tag elements.
 *
 * @param string $text
 * @param int $words_limit
 * @param string $more_text
 *
 * @return string
 */
function truncate_text( $text, $words_limit = 55, $more_text = '&hellip;' ) {

    $separator = ' ';

    /*
     * translators: If your word count is based on single characters (e.g. East Asian characters),
     * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
     * Do not translate into your own language.
     */
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

add_filter('the_content', 'truncate_the_content', 99);
/**
 * Truncate the content to a set number of words.
 *
 * @since 1.0.0
 *
 * @param string $text
 *
 * @return string
 */
function truncate_the_content( $text ) {
    $text = strip_shortcodes( $text );

    return truncate_text( $text );
}

add_filter('the_content', 'truncate_the_content', 99);
/**
 * Truncate the content to a set number of words.
 *
 * @since 1.0.0
 *
 * @param string $text
 *
 * @return string
 */
function truncate_the_content( $text ) {
    if ( is_singular() ) {
        return $text;
    }

    $text = strip_shortcodes( $text );

    return truncate_text( $text );
}


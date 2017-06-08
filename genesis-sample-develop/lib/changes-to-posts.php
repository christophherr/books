<?php
/**
 * Genesis Sample.
 *
 * This file adds additional address fields to the user profile.
 *
 * @package Genesis Sample
 * @author  Christoph Herr
 * @license GPL-2.0+
 * @link	https://www.christophherr.com
 */

add_action( 'genesis_entry_header', 'ch_show_featured_image_on_posts' );

/**
 * Add featured image to posts.
 *
 * @return void
 */
function ch_show_featured_image_on_posts() {
	$image = genesis_get_image( array(
		'format' => 'html',
		'size' => 'featured-image',
		'context' => '',
		'attr' => array(
			'class' => 'alignnone',
		),
	) );

	if ( is_singular() ) {
		if ( $image ) {
			printf( '<div class="featured-image">%s</div>', $image );
		}
	}
}

add_filter( 'genesis_post_info', 'sp_post_info_filter' );
/**
 * Modify the comment link text in entry meta.
 *
 * @param string $post_info Meta information about the post.
 * @return string
 */
function sp_post_info_filter( $post_info ) {
	return '[post_date] by [post_author_posts_link] [post_comments zero="Propose a Trade" one="1 Comment" more="% Comments"] [post_edit]';
}

add_action( 'genesis_entry_content', 'ch_add_custom_fields_to_posts' );
/**
 * Add custom fields to posts.
 *
 * @return void
 */
function ch_add_custom_fields_to_posts() {
	if ( is_singular( array( 'post' ) ) ) {
		$isbn = esc_html( get_post_meta( get_the_ID(), 'isbn', true ) );
		$link = esc_url( get_post_meta( get_the_ID(), 'link_to_the_book', true ) );
		echo '<div class="isbn">ISBN: ' . $isbn . '</div>';
		echo '<div class="link">Link to the Book: <a href="' . $link . '">' . $link . '</a></div>';
	}
}


add_filter( 'comment_form_defaults', 'ch_modify_standard_comment_form_text' );
/**
 * Modify the standard comment form text
 *
 * @param array $arg Standard comment form text.
 * @return array
 */
function ch_modify_standard_comment_form_text( $arg ) {
	$arg['title_reply'] = __( 'Propose a Trade', 'genesis-sample' );
	$arg['comment_field'] = '<p class="comment-form-comment"><label for="comment"></label><textarea id="comment" name="comment" cols="45" rows="1" aria-required="true"></textarea></p>';
	$arg['label_submit'] = __( 'Submit Trade Proposal', 'genesis-sample' );
	return $arg;
}

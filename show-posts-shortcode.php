<?php
/**
 * @package Show_Posts
 * @author Ashish Yadhuvanshi
 * @version 1.0
 */

/*
Plugin Name: Show Post Shortcode
Plugin URI: https://imagegrafia.com/show-posts
Description: Shortcode to display posts in a category: <code>[showposts category="2" num="4"]</code>. You can also use parameters <code>order</code> and <code>orderby</code>.
Author: Ashish Yadhuvanshi
Version: 1.0
Author URI: http://twitter.com/ashishkvs
*/

function showMyPosts( $atts )
{

	extract( shortcode_atts( array(
		'category' => '',
		'num' => '5',
		'order' => 'ASC',
		'orderby' => 'date',
	), $atts) );

	$out = '';

	$query = array();

	if ( $category != '' )
		$query[] = 'category=' . $category;

	if ( $num )
		$query[] = 'numberposts=' . $num;

	if ( $order )
		$query[] = 'order=' . $order;

	if ( $orderby )
		$query[] = 'orderby=' . $orderby;

	$posts_to_show = get_posts( implode( '&', $query ) );

	$out = '<ul>';

	foreach ($posts_to_show as $post_to_show) {
		$permalink = get_permalink( $post_to_show->ID );
		
		$date = date_parse($post_to_show->post_date);
		// print_r($post_to_show);		
		$out .= <<<HTML
		<li >
			<div class="calendar-post-thumb ">
                <div class="calendar-thumb py-2 pl-2">
					<p class="date">{$date['day']} / {$date['month']}</p>
                    <p class="date">{$date['year']}</p>
                </div>
                <div class=" quiz-link">
                    <h3><a href="{$permalink}">{$post_to_show->post_title}</a> </h3>
					<p class="quiz-thumbnail-excerpt">{$post_to_show->post_excerpt}</p>
                </div>
			</div>
		</li>
HTML;
	}

	$out .= '</ul>';

    return $out;
}

add_shortcode('showposts', 'showMyPosts');

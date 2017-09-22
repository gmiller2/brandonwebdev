<?php
	add_action('after_setup_theme', 'blankslate_setup');

	function blankslate_setup(){
	load_theme_textdomain('blankslate', get_template_directory() . '/languages');
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	global $content_width;
	if (
	! isset( $content_width )
	)
	$content_width = 640;
	register_nav_menus(array( 'main-menu' =>
	__( 'Main Menu', 'blankslate' ) ));
	}

	add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');

	function blankslate_enqueue_comment_reply_script(){
	if(get_option('thread_comments'))
	{
	wp_enqueue_script('comment-reply');
	}}
	add_filter('the_title', 'blankslate_title');

	function blankslate_title($title) {
	if ($title == '') {
	return 'Untitled';
	} else {
	return $title;}
	}

	add_filter('wp_title', 'blankslate_filter_wp_title');
	function blankslate_filter_wp_title($title){
	return $title . esc_attr(get_bloginfo('name'));
	}

	add_filter('comment_form_defaults', 'blankslate_comment_form_defaults');
	function blankslate_comment_form_defaults( $args ){
	$req = get_option( 'require_name_email' );
	$required_text = sprintf( ' ' . __('Required fields are marked %s', 'blankslate'),
	'<span class="required">*</span>' );
	$args['comment_notes_before'] = '<p class="comment-notes">' .
	__('Your email is kept private.', 'blankslate') . (
	$req ? $required_text : '' ) . '</p>';
	$args['title_reply'] = __('Post a Comment', 'blankslate');
	$args['title_reply_to'] = __('Post a Reply to %s', 'blankslate');
	return $args;
	}

	add_action( 'init', 'blankslate_set_default_widgets' );

	function blankslate_set_default_widgets() {
	if ( is_admin() && isset( $_GET['activated'] ) ) {
	update_option( 'sidebars_widgets', $preset_widgets );
	}}

	add_action( 'init', 'blankslate_add_shortcodes' );

	function blankslate_add_shortcodes() {
	add_filter('widget_text', 'do_shortcode');
	add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
	add_shortcode('caption', 'fixed_img_caption_shortcode');
	}

	function fixed_img_caption_shortcode($attr, $content = null) {
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);

	if ( $output != '' ) return $output;
	extract(shortcode_atts(array('id'=> '','align'	=> 'alignnone','width'	=> '','caption' => ''), $attr));

	if ( 1 > (int) $width || empty($caption) )return $content;

	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align). '">'. do_shortcode( $content ) . '<p class="wp-caption-text">'.
	$caption . '</p></div>';
	}
	add_action( 'widgets_init', 'blankslate_widgets_init' );

	function blankslate_widgets_init() {
	register_sidebar( array ('name' => __('Sidebar Widget Area', 'blankslate'),
	'id' => 'primary-widget-area','before_widget' => '<li id="%1$s"
	class="widget-container %2$s">','after_widget' => "</li>",'before_title' =>
	'<h3 class="widget-title">','after_title' => '</h3>',) );
	}

	$preset_widgets = array ('primary-aside'  => array( 'search', 'pages', 'categories', 'archives' ),);

	function blankslate_get_page_number() {if (get_query_var('paged')) {
	print ' | ' . __( 'Page ' , 'blankslate') . get_query_var('paged');}
	}

	function blankslate_catz($glue) {$current_cat = single_cat_title( '', false );

	$separator = "\n";$cats = explode( $separator, get_the_category_list($separator) );

	foreach ( $cats as $i => $str ) {if ( strstr( $str, ">$current_cat<" ) ) {

	unset($cats[$i]);break;}}if ( empty($cats) )return false;

	return trim(join( $glue, $cats ));
	}

	function blankslate_tag_it($glue) {$current_tag = single_tag_title( '', '',  false );

	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );

	foreach ( $tags as $i => $str ) {if ( strstr( $str, ">$current_tag<" ) ) {
	unset($tags[$i]);break;
	}}

	if ( empty($tags) )return false;
	return trim(join( $glue, $tags ));
	}

	function blankslate_commenter_link() {
	$commenter = get_comment_author_link();

	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
	$commenter = preg_replace( '/(<a[^>]* class=[\'"]?)/', '\\1url ' , $commenter );
	}
	else {$commenter = preg_replace( '/(<a )/', '\\1class="url "' , $commenter );
	}

	$avatar_email = get_comment_author_email();

	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );

	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
	}

	function blankslate_custom_comments($comment, $args, $depth)
	{$GLOBALS['comment'] = $comment;$GLOBALS['comment_depth'] = $depth;?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
		<div class="comment-author vcard"><?php blankslate_commenter_link() ?></div>
		<div class="comment-meta">
		<?php printf(__('Posted %1$s at %2$s', 'blankslate' ), get_comment_date(), get_comment_time() );
		?>

		<span class="meta-sep"> | </span>
		<a href="#comment-<?php echo get_comment_ID(); ?>" title="<?php _e('Permalink to this comment', 'blankslate' ); ?>">

		<?php _e('Permalink', 'blankslate' ); ?></a>

		<?php edit_comment_link(__('Edit', 'blankslate'), ' <span class="meta-sep"> | </span> <span class="edit-link">', '</span>'); ?>
		</div>

		<?php if ($comment->comment_approved == '0') {
			echo '\t\t\t\t\t<span class="unapproved">'; _e('Your comment is awaiting moderation.', 'blankslate');
			echo '</span>\n'; } ?><div class="comment-content"><?php comment_text() ?></div>
			<?php
			if($args['type'] == 'all' || get_comment_type() == 'comment')
			:comment_reply_link(array_merge($args, array('reply_text' => __('Reply','blankslate'),'login_text' => __('Login to reply.', 'blankslate'),'depth' => $depth,'before' => '<div class="comment-reply-link">','after' => '</div>')));
			endif;
			?>
			<?php
			}
			function blankslate_custom_pings($comment, $args, $depth) {$GLOBALS['comment'] = $comment;?>
			<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
			<div class="comment-author">
			<?php printf(__('By %1$s on %2$s at %3$s', 'blankslate'),get_comment_author_link(),get_comment_date(),get_comment_time() );
			edit_comment_link(__('Edit', 'blankslate'), ' <span class="meta-sep"> | </span> <span class="edit-link">', '</span>'); ?>
			</div>
			<?php if ($comment->comment_approved == '0') { echo '\t\t\t\t\t<span class="unapproved">';
			_e('Your trackback is awaiting moderation.', 'blankslate'); echo '</span>\n'; } ?>
			<div class="comment-content">
			<?php comment_text() ?></div><?php
			}
			// Custom WordPress Login Logo

			function login_css() {
			wp_enqueue_style( 'login_css', get_template_directory_uri() . '/css/login.css' );
			}

			// Disqus comments
			function disqus_count($disqus_shortname) {
			wp_enqueue_script('disqus_count','http://'.$disqus_shortname.'.disqus.com/count.js');
			echo '<a href="'. get_permalink() .'#disqus_thread"></a>';
			}

			// Enable certain WordPress features and add custom image thumbnail sizes
			function new_excerpt_more( $more ) {
			return '....';
			}
			add_filter('excerpt_more', 'new_excerpt_more');

			add_action('login_head', 'login_css');
			add_theme_support('post-thumbnails');
			add_image_size( 'resortmain', 1024, 682, true );
			add_image_size( 'resortmain_lgthumb', 600, 401, true);
			add_image_size( 'resortmain_thumb', 400, 267, true);
			if (class_exists('MultiPostThumbnails')) {
			$thumb1 = new MultiPostThumbnails(array(
			'label' => 'Small Image 1',
			'id' => 'resortthumbs',
			'post_type' => 'vacations'
			)
			);
			$thumb2 = new MultiPostThumbnails(array(
			'label' => 'Small Image 2',
			'id' => 'resortthumbs2',
			'post_type' => 'vacations'
			)
			);
			$thumb3 = new MultiPostThumbnails(array(
			'label' => 'Small Image 3',
			'id' => 'resortthumbs3',
			'post_type' => 'vacations'
			)
			);
			}

			// Add vacation type in WP Dashboard
			add_image_size( 'resortthumbs-img', 500, 337, true);
			add_action('init', 'vacation_register');
			function vacation_register() {
			$labels = array(
			'name' => _x('Vacations', 'post type general name'),
			'singular_name' => _x('Vacation', 'post type singular name'),
			'add_new' => _x('Add New', 'vacation'),
			'add_new_item' => __('Add New Vacation'),
			'edit_item' => __('Edit Vacation'),
			'new_item' => __('New Vacation'),
			'view_item' => __('View Vacation'),
			'search_items' => __('Search Vacations'),
			'not_found' => __('No vacations found'),
			'not_found_in_trash' => __('No vacations found in Trash'),
			'parent_item_colon' => '' );

			$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/resorticon.png',
			'rewrite' => array('slug' => 'vacations', 'with_front' => false),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 4,
			'has_archive' => true,
			'supports' => array('title','editor','thumbnail','revisions')
			);

			register_post_type( 'vacations' , $args );
			}

			// Make vacation taxonomies (categories, custom post types)
			add_action( 'init', 'make_vacation_taxonomies', 0 );

			function make_vacation_taxonomies() {
			register_taxonomy(
			"company",
			array('vacations'),
			array(
 			'hierarchical' => true,
 			'label' => 'Company',
 			'query_var' => true,
 			'rewrite' => array( 'slug' => 'co', 'with_front' => false ),
			)
			);

			register_taxonomy(
			"vacationtype",
			array('vacations'),
			array(
			"hierarchical" => true,
			"label" => "Vacation Types",
			"singular_label" => "Vacation Type",
			"rewrite" => array('slug' => 'land', 'with_front' => false)
			)
			);

			register_taxonomy(
			"destinations",
			array('vacations'),
			array(
			"hierarchical" => true,
			"label" => "Destinations",
			"singular_label" => "Destination",
			'query_var' => 'destinations',
			"rewrite" => array('slug' => 'destinations', 'with_front' => false),
			)
			);
			}

			add_action("admin_init", "admin_init");
			function admin_init(){
			add_meta_box("important_point-meta",
			"Important Point", "important_point",
			"vacations", "normal", "low")
			;

			// Add fields in WP Dashboard
			add_meta_box("otherinfo_meta",
			"Amenities / Includes",
			"otherinfo_meta",
			"vacations",
			"normal",
			"low");

			add_meta_box("rating_meta", "Star Rating", "rating_meta", "vacations", "normal", "low");

			add_meta_box("bookonlinebtn_meta", "Can this vacation be booked online?", "bookonlinebtn_meta", "vacations", "normal", "low");

			add_meta_box("onhomepage_meta", "Feature this vacation on the home page?", "onhomepage_meta", "vacations", "normal", "low");

			}

			// Descriptions in Wordpress Vacation post edit page
			function important_point(){
			global $post; $custom = get_post_custom($post->ID);
			$important_point = $custom["important_point"][0];
			?>
			<label><i>Example: "All Inclusive" or "Best Resort in Cancun"</i></label><br /><br />
			<input size="50" name="important_point" value="<?php echo $important_point; ?>" />
			<?php
			}
			function otherinfo_meta() {
			global $post; $custom = get_post_custom($post->ID);
			$amenities = $custom["amenities"][0];
			?>
			<p><label><i>Be sure to press ENTER after every amenity, and DO NOT include bullet points!<br /><br />
			Example:<br />Swim-up Bar<br />Tennis Courts<br />Free WiFi</i></label>
			<br /><br /><textarea cols="100" rows="7" name="amenities"><?php echo $amenities; ?></textarea></p>
			<?php }

			function rating_meta() {
			global $post; $custom = get_post_custom($post->ID);
			$selected = isset( $custom['rating'] ) ? esc_attr( $custom['rating'][0] ) : '';
			?>
			<p>	<label>Rating: </label>
			<select name="rating" id="rating">
			<option value="Option 4" <?php selected( $selected, 'Option 4' ); ?>>6 Apples (Golden)</option>
			<option value="Option 8" <?php selected( $selected, 'Option 8' ); ?>>6 Apples</option>
			<option value="Option 9" <?php selected( $selected, 'Option 9' ); ?>>5 Apples (Golden)</option>
			<option value="Option 3" <?php selected( $selected, 'Option 3' ); ?>>5 Apples</option>
			<option value="Option 10" <?php selected( $selected, 'Option 10' ); ?>>4 Apples (Golden)</option>
			<option value="Option 2" <?php selected( $selected, 'Option 2' ); ?>>4 Apples</option>
			<option value="Option 1" <?php selected( $selected, 'Option 1' ); ?>>3 Apples</option>
			<option value="Option 7" <?php selected( $selected, 'Option 7' ); ?>>5 Stars</option>
			<option value="Option 6" <?php selected( $selected, 'Option 6' ); ?>>4 Stars</option>
			<option value="Option 5" <?php selected( $selected, 'Option 5' ); ?>>3 Stars</option>
			<option value="Option 11" <?php selected( $selected, 'Option 11' ); ?>>Collette Tour</option>
			</select>


			<?php }

			function bookonlinebtn_meta() {
			global $post; $custom = get_post_custom($post->ID);
			$selected = isset( $custom['bookonlinebtn'] ) ? esc_attr( $custom['bookonlinebtn'][0] ) : '';
			?>
			<p>	<label></label>
			<select name="bookonlinebtn" id="bookonlinebtn">
			<option value="Yes" <?php selected( $selected, 'Yes' ); ?>>Yes (if not sure, keep this selected)</option>
			<option value="No" <?php selected( $selected, 'No' ); ?>>No</option>
			</select>



			<?php }

			function onhomepage_meta() {
			global $post; $custom = get_post_custom($post->ID);
			$selected = isset( $custom['onhomepage'] ) ? esc_attr( $custom['onhomepage'][0] ) : '';
			?>
			<p>	<label></label>
			<select name="onhomepage" id="onhomepage">
			<option value="No" <?php selected( $selected, 'No' ); ?>>No (if not sure, keep this selected)</option>
			<option value="Yes" <?php selected( $selected, 'Yes' ); ?>>Yes</option>
			</select>


			<?php
			}
			add_action('save_post', 'save_details');
			function save_details(){
			global $post;
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
			} else {
			update_post_meta($post->ID, "important_point", $_POST["important_point"]);
			update_post_meta($post->ID, "amenities", $_POST["amenities"]);
			update_post_meta( $post->ID, 'rating', esc_attr( $_POST['rating'] ));
			update_post_meta( $post->ID, 'bookonlinebtn', esc_attr( $_POST['bookonlinebtn'] ));
			update_post_meta( $post->ID, 'onhomepage', esc_attr( $_POST['onhomepage'] ));
			}
			}

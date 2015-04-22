<?php
/**
* Plugin Name: Super Advanced Posts  
* Plugin URI: http://www.finestdeveloper.com/plugins/super-advanced-posts  
* Description: Adds a widget that can display recent posts and other posts from All categories and taxonomy or from custom post types.
* Version: 2.1 
* Author: Tarun Yaduvanshi
* Author URI: http://www.finestdeveloper.com
*/

include('include/admin-function.php');

class super_advanced_posts extends WP_Widget {

function __construct() {
$widget_ops = array(
'classname'   => 'super_advanced_posts', 
'description' => __('Adds a widget that can display recent posts and other posts from all categories and taxonomy or from custom post types.
')
);
parent::__construct('super_advanced_posts', __('Super Advanced Posts'), $widget_ops);
}

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$post_typess = apply_filters( 'widget_post_type', $instance['post_type'] );
$taxtermin = apply_filters( 'widget_taxcatin', $instance['taxcatin'] );
$taxcatin = apply_filters( 'widget_term', $instance['taxtermin'] );
$showposts = apply_filters( 'widget_showposts', $instance['showposts'] );
$order = apply_filters( 'widget_order', $instance['order'] );
$orderby = apply_filters( 'widget_orderby', $instance['orderby'] );
$thumbnail = apply_filters( 'widget_thumbnail', $instance['thumbnail'] );
$imagesize = apply_filters( 'widget_imagesize', $instance['imagesize'] );
$date = apply_filters( 'widget_date', $instance['date'] );
$excerpt = apply_filters( 'widget_excerpt', $instance['excerpt'] );
$excerpt_length = apply_filters( 'widget_excerpt_length', $instance['excerpt_length'] );
$readmore = apply_filters( 'widget_readmore', $instance['readmore'] );
$excerpt_readmore = apply_filters( 'widget_excerpt_readmore', $instance['excerpt_readmore'] );
$comment_num = apply_filters( 'widget_comment_num', $instance['comment_num'] );



$new_excerpt_more= create_function('$more', 'return " ";');	
add_filter('excerpt_more', $new_excerpt_more);


$new_excerpt_length = create_function('$length', "return " . $excerpt_length . ";");

if ( $instance["excerpt_length"] > 0 ) add_filter('excerpt_length', $new_excerpt_length);

echo $args['before_widget'];


if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];



include('include/frent-structure.php');


echo $args['after_widget'];

remove_filter('excerpt_length', $new_excerpt_length);
remove_filter('excerpt_more', $new_excerpt_more);

}

public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'super_advanced_posts_domain' );
}

if ( isset( $instance[ 'post_type' ] ) ) {
$post_typess = $instance[ 'post_type' ];
}


if ( isset( $instance[ 'taxcatin' ] ) ) {
$taxcatin = $instance[ 'taxcatin' ];
}

if ( isset( $instance[ 'taxtermin' ] ) ) {
$taxtermin = $instance[ 'taxtermin' ];
}


if ( isset( $instance[ 'showposts' ] ) ) {
$showposts = $instance[ 'showposts' ];
}

if ( isset( $instance[ 'orderby' ] ) ) {
$orderby = $instance[ 'orderby' ];
}

if ( isset( $instance[ 'order' ] ) ) {
$order = $instance[ 'order' ];
}

if ( isset( $instance[ 'thumbnail' ] ) ) {
$thumbnail = $instance[ 'thumbnail' ];
}

if ( isset( $instance[ 'imagesize' ] ) ) {
$imagesize = $instance[ 'imagesize' ];
}

if ( isset( $instance[ 'date' ] ) ) {
$date = $instance[ 'date' ];
}


if ( isset( $instance[ 'excerpt' ] ) ) {
$excerpt = $instance[ 'excerpt' ];
}

if ( isset( $instance[ 'excerpt_length' ] ) ) {
$excerpt_length = $instance[ 'excerpt_length' ];
}

if ( isset( $instance[ 'readmore' ] ) ) {
$readmore = $instance[ 'readmore' ];
}

if ( isset( $instance[ 'excerpt_readmore' ] ) ) {
$excerpt_readmore = $instance[ 'excerpt_readmore' ];
}

if ( isset( $instance[ 'comment_num' ] ) ) {
$comment_num = $instance[ 'comment_num' ];
}

// Widget admin form

echo '<p>';
echo '<label  for='. $this->get_field_id( "title" ). _e( 'Title:' ) .'></label> ';
echo '<input class="widefat"  id="'.$this->get_field_id( 'title' ). '" name="' .$this->get_field_name( 'title' ). '" type="text" value="'. esc_attr( $title ).'" />';
?>
</p>

<p>
  <label for="<?php echo $this->get_field_id('show_type'); ?>">
    <?php _e('Show Post Type:');?>
    <select class="widefat" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
      <?php
global $wp_post_types;
foreach($wp_post_types as $pvalue=>$pvaluelabel) {
if($pvaluelabel->exclude_from_search) continue;
echo '<option value="' . $pvalue . '"' . selected($pvalue,$post_typess ,true) . '>' . $pvaluelabel->labels->name . '</option>';
}
?>
    </select>
  </label>
</p>

<p>
  <label for="<?php echo $this->get_field_id( 'showposts' ); ?>">
    <?php _e( 'Number of Show Posts:' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'showposts' ); ?>" name="<?php echo $this->get_field_name( 'showposts' ); ?>" type="text" value="

<?php  $pshowpost = esc_attr( $showposts );

if($pshowpost == '') {
$pshowposts = 10;
} else {
$pshowposts = $pshowpost;
}  echo $pshowposts; ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'orderby' ); ?>">
    <?php _e( 'Order By:' ); ?>
  </label>
  <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" >
    <?php 

$postorderby= array('title', 'author', 'date', 'rand');
foreach ( $postorderby as $orderby ) {
echo '<option ';
if($orderby == $instance[ 'orderby' ]) {
echo "selected ";
}
echo ' value='. esc_attr( $orderby ).' >' . esc_attr( $orderby ) . '</option >';
}?>
  </select>
  <label for="<?php echo $this->get_field_id( 'order' ); ?>">
    <?php _e( 'Order:' ); ?>
  </label>
  <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" >
    <?php $postorder= array('asc', 'desc');
foreach ( $postorder as $order ) {
echo '<option ';
if($order == $instance[ 'order' ]) {
echo "selected ";
}
echo ' value='. esc_attr( $order ).' >' . esc_attr( $order ) . '</option >';
}?>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'thumbnail' ); ?>">
    <?php _e( 'Show Featue Image:' ); ?>
  </label>
  <input   class="thumbnailcheck"  value="thumbnailcheck" <?php $thumbnailcheck = 'thumbnailcheck';


if($thumbnailcheck == $instance[ 'thumbnail' ]) {
echo 'checked=checked';
}?> type="checkbox" id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" >
  <select class="widefat thumbnailimagesize" id="<?php echo $this->get_field_id( 'imagesize' ); ?>" name="<?php echo $this->get_field_name( 'imagesize' ); ?>" >
    <?php 

$imagesizes= array('thumbnail', 'medium', 'large','thumbnail_80*80','thumbnail_50*50');

foreach ( $imagesizes as $imagesize ) { 
echo '<option ';
if($imagesize == $instance[ 'imagesize' ]) {
echo "selected=selected";
}
echo ' value='. esc_attr( $imagesize ).' >' . esc_attr( $imagesize ) . '</option >';
}

?>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id("date"); ?>">
    <input type="checkbox" class="checkbox " id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php checked( (bool) $instance["date"], true ); ?> />
    <?php _e( 'Include Post Date' ); ?>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id("excerpt"); ?>">
    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>" name="<?php echo $this->get_field_name("excerpt"); ?>"<?php checked( (bool) $instance["excerpt"], true ); ?> />
    <?php _e( 'Include Post Excerpt Content' ); ?>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id("excerpt_length"); ?>">
    <?php _e( 'Excerpt Content length (in words):' ); ?>
  </label>
  <input style="text-align: center;" type="text" id="<?php echo $this->get_field_id("excerpt_length"); ?>" name="<?php echo $this->get_field_name("excerpt_length"); ?>" value="<?php if($excerpt_length  ==''){_e('10');}else{echo $excerpt_length; }?>" size="3" />
</p>
<p>
  <label for="<?php echo $this->get_field_id("readmore"); ?>">
    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("readmore"); ?>" name="<?php echo $this->get_field_name("readmore"); ?>"<?php checked( (bool) $instance["readmore"], true ); ?> />
    <?php _e( 'Include Read More Link in Excerpt Content' ); ?>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id("excerpt_readmore"); ?>">
    <?php _e( 'Excerpt Read More Text:' ); ?>
  </label>
  <input style="text-align: center;" type="text" id="<?php echo $this->get_field_id("excerpt_readmore"); ?>" name="<?php echo $this->get_field_name("excerpt_readmore"); ?>" value="<?php if($excerpt_readmore == ''){_e('Read more &rarr;');}else{ echo $excerpt_readmore; }?>" size="10" />
</p>
<p>
  <label for="<?php echo $this->get_field_id("comment_num"); ?>">
    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>" name="<?php echo $this->get_field_name("comment_num"); ?>"<?php checked( (bool) $instance["comment_num"], true ); ?> />
    <?php _e( 'Show Number of Comments' ); ?>
  </label>
</p>


 
<?php }
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? strip_tags( $new_instance['post_type'] ) : '';
$instance['taxcatin'] = ( ! empty( $new_instance['taxcatin'] ) ) ? strip_tags( $new_instance['taxcatin'] ) : '';
$instance['taxtermin'] = ( ! empty( $new_instance['taxtermin'] ) ) ? strip_tags( $new_instance['taxtermin'] ) : '';
$instance['showposts'] = ( ! empty( $new_instance['showposts'] ) ) ? strip_tags( $new_instance['showposts'] ) : '';
$instance['order'] = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
$instance['thumbnail'] = ( ! empty( $new_instance['thumbnail'] ) ) ? strip_tags( $new_instance['thumbnail'] ) : '';
$instance['imagesize'] = ( ! empty( $new_instance['imagesize'] ) ) ? strip_tags( $new_instance['imagesize'] ) : '';
$instance['date'] = ( ! empty( $new_instance['date'] ) ) ? strip_tags( $new_instance['date'] ) : '';

$instance['excerpt'] = ( ! empty( $new_instance['excerpt'] ) ) ? strip_tags( $new_instance['excerpt'] ) : '';
$instance['excerpt_length'] = ( ! empty( $new_instance['excerpt_length'] ) ) ? strip_tags( $new_instance['excerpt_length'] ) : '';
$instance['readmore'] = ( ! empty( $new_instance['readmore'] ) ) ? strip_tags( $new_instance['readmore'] ) : '';
$instance['excerpt_readmore'] = ( ! empty( $new_instance['excerpt_readmore'] ) ) ? strip_tags( $new_instance['excerpt_readmore'] ) : '';
$instance['comment_num'] = ( ! empty( $new_instance['comment_num'] ) ) ? strip_tags( $new_instance['comment_num'] ) : '';

return $instance;
}
} 
function wpb_load_widget() {
register_widget( 'super_advanced_posts' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
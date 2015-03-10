<?php 
query_posts('orderby='.$orderby.'&order='.$order.'&post_type='.$post_typess.'&showposts='.$showposts.''); 

echo '<ul >';
while (have_posts()) : the_post(); 
echo '<li class="post-item">
';

?>

<a class="post-title" href="<?php echo get_permalink(); ?>">
<?php the_title(); ?>
</a>
<?php if ( $instance['date'] ) : ?>
<p class="post-date">
  <?php the_time("j M Y"); ?>
</p>
<?php endif; ?>
<div class="post-entry">
  <?php

if ( has_post_thumbnail() ) {
if($thumbnailcheck != $thumbnail){
$post_id=get_the_ID();
echo '<a href="'. get_permalink().'">';
the_post_thumbnail( esc_attr( $instance[ 'imagesize' ] ) );  
echo '</a>';
} 
}

if ( $instance['excerpt'] ) : ?>
  <?php if ( $instance['readmore'] ) : $linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>'; else: $linkmore =''; endif; ?>
  <p><?php echo get_the_excerpt().$linkmore; ?> </p>
  <?php endif; ?>
</div>
<?php if ( $instance['comment_num'] ) : ?>
<p class="comment-num">(
  <?php comments_number(); ?>
  )</p>
<?php endif; 


echo '</li>';

endwhile;
echo '</ul>';
wp_reset_query();
?>

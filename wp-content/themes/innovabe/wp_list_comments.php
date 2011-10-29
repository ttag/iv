<?php

function custom_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="gravatar">
      	<?php echo get_avatar($comment,$size='48',$default='' ); ?>
      	<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
      <div class='comment_content'>
      <?php printf(__('<cite class="author_name heading">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
      <?php edit_comment_link(__('(Edit)'),'  ','') ?>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="comment-meta commentmetadata">
      <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>
      </div>
	  <div class='comment_text'>
      <?php comment_text() ?>
	  </div>

      </div>
     </div>
<?php
        }

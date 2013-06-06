<?php
    $removed_text = "<p>This {$comment_type} has been removed.</p>";
?>
<li class="comment clearfix<?php echo $container_class; ?>" id="<?php echo $comment_type.'-reply-'.$comment->comment_ID ?>">
    <?php 
    if($comment->comment_approved == 1) {
        get_partial( 'parts/crest', array( "user_id" => $comment->user_id, "width" => "span2" ) );
    }	
    ?>
    <div class="span10">
        <article class="content-container">
            <section class="content-body clearfix">
                <div class="content-details clearfix">
                    <time class="content-date" pubdate datetime="<?php echo date( "Y-m-d", $date ); ?>">
                        <?php echo date( "F j, Y", $date ); ?>
                        <span class="time-stamp"><?php echo date( "g:ia", $date ); ?></span>
                    </time>
                </div>
                <?php echo ($comment->comment_approved == 1) ? wpautop($comment->comment_content) : $removed_text; ?>
            </section>
        </article> <!-- END ARTICLE CONTENT CONTAINER -->
    
        <div class="clearfix"></div>
    </div> <!-- END SPAN10 -->
    <?php print_r($comment); ?>
</li>
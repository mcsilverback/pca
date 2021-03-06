<?php get_header(); ?>
    
    <div class="post-title col-full">
    
		<div class="fl event-name">
		
			<h1 class="title"><?php the_title(); ?></h1>
			
		</div>
		
	</div>
    	
    <div id="content" class="page col-full">
		<div id="main" class="col-left">
		           
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
                <div class="post">

                    <div class="entry">
	                	<?php the_content(); ?>
	               	</div><!-- /.entry -->

					<?php edit_post_link( __('{ Edit }', 'woothemes'), '<span class="small">', '</span>' ); ?>
                    
                </div><!-- /.post -->
                
                <?php $comm = get_option('woo_comments'); if ( 'open' == $post->comment_status && ($comm == "page" || $comm == "both") ) : ?>
                    <?php comments_template(); ?>
                <?php endif; ?>
                                                    
			<?php endwhile; else: ?>
				<div class="post">
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
                </div><!-- /.post -->
            <?php endif; ?>  
        
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>
<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- WooTabs widget
- Flickr widget
- Ad widget
- Search widget
- Twitter widget
- Recent Blog Posts widget
- Featured Media widget
- Customer Feedback widget
- Blog Author widget
- Deregister Default Widgets 
- Overview Map widget

-----------------------------------------------------------------------------------*/



/*---------------------------------------------------------------------------------*/
/* WooTabs widget */
/*---------------------------------------------------------------------------------*/

class Woo_Tabs extends WP_Widget {

   function Woo_Tabs() {
  	   $widget_ops = array('description' => 'This widget is the Tabs that classicaly goes into the sidebar. It contains the Popular posts, Latest Posts, Recent comments and a Tag cloud.' );
       parent::WP_Widget(false, $name = __('Woo - Tabs', 'woothemes'), $widget_ops);    
   }


   function widget($args, $instance) {        
       extract( $args );
       
       $number = $instance['number']; if ($number == '') $number = 5;
       $thumb_size = $instance['thumb_size']; if ($thumb_size == '') $thumb_size = 35;
       ?>  

 		<div id="tabs" class="widget">
 		
 			<div class="outer">
 			<div class="inner">
           
            <ul class="wooTabs">
                <li class="popular"><a href="#tab-pop"><?php _e('Popular', 'woothemes'); ?></a></li>
                <li class="latest"><a href="#tab-latest"><?php _e('Latest', 'woothemes'); ?></a></li>
                <li class="comments"><a href="#tab-comm"><?php _e('Comments', 'woothemes'); ?></a></li>
                <li class="tags"><a href="#tab-tags"><?php _e('Tags', 'woothemes'); ?></a></li>
            </ul>
            
            <div class="clear"></div>
            
            <div class="boxes box inside">
                        
                <ul id="tab-pop" class="list">            
                    <?php if ( function_exists('woo_tabs_popular') ) woo_tabs_popular($number, $thumb_size); ?>                    
                </ul>
            
                <ul id="tab-latest" class="list">
                    <?php if ( function_exists('woo_tabs_latest') ) woo_tabs_latest($number, $thumb_size); ?>                    
                </ul>	
            
                <ul id="tab-comm" class="list">
                    <?php if ( function_exists('woo_tabs_comments') ) woo_tabs_comments($number, $thumb_size); ?>                    
                </ul>	
                
                <div id="tab-tags" class="list">
                    <?php wp_tag_cloud('smallest=12&largest=20'); ?>
                </div>
                
            </div><!-- /.boxes -->
			
			</div><!-- /inner -->
			</div><!-- /outer -->
			
        </div><!-- /wooTabs -->
    
         <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {                
       $number = esc_attr($instance['number']);
       $thumb_size = esc_attr($instance['thumb_size']);
	   
       ?>    
       <p>
       <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:','woothemes'); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
       </label>
       </p>  
       <p>
       <label for="<?php echo $this->get_field_id('thumb_size'); ?>"><?php _e('Thumbnail Size (0=disable):','woothemes'); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('thumb_size'); ?>" name="<?php echo $this->get_field_name('thumb_size'); ?>" type="text" value="<?php echo $thumb_size; ?>" />
       </label>
       </p>  
       <?php 
   }

} 
register_widget('Woo_Tabs');



/*---------------------------------------------------------------------------------*/
/* Flickr widget */
/*---------------------------------------------------------------------------------*/
class Woo_flickr extends WP_Widget {

	function Woo_flickr() {
		$widget_ops = array('description' => 'This Flickr widget populates photos from a Flickr ID.' );

		parent::WP_Widget(false, __('Woo - Flickr', 'woothemes'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
		$id = $instance['id'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];
		
		echo $before_widget;
		echo $before_title; ?>
		<?php _e('Photos on <span>flick<span>r</span></span>','woothemes'); ?>
        <?php echo $after_title; ?>
            
        <div class="wrap">
            <div class="fix"></div>
            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $sorting; ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type; ?>&amp;<?php echo $type; ?>=<?php echo $id; ?>"></script>        
            <div class="fix"></div>
        </div>

	   <?php			
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
		$id = esc_attr($instance['id']);
		$number = esc_attr($instance['number']);
		$type = esc_attr($instance['type']);
		$sorting = esc_attr($instance['sorting']);
		?>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
        </p>
       	<p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number:','woothemes'); ?></label>
            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
                <?php for ( $i = 1; $i < 10; $i += 1) { ?>
                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type:','woothemes'); ?></label>
            <select name="<?php echo $this->get_field_name('type'); ?>" class="widefat" id="<?php echo $this->get_field_id('type'); ?>">
                <option value="user" <?php if($type == "user"){ echo "selected='selected'";} ?>><?php _e('User', 'woothemes'); ?></option>
                <option value="group" <?php if($type == "group"){ echo "selected='selected'";} ?>><?php _e('Group', 'woothemes'); ?></option>            
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sorting'); ?>"><?php _e('Sorting:','woothemes'); ?></label>
            <select name="<?php echo $this->get_field_name('sorting'); ?>" class="widefat" id="<?php echo $this->get_field_id('sorting'); ?>">
                <option value="latest" <?php if($sorting == "latest"){ echo "selected='selected'";} ?>><?php _e('Latest', 'woothemes'); ?></option>
                <option value="random" <?php if($sorting == "random"){ echo "selected='selected'";} ?>><?php _e('Random', 'woothemes'); ?></option>            
            </select>
        </p>
		<?php
	}
} 

register_widget('woo_flickr');


/*---------------------------------------------------------------------------------*/
/* Ad Widget */
/*---------------------------------------------------------------------------------*/

class Woo_AdWidget extends WP_Widget {

	function Woo_AdWidget() {
		$widget_ops = array('description' => 'Use this widget to add any type of Ad as a widget.' );
		parent::WP_Widget(false, __('Woo - Adspace Widget', 'woothemes'),$widget_ops);      
	}

	function widget($args, $instance) {  
		$title = $instance['title'];
		$adcode = $instance['adcode'];
		$image = $instance['image'];
		$href = $instance['href'];
		$alt = $instance['alt'];

        echo '<div class="adspace-widget widget">';

		if($title != '')
			echo '<h3>'.$title.'</h3>';

		if($adcode != ''){
		?>
		
		<?php echo $adcode; ?>
		
		<?php } else { ?>
		
			<a href="<?php echo $href; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $alt; ?>" /></a>
	
		<?php
		}
		
		echo '</div>';

	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	function form($instance) {        
		$title = esc_attr($instance['title']);
		$adcode = esc_attr($instance['adcode']);
		$image = esc_attr($instance['image']);
		$href = esc_attr($instance['href']);
		$alt = esc_attr($instance['alt']);
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('adcode'); ?>"><?php _e('Ad Code:','woothemes'); ?></label>
            <textarea name="<?php echo $this->get_field_name('adcode'); ?>" class="widefat" id="<?php echo $this->get_field_id('adcode'); ?>"><?php echo $adcode; ?></textarea>
        </p>
        <p><strong>or</strong></p>
        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Image Url:','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $image; ?>" class="widefat" id="<?php echo $this->get_field_id('image'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('href'); ?>"><?php _e('Link URL:','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('href'); ?>" value="<?php echo $href; ?>" class="widefat" id="<?php echo $this->get_field_id('href'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Alt text:','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('alt'); ?>" value="<?php echo $alt; ?>" class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" />
        </p>
        <?php
	}
} 

register_widget('Woo_AdWidget');


/*---------------------------------------------------------------------------------*/
/* Search widget */
/*---------------------------------------------------------------------------------*/
class Woo_Search extends WP_Widget {

   function Woo_Search() {
	   $widget_ops = array('description' => 'This is a WooThemes standardized search widget.' );
       parent::WP_Widget(false, __('Woo - Search', 'woothemes'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );
   	$title = $instance['title'];
	?>
		<?php echo $before_widget; ?>
        <?php if ($title) { echo $before_title . $title . $after_title; } ?>
        <?php include(TEMPLATEPATH . '/search-form.php'); ?>
		<?php echo $after_widget; ?>   
   <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
       $title = esc_attr($instance['title']);
       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','woothemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
      <?php
   }
} 

register_widget('Woo_Search');


/*---------------------------------------------------------------------------------*/
/* Twitter widget */
/*---------------------------------------------------------------------------------*/
class Woo_Twitter extends WP_Widget {

   function Woo_Twitter() {
	   $widget_ops = array('description' => 'Add your Twitter feed to your sidebar with this widget.' );
       parent::WP_Widget(false, __('Woo - Twitter Stream', 'woothemes'),$widget_ops);      
   }
   
   function widget($args, $instance) {  
    extract( $args );
   	$title = $instance['title'];
    $limit = $instance['limit']; if (!$limit) $limit = 5;
	$username = $instance['username'];
	$unique_id = $args['widget_id'];
	?>
		<?php echo $before_widget; ?>
        <?php if ($title) echo $before_title . $title . $after_title; ?>
        <ul id="twitter_update_list_<?php echo $unique_id; ?>"><li></li></ul>	
        <?php echo woo_twitter_script($unique_id,$username,$limit); //Javascript output function ?>	 
        <?php echo $after_widget; ?>
        
   		
	<?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
       $title = esc_attr($instance['title']);
       $limit = esc_attr($instance['limit']);
	   $username = esc_attr($instance['username']);
       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','woothemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:','woothemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('username'); ?>"  value="<?php echo $username; ?>" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:','woothemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('limit'); ?>"  value="<?php echo $limit; ?>" class="" size="3" id="<?php echo $this->get_field_id('limit'); ?>" />

       </p>
      <?php
   }
   
} 
register_widget('Woo_Twitter');


/*---------------------------------------------------------------------------------*/
/* Recent Blog Posts Widget */
/*---------------------------------------------------------------------------------*/

class Woo_RecentBlogPosts extends WP_Widget {

	function Woo_RecentBlogPosts() {
		$widget_ops = array('description' => 'Use this widget to add your most recent blog posts as a widget.' );
		parent::WP_Widget(false, __('Woo - Recent Blog Posts Widget', 'woothemes'),$widget_ops);      
	}

	function widget($args, $instance) {  
		$title = $instance['title'];
		$numposts = $instance['numposts'];
		$blogcategory = $instance['blogcategory'];

        ?><div class="recentblogposts-widget widget"><?php
			if($title != '') {
			?><h3><?php _e($title,'woothemes'); ?></h3><?php
			}
			if(isset($numposts)) {
			} else {
				$numposts = 3;
			} ?>
			<div class="outer">
				<div class="inner">	
       				<ul class="pagination">
       				<?php $category_id = get_cat_ID( $blogcategory ); ?>
					<?php query_posts('cat='.$category_id.'&orderby=date&order=DESC&showposts='.$numposts);?>
					<?php while (have_posts()) : the_post();  $GLOBALS['shownposts'][$count] = $post->ID; $count++; ?>
            			<li>
							<?php woo_get_image('image',48,48,'thumbnail',90,$post->ID,'img'); ?>                
                    		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    		<span class="meta"><?php _e('Posted on ','woothemes'); ?><?php the_time(get_option('date_format')); ?></span>
                			<div style="clear:both"></div>
           				</li>
          			<?php endwhile; ?>      
        			</ul>      
				</div>
				<ul class="pagination">
					<li class="active">
					<a href="<?php echo get_category_link($category_id); ?>"><?php _e('View more blog posts in the archive ','woothemes'); ?></a>
					</li>
				</ul>
			</div>
		</div>
		
		<?php
	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	function form($instance) {        
		$title = esc_attr($instance['title']);
		$numposts = esc_attr($instance['numposts']);
		$blogcategory = esc_attr($instance['blogcategory']);

		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('numposts'); ?>"><?php _e('Number of Posts:','woothemes'); ?></label>
           	<input type="text" name="<?php echo $this->get_field_name('numposts'); ?>" value="<?php echo $numposts; ?>" class="widefat" id="<?php echo $this->get_field_id('numposts'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('blogcategory'); ?>"><?php _e('Blog Category:','woothemes'); ?></label>
            <?php 
            //Access the WordPress Categories via an Array
			$woo_categories = array();  
			$woo_categories_obj = get_categories('hide_empty=0');
			foreach ($woo_categories_obj as $woo_cat) {
    			$woo_categories[$woo_cat->cat_ID] = $woo_cat->cat_name;}
			$categories_tmp = array_unshift($woo_categories, "Select a category:");   
            ?>
            <select id="<?php echo $this->get_field_id('blogcategory'); ?>" name="<?php echo $this->get_field_name('blogcategory'); ?>">
			<?php 
			//DISPLAY SELECT OPTIONS
			foreach ($woo_categories as $woo_category) {
				if ($blogcategory == $woo_category) {
					$selected_option = 'selected="selected"';
				} else {
					$selected_option = '';
				} ?>
				<option value="<?php echo $woo_category; ?>" <?php echo $selected_option; ?>><?php echo $woo_category; ?></option>
				<?php
			} ?>
			</select>  
        </p>
        <?php
	}
} 

register_widget('Woo_RecentBlogPosts');
	
/*---------------------------------------------------------------------------------*/
/* Featured Media Widget */
/*---------------------------------------------------------------------------------*/

class Woo_FeaturedMedia extends WP_Widget {

	function Woo_FeaturedMedia() {
		$widget_ops = array('description' => 'Use this widget to add Featured Media as a widget.' );
		parent::WP_Widget(false, __('Woo - Featured Media Widget', 'woothemes'),$widget_ops);      
	}

	function widget($args, $instance) {  
		$title = $instance['title'];
		$numposts = $instance['numposts'];
		$featuredvideo = $instance['featuredvideo'];
		$featuredimages = $instance['featuredimages'];
		$featuredaudio = $instance['featuredaudio'];
		
        ?><div class="recentblogposts-widget widget"><?php
			if($title != '') {
			?><h3><?php _e($title,'woothemes'); ?></h3><?php
			}
			if(isset($numposts)) {
			} else {
				$numposts = 3;
			} 
			if(isset($featuredvideo)) {
				$tags .= $featuredvideo;
			}
			if(isset($featuredimages)) {
				$tags .= ','.$featuredimages;
			} 
			if(isset($featuredaudio)) {
				$tags .= ','.$featuredaudio;
			} ?>
			<div class="outer">
				<div class="inner">	
		
       				<ul class="pagination">
 					<?php query_posts('tag='.$tags.'&orderby=date&order=DESC&showposts='.$numposts);?>
					<?php while (have_posts()) : the_post();  $GLOBALS['shownposts'][$count] = $post->ID; $count++; ?>
            			<li>
							<div class="fl">
								<?php 
								$posttags = get_the_tags();
								foreach ($posttags as $posttag) {
									if ($posttag) {
										if (strtolower($posttag->name) == strtolower($featuredvideo)) {
										?><img src="<?php echo get_bloginfo('template_directory'); ?>/images/ico-media-video.png" alt="video" title="Video" /><?php 
										} elseif (strtolower($posttag->name) == strtolower($featuredimages)) {
										?><img src="<?php echo get_bloginfo('template_directory'); ?>/images/ico-media-photo.png" alt="image" title="Image" /><?php 
										} elseif (strtolower($posttag->name) == strtolower($featuredaudio)) {
										?><img src="<?php echo get_bloginfo('template_directory'); ?>/images/ico-media-audio.png" alt="audio" title="Audio" /><?php 
										} else {
										}
									}
								}
								?>
							</div>
							<div class="fl">
	                    		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                    		<span class="meta"><?php the_time(get_option('date_format')); ?></span>
                    		</div>
                			<div style="clear:both"></div>
           				</li>
          			<?php endwhile; ?>      
        			</ul>      
				</div>
			</div>
		</div><?php
	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	function form($instance) {        
		$title = esc_attr($instance['title']);
		$numposts = esc_attr($instance['numposts']);
		$featuredvideo = esc_attr($instance['featuredvideo']);
		$featuredimages = esc_attr($instance['featuredimages']);
		$featuredaudio = esc_attr($instance['featuredaudio']);
		
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('numposts'); ?>"><?php _e('Number of Posts:','woothemes'); ?></label>
           	<input type="text" name="<?php echo $this->get_field_name('numposts'); ?>" value="<?php echo $numposts; ?>" class="widefat" id="<?php echo $this->get_field_id('numposts'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('featuredvideo'); ?>"><?php _e('Videos Tag:','woothemes'); ?></label>
           	<input type="text" name="<?php echo $this->get_field_name('featuredvideo'); ?>" value="<?php echo $featuredvideo; ?>" class="widefat" id="<?php echo $this->get_field_id('featuredvideo'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('featuredimages'); ?>"><?php _e('Images Tag:','woothemes'); ?></label>
           	<input type="text" name="<?php echo $this->get_field_name('featuredimages'); ?>" value="<?php echo $featuredimages; ?>" class="widefat" id="<?php echo $this->get_field_id('featuredimages'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('featuredaudio'); ?>"><?php _e('Audio Tag:','woothemes'); ?></label>
           	<input type="text" name="<?php echo $this->get_field_name('featuredaudio'); ?>" value="<?php echo $featuredaudio; ?>" class="widefat" id="<?php echo $this->get_field_id('featuredaudio'); ?>" />
        </p>
        <?php
	}
} 

register_widget('Woo_FeaturedMedia');

/*---------------------------------------------------------------------------------*/
/* Customer Feedback Widget */
/*---------------------------------------------------------------------------------*/

class Woo_CustomerFeedback extends WP_Widget {

	function Woo_CustomerFeedback() {
		$widget_ops = array('description' => 'Use this widget to add your Customer Feedback as a widget.' );
		parent::WP_Widget(false, __('Woo - Customer Feedback Widget', 'woothemes'),$widget_ops);      
	}

	function widget($args, $instance) {  
		$title = $instance['title'];
		$customerquote = $instance['customerquote'];
		$customername = $instance['customername'];
		$customerlink = $instance['customerlink'];
		$upload = $instance['upload'];
		
        ?><div class="feedback-widget widget"><?php
			if($title != '') {
			?><h3><?php _e($title,'woothemes'); ?></h3><?php
			}
			 
			 ?>
			 
			<div class="outer">
				<div class="inner">	
					
					<div class="customer-quote"><em><?php echo $customerquote; ?></em></div>
					<div class="customer-details">
						<div class="customer-name">
							<h4><?php echo $customername; ?></h4>
							<a href="http://<?php echo str_replace('http://','',$customerlink); ?>" target="_blank"><?php echo $customerlink; ?></a>
						</div>

       				<?php if (isset($upload) && $upload != '') { ?><div class="customer-image"><img src="<?php echo $upload; ?>" alt="Customer Image" width="40" /></span></div><?php } ?>

       				</div>
       				
       				<div class="fix"></div>
       				     
				</div>
				
			</div>
		</div><?php
	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	function form($instance) {        
		$title = esc_attr($instance['title']);
		$customerquote = esc_attr($instance['customerquote']);
		$customername = esc_attr($instance['customername']);
		$customerlink = esc_attr($instance['customerlink']);
		$upload = esc_attr($instance['upload']);
		?>
		<script type="text/javascript">jQuery(document).ready(function(){ setupAdUploaders(); });</script>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('customerquote'); ?>"><?php _e('Customer Quote:','woothemes'); ?></label>
           	<textarea id="<?php echo $this->get_field_id('customerquote'); ?>" name="<?php echo $this->get_field_name('customerquote'); ?>" class="widefat"><?php echo $customerquote; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('customername'); ?>"><?php _e('Customer Name:','woothemes'); ?></label>
           	<input type="text" name="<?php echo $this->get_field_name('customername'); ?>" value="<?php echo $customername; ?>" class="widefat" id="<?php echo $this->get_field_id('customername'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('customerlink'); ?>"><?php _e('Customer Website:','woothemes'); ?></label>
           	<input type="text" name="<?php echo $this->get_field_name('customerlink'); ?>" value="<?php echo $customerlink; ?>" class="widefat" id="<?php echo $this->get_field_id('customerlink'); ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('upload'); ?>"><?php _e('Upload Customer Image','woothemes'); ?></label>
        <input type="text" name="<?php echo $this->get_field_name('upload'); ?>" value="<?php echo $upload; ?>" class="widefat upload-box" />
        <span class="button widget_image_upload_button" id="<?php echo $this->get_field_id('upload'); ?>">Upload Image</span>
        <?php if(!empty($upload)) { echo "<img class='woo-upload-start-image' id='image_". $this->get_field_id('upload') ."' src='". $upload . "' width='75' />"; } ?>
        </p>
        <?php
	}
} 

register_widget('Woo_CustomerFeedback');

add_action('admin_head', 'woo_widget_customer_feedback_head');

function woo_widget_customer_feedback_head() { 
	?>
    <style type="text/css">
		.woo-upload-nav { height:30px; margin-top:10px; }
		.woo-upload-nav li { float:left}
		.woo-upload-nav li.active a { background: #fff; color: #333 }
		.woo-upload-nav li  a { text-decoration: none;float:left;  width:25px; text-align:center; padding:4px 0; margin-right:4px; background:#f8f8f8; border:1px solid #e7e7e7; border-radius: 8px; 	-moz-border-radius:8px; -webkit-border-radius: 8px; }
		.woo-upload-crop { width:225px; overflow:hidden;border-top:dashed #ccc 1px; margin-top:10px;}
		.woo-upload-holder { width:9000px; }
		.woo-upload-piece { float:left; width:215px; padding:0 5px}
		.upload-box {margin-bottom:10px}
		.woo-upload-start-image, .woo-option-image { margin:10px 0; clear:both; display:block}
		.seperator { text-align:left; padding:2px 0; margin:15px 0 20px 0; border-bottom:2px solid #aaa;  font-weight:700; color: #888}
		.clear {clear:both}  
	</style>
    <?php
	//AJAX Upload
	?>
    <script type="text/javascript">
	
	jQuery(document).ready(function(){
		
		jQuery('.woo-upload-nav a').live('click',function(){
		
			var nav = jQuery(this).parent().parent();
			var navClicked = jQuery(this);
			nav.find('li').removeClass('active');
			navClicked.parent().addClass('active');
			var move = navClicked.attr('rel');
			nav.next().next().children().animate({'marginLeft':move},200);
			return false;
		
		})
	
	});
	
	</script>
	<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/functions/js/ajaxupload.js"></script>
	<script type="text/javascript">
		
	function setupAdUploaders(){
		
		jQuery(document).ready(function(){
		
		//AJAX Upload

		jQuery('.widget_image_upload_button').each(function(){
		
		var clickedObject = jQuery(this);
		var clickedID = jQuery(this).attr('id');	
		new AjaxUpload(clickedID, {
			  action: '<?php echo admin_url("admin-ajax.php"); ?>',
			  name: clickedID, // File upload name
			  data: { // Additional data to send
					action: 'woo_widget_ajax_post_action',
					type: 'upload',
					data: clickedID },
			  autoSubmit: true, // Submit file after selection
			  responseType: false,
			  onChange: function(file, extension){},
			  onSubmit: function(file, extension){
					clickedObject.text('Uploading'); // change button text, when user selects file	
					this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
					interval = window.setInterval(function(){
						var text = clickedObject.text();
						if (text.length < 13){	clickedObject.text(text + '.'); }
						else { clickedObject.text('Uploading'); } 
					}, 200);
			  },
			  onComplete: function(file, response) {
			   
				window.clearInterval(interval);
				clickedObject.text('Upload Image');	
				this.enable(); // enable upload button
				setupAdUploaders(); // Reinitialize the uploaders
				
				// If there was an error
				if(response.search('Upload Error') > -1){
					var buildReturn = '<span class="upload-error">' + response + '</span>';
					jQuery(".upload-error").remove();
					clickedObject.parent().after(buildReturn);
				
				}
				else{
					var buildReturn = '<img class="hide woo-option-image" id="image_'+clickedID+'" src="'+response+'" width="75" alt="" />';
//					var buildReturn = '<img class="hide" id="image_'+clickedID+'" src="<?php bloginfo('template_url') ?>/thumb.php?src='+response+'&w=345" alt="" />';
					jQuery(".upload-error").remove();
					jQuery("#image_" + clickedID).remove();	
					clickedObject.parent().after(buildReturn);
					jQuery('img#image_'+clickedID).fadeIn();
					clickedObject.next('span').fadeIn();
					clickedObject.prev('input').val(response);
				}				
				
			  }
			 
			});
			
		});

	});
	
	}; // end function
	
	setupAdUploaders();
	
	</script>
    <?php
}

add_action('wp_ajax_woo_widget_ajax_post_action', 'woo_widget_ad_ajax_callback');

function woo_widget_ad_ajax_callback() {
	global $wpdb; // this is how you get access to the database
	$themename = get_option('template') . "_";
	//Uploads
	if(isset($_POST['type'])){
		if($_POST['type'] == 'upload'){
			
			$clickedID = $_POST['data']; // Acts as the name
			$filename = $_FILES[$clickedID];
			$override['test_form'] = false;
			$override['action'] = 'wp_handle_upload';    
			$uploaded_file = wp_handle_upload($filename,$override);
			 
					$upload_tracking[] = $clickedID;
					update_option( $clickedID , $uploaded_file['url'] );
					//update_option( $themename . $clickedID , $uploaded_file['url'] );
			 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
			 else { echo $uploaded_file['url']; } // Is the Response
		}
		
	}
	die();

}

/*---------------------------------------------------------------------------------*/
/* Blog Author Info */
/*---------------------------------------------------------------------------------*/
if (class_exists('WP_Widget')) {
	class Woo_BlogAuthorInfo extends WP_Widget {
	
	   function Woo_BlogAuthorInfo() {
		   $widget_ops = array('description' => 'This is a WooThemes Blog Author Info widget.' );
		   parent::WP_Widget(false, __('Woo - Blog Author Info', 'woothemes'),$widget_ops);      
	   }
	
	   function widget($args, $instance) {  
		extract( $args );
		$title = $instance['title'];
		$bio = $instance['bio'];
		$email = $instance['email'];
		$avatar_size = $instance['avatar_size']; if ( !$avatar_size ) $avatar_size = 48;
		$avatar_align = $instance['avatar_align']; if ( !$avatar_align ) $avatar_align = 'left';
		$read_more_text = $instance['read_more_text'];
		$read_more_url = $instance['read_more_url'];
		?>
			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; } ?>
			<div class="about">
            <span class="<?php echo $avatar_align; ?>"><?php if ( $email ) echo get_avatar( $email, $size = $avatar_size ); ?></span>
            <p><?php echo $bio; ?></p>
			<?php if ( $read_more_url ) echo '<p style="margin-bottom:0;"><a class="button" href="' . $read_more_url . '">' . $read_more_text . '</a></p>'; ?>
			<div class="fix"></div>
			</div>
			<?php echo $after_widget; ?>   
	   <?php
	   }
	
	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }
	
	   function form($instance) {        
	   
			$title = esc_attr($instance['title']);
			$bio = esc_attr($instance['bio']);
			$email = esc_attr($instance['email']);
			$avatar_size = esc_attr($instance['avatar_size']);
			$avatar_align = esc_attr($instance['avatar_align']);
			$read_more_text = esc_attr($instance['read_more_text']);
			$read_more_url = esc_attr($instance['read_more_url']);
			?>
			<p>
			   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','woothemes'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('bio'); ?>"><?php _e('Bio:','woothemes'); ?></label>
				<textarea name="<?php echo $this->get_field_name('bio'); ?>" class="widefat" id="<?php echo $this->get_field_id('bio'); ?>"><?php echo $bio; ?></textarea>
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('<a href="http://www.gravatar.com/">Gravatar</a> E-mail:','woothemes'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('email'); ?>"  value="<?php echo $email; ?>" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e('Gravatar Size:','woothemes'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('avatar_size'); ?>"  value="<?php echo $avatar_size; ?>" class="widefat" id="<?php echo $this->get_field_id('avatar_size'); ?>" />
			</p>
            <p>
                <label for="<?php echo $this->get_field_id('avatar_align'); ?>"><?php _e('Gravatar Alignment:','woothemes'); ?></label>
                <select name="<?php echo $this->get_field_name('avatar_align'); ?>" class="widefat" id="<?php echo $this->get_field_id('avatar_align'); ?>">
                    <option value="left" <?php if($avatar_align == "left"){ echo "selected='selected'";} ?>><?php _e('Left', 'woothemes'); ?></option>
                    <option value="right" <?php if($avatar_align == "right"){ echo "selected='selected'";} ?>><?php _e('Right', 'woothemes'); ?></option>            
                </select>
            </p>
 			<p>
			   <label for="<?php echo $this->get_field_id('read_more_text'); ?>"><?php _e('Read More Text (optional):','woothemes'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('read_more_text'); ?>"  value="<?php echo $read_more_text; ?>" class="widefat" id="<?php echo $this->get_field_id('read_more_text'); ?>" />
			</p>
			<p>
			   <label for="<?php echo $this->get_field_id('read_more_url'); ?>"><?php _e('Read More URL (optional):','woothemes'); ?></label>
			   <input type="text" name="<?php echo $this->get_field_name('read_more_url'); ?>"  value="<?php echo $read_more_url; ?>" class="widefat" id="<?php echo $this->get_field_id('read_more_url'); ?>" />
			</p>
          
			<?php
	   	}
	} 
	
	register_widget('Woo_BlogAuthorInfo');
}

/*---------------------------------------------------------------------------------*/
/* Deregister Default Widgets */
/*---------------------------------------------------------------------------------*/
function woo_deregister_widgets(){
    unregister_widget('WP_Widget_Search');         
}
add_action('widgets_init', 'woo_deregister_widgets');  

/*---------------------------------------------------------------------------------*/
/* Overview Map widget */
/*---------------------------------------------------------------------------------*/

class woo_MapsOverviewWidget extends WP_Widget {
	function woo_MapsOverviewWidget() {
		$widget_ops = array('classname' => 'widget_maps_overview_widget', 'description' => 'Add a Overview of all the places you\'ve blogged about.' );
		$this->WP_Widget('maps_overview_widget', 'Woo - Overview Map', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		extract( $args );
		$title = $instance['title'];
		$zoom = $instance['zoom'];
		$tag = $instance['tag'];
		$height = $instance['height'];	
		$type = $instance['type'];	
		$center = $instance['center'];
		
		if(!empty($title)){
			echo $before_widget;
			echo $before_title . $title . $after_title;
		} 
		else {
			echo $before_widget;
		}
		$key = get_option('woo_maps_apikey');
		if(empty($key)){ ?>
		 <div style="margin:10px">Please enter your <strong>API Key</strong> before using the maps.</div>
		<?php
		
		echo $after_widget; 
		
		} else {
		?>
        <div id="overview_map_canvas_<?php echo $args['widget_id']; ?>" style="height:<?php echo $height; ?>px; width:100%"></div>
        <?php		
			
	   	echo $after_widget; 
		
		/* Maps Bit */
		$coords = array();
		if(!empty($tag)) {
			$posts = get_posts('numberposts=100&tag=' . $tag);
		} else {
			$posts = get_posts('numberposts=100');
		}
		
		foreach($posts as $post){
			$lat = get_post_meta($post->ID, 'woo_maps_lat',true);
			if(!empty($lat)){
				$coords[$post->ID] = get_post_meta($post->ID, 'woo_maps_lat',true) . ', ' . get_post_meta($post->ID, 'woo_maps_long',true);
			}
		
		}
		$coord_keys = array_keys($coords);
		$first_key = $coord_keys[0];
		
		$center_final = $coords[$first_key];
		if(!empty($center)) { $center_final = $center; }
		
		?>
        <script type="text/javascript">
			jQuery(document).ready(function(){
				function initialize() {
				  if (GBrowserIsCompatible()) {
					var map = new GMap2(document.getElementById("overview_map_canvas_<?php echo $args['widget_id']; ?>"));
					map.setMapType(<?php echo $type; ?>);
					map.setUIToDefault();
					<?php if(get_option('woo_maps_scroll') == 'true'){ ?>
					map.disableScrollWheelZoom();
					<?php } ?>
					map.setCenter(new GLatLng(<?php echo $center_final; ?>), <?php echo $zoom; ?>);

					<?php foreach($coords as $c_key => $c_value) { ?>      					
      				var point = new GLatLng(<?php echo $c_value; ?>);
					var marker = new GMarker(point,{title:'<?php echo get_the_title($c_key); ?>'}); 
					map.addOverlay(marker);
					GEvent.addListener(marker,'click',function(){ window.location = '<?php echo get_permalink($c_key); ?>'; });
					<?php } ?>
					
				  }
				}
				initialize();
			})
		</script>
        
        <?php
		}
	}

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }


	function form($instance) {
		$title = strip_tags($instance['title']);
		$zoom = $instance['zoom'];
		$tag = $instance['tag'];
		$height = $instance['height'];
		$type = $instance['type'];
		$center = $instance['center'];
		
		if(empty($zoom)) $zoom = '0';
		if(empty($height)) $height = '300';
		if(empty($type)) $type = 'G_NORMAL_MAP';
?>
	    <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
	    <p>
            <label for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Tag: (optional / clustering)','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('tag'); ?>" value="<?php echo $tag; ?>" class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('zoom'); ?>"><?php _e('Map Zoom:','woothemes'); ?></label>
            <select class="widefat" name="<?php echo $this->get_field_name('zoom'); ?>" id="<?php echo $this->get_field_id('zoom'); ?>">
			<?php 
                for($i = 0; $i < 20; $i++) {
                if($i == $zoom){ $selected = 'selected="selected"';} else { $selected = '';}		
                 ?><option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
            <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('center'); ?>"><?php _e('Center Coordinates: (optional)','woothemes'); ?> <small>Example: 43.7712879,11.2064976</small></label>
            <input type="text" name="<?php echo $this->get_field_name('center'); ?>" value="<?php echo $center; ?>" class="widefat" id="<?php echo $this->get_field_id('center'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Map Height:','woothemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $height; ?>" class="widefat" id="<?php echo $this->get_field_id('height'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Map Type:','woothemes'); ?></label>
           <select class="widefat" name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>">
			<?php
                $map_types = array('Normal' => 'G_NORMAL_MAP','Satellite' => 'G_SATELLITE_MAP','Hybrid' => 'G_HYBRID_MAP','Physical' => 'G_PHYSICAL_MAP',); 
                foreach($map_types as $k => $v) {
                if($type == $v){ $selected = 'selected="selected"';} else { $selected = '';}		
                 ?><option value="<?php echo $v; ?>" <?php echo $selected; ?>><?php echo $k; ?></option>
            <?php } ?>
            </select>
          </p>
        <?php
	}
}
register_widget('woo_MapsOverviewWidget');


?>
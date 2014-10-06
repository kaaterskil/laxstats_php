<?php
		//get data
		$blog_ref	= $blogs->field['reference'];
		$date		= $blogs->field['date'];
		$title		= $blogs->field['title'];
		$letter		= $blogs->field['letter'];
		$file_name	= $blogs->field['fileName'];
		$file_type	= $blogs->field['fileType'];
		$file_path	= $blogs->field['filePath'];
		//process data
		$date		= date('l, F j, Y', strtotime($date));
		$letter		= format_string($letter);
		//set links
		$params		= get_all_get_params(array('p', 'br', 'a')).'&br='.$blog_ref;
		$href_blog	= set_href(FILENAME_CORNER_BLOG, $params);
		$params		= get_all_get_params(array('p', 'br', 'a')).'&br='.$blog_ref.'#postComment';
		$href_comment = set_href(FILENAME_CORNER_BLOG, $params);
		$params = get_all_get_params(array('p', 'br', 'a')).'&br='.$blog_ref.'&a=dlf';
		$href_download = set_href($page_ref, $params);
?>
			<!-- eof blog entry -->
			<div class="blog_container">
				<div class="blog_title"><a name="<?php echo $blog_ref; ?>"><?php echo $title; ?></a></div>
				<div class="blog_date"><?php echo $date; ?></div>
				<div class="blog_text"><?php echo $letter; ?></div>
<?php
		//print attachment
		if($file_name != ''){
			$icon_path = set_icon($file_name);
?>
				<div class="blog_text"><?php echo draw_image($icon_path); ?> <a href="<?php echo $href_download; ?>"><?php echo $file_name; ?></a></div>
<?php
		}
		//print comments
		if(isset($comments->result['blogRef'])){
			$keys = array_keys($comments->result['blogRef'], $blog_ref);
			$count = count($keys);
			$string = ($count > 1 ? $count.' comments' : $count.' comment');
			if($page_ref == FILENAME_CORNER_HOME){
?>
				<div class="comment_results">
					<a href="<?php echo $href_blog; ?>"><?php echo $string; ?></a>
					<span id="blog<?php echo $blog_ref; ?>s"> | <a href="javascript:show_comments('blog<?php echo $blog_ref; ?>', true);">show comments</a></span> | 
					<a href="<?php echo $href_comment; ?>">post a comment</a>
				</div>
				<div id="blog<?php echo $blog_ref; ?>" class="comment_container">
<?php
			}else{
?>
				<div class="comment_results">
					<a href="<?php echo $href_blog; ?>"><?php echo $string; ?></a>
					<span id="blog<?php echo $blog_ref; ?>s"> | <a href="javascript:show_comments('blog<?php echo $blog_ref; ?>', true);">show comments</a></span>
				</div>
				<div id="blog<?php echo $blog_ref; ?>" class="comment_container">
<?php
			}
			for($i = 0; $i < $count; $i++){
				$e = $keys[$i];
				$comment_name = $comments->result['name'][$e];
				$comment_date = $comments->result['created'][$e];
				$comment = $comments->result['comments'][$e];
				$comment_date = date('F j, Y h:i A', strtotime($comment_date));
?>
					<div class="comment_details">
						<b>Name: </b><span class="comment_name"><?php echo $comment_name; ?></span><br>
						<b>Date: </b><?php echo $comment_date; ?>
					</div>
					<div class="comment_text"><?php echo $comment; ?></div>
<?php
			}
?>
					<div class="comment_footer"><a href="javascript:show_comments('blog<?php echo $blog_ref; ?>', false);">hide comments</a></div>
				</div>
<?php
		}else{
			if($page_ref == FILENAME_CORNER_HOME){
?>
				<div class="comment_results">
					<a href="<?php echo $href_blog; ?>">0 comments</a> | 
					<a href="<?php echo $href_comment; ?>">post a comment</a>
				</div>
<?php
			}else{
?>
				<div class="comment_results"><a href="<?php echo $href_blog; ?>">0 comments</a></div>
<?php
			}
		}
?>
			</div>
			<!-- eof blog entry -->

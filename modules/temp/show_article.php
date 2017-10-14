<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//

$sumView = 0;
$db->table = "article";
$db->condition = "`is_active` = 1 AND `article_id` = $id";
$db->order = "";
$db->limit = 1;
$rows = $db->select();
if($db->RowCount>0){
	foreach($rows as $row) {
		$db->table = "article";
		$db->condition = "`is_active` = 1 AND `article_menu_id` = ". intval($row['article_menu_id']). " AND `article_id` <> $id";
		$db->order = "`created_time` DESC";
		$db->limit = 10;
		$rows2 = $db->select();
		$total = $db->RowCount;
		?>
		<div class="wrap-detail">
			<div class="social-share">
				<input type="checkbox" class="checkbox" id="share">
				<label for="share" class="label fa fa-share-alt" title="Share social buttons"></label>
				<div class="social">
					<ul>
						<li onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url()?>','_blank')" class="fa fa-facebook"></li>
						<li onclick="javascript:window.open('https://twitter.com/intent/tweet?source=webclient&url=<?php echo site_url()?>','_blank')" class="fa fa-twitter"></li>
						<li onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo site_url()?>','_blank')" class="fa fa-google-plus"></li>
					</ul>
				</div>
			</div>
			<?php
			if($row['name']!='') echo '<h2 class="title-vs">' . stripslashes($row['name']) . '</h2>';
			if($slug_cat=='news' || $slug_cat=='tin-tuc') echo '<p class="time-views"><label class="time">' . $lgTxt_post_date . $date->vnFull($row['created_time']) . '</label><label>-</label><label class="views">' . $lgTxt_post_views . formatNumberVN($row['views'])  . '</label></p>';
			if($row['comment']!='') echo '<h3 class="txt-medium f-space15">' . stripslashes($row['comment']) . '</h3>';
			if($row['content']!='') echo '<div class="detail-wp f-space20 clearfix">' . stripslashes($row['content']) . '</div>';

			if($total>0) {
				echo '<div class="others">';
				if($id_category==94 && $id_menu==467) echo '<h3 class="title-other">' . $lgTxt_title_others1 . '</h3>';
				elseif($id_category==98) echo '<h3 class="title-other">' . $lgTxt_title_others2 . '</h3>';
				else echo '<h3 class="title-other">' . $lgTxt_title_others2 . '</h3>';
                echo '<ul class="list-other">';
				foreach($rows2 as $row2) {
					include(_F_TEMPLATES . DS . "show_other_article.php");
				}
				echo '</ul>';
                echo '</div>';
			}
			?>
        </div>
		<?php

		$sumView = $row['views']+1;
	}
	$db->table = "article";
	$data = array(
			'views'=>$sumView
	);
	$db->condition = "article_id = ".$id;
	$db->update($data);

}
else include(_F_MODULES . DS . "error_404.php");
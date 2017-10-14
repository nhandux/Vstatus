<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$photo_avt = '';
$alt = ($row['img_note'] != '') ? stripslashes($row['img_note']) : stripslashes($row['name']);
if(file_exists(ROOT_DIR  . DS . 'uploads' . DS . 'article' . DS . 'post-' . $row['img']) && $row['img']!='') {
	$photo_avt = '<img src="'. HOME_URL .'/uploads/article/post-'. $row['img'] . '" alt="' . $alt . '">';
} else {
	$photo_avt = '<img src="'. HOME_URL .'/images/404-post.jpg" alt="'.$alt.'">';
}

$photo_avt = '<a href="'. HOME_URL_LANG . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . $photo_avt . '</a>';
$title = $time = $hot = '';
if($row['hot']==1) $hot = '<span class="p-hot">New</span>';
$title = '<h2><a href="'. HOME_URL_LANG . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . $hot . stripslashes($row['name']) . '</a></h2>';

if($slug_cat=='news' || $slug_cat=='tin-tuc') {
	$time = '<p class="time">' . $date->vnFull($row['created_time']) . '</p>';
}
?>
<div class="item-vs">
	<div class="img"><?php echo $photo_avt;?></div>
	<div class="description">
		<?php
		echo $title . $time;
		if($row['comment']!='') echo '<p>' . $stringObj->crop(stripslashes($row['comment']), 30) . '</p>';
		echo '<p class="more"><a href="'. HOME_URL_LANG . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . $lgTxt_detail . '</a></p>';
		?>
	</div>
</div>
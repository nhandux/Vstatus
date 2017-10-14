<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
$date = new DateClass();
$stringObj = new String();
?>
<section class="box-post">
    <div class="box-wp box-main">
        <div class="box-title txt-center">
            <h2 class="title"><a href="<?php echo HOME_URL_LANG . '/' . getSlugCategory(98);?>"><?php echo $lgTxt_title_news_hot;?></a></h2>
        </div>
        <div class="list-post clearfix">
            <?php
            $db->table = "article";
            $db->condition = "`is_active` = 1 AND `article_menu_id` IN (SELECT `article_menu_id` FROM `".TTH_DATA_PREFIX."article_menu` WHERE `category_id` = 98)";
            $db->order = "`hot` DESC, `created_time` DESC";
            $db->limit = 3;
            $rows = $db->select();
            if($db->RowCount>0) {
                foreach($rows as $row) {
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
                    $title = '<h3 class="txt-crop-2lines"><a href="'. HOME_URL_LANG . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . $hot . stripslashes($row['name']) . '</a></h3>';
                    $time = '<p class="time">' . $date->vnFull($row['created_time']) . '</p>';
                    ?>
                    <div class="item-post">
                        <div class="box">
                            <div class="img"><?php echo $photo_avt;?></div>
                            <div class="description">
                                <?php
                                echo $time . $title;
                                if($row['comment']!='') echo '<p class="text">' . $stringObj->crop(stripslashes($row['comment']), 20) . '</p>';
                                echo '<p class="more"><a href="'. HOME_URL_LANG . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . $lgTxt_red_more . '</a></p>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>
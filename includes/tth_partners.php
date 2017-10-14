<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
?>
<!-- .partners -->
<section class="partners">
    <div class="box-wp">
        <div class="box-title txt-center">
            <h2 class="title"><?php echo getNameCategory(102);?></h2>
        </div>
        <div class="list-partner">
            <?php
            $db->table = "gallery";
            $db->condition = "`is_active` = 1 AND `gallery_menu_id` IN (SELECT `gallery_menu_id` FROM `".TTH_DATA_PREFIX."gallery_menu` WHERE `category_id` = 102)";
            $db->order = "`created_time` DESC";
            $db->limit = "";
            $rows = $db->select();
            if($db->RowCount>0) {
                echo '<ul id="_partners" class="list owl-carousel owl-theme clearfix">';
                foreach ($rows as $row){
                    $imgShow = ($row['link']=='') ?
                        '<img src="' . HOME_URL . '/uploads/gallery/part-' . $row['img'] . '" alt="' . stripslashes($row['name']) . '">'
                        :
                        '<a target="_blank" href="'.$row['link'].'" title="'.stripslashes($row['name']).'"><img src="' . HOME_URL . '/uploads/gallery/part-' . $row['img'] . '" alt="' . stripslashes($row['name']) . '"></a>';
                    echo '<li class="item owl-item">' . $imgShow . '</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>
</section>
<!-- / .partners -->

<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
?>
<!-- .slider -->
<section class="box-slider">
    <div id="_slider" style="position: relative; top: 0; left: 0; width: 1600px; height: 650px;">
        <div data-u="loading" style="position: absolute; top: 0; left: 0;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0; left: 0; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('<?php echo HOME_URL;?>/images/loader.gif') no-repeat center center;top:0;left:0;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor: move; position: relative; top: 0; left: 0; width: 1600px; height: 650px; overflow: hidden;">
            <?php
            $db->table = "gallery";
            $db->condition = "`is_active` = 1 AND `gallery_menu_id` IN (SELECT `gallery_menu_id` FROM `".TTH_DATA_PREFIX."gallery_menu` WHERE `category_id` = 91)";
            $db->order = "`created_time` DESC";
            $db->limit = "";
            $rows = $db->select();
            foreach ($rows as $row){
                $imgShow = ($row['link']=='') ?
                    '<img data-u="image" src="' . HOME_URL . '/uploads/gallery/slider-' . $row['img'] . '" alt="' . stripslashes($row['name']) . '">'
                    :
                    '<a target="_blank" href="'.$row['link'].'" title="'.stripslashes($row['name']).'"><img data-u="image" src="' . HOME_URL . '/uploads/gallery/slider-' . $row['img'] . '" alt="' . stripslashes($row['name']) . '"></a>';

                $caption = '';
                if($row['hot']==1) {
                    $caption = '<div data-u="caption" class="caption"><div class="box">';
                    if($row['name']!='') $caption .= '<h1>' . stripslashes($row['name']) . '</h1>';
                    if($row['comment']!='') $caption .= '<p>' . stripslashes($row['comment']) . '</p>';
                    $caption .= '</div></div>';
                }
                echo '<div data-p="112.50" style="display: none;">' . $imgShow . $caption . '</div>';
            }
            ?>
        </div>
        <span u="arrowleft" class="jssora02l" style="top: 123px; left: 30px;"></span>
        <span u="arrowright" class="jssora02r" style="top: 123px; right: 30px;"></span>
    </div>
    <div class="tool">
        <?php
        $db->table = "article_menu";
        $db->condition = "`is_active` = 1 AND `parent` = 0 AND `category_id` = 94";
        $db->order = "`sort` ASC";
        $db->limit = 4;
        $rows = $db->select();
        if($db->RowCount>0) {
            echo '<ul>';
            $i = 0;
            foreach($rows as $row) {
                $i++;
                echo '<li><a class="img" href="' . HOME_URL_LANG . '/' . stripslashes($row['slug']) . '"><img src="' . HOME_URL . '/images/tool-' . $i . '.png"></a><a href="' . HOME_URL_LANG . '/' . stripslashes($row['slug']) . '">' . stripslashes($row['name']) . '</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
</section>
<script>
    jssor_slider_init();
</script>
<!-- / .slider -->
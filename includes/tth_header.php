<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
?>
<!-- .header -->
<header class="header">
    <a id="hamburger" href="#menu"><span></span></a>
    <div class="logo">
        <div class="box-wp">
            <div class="img">
                <a href="<?php echo HOME_URL_LANG;?>" title="<?php echo getConstant('title');?>"><img src="<?php echo HOME_URL . getConstant('file_logo');?>" alt="<?php echo getConstant('meta_site_name');?>"></a>
            </div>
            <div class="language">
                <ul>
                    <li>Đăng nhập</li>
                    <li>|</li>
                    <li><img src="./images/vi.png"></li>
                    <li><img src="./images/ja.png"></li>
                    <li><img src="./images/en.png"></li>
                </ul>
            </div>
        </div>
    </div>
    <nav class="navbar">
        <div class="navigation box-wp" role="navigation">
            <ul>
                <?php
                $db->table = "category";
                $db->condition = "`is_active` = 1 AND `menu_main` = 1";
                $db->order = "`sort` ASC";
                $db->limit = "";
                $rows = $db->select();
                foreach ($rows as $row) {
                    $active = '';
                    if ($slug_cat == $row['slug']) $active = ' class="active"';
                    echo '<li' . $active . '><a href="' . HOME_URL_LANG . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '"><span>' . stripslashes($row['name']) . '</span></a>' . loadMenuChild('article_menu', $row['category_id'], 0, $slug_cat, $id_menu) . '</li>';
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class="stock">
        <div class="box-wp">
            <marquee align="center" direction="left" onmouseover="this.stop()" onmouseout="this.start()"  BEHAVIOR="scroll" scrollamount="4" width="100%" >
                <p>
                    <label>VN-Index 728.45 <i class="fa fa-caret-up fa-fw"></i>1.25 <i class="fa fa-caret-up fa-fw"></i>0.17%</label>
                    <label>HNX-Index 92.13 <i class="fa fa-caret-down fa-fw"></i>0.22 <i class="fa fa-caret-down fa-fw"></i>0.24%</label>
                    <label>Dow Jones 20,606.93 <i class="fa fa-caret-down fa-fw"></i>372.82 <i class="fa fa-caret-down fa-fw"></i>1.78%</label>
                    <label>Nasdaq 6,011.24 <i class="fa fa-caret-up fa-fw"></i>872.82 <i class="fa fa-caret-up fa-fw"></i>2.18%</label>
                </p>
            </marquee>
        </div>
    </div>
</header>
<!-- / .header -->
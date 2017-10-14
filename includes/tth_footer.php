<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
?>
<!-- .footer -->
<footer class="footer">
	<div class="sub-link">
		<div class="box-wp">
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
					echo '<li' . $active . '><a href="' . HOME_URL_LANG . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
	<div class="information">
		<div class="box-info box-wp">
			<div class="col-1">
				<div class="img"><a href="<?php echo HOME_URL_LANG;?>" title="<?php echo getConstant('title');?>"><img src="<?php echo HOME_URL;?>/images/logo-bottom.png" alt="<?php echo getConstant('meta_site_name');?>"></a></div>
			</div>
			<div class="col-2"><?php echo getPage('info_bottom');?></div>
			<div class="col-1">
                <div class="newsletter">
                    <form method="post" name="newsletter" onsubmit="return sendRegEmail();">
                        <input type="text" id="_reg_email" name="email" autocomplete="off" placeholder="<?php echo $lgTxt_register_mail_input;?>">
                        <button type="submit" name="register"><?php echo $lgTxt_register_mail_submit;?></button>
                    </form>
                </div>
				<h4 class="f-space20"><?php echo $lgTxt_social;?></h4>
				<?php
				echo '<ul class="social">';
				if(getConstant('link_facebook')!="") echo '<li class="facebook"><a target="_blank" href="' . getConstant('link_facebook') . '" title="Facebook"><i class="fa fa-facebook"></i></a></li>';
				if(getConstant('link_googleplus')!="") echo '<li class="google-plus"><a target="_blank" href="' . getConstant('link_googleplus') . '" rel="publisher" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>';
				if(getConstant('link_twitter')!="") echo '<li class="twitter"><a target="_blank" href="' . getConstant('link_twitter') . '" title="Twitter"><i class="fa fa-twitter"></i></a></li>';
				if(getConstant('link_youtube')!="") echo '<li class="youtube"><a target="_blank" href="' . getConstant('link_youtube') . '" title="Youtube"><i class="fa fa-youtube"></i></a></li>';
				if(getConstant('link_linkedin')!="") echo '<li class="linkedin"><a target="_blank" href="' . getConstant('link_linkedin') . '" title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>';
				if(getConstant('link_instagram')!="") echo '<li class="instagram"><a target="_blank" href="' . getConstant('link_instagram') . '" title="Instagram"><i class="fa fa-instagram"></i></a></li>';
				echo '</ul>';
				?>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="box-wp">
			<div class="text"><?php echo getPage('copyright');?></div>
			<div class="danaweb">
				<p>Designed and Maintained by<a title="DanaWeb.vn" href="http://danaweb.vn" target="_blank"><img alt="DanaWeb.vn" src="images/danaweb.png"></a>
			</div>
		</div>
	</div>
</footer>
<!-- / .footer -->
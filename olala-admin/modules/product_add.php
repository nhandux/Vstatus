<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
$category_id = 0;
$product_menu_id = isset($_GET['id']) ? $_GET['id']+0 : $product_menu_id+0;
$db->table = "product_menu";
$db->condition = "`product_menu_id` = $product_menu_id";
$db->order = "";
$db->limit = 1;
$rows = $db->select();
if($db->RowCount==0) loadPageAdmin("Mục không tồn tại.", "?".TTH_PATH."=product_manager");
foreach($rows as $row) {
	$category_id =	$row["category_id"]+0;
}
?>
<!-- Menu path -->
<div class="row">
	<ol class="breadcrumb">
		<li>
			<a href="<?php echo ADMIN_DIR?>"><i class="fa fa-home"></i> Trang chủ</a>
		</li>
		<li>
			<a href="?<?php echo TTH_PATH?>=product_manager"><i class="fa fa-edit"></i> Quản lý nội dung</a>
		</li>
		<li>
			<a href="?<?php echo TTH_PATH?>=product_manager"><i class="fa fa-bookmark"></i> Sản phẩm</a>
		</li>
		<li>
			<a href="?<?php echo TTH_PATH?>=product_list&id=<?php echo $product_menu_id?>"><i class="fa fa-list"></i> <?php echo getNameMenu($product_menu_id, 'product')?></a>
		</li>
		<li>
			<i class="fa fa-plus-square-o"></i> Thêm sản phẩm
		</li>
	</ol>
</div>
<!-- /.row -->
<?php
include_once (_A_TEMPLATES . DS . "product.php");
if(empty($typeFunc)) $typeFunc = "no";

$date = new DateClass();
$OK = false;
$error = '';
if($typeFunc=='add'){
	if(empty($name)) $error = '<span class="show-error">Vui lòng nhập tiêu đề.</span>';
	else {
		$comment    = (isset($_POST['comment'])) ? $_POST['comment'] : '';
		$content    = (isset($_POST['content'])) ? $_POST['content'] : '';
		$direction  = isset($_POST['direction']) ? $_POST['direction'] : array();
		$road       = isset($_POST['road']) ? $_POST['road'] : array();
		$city       = isset($_POST['city']) ? $_POST['city'] : '';
		$district   = isset($_POST['district']) ? $_POST['district'] : '';
		$address    = isset($_POST['address']) ? $_POST['address'] : '';
		$type       = isset($_POST['type']) ? $_POST['type'] : '';
		$status     = isset($_POST['status']) ? $_POST['status'] : '';
		//-----
		$handleUploadImg = false;
		$file_max_size = FILE_MAX_SIZE;
		$dir_dest = ROOT_DIR . DS . 'uploads' . DS . 'product';
		$file_size = $_FILES['img']['size'];

		if($file_size>0) {
			$imgUp = new Upload($_FILES['img']);

			$imgUp->file_max_size = $file_max_size;
			if ($imgUp->uploaded) {
				$handleUploadImg = true;
				$OK = true;
			}
			else {
				$error = '<span class="show-error">Hình ảnh: '.$imgUp->error.'</span>';
			}
		}
		else {
			$handleUploadImg = false;
			$OK = true;
		}

		//--- Hướng
		$direction_2 = array();
		if(count($direction)>0) {
			foreach($direction as $val) {
				$txt = getNameToSlug($val, 'others');
				array_push($direction_2, $txt);
			}
		}
		$direction = json_encode($direction);
		$direction_2 = json_encode($direction_2, JSON_UNESCAPED_UNICODE);

		//--- Loại đường
		$road_2 = array();
		if(count($road)>0) {
			foreach($road as $val) {
				$txt = getNameToSlug($val, 'others');
				array_push($road_2, $txt);
			}
		}
		$road = json_encode($road);
		$road_2 = json_encode($road_2, JSON_UNESCAPED_UNICODE);

		//--- Thành phố
		$city_2 = getNameMenuSlug($city, 'others');
		//--- Quận / huyện
		$district_2 = getNameToSlug($district, 'others');
		//--- Tên đường
		$address = mb_convert_case($address, MB_CASE_TITLE, "UTF-8");
		$address_2 = $address;
		$db->table = "others";
		$db->condition = "`others_menu_id` = 6 AND `name` LIKE '$address'";
		$db->order = "";
		$db->limit = 1;
		$rows = $db->select();
		if($db->RowCount>0) {
			foreach($rows as $row) {
				$address = stripslashes($row['slug']);
			}
		} elseif(!empty($address)) {
			$id_query = 0;
			$db->table = "others";
			$data = array(
				'others_menu_id'=>6,
				'name'=>$db->clearText($address),
				'sort'=>sortAcsStreet()+1,
				'created_time'=>time(),
				'modified_time'=>time(),
				'user_id'=>$_SESSION["user_id"]
			);
			$db->insert($data);
			$id_query = $db->LastInsertID;
			// Link SEO
			$address = updateLinkSEO($address, 88, 6, $id_query);
			// Update Slug
			$db->table = "others";
			$data = array(
				'slug'=>$db->clearText($address)
			);
			$db->condition = "`others_id` = $id_query";
			$db->update($data);
		}

		//--- Loại tin
		$type_2 = getNameToSlug($type, 'others');

		if($OK) {
			$id_query = 0;
			$db->table = "product";
			$data = array(
				'product_menu_id'=>$product_menu_id+0,
				'name'=>$db->clearText($name),
				'img_note'=>$db->clearText($img_note),
				'acreage'=>formatNumberToInt($acreage),
				'price'=>formatNumberToInt($price),
				'price_unit'=>$db->clearText($price_unit),
				'direction'=>$db->clearText($direction),
				'direction_2'=>$db->clearText($direction_2),
				'road'=>$db->clearText($road),
				'road_2'=>$db->clearText($road_2),
				'bedroom'=>formatNumberToInt($bedroom),
				'bathroom'=>formatNumberToInt($bathroom),
				'city'=>$db->clearText($city),
				'city_2'=>$db->clearText($city_2),
				'district'=>$db->clearText($district),
				'district_2'=>$db->clearText($district_2),
				'address'=>$db->clearText($address),
				'address_2'=>$db->clearText($address_2),
				'type'=>$db->clearText($type),
				'type_2'=>$db->clearText($type_2),
				'tags'=>$db->clearText($tags),
				'status'=>$status+0,
				'comment'=>$db->clearText($comment),
				'content'=>$db->clearText($content),
				'upload_id'=>$upload_img_id+0,
				'youtube'=>$db->clearText($youtube),
				'is_active'=>$is_active+0,
				'hot'=>$hot+0,
				'pin'=>$pin+0,
				'title'=>$db->clearText($title),
				'description'=>$db->clearText($description),
				'keywords'=>$db->clearText($keywords),
				'created_time'=>strtotime($date->dmYtoYmd($created_time)),
				'user_id'=>$_SESSION["user_id"]
			);
			$db->insert($data);
			$id_query = $db->LastInsertID;
			// Link SEO
			$slug = (empty($slug)) ? $name : $slug;
			$slug = updateLinkSEO($slug, $category_id, $product_menu_id, $id_query);
			// Update Slug
			$db->table = "product";
			$data = array(
				'slug'=>$db->clearText($slug)
			);
			$db->condition = "`product_id` = $id_query";
			$db->update($data);

			if($handleUploadImg) {
				$stringObj = new String();
				$name_image = $stringObj->getSlug(substr($name, 0, 100) . '-' . time());

				$imgUp->file_new_name_body          = 'full_' . $name_image;
				$imgUp->Process($dir_dest);

				$imgUp->file_new_name_body          = $name_image;
				$imgUp->image_watermark             = ROOT_DIR . DS . 'images' . DS . 'signature1.png';
				$imgUp->image_watermark_position    = 'BL';
				$imgUp->image_resize                = true;
				$imgUp->image_ratio_crop            = true;
				$imgUp->image_x                     = 490;
				$imgUp->image_y                     = 256;
				$imgUp->Process($dir_dest);

				if($imgUp->processed) {
					$name_img = $imgUp->file_dst_name;
					$db->table = "product";
					$data = array(
						'img'=>$db->clearText($name_img)
					);
					$db->condition = "`product_id` = $id_query";
					$db->update($data);
				}

				$imgUp->file_new_name_body      = 'bds-' . $name_image;
				$imgUp->image_resize            = true;
				$imgUp->image_ratio_crop        = true;
				$imgUp->image_x                 = 540;
				$imgUp->image_y                 = 352;
				$imgUp->Process($dir_dest);

				$imgUp-> Clean();
			}

			$db->table = "uploads_tmp";
			$data = array(
				'status'=>1
			);
			$db->condition = "`upload_id` = ".($upload_img_id+0);
			$db->update($data);

			loadPageSucces("Đã thêm dữ liệu thành công.", "?".TTH_PATH."=product_list&id=".$product_menu_id);
			$OK = true;
		}
	}
}
else {
	$upload_img_id  = 0;
	if($upload_img_id==0) {
		$db->table = "uploads_tmp";
		$data = array(
				'created_time'=>time()
		);
		$db->insert($data);
		$upload_img_id = $db->LastInsertID;
	}

	$name			    = "";
	$slug               = "";
	$img                = "";
	$img_note           = "";
	$acreage            = "";
	$price              = "";
	$price_unit         = "";
	$direction          = "[]";
	$road               = "[]";
	$bedroom            = "";
	$bathroom           = "";
	$city               = "";
	$district           = "";
	$address            = "";
	$tags               = "";
	$type               = "";
	$status             = 0;
	$comment            = "";
	$content            = "";
	$youtube            = "";
	$is_active		    = 1;
	$hot			    = 0;
	$pin                = 0;
	$title			    = "";
	$description	    = "";
	$keywords		    = "";
	$created_time       = $date->vnDateTime(time());
}
if(!$OK) product("?".TTH_PATH."=product_add", "add", 0, $product_menu_id, $name, $slug, $img, $img_note, $acreage, $price, $price_unit, $direction, $road, $bedroom, $bathroom, $city, $district, $address, $tags, $type, $status, $comment, $content, $youtube, $upload_img_id, $is_active, $hot, $pin, $created_time, $title, $description, $keywords, $error);
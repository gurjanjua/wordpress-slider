<?php 
session_start();
?>	
<script type="text/javascript">
	jQuery(document).ready(function(){
		var counter = 6;
		var x=0;
		jQuery(".color").click(function(e){
			e.preventDefault();
			if(x<counter){
				x++;
				jQuery.post("http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/products_more.php",{ counter:x},function(data){
					jQuery(".block").append(data);
				});
			}
		});
	});
</script>
<style type="text/css">
	.add{height: 40px; }
	.span{position: relative; bottom:15px; margin-left: 5px; color: deepskyblue; text-decoration: underline;}
	.div-width{width:49%; cursor: pointer; position: relative; top:-6px;}
	.delete-option{position: relative;float: right; cursor: pointer;}
</style>
<?php
if(isset($_REQUEST['submit']))
{	
	$Product_name=$_REQUEST['product_name'];
	$Image_name=uniqid().$_FILES['product_image']['name'];
	$Product_description=$_REQUEST['product_description'];
	//path for image and upload product images
	$image_path=__DIR__."/images/".$Image_name;
	move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path);
	
	//panel size
	if(isset($_REQUEST['panel_size'])){
		$panels_sizes = array_filter($_REQUEST['panel_size']);
		$panels_size = array_combine(range(1, count($panels_sizes)), array_values($panels_sizes));
	}

	//upload panels images 
	if(isset($_FILES['panel_image']['name'])){
		
		$panel_images = array_filter($_FILES['panel_image']['name']);
		$panel_image = array_combine(range(1, count($panel_images)), array_values($panel_images));
		foreach ($panel_image as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_panel_image[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
		$panel_tmp_names = array_filter($_FILES['panel_image']['tmp_name']);
		$panel_tmp_name = array_combine(range(1, count($panel_tmp_names)), array_values($panel_tmp_names));
		foreach ($panel_tmp_name as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_panel_name[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
		$counter = count($sort_panel_image);
		for($i=1;$i<=$counter;$i++)
		{
			$length=count($sort_panel_image[$i]);
			for($j=1;$j<=$length;$j++)
			{
				$lengthAgain=count($sort_panel_image[$i][$j]);
				for($k=0;$k<$lengthAgain;$k++){	
					if($sort_panel_image[$i][$j][$k]==""){
							$new_panels_image = $sort_panel_image[$i][$j][$k];
					}
					else {
					$new_panels_image = uniqid().$sort_panel_image[$i][$j][$k];
					echo $target = __DIR__."/products/large/".$new_panels_image;
					$uploadPanelImage[$i][$j][$k] = $new_panels_image;
					if($i==1){	
						$nheight= '305';
						$nwidth= '100';
					}
					if($i==2){	
						$nheight= '345';
						$nwidth= '100';
					}
					if($i==3){	
						$nheight= '380';
						$nwidth= '100';
					}
					$err=null;
					if($new_panels_image)
					{ 
						$ext = getExt($new_panels_image);
						if ((!$ext)&&($ext!="jpg")&&($ext!="jpeg")&&($ext!="png")&&($ext!= "gif"))
						{
							$err="<strong>ho snap!</strong>please enter valid image jpg,jpeg,png or gif";
						}
						else{
							if($ext=="jpg" || $ext=="jpeg" )
							{
								$source = imagecreatefromjpeg($sort_panel_name[$i][$j][$k]);
							}
							else if($extension=="png")
							{
								$source = imagecreatefrompng($sort_panel_name[$i][$j][$k]);
							}
							else 
							{
								$source = imagecreatefromgif($sort_panel_name[$i][$j][$k]);
							}
							list($width,$height)=getimagesize($sort_panel_name[$i][$j][$k]);
							if($width>800){
								if($i==1){
									$max = 305;
								}
								if($i==2){
									$max = 345;
								}
								if($i==3){
									$max = 380;									
								}
								if ( $height > $width  && $max < $width) 
								{
									$nheight = $max / $width *  $height;
									$nwidth = $max;
								}
								if ( $height < $width && $max < $width)
								{
									$nwidth = $max /$height * $width;
									$nheight = $max;
								}
							}
							$temp=imagecreatetruecolor($nwidth,$nheight);
							imagecopyresampled($temp,$source,0,0,0,0,$nwidth,$nheight,$width,$height);
							$newfile= __DIR__."/products/small/".$new_panels_image;
							imagejpeg($temp,$newfile,100);
							imagedestroy($source);
							imagedestroy($temp);
						} 
					}
					move_uploaded_file($sort_panel_name[$i][$j][$k], $target);
				}
			}
			}
		}
	}
	
	//upload color images
	if(isset($_FILES['color_image']['name'])){
		$color_images = array_filter($_FILES['color_image']['name']);
		$color_image = array_combine(range(1, count($color_images)), array_values($color_images));
		foreach ($color_image as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_color_image[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
		$color_tmp_names = array_filter($_FILES['color_image']['tmp_name']);
		$color_tmp_name = array_combine(range(1, count($color_tmp_names)), array_values($color_tmp_names));
		foreach ($color_tmp_name as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_color_name[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
		$counter = count($sort_color_image);
		for($i=1;$i<=$counter;$i++)
		{
			$length=count($sort_color_image[$i]);
			for($j=1;$j<=$length;$j++)
			{
				if($sort_color_image[$i][$j][0]!=""){	
					$new_colors_image =uniqid().$sort_color_image[$i][$j][0];
				}
				$target = __DIR__."/color_image/".$new_colors_image;
				move_uploaded_file($sort_color_name[$i][$j][0], $target);
				$uploadColorImage[$i][$j][0] = $new_colors_image; 
			}
		} 
	}
	//color name
	if(isset($_REQUEST['color_name'])){
		
		$color_names = array_filter($_REQUEST['color_name']);
		$color_name = array_combine(range(1, count($color_names)), array_values($color_names));
		foreach ($color_name as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_name[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
	}
	
	$Panels_sizes = json_encode($panels_size);
	$Colors_name = json_encode($sort_name);
	$Colors_image = json_encode($uploadColorImage);
	$Panels_image = json_encode($uploadPanelImage);
	$length_counter = count($_REQUEST["panel_size"]);
	
	//sort order
	if(isset($_REQUEST['sort_order'])){
		$sort_order_no = $_REQUEST['sort_order'];
		if($sort_order_no == ""){
			$sort_order_no = 999;
		}
	}

	global $wpdb;   
	$wpdb->query( $wpdb->prepare( 
		"INSERT INTO wp_slider(product_name,image_name,product_description,color_name,colors_image,panels_image,panels_size,length_counter,sort_order_no) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%d','%d')", 
		array(  
			$Product_name,
			$Image_name,
			$Product_description,
			$Colors_name,
			$Colors_image,
			$Panels_image,
			$Panels_sizes,
			$length_counter,
			$sort_order_no
			)))
	or die(mysql_error());
	$_SESSION['alert']="Succesfully Inserted";
} 
function getExt($new_panels_image) {
	$pos = strrpos($new_panels_image,".");
	if (!$pos) { return "null"; }
	$len = strlen($new_panels_image) - $pos;
	$ext = substr($new_panels_image,$pos+1,$len);
	return strtolower($ext);
}
?>
<form method="post" enctype="multipart/form-data">
	<table class="form-table">
		<tbody>
			<tr>
				<td><div style="color:green;">				
					<?php if(!empty($_SESSION['alert'])){
						echo $_SESSION['alert'].'<span class="dashicons dashicons-yes"></span>';
						unset($_SESSION['alert']);
					}?></div>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="product_name">Product Name</label></th>
				<td><input name="product_name" type="text" id="product_name" placeholder="Enter Product Name" class="regular-text" required></td>
			</tr>
			<tr>
				<th scope="row"><label for="product_image">Product Image</label></th>
				<td><input name="product_image" type="file" id="product_image"  class="regular-text" required></td>
			</tr>
			<tr>
				<th scope="row"><label for="product_description">Product Description</label></th>
				<td><textarea name="product_description" id="product_description"  class="regular-text code" rows="3" style="width:50%"></textarea></td>
			</tr>
			<tr>
				<th scope="row"><label for="sort_order">Sort Order Number</label></th>
				<td><input name="sort_order" type="text" id="sort_order"  class="regular-text"></td>
			</tr>
			<tr>
				<th scope="row">Size Options</th>
				<td class="block">
					<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/add.png');?>" height="50">
					<span class="color">Add Size Options</span>
				</td>
			</tr>
			<tr>
				<td><input name="submit" type="submit" value="Submit"  class="large-text code"></td>
			</tr>
		</tbody>
	</table>
</form>

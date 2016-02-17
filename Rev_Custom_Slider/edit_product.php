<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".delete-panel").click(function(){
			var counter=jQuery(this).attr("counter");
			var level = jQuery(this).attr("level");
			var id = jQuery(this).attr("id");
			var image = jQuery(this).attr("image-name");
			var counterAgain = jQuery(this).attr("counterAgain");
			jQuery.ajax({
				type:"GET",
				url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/delete_panels_image.php",
				data:"id="+id+"&level="+level+"&counter="+counter+"&image="+image+"&counterAgain="+counterAgain,
				success:function(data){
					window.location.reload();
				}
			});
		});
		jQuery(".delete-color").click(function(){
			var counter=jQuery(this).attr("counter");
			var level = jQuery(this).attr("level");
			var id = jQuery(this).attr("id");
			var image = jQuery(this).attr("image-name");
			jQuery.ajax({
				type:"GET",
				url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/delete_color_image.php",
				data:"id="+id+"&level="+level+"&counter="+counter+"&image="+image,
				success:function(data){
					window.location.reload();
				}
			});
		});
		jQuery(".panel_more").click(function(){
			var level = jQuery(this).attr("level");
			var counter = jQuery(this).attr("counter");
			var divType = jQuery(this).prev().prev().prev().children().attr('type');
			var divClass = jQuery(this).prev().prev().prev().children().attr('class');
			var divID = jQuery(this).prev().prev().prev().children().attr('id');
			var divName = jQuery(this).prev().prev().prev().children().attr('name');
			jQuery.ajax({
				type:"GET",
				url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/edit_panel_product.php",
				data:"divType="+divType+"&divClass="+divClass+"&divID="+divID+"&divName="+divName,
				beforeSend:function(){
					
				},
				success:function(data){
					jQuery(".panel_more_"+level+"_"+counter).before(data);
				}
			});
		});

		jQuery('.add_color_more').click(function(){
			var level = jQuery(this).attr('level');
			var counter = jQuery(this).attr('counter');
			var length = 10;
			var incrementCounter = parseInt(counter)+1 ;
			var x = parseInt(counter);
			if(x<=length){
			jQuery(this).attr('counter',incrementCounter);
				jQuery.ajax({
					type:"GET",
					url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/colors_more.php",
					data:"level="+level+"&counter="+x,
					beforeSend:function(){

					},
					success:function(data){

						jQuery(".color_options_more_"+level).append(data);
					}
				});
				x++;
			}
		});
		var counter = 3;
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
		jQuery('.input-show').click(function(){
			jQuery(this).prev().css('display','block');
			jQuery(this).css('display','none');
		});
	});
jQuery(document).ready(function(){
	jQuery(".add_size_more").click(function(e){
		e.preventDefault();
		var i = jQuery(this).attr('level');
		var counter = 3;
		var inclevel = parseInt(i)+1;
		if(i<=counter){
			jQuery(".add_size_more").attr("level",inclevel);
			jQuery.post("http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/products_more.php",{ counter:i},function(data){
				jQuery(".size_more").append(data);
			i++;
			});
		}
	});
	jQuery(".delete-option").click(function(){
		jQuery(this).parent().parent().parent().remove();
	});
});
</script>
<?php

// New Code for Editing by ShadowKiller
if(isset($_REQUEST['submit'])){
	global $wpdb;
	$Product_name =$_REQUEST['product_name'];
	// Fetching Old Data
	$getAllData = $wpdb->get_results("SELECT * from wp_slider where id='".$_REQUEST['id']."'");	
	$prev_name = $getAllData[0]->product_name;
	// Code For Product Image
	if($_FILES['product_image']['name']==''){
		$productImage = $getAllData[0]->image_name;
	} else {
		$image_path = __DIR__."/images/".$_FILES['product_image']['name'];
		move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path);
		$productImage = $_FILES['product_image']['name'];
	}

	// Color Image Code 
	if(isset($_FILES['color_image']['name'])){
		$prevColorImage = json_decode($getAllData[0]->colors_image,true);
		$new_colors = array_filter($_FILES['color_image']['name']);
		$new_color = array_combine(range(1, count($new_colors)), array_values($new_colors));
		foreach ($new_color as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_color_image[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
		$new_color_tmp_names = array_filter($_FILES['color_image']['tmp_name']);
		$new_color_tmp_name = array_combine(range(1, count($new_color_tmp_names)), array_values($new_color_tmp_names));
		foreach ($new_color_tmp_name as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_color_name[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
		$countOptions = count($sort_color_image);
		$counter=1;
		while($counter<=$countOptions){
			$countOptionsAgain = count($sort_color_image[$counter]);
			$counterAgain = 1;
			while($counterAgain<=$countOptionsAgain){	
				if($sort_color_image[$counter][$counterAgain][0]==''){
					$uploadColorImage[$counter][$counterAgain][0] = $prevColorImage[$counter][$counterAgain][0]; 
				} else {
					if($sort_color_image[$counter][$counterAgain][0]!=""){	
						$new_colors_image =uniqid().$sort_color_image[$counter][$counterAgain][0];
					}
					//$new_colors_image = uniqid().$sort_color_image[$counter][$counterAgain][0];
					$image_path = __DIR__."/color_image/".$new_colors_image;
					move_uploaded_file($sort_color_name[$counter][$counterAgain][0], $image_path);
					$uploadColorImage[$counter][$counterAgain][0] = $new_colors_image; 
				}
				$counterAgain++;
			}
			$counter++;
		}
	}
	// Panel Images Code 
	if(isset($_FILES['panel_image']['name'])){
		$prevPanelImages = json_decode($getAllData[0]->panels_image,true);
		$new_panels = array_filter($_FILES['panel_image']['name']);
		$new_panel = array_combine(range(1, count($new_panels)), array_values($new_panels));
		foreach ($new_panel as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_panel_image[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
		$new_panel_tmp_names = array_filter($_FILES['panel_image']['tmp_name']);
		$new_panel_tmp_name = array_combine(range(1, count($new_panel_tmp_names)), array_values($new_panel_tmp_names));
		foreach ($new_panel_tmp_name as $key => $value) {
			$tipCounter = 1;
			foreach ($value as $k => $v) {
				foreach ($v as $length => $value) {
					$sort_panel_name[$key][$tipCounter][]=$value;
				}
				$tipCounter++;
			}
		}
		$countOptions = count($new_panel);
		$counter = 1;
		while($counter<=$countOptions){
			$countOptionsAgain = count($sort_panel_image[$counter]);
			$counterAgain = 1;
			while($counterAgain<=$countOptionsAgain){
				$countOptionsAgain2 = count($sort_panel_image[$counter][$counterAgain]);
				$length = 0;
				while($length<$countOptionsAgain2){
					if($sort_panel_image[$counter][$counterAgain][$length]==''){
						$uploadPanelImage[$counter][$counterAgain][$length] = $prevPanelImages[$counter][$counterAgain][$length]; 
					} else {
						$new_panels_image =uniqid().$sort_panel_image[$counter][$counterAgain][$length];
						$target = __DIR__."/products/large/".$new_panels_image;
						$uploadPanelImage[$counter][$counterAgain][$length] = $new_panels_image; 
						if($counter==1){	
							$nheight= '305';
							$nwidth= '100';
						}
						if($counter==2){	
							$nheight= '345';
							$nwidth= '100';
						}
						if($counter==3){	
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
									$source = imagecreatefromjpeg($sort_panel_name[$counter][$counterAgain][$length]);
								}
								else if($extension=="png")
								{
									$source = imagecreatefrompng($sort_panel_name[$counter][$counterAgain][$length]);
								}
								else 
								{
									$source = imagecreatefromgif($sort_panel_name[$counter][$counterAgain][$length]);
								}
								list($width,$height)=getimagesize($sort_panel_name[$counter][$counterAgain][$length]);
								if($width>800){
									if($counter==1){
										$max = 305;
									}
									if($counter==2){
										$max = 345;
									}
									if($counter==3){
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
						move_uploaded_file($sort_panel_name[$counter][$counterAgain][$length], $target);
					}
					$length++;
				}
				$counterAgain++;
			}
			$counter++;
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
	//panel size
	if(isset($_REQUEST['panel_size'])){
		$panels_sizes = array_filter($_REQUEST['panel_size']);
		$panels_size = array_combine(range(1, count($panels_sizes)), array_values($panels_sizes));
	}
	$length_counter = count($_REQUEST['panel_size']);
$wpdb->update('wp_slider',array( 
		'image_name' => $productImage,
		'product_name' => $_REQUEST['product_name'],	
		'product_description' => $_REQUEST['product_description'],
		'panels_size' => json_encode($panels_size),
		'color_name' => json_encode($sort_name),
		'colors_image' => json_encode($uploadColorImage),
		'panels_image' => json_encode($uploadPanelImage),
		'length_counter' => $length_counter,
		'sort_order_no' => $_REQUEST['sort_order']
		), 
	array('ID' => $_REQUEST['id']), 
	array('%s','%s','%s','%s','%s','%s','%s','%d','%d'), 
	array('%d') 
	);
}
function getExt($new_panels_image) {
	$pos = strrpos($new_panels_image,".");
	if (!$pos) { return "null"; }
	$len = strlen($new_panels_image) - $pos;
	$ext = substr($new_panels_image,$pos+1,$len);
	return strtolower($ext);
}
?>
<style type="text/css">
	.color-image{height: 50px; position: relative; left: 42px;}
	.delete{height: 30px; cursor: pointer; position: relative; top: -15px; left: 46px;}
	.span{position: absolute; margin-top: 15px; margin-left: 5px; color: deepskyblue; text-decoration: underline;}
	.panel-image{position: relative; height: 50px; left: 43px;}
	.div{margin-top:10px; cursor: pointer; display: block; width: 170px;}
	.space-top{margin-top: 4%}
	.add{height: 50px;}
	.del-img{margin-left: 12px;}
	.space-left{margin-left: 13px; margin-top: 25px;}
	.display-block{width:20%; cursor: pointer; display: block;}
	.right{float: right; margin-right: 0%; position: relative; cursor: pointer;}
	.form-table td{position: relative;}
	.input-setting{position: absolute; top: 10%;}
	.div-width { width: 49%;cursor: pointer;position: relative;top: -6px;}
	.add{height: 40px; }
	.span{position: relative; bottom:15px; margin-left: 5px; color: deepskyblue; text-decoration: underline;}
	.div-width{width:49%; cursor: pointer; position: relative; top:-6px;}
	.input-hide{display: none;}
	.input-show{cursor: pointer; color: deepskyblue; }
	.clear{clear: both;}
	.input-container{float: left;}
	.input-container2{float: right}
</style>
<form method="post" enctype="multipart/form-data">
	<?php 
	global $wpdb;
	$id=$_REQUEST['id'];
	$query = $wpdb->get_results("SELECT * FROM wp_slider WHERE id='$id'");
	foreach ($query as $value) { ?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="product_name">Product Name</label></th>
				<td><input name="product_name" type="text" id="product_name" value="<?php echo $value->product_name;?>" class="regular-text" ></td>
			</tr>
			<tr>
				<th scope="row"><label for="product_image">Product Image</label></th>
				<td><input name="product_image" type="file" id="product_image"  class="regular-text"></td>
				<?php
				$image_path=plugins_url('Rev_Custom_Slider/images/'.$value->image_name); 
				?>
				<td><img src="<?php echo $image_path;?>" height="50"></td>
			</tr>
			<tr>
				<th scope="row"><label for="product_description">Product Description</label></th>
				<td><textarea name="product_description" id="product_description"  class="large-text code" rows="3" style="width:50%" ><?php echo $value->product_description;?></textarea></td>
			</tr>
			<tr>
				<th scope="row"><label for="sort_order">Sort Order Number</label></th>
				<td><input name="sort_order" type="text" id="sort_order"  class="regular-text" value="<?php echo $value->sort_order_no;?>"></td>
			</tr>
			<?php 
			$Product_name = $value->product_name;
			$Colors_image = $value->colors_image;
			$Panels_image = $value->panels_image;
			$Sizes = $value->panels_size;
			$Description = $value->size_description;
			$Colors_image=json_decode($Colors_image,true);
			$Panels_image=json_decode($Panels_image,true);
			$Panels_sizes=json_decode($Sizes,true);
			$Sizes_description=json_decode($Description,true);
			$Colors_name = json_decode($value->color_name,true);
			$counter=$value->length_counter;
			if($counter==0){
				?>
				<tr>
					<th scope="row">Size Options</th>
					<td class="block">
						<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/add.png');?>" height="50">
						<span class="color">Add Size Options</span>
					</td>
				</tr>
				<?php 
			}
			else {
			for($i=1;$i<=$counter;$i++) { ?>
				<tr>
					<th scope="row"></th>
					<td class="block">
						<table class="box box_<?php echo $i;?>">
							<tr>
								<th><h3>Size Option <?php echo $i;?></h3></th>
								<td class="right delete-option" level="<?php echo $level;?>">
								<?php if($i>1){?>
									<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/delete2.png');?>" height="40">
									<?php }?>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="panel_size">Panels Size</label></th>
								<td class="panel_size">
									<?php
									$length=count($Panels_sizes[$i]);
									for($j=0;$j<$length;$j++) {
										$Size=$Panels_sizes[$i][$j];
										?>
										<input type="text" name="panel_size[<?php echo $i;?>][]" id="panel_size" class="regular-text input" value="<?php echo $Size;?>">
										<?php }?>
									</td>
								</tr>
								<?php
								$length = count($Colors_name[$i]);
								for($j=1;$j<=$length;$j++){ ?>
								<tr>
									<th colspan="2"><h3>Color Option <?php echo $j;?></h3></th>
								</tr>
								<tr>
									<th scope="row"><label for="color_name">Color Name</label></th>
									<td class="color_name">
										<input type="text" name="color_name[<?php echo $i;?>][<?php echo $j?>][]" id="color_name" class="regular-text" value="<?php echo $Colors_name[$i][$j][0];?>">
									</td>
								</tr>
								<tr>
									<th scope="row"><label for="color_image">Color Image</label></th>
									<td>
									<?php if($Colors_image[$i][$j][0]==""){ ?>
									<div class="input-container">
										<input type="file" name="color_image[<?php echo $i; ?>][<?php echo $j?>][]" class="regular-text input-setting" id="color_image">
									</div>
										<?php } else {?>
										<div class="input-container">
											<input type="file" name="color_image[<?php echo $i; ?>][<?php echo $j?>][]" class="input-hide regular-text input-setting" id="color_image">
											<span class="input-show">Change Color Image</span>
										</div>	
										<div class="input-container2">
											<img src="<?php echo plugins_url('Rev_Custom_Slider/color_image/').$Colors_image[$i][$j][0]; ?>" class="color-image">
											<span class="delete-color" image-name="<?php echo $Colors_image[$i][$j][0];?>" counter="<?php echo $j;?>" level="<?php echo $i;?>" id="<?php echo $id;?>">
												<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/delete.png');?>" class="delete ">
											</span>
										</div>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<th scope="row"><label for="panel_image">Panels Image</label></th>
									<td class="panel_image_<?php echo $i;?>">
										<?php
										$lengthAgain=count($Panels_image[$i][$j]);
										for($k=0;$k<$lengthAgain;$k++)
										{
											$panelimage=$Panels_image[$i][$j][$k];
											$image_path=plugins_url('Rev_Custom_Slider/panels/'.$panelimage);
											?>
											<div class="input-container">
												<input type="file" name="panel_image[<?php echo $i; ?>][<?php echo $j?>][]" class="input-hide regular-text" id="panel_image">
												<span class="input-show">Change Panel Image</span>
											</div>	
											<div class="input-container2">
												<img src="<?php echo plugins_url('Rev_Custom_Slider/products/small/'.$panelimage);?>" class="panel-image">
												<span class="delete-panel" image-name="<?php echo $Panels_image[$i][$j][$k];?>" counter="<?php echo $j;?>" level="<?php echo $i;?>" counterAgain="<?php echo $k;?>" id="<?php echo $id;?>">
													<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/delete.png');?>" class="delete ">
												</span>
											</div>	
											<div class="clear"></div>
											<?php 
										} ?> 
										<span class="div panel_more panel_more_<?php echo $i;?>_<?php echo $j;?>" level="<?php echo $i;?>" counter="<?php echo $j;?>">
											<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/add.png');?>" class="add">
											<span class="span"> Add More Panels</span>
										</span>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td colspan="2" class="color_options_more_<?php echo $i;?>"></td>
								</tr>
								<tr>
									<td colspan="2">
										<span class="div add_color_more" level="<?php echo $i;?>" counter="<?php echo $j;?>">
											<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/add.png');?>" class="add">
											<span class="span"> Add Color options</span>
										</span>
									</td>
								</tr>
							</table> 
						</td>
					</tr>
			<?php } 			
			if($counter<3){?>
			<tr>
				<td></td>
				<td class="size_more"></td>
			</tr>
			<tr>
				<td colspan="2">
					<span class="div add_size_more" level="<?php echo $i;?>">
						<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/add.png');?>" class="add">
						<span class="span"> Add Size more</span>
					</span>
				</td>
			</tr> 
			<?php } }?> 
			<tr>
				<td>
					<input type="hidden" value="<?php echo $id;?>" name="id">
					<input name="submit" type="submit" value="Submit" class="large-text code"></td>
				</tr>
				</tbody>
			</table>
			<?php } ?>
		</form>

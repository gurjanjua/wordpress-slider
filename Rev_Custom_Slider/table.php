<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.view-table').DataTable();
	});
	jQuery(document).ready(function(){
		jQuery(".delete").click(function(e){
			e.preventDefault();
			var result = confirm("Are you sure");
			if(result==true){
				var id = jQuery(this).attr('id');
				jQuery.ajax({
					type:"GET",
					url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/delete.php",
					data:"id="+id,
					beforeSend:function(){
						
					},
					success:function(data){
						window.location.reload();
					}
				});	
			}
		})
	});
</script>
<style type="text/css">
	.dataTables_wrapper{margin-top: 20px;}
</style>
<table class="view-table">
	<thead>
		<tr>
			<th>Sno</th>
			<th>Product Name</th>
			<th>Product Image</th>
			<th>Product Description</th>
			<th width="100">Colors Images</th>
			<th>Panels Images</th>
			<th>Panels Sizes</th>
			<th>Action</th>
		</tr>	
	</thead>
	<tbody>
		<?php
		$sno=1;
		global $wpdb;
		$result = $wpdb->get_results ( "SELECT * FROM wp_slider" );
		foreach ( $result as $print )   
		{	
			$Product_name = $print->product_name;
			$counter=$print->length_counter;
			$image=$print->image_name;
			?>
			<tr>
				<td><?php echo $sno;?></td>
				<!-- fetching product-name -->
				<td><?php echo $print->product_name;?></td>
				<!-- end of fetching product-name -->
				<!-- fetching product-image -->
				<td><img src="<?php echo plugins_url('Rev_Custom_Slider/images/'.$image);?>" height="50" width="70"></td>
				<!-- end of fetching product-image -->
				<!-- fetching product-description -->
				<td><?php echo $print->product_description;?></td>
				<!-- end of fetching product-description -->
				<!-- fetching color-image -->
				<td>
					<?php
					$colors=$print->colors_image;
					$colors=json_decode($colors,true);
					for($i=1;$i<=$counter;$i++)
					{
						$length=count($colors[$i]);
						for($j=1;$j<=$length;$j++)
						{
							$image=$colors[$i][$j][0];
							if($image!=""){ 
								?>
								<img src="<?php echo plugins_url('Rev_Custom_Slider/color_image/'.$image);?>" height="50" width="50">
								<?php 
							}
						}
					}
					?>
				</td>
				<!-- end of fetching color-image -->
				<!-- fetching panel-image -->
				<td>
					<?php
					$panels=$print->panels_image;
					$panels_image=json_decode($panels,true);
					$counter = count($panels_image);
					for($i=1;$i<=$counter;$i++)
					{
						$length=count($panels_image[$i]);
						for($j=1;$j<=$length;$j++)
						{
							$lengthAgain = count($panels_image[$i][$j]);
							for($k=0;$k<$lengthAgain;$k++){
								$image=$panels_image[$i][$j][$k];
								?>
								<img src="<?php echo plugins_url('Rev_Custom_Slider/products/small/'.$image);?>" height="50">
							<?php 	
							}
						}
						if($i!=$counter){ echo "<br>"; }
					}
					?>
				</td>
				<!-- end of fetching panel-image -->
				<!-- fetching panel-size  -->
				<td>
					<?php
					$panels=$print->panels_size;
					$panels_size=json_decode($panels,true);
					$counter=count($panels_size);
					for($i=1;$i<=$counter;$i++)
					{
						$length=count($panels_size[$i]);
						for($j=0;$j<$length;$j++)
						{
							echo $size=$panels_size[$i][$j]."<br>";
						}
					}
					?>
				</td>
				<!--end of fetching panel-image -->
				<td>
					<div>
						<span>
							<a href="admin.php?page=wp-slider&tab=edit&id=<?php echo $print->id;?>">
								<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/edit.png');?>" style="position: relative; top: 14px; width:30px;">
							</a>
						</span>
						<span>
							<a href="" class="delete" id="<?php echo $print->id;?>">
								<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/del.png');?>" style="position: relative; top: 10px; width:25px;">
							</a>
						</span>
					</div>
				</td>
			</tr>
			<?php 
			$sno++;
		} 
		?>
	</tbody>
</table>
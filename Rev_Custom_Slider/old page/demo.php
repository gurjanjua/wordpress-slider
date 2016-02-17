<tr>
									<th scope="row"><label for="color_image">Color Image</label></th>
									<td>
										<input type="file" name="color_image[<?php echo $i; ?>][]" class="regular-text" id="color_image">
										<img src="<?php echo plugins_url('Slider/color_image/').$Colors_image[$i][0]; ?>" class="color-image image-set">
									</td>
								</tr>
								<tr>
									<th scope="row"><label for="panel_image">Panels Image</label></th>
									<td class="panel_image_<?php echo $i;?>">
										<?php
										$length=count($Panels_image[$i]);
										for($j=0;$j<$length;$j++)
										{
											$panelimage=$Panels_image[$i][$j];
											$image_path=plugins_url('Slider/panels/'.$panelimage);
											?>
											<div class="input-container">
												<input type="file" name="panel_image[<?php echo $i; ?>][]" class="regular-text" id="panel_image">
												<img src="<?php echo plugins_url('Slider/panels/'.$panelimage);?>" class="panel-image">
												<span class="delete-panel" image-name="<?php echo $Panels_image[$i][$j];?>" counter="<?php echo $j;?>" array="<?php echo $i;?>" id="<?php echo $id;?>">
													<img src="<?php echo plugins_url('Slider/icon/delete.png');?>" class="delete ">
												</span>
											</div>
											<?php 
										} ?> 
										<span class="div panel_more panel_more_<?php echo $i;?>" level="<?php echo $i;?>">
											<img src="<?php echo plugins_url('Slider/icon/add.png');?>" class="add">
											<span class="span"> Add More</span>
										</span>
									</td>
								</tr>
								
								</table> 
							</td>
						</tr>
						<?php 
					}
					?>
					<tr>
						<th></th>
						<td class="append"></td>
					</tr>
					<tr>
						<th></th>
						<td>
							<div class="display-block add_more_options" data-level="<?php echo $counter;?>">
								<img src="<?php echo plugins_url('Slider/icon/add.png');?>" height="50">
								<span class="span">Add Color Options</span>
							</div>	
						</td>
					</tr>
					<tr>
						<td>
							<input type="hidden" value="<?php echo $id;?>" name="id">
							<input name="submit" type="submit" value="Submit" class="large-text code"></td>
						</tr>
					</tbody>
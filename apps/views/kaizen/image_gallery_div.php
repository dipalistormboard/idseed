
<div style="margin-top:20px;border-style: solid;border-width: 1px;padding: 10px;margin-right: 50px;" id="div_<?php echo $count ?>" >
<a href="javascript:void(0);" onclick="closedivimage('div_<?php echo $count ?>');" style="margin-left: 500px;">X</a>
<td align="left" valign="top">
    <table width="96%" border="0" cellspacing="0" cellpadding="0">
                
                                                
            <tr id="img_<?php echo $count ?>" >
            <td width="134" align="left" valign="top"><label class="labelname">Species Image:</label></td>
            <td align="left" valign="top" width="349">
                <?php $image = base_url("public/images/no_image.jpg");
                        if(!empty($species_img) ){$image =  base_url()."public/uploads/factsheet_species_image/".$species_img;
                        }?>
                                <img id="image_<?php echo $count ?>"  src="<?php if(!empty($image)){ echo $image; }?>" style="width:130px;height:130px;"/>

                                <a class="fancybox_crop fancybox.iframe upload removebtn" href="<?php echo base_url("kaizen/factsheet/newcrop"); ?>?image_id=factsheet_similar_species_image_<?php echo $count; ?>&image_val=<?php if(!empty($species_img)){ echo $species_img; }?>&folder_name=factsheet_species_image&img_sceen=image_<?php echo $count; ?>&prev_img=<?php if(!empty($species_img)){ echo $species_img; }?>&controller=factsheet&height=584&width=355" >Upload</a>
                                
                              <input type="hidden" id="factsheet_similar_species_image_<?php echo $count; ?>" name="factsheet_similar_species_image_<?php echo $count; ?>"  value="<?php if(!empty($species_img)){ echo $species_img; } ?>" />
									</td>
                                                                        
									<td align="left" valign="top" height="12"></td>
                                    </tr>
                                    <tr>
										<td align="left" valign="top" height="10"></td>
								</tr>         
                                    <tr >
                                    
                                    <td width="134" align="left" valign="top"><label class="labelname">Title:</label></td>
                                    
                                <td align="left" valign="top" width="349">
                                    
                                   <input type="Text" id="factsheet_similar_species_image_title_<?php echo $count ?>" name="factsheet_similar_species_image_title_<?php echo $count ?>" value="<?php if(!empty($species_title)){ echo $species_title; } ?>" class="inputinpt" />
                                </td>
                                    </tr>
                                      <tr>
										<td align="left" valign="top" height="10"></td>
								</tr>         
                                    <tr >
                                    
                                    <td width="134" align="left" valign="top"><label class="labelname">Caption:</label></td>
                                    
                                <td align="left" valign="top" width="349">
                                    
                                   <input type="Text" id="factsheet_similar_species_image_caption_<?php echo $count ?>" name="factsheet_similar_species_image_caption_<?php echo $count ?>" value="<?php if(!empty($species_caption)){ echo $species_caption; } ?>" class="inputinpt" />
                                </td>
                                    </tr>
                                    
                                    </table>
						</td>  
		
			</table>
						
						<div class="spacer"></div>
						</div>

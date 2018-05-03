<?php $this->load->view($header); ?>
<?php $this->load->view($left); ?>
<script type="text/javascript" src="<?php echo site_url("public/ckeditor/ckeditor.js");?>"></script>
<link rel="stylesheet" href="<?php echo site_url("public/kaizen/validator/css/validationEngine.jquery.css");?>" type="text/css"/>
<script src="<?php echo site_url("public/kaizen/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url("public/js/jquery.fancybox.js");?>" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo base_url("public/kaizen/css/jquery.fancybox.css");?>" type="text/css"/>
<script>
$('.fancybox').fancybox({width:1200,height:1000});
</script>

<script type="text/javascript">
$(document).ready(function(){
	$("#cont").validationEngine();
	});
function form_submit(){
$('#cont').submit();
}
function goto_page(){
document.location.href = "<?php echo site_url("kaizen/gallery/");?>";

}


function confirmdel_gallery(id,page){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/gallery/dodelete/");?>?deleteid="+id+"&ref="+page;
	}
	else{
		return false;
	}
}

</script>

<div class="bodyright">
		<div class="bodytop"> </div>
		<div class="bodymid">
				<div class="midarea">
						<?php 
		  $attributes = array('name' => 'cont', 'id' => 'cont');
		  echo form_open_multipart('kaizen/gallery/addedit/'.$details->id,$attributes);
		  echo form_hidden('gallery_id', $details->id);
		  
		  ?>
						<?php
		if($this->session->userdata('ERROR_MSG')==TRUE){
			echo '<div class="notific_error">
					<h2 align="center" style="color:#fff;">'.$this->session->userdata('ERROR_MSG').'</h1></div>';
			$this->session->unset_userdata('ERROR_MSG');
		}
		if($this->session->userdata('SUCC_MSG')==TRUE){
			echo '<div class="notific_suc"><h2 align="center" style="color:#000;">'.$this->session->userdata('SUCC_MSG').'</h1></div>';
			$this->session->unset_userdata('SUCC_MSG');
		}
		?>
						<?php echo validation_errors('<div class="notific_error">', '</div>'); ?>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
								<tr>
										<td align="left" valign="top" height="5"></td>
								</tr>
								<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Enter Title : <span>*</span></label></td>
																<td align="left" valign="top" width="349"><input type="text" name="gallery_title" id="gallery_title" value="<?php if(isset($details->title)){echo $details->title;}?>" class="inputinpt validate[required]" /></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
                                
                                <tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Enter Sub-Title : <span></span></label></td>
																<td align="left" valign="top" width="349"><input type="text" name="sub_title" id="sub_title" value="<?php if(isset($details->sub_title)){echo $details->sub_title;}?>" class="inputinpt" /></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
                                 <tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Size : </label></td>
																<td align="left" valign="top" width="349">
                                                               Length: <input type="text" name="size_length" id="size_length" style="width: 50px;" value="<?php if(isset($details->size_length)){echo $details->size_length;}?>" class="inputinpt validate[optional,custom[number]]" />cm
                                                               Width: <input type="text" name="size_width" id="size_width" style="width: 50px;" value="<?php if(isset($details->size_width)){echo $details->size_width;}?>" class="inputinpt validate[optional,custom[number]]" />cm
                                                               Breadth: <input type="text" name="size_breadth" id="size_breadth" style="width: 50px;" value="<?php if(isset($details->size_breadth)){echo $details->size_breadth;}?>" class="inputinpt validate[optional,custom[number]]" />cm</td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
                                 <tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Shape :</label></td>
																<td align="left" valign="top" width="349"><input type="text" name="shape" id="shape" value="<?php if(isset($details->shape)){echo $details->shape;}?>" class="inputinpt" /></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
                                 <tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Colour : </label></td>
																<td align="left" valign="top" width="349"><input type="text" name="colour" id="colour" value="<?php if(isset($details->colour)){echo $details->colour;}?>" class="inputinpt" /></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
								
                                
								<tr>
										<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Gallery Photo : </label></td>
																<td align="left" valign="top" width="349"><div class="formFields">
								<div class="image-upload">
                                            <a class="fancybox fancybox.iframe upload removebtn" href="<?php echo base_url();?>kaizen/gallery/popup/gallery_photo/" style="margin-top:5px;" >Upload</a>
                                            <input type="hidden" id="gallery_photo" name="gallery_photo" value="<?php if(!empty($details->gallery_photo)){ echo $details->gallery_photo; } ?>" />
                                           <!-- <p class="sizetxt">Size Requirement: 360 X 262 pixels</p>-->
                                            </div>
																		</div>
																		<div class="spacer"></div>
																		<p class="sizetxt">Size Requirement: 270 x 335 pixels</p></td>
														</tr>
												</table></td>
								</tr>
                                
                                
                                
								<tr>
										<td align="left" valign="top" height="15"></td>
								</tr>
                                
								<?php						
					if(isset($details->gallery_photo)){						
					?>
								<tr>
										<td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
																<td align="left" valign="top" width="349"><?php
		
		if($details->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/".$details->gallery_photo))	
		{
			
			$image_thumb=file_upload_base_url()."gallery_photo/".$details->gallery_photo;
			
		}
		else
		{
			$image_thumb=file_upload_base_url()."noimage_thumb.jpg";
		}?>
																		<img  id="image_gallery_photo" src="<?php echo $image_thumb;?>" width="100" height="100"/></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="12"></td>
								</tr>
								<tr>
										<td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
																<td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>');" class="removebtn" >Remove</a></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="12"></td>
								</tr>
								<?php
					}
					?>
                    			<tr>
                                    <td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                                <td width="134" align="left" valign="top" ><label class="labelname">Excerpt:</label></td>
                                                <td colspan="2"><?php
                                                if(!empty($details->excerpt)){
                                                    $cont_txt1 = $details->excerpt;
                                                }
                                                else{
                                                    $cont_txt1 = "";
                                                } ?>
                                            <textarea id="excerpt" name="excerpt" rows="3" cols="43" ><?php echo ($cont_txt1);?></textarea></td>
                                            </table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="15"></td>
								</tr>
                                
								<tr>
                                    <td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                                <td width="134" align="left" valign="top" ><label class="labelname">Description:</label></td>
                                                <td align="left" valign="top" width="349">&nbsp;</td>
                                        </tr>
                                        <tr>
                                        <td colspan="2"><?php
                                    if(!empty($details->description)){
                                        $cont_txt = $details->description;
                                    }
                                    else{
                                        $cont_txt = "";
                                    }?>
                                        <textarea id="description" name="description" rows="3" cols="60" ><?php echo ($cont_txt);?></textarea></td>
                                            </tr>
                                    </table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="15"></td>
								</tr>
                                
                                
                                		<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Status:</label></td>
																<td align="left"  width="349"><input type="radio" name="is_active" id="is_active" value="1" 
					  <?php echo ((isset($details->is_active) && $details->is_active ==1)?'checked="checked"':'')?>/>
																		&nbsp;Active &nbsp;&nbsp;
																		<input type="radio" name="is_active" id="is_active_1" value="0" <?php echo ((isset($details->is_active) && $details->is_active ==0)?'checked="checked"':'')?> />
																		&nbsp;Inactive &nbsp;&nbsp; </td>
														</tr>
												</table></td>
								</tr>
                                
								<tr style="display:none;">
										<td align="left" valign="top" height="15"></td>
								</tr>
								<tr style="display:none;">
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Sequence:</label></td>
																<td align="left" valign="top" width="349"><input type="text" id="display_order" name="display_order" value="<?php if(isset($details->display_order)){echo $details->display_order;}?>" class="inputinpt" style="width:150px;"/></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="12"></td>
								</tr>
						</table>
						<div class="bottonportion" style="height:auto">
								<div class="bottonserleft" style="float:none">
										<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
										</table>
								</div>
						</div>
						<div class="bottonserright" style="padding-bottom:20px;"> <a href="javascript:void(0);" title="Delete" onClick="confirmdel_gallery('<?php echo $details->id;?>','<?php echo rawurlencode(site_url("kaizen/gallery/dolist"));?>');" class="darkgreybtn" <?php if(isset($details->id) && $details->id >0){}else{echo 'style="display:none;"';}?>> <span>Delete</span> </a> <a href="javascript:void(0);" class="darkgreybtn" onClick="form_submit();"><span>Save</span></a> <?php echo form_close();?> </div>
				</div>
		</div>
		<div class="bodybottom"> </div>
</div>
<script type="text/javascript">
   if ( typeof CKEDITOR == 'undefined' )
{

}
else
{
	 var editor = CKEDITOR.replace( 'description' );			
}

function confirmdel(id){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/gallery/dodeleteimg/");?>?deleteid="+id;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>

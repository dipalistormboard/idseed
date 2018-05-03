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
    var photo_gif_val = '<?php echo $details->photo_gif; ?>';
        if(photo_gif_val=='1'){
            $('.img').show()
            $('.gif').hide()
        }else{
            $('.gif').show()
            $('.img').hide()
        }
	});

function form_submit(value)
{
$('#from').val(value);
$('#cont').submit();
}



function goto_page(){
document.location.href = "<?php echo site_url("kaizen/gallery/");?>";
}
function showhideimage_gif(val){
    if(val=='gif'){
        $('.gif').show()
        $('.img').hide()
    }else{
        $('.img').show()
        $('.gif').hide()
    }
}


function confirmdel_gallery(id,page,language){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/gallery/dodelete/");?>?deleteid="+id+"&ref="+page+"&language="+language;
	}
	else{
		return false;
	}
}
$(document).ready(function() {
	
    formmodified=0;
	var warn_on_leave = false; 
    $('form *').change(function(){
        formmodified=1;
    });
	
 		
    window.onbeforeunload = confirmExit;
    function confirmExit() {
	  var value = $('#returnval').val();
	
	    if(value!=''){
		  formmodified=1;
	    } 
		
        if (formmodified == 1) {
            return "New information not saved. Do you wish to leave the page?";
        }
	    if(warn_on_leave) { 
	        return 'Attention: Your text has not been saved!'; 
	    } 
    }
    $("#btnsave").click(function() {
        formmodified = 0;
		   warn_on_leave = false; 
    });
    $("#btndelete").click(function() {
        formmodified = 0;
		   warn_on_leave = false; 
    });
    $("#btnsave_back").click(function() {
        formmodified = 0;
		   warn_on_leave = false; 
    });
	
	

	CKEDITOR.on('currentInstance', function() {                
	    try { 
	        CKEDITOR.currentInstance.on('key', function() {        
	            warn_on_leave = true; 
	        }); 
	    } catch (err) { }                                        
	});

	
});
</script>

<div class="bodyright">
    <?php if(!empty($details->title)){ if(empty($language)){ ?>
            
            <div style="float:right;">
            
            <a href="<?php echo site_url("kaizen/gallery/doedit/".$details->id."?language=french&page=".$pgs); ?>">
            Switch to French
            </a></div>
            
            <?php }else{ ?>
            
            <div style="float:right;">
            
            <a href="<?php echo site_url("kaizen/gallery/doedit/".$details->id."?page=".$pgs); ?>">
            Switch to English
            </a></div>
            
            <?php } } ?>
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
            <input type="hidden" id="language" name="language" value="<?php echo !empty($language)?$language:''; ?>" />
            <input type="hidden" id="pagenum" name="pagenum" value="<?php echo !empty($pgs)?$pgs:''; ?>" />            
            <input type="hidden" name="returnval" id="returnval" value=""/>
                        <input type="hidden" name="from" id="from" value=""/>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
								<tr>
										<td align="left" valign="top" height="5"></td>
								</tr>
								<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Title : <span>*</span></label></td>
																<td align="left" valign="top" width="349">
																	<?php
																	                                                if(!empty($details->title)){
																	                                                    $cont_txt2 = $details->title;
																	                                                }
																	                                                else{
																	                                                    $cont_txt2 = "";
																	                                                } ?>
																<textarea id="gallery_title" name="gallery_title" class="validate[required]" style="width:99% !important; height:180px; resize:none;"><?php echo ($cont_txt2);?></textarea>
																												
																	
																</td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
                                
                                <tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Family: <span></span></label></td>
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
										<td align="left" valign="top" height="15"></td>
								</tr>
                                
                                
                            <tr>
							<td align="left" valign="top">
                                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                            <td width="134" align="left" valign="top"><label class="labelname">Upload Image:</label></td>
                                            <td align="left"  width="349">
                                                <input type="radio" name="photo_gif" id="photo_gif" onclick="showhideimage_gif('img')" value="1" 
  <?php echo ((isset($details->photo_gif) && $details->photo_gif ==1)?'checked="checked"':'')?>/>
                                                    &nbsp;Upload Image With Crop &nbsp;&nbsp;
                                                <input type="radio" name="photo_gif" id="photo_gif_1" onclick="showhideimage_gif('gif')"value="0" <?php echo ((isset($details->photo_gif) && $details->photo_gif ==0)?'checked="checked"':'')?> />
                                                    &nbsp;Upload GIF &nbsp;&nbsp; </td>
                                    </tr>
								</table></td>
								</tr>
                                
                                
                                
								<tr class="img">
										<td align="left" valign="top" height="13"></td>
								</tr>
								
                                
								<?php /*?><tr class="img">
										<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Upload Image With Crop : </label></td>
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
								</tr><?php */?>
                                
                                 <!-- crop tool -->
        <tr id="image1" class="img">
            <td width="134" align="left" valign="top"><label class="labelname">Image:</label></td></tr>
        <tr id="image2"  class="img">
            <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
                    <td align="left" valign="top" width="349">
                        <?php $image = base_url("public/images/no_image.jpg");
                        
						if(!empty($details->gallery_photo) && is_file(file_upload_absolute_path()."gallery_photo/".$details->gallery_photo))
						{
							$image =  base_url()."public/uploads/gallery_photo/".$details->gallery_photo;
						}
						
						?>
                                <img id="image"  src="<?php if(!empty($image)){ echo $image; }?>" style="width:130px;height:130px;"/>
                                
                                
                              <a class="fancybox fancybox.iframe upload removebtn" href="<?php echo base_url("kaizen/gallery/newcrop"); ?>?image_id=gallery_photo&image_val=<?php if(!empty($details->gallery_photo)){ echo $details->gallery_photo; }?>&folder_name=gallery_photo&img_sceen=image&prev_img=<?php if(!empty($details->gallery_photo)){ echo $details->gallery_photo; }?>&controller=gallery&height=296&width=232" >Upload</a>
                              <input type="hidden" id="gallery_photo" name="gallery_photo"  value="<?php if(!empty($details->gallery_photo)){ echo $details->gallery_photo; } ?>" />
                               </td></tr></table></td>
									</td>
                                                                        
            <td align="left" valign="top" height="12"></td>
        </tr>
        <?php if(!empty($details->gallery_photo)){ ?>
        <tr style="" id="image3"  class="img">
          <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
                <td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>','gallery_photo','<?php echo !empty($language)?$language:''; ?>');" class="removebtn" >Remove</a></td>
              </tr>
            </table></td>
        </tr>
        <?php } ?>
        <!-- crop tool end -->
                                
								<tr class="img">
										<td align="left" valign="top" height="15"></td>
								</tr>
                                
								<?php /*?><?php						
					if(isset($details->gallery_photo)){						
					?>
								<tr class="img">
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
								<tr class="img">
										<td align="left" valign="top" height="12"></td>
								</tr>
								<tr class="img">
										<td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
																<td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>','gallery_photo','<?php echo !empty($language)?$language:''; ?>');" class="removebtn" >Remove</a></td>
														</tr>
												</table></td>
								</tr>
								<tr class="img">
										<td align="left" valign="top" height="12"></td>
								</tr>
								<?php
					}
					?><?php */?>
                                <!-- gif image start -->
                                <tr class="gif">
										<td align="left" valign="top" height="13"></td>
								</tr>
								
								<tr class="gif">
										<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Upload GIF : </label></td>
																<td align="left" valign="top" width="349"><div class="formFields">
																				<div class="fileinputs">
																						<input type="file" class="file" name="htmlfile" onChange="document.getElementById('fakefilepc1').value = this.value;" style="width:350px;"/>
																						<div class="fakefile">
																								<input id="fakefilepc1" type="text" disabled="disabled" name="newsletterfile" />
																								<img src="<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>" alt="" height="31" width="84" onMouseOver="this.src='<?php echo site_url("public/kaizen/images/browsebtn-ho.jpg");?>'" onMouseOut="this.src='<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>'" /> </div>
																				</div>
																		</div>
																		<div class="spacer"></div>
																		<!--<p class="sizetxt">Size Requirement: 2000 x 650 pixels</p></td>-->
														</tr>
												</table></td>
								</tr>
								<tr class="gif">
										<td align="left" valign="top" height="15"></td>
								</tr>
								<?php						
					if(!empty($details->gif_image)){						
					?>
								<tr class="gif">
										<td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
																<td align="left" valign="top" width="349"><?php
		
		if($details->gif_image!='' && is_file(file_upload_absolute_path()."gallery_photo/".$details->gif_image))	
		{
			
			$image_thumb=file_upload_base_url()."gallery_photo/".$details->gif_image;
			
		}
		else
		{
			$image_thumb=file_upload_base_url()."noimage_thumb.jpg";
		}?>
																		<img src="<?php echo $image_thumb;?>" width="150" height="100"/></td>
														</tr>
												</table></td>
								</tr>
								<tr class="gif">
										<td align="left" valign="top" height="12"></td>
								</tr>
								<tr class="gif">
										<td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
																<td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>','gif_image','<?php echo !empty($language)?$language:''; ?>');" class="removebtn" >Remove</a></td>
														</tr>
												</table></td>
								</tr>
								<tr class="gif">
										<td align="left" valign="top" height="12"></td>
								</tr>
								<?php
					}
					?>
                                <!-- gif image part end-->
                                
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
                                            <textarea id="excerpt" name="excerpt" style="width:99% !important; height:180px; resize:none;"><?php echo ($cont_txt1);?></textarea></td>
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
                                            <textarea id="description" name="description" rows="10" cols="60" style="resize:none"><?php echo ($cont_txt);?></textarea></td>
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
                                
								<tr>
										<td align="left" valign="top" height="15"></td>
								</tr>
								<tr>
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
<div class="bottonserright" style="padding-bottom:20px;"> 
  <?
     if(empty($language)){
       $language ='english';
     }
     else{
       $language = 'french';
     }
    
  ?>
<a href="javascript:void(0);" title="Delete" onClick="confirmdel_gallery('<?php echo $details->id;?>','<?php echo rawurlencode(site_url("kaizen/gallery/dolist"));?>','<? echo $language?>');" class="darkgreybtn" <?php if(isset($details->id) && $details->id >0){}else{echo 'style="display:none;"';}?> id="btndelete"> <span>Delete</span> </a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:void(0);" class="darkgreybtn" onClick="form_submit('edit');" id="btnsave"><span>Save</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
 <a href="javascript:void(0);" class="darkgreybtn" onClick="form_submit('<?php echo $pgs.'#'.$details->id; ?>');" id="btnsave_back"><span>Save and Go-Back</span></a>
  <?php echo form_close();?> </div>
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
	 var editor = CKEDITOR.replace( 'excerpt',{
             toolbar :
    [
   
    ['Bold','Italic','Underline','Strike'],
    
    ]   
         } );	
		 
		 var editor = CKEDITOR.replace( 'gallery_title',{
		             toolbar :
		    [
   
		    ['Bold','Italic','Underline','Strike'],
    
		    ]   
		         } );			
}

function confirmdel(id,dbfield,language){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/gallery/dodeleteimg/");?>?deleteid="+id+"&dbfield="+dbfield+"&language="+language;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>
<?php $this->load->view($header); ?>
<?php $this->load->view($left); ?>
<script type="text/javascript" src="<?php echo site_url("public/ckeditor/ckeditor.js");?>"></script>
<link rel="stylesheet" href="<?php echo site_url("public/kaizen/validator/css/validationEngine.jquery.css");?>" type="text/css"/>
<script src="<?php echo site_url("public/kaizen/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url("public/js/jquery.fancybox.js");?>" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo base_url("public/kaizen/css/jquery.fancybox.css");?>" type="text/css"/>
<script>
$('.fancybox').fancybox({
  width:'1200',
  height: '800'
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#cont").validationEngine();
	});
function form_submit(value)
{
$('#from').val(value);
$('#cont').submit();
}
function goto_page(){
document.location.href = "<?php echo site_url("kaizen/glossary/");?>";

}


function confirmdel_glossary(id,page){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/glossary/dodelete/");?>?deleteid="+id+"&ref="+page;
	}
	else{
		return false;
	}
}

function addAnothercontent(glossary_image,id){
	
	var count = $('#count_content').val();
	var count_val = parseInt(count)+1;
	jQuery('#count_content').val(count_val);
	//alert(count_val);
	jQuery.ajax({
			   type: "POST",
                           async: false,
				url : '<?php echo site_url("kaizen/contact_info/add_content/");?>',
              data: { count:count,glossary_image:glossary_image,id:id},
				dataType : "html",
				success: function(data)
				{
					if(data)
					{
							jQuery("#add_content").prepend(data);
					}
					else
					{
						//alert("Sorry, Some problem is there. Please try again.");
					}
				},
				error : function() 
				{
					alert("Sorry, The requested property could not be found.");		
				}
			});
}
function call_hideshow(showhide_id){
	
	var incr = parseInt(showhide_id) + 1;	
	$('#add_id'+showhide_id).hide();
	$('#glossary_img'+showhide_id).show();
	$('#add_id'+incr).show();
	
}

$(document).ready(function() {
	
    formmodified=0;
	var warn_on_leave = false; 
    $('form *').change(function(){
        formmodified=1;
    });
	
 
	//alert(formmodified);
	/* $('input:hidden').each(function() {
	    var value = $(this).val();
		if(value!=''){
			formmodified=1;
		}
	    // do something with the value
	}); */
		
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
    $("#btnsave_back").click(function() {
        formmodified = 0;
		   warn_on_leave = false; 
    });
	
    $("#btndelete").click(function() {
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
            
          <a href="<?php echo site_url("kaizen/glossary/doedit/".$details->id."?language=french&page=".$pgs); ?>">
          Switch to French
          </a>
          </div>
            
            <?php }else{ ?>
            
            <div style="float:right;">
           
            <a href="<?php echo site_url("kaizen/glossary/doedit/".$details->id."?page=".$pgs); ?>">
            Switch to English
            </a>
          </div>
            
            <?php } } ?>
		<div class="bodytop"> </div>
		<div class="bodymid">
				<div class="midarea">
						<?php 
		  $attributes = array('name' => 'cont', 'id' => 'cont');
		  echo form_open_multipart('kaizen/glossary/addedit/'.$details->id,$attributes);
		  echo form_hidden('glossary_id', $details->id);
		  
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
                    <input type="hidden" name="from" id="from" value=""/>
					 <input type="hidden" name="returnval" id="returnval" value=""/>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
								<tr>
										<td align="left" valign="top" height="5"></td>
								</tr>
								<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Enter Title : <span>*</span></label></td>
																<td align="left" valign="top" width="349"><input type="text" name="glossary_title" id="glossary_title" value="<?php if(isset($details->title)){echo $details->title;}?>" class="inputinpt validate[required]" style="width:97%" /></td>
														</tr>
												</table></td>
								</tr>
                                
                                <tr>
										<td align="left" valign="top" height="5"></td>
								</tr>
                                <tr>
										<td align="left" valign="top" height="5"></td>
								</tr>
								<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Image Caption: </label></td>
																<td align="left" valign="top" width="349">
                                                               
         <textarea name="glossary_caption" id="glossary_caption" style="width:100%; height: 180px; resize:none"><?php if(isset($details->caption)){echo $details->caption;}?></textarea>
                                                                </td>
														</tr>
												</table></td>
								</tr>
                                
                                
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
								
                                
                                
                                
                                
                              <?php /*?>  <tr>
										<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Image : </label></td>
																<td align="left" valign="top" width="349"><div class="formFields">
																				<div class="fileinputs">
																						<input type="file" class="file" name="htmlfile" onChange="document.getElementById('fakefilepc1').value = this.value;" style="width:350px;"/>
																						<div class="fakefile">
																								<input id="fakefilepc1" type="text" disabled="disabled" name="newsletterfile" />
																								<img src="<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>" alt="" height="31" width="84" onMouseOver="this.src='<?php echo site_url("public/kaizen/images/browsebtn-ho.jpg");?>'" onMouseOut="this.src='<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>'" /> </div>
																				</div>
																		</div>
																		<div class="spacer"></div>
																		<!--<p class="sizetxt">Size Requirement: 2000 x 650 pixels</p>--></td>
														</tr>
												</table></td>
								</tr><?php */?>
								<tr>
										<td align="left" valign="top" height="15"></td>
								</tr>
                                
                                
         <!-- crop tool start -->
        <tr id="image1" >
            <td width="134" align="left" valign="top"><label class="labelname">Image 1:</label></td></tr>
        <tr id="image2" >
            <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
                    <td align="left" valign="top" width="349">
                        <?php $image = base_url("public/images/no_image.jpg");
                        
						if(!empty($details->glossary_image) && is_file(file_upload_absolute_path()."glossary/".$details->glossary_image))
						{
							$image =  base_url()."public/uploads/glossary/".$details->glossary_image;
						}
						
						?>
                                <img id="gimage1"  src="<?php if(!empty($image)){ echo $image; }?>" style="width:130px;height:130px;"/>
                                
                                
                              <a class="fancybox fancybox.iframe upload removebtn" href="<?php echo base_url("kaizen/glossary/newcrop"); ?>?image_id=glossary_image&image_val=<?php if(!empty($details->glossary_image)){ echo $details->glossary_image; }?>&folder_name=glossary&img_sceen=gimage1&prev_img=<?php if(!empty($details->glossary_image)){ echo $details->glossary_image; }?>&controller=glossary&height=296&width=232" >Upload</a>
                              <input type="hidden" id="glossary_image" name="glossary_image"  value="<?php if(!empty($details->glossary_image)){ echo $details->glossary_image; } ?>" />
                               </td></tr></table></td>
									</td>
                                                                        
            <td align="left" valign="top" height="12"></td>
        </tr>
        <?php if(!empty($details->glossary_image)){ ?>
        <tr style="" id="image3">
          <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
                <td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>','glossary_image','<?php echo !empty($language)?$language:''; ?>');" class="removebtn" >Remove</a></td>
              </tr>
            </table></td>
        </tr>
        <?php } ?>
        <!-- crop tool end -->
		<tr id="add_id2" style="display:<?php if(!empty($details->glossary_image2)){ ?> none; <?php } ?>"><td><a href="javascript:void(0);" onclick="call_hideshow('2');">Add Image</a></td></tr>
         <!-- crop tool start -->
		 <tr id="glossary_img2" style="display:<?php if(empty($details->glossary_image2)){ ?> none; <?php } ?>"  >
			 <td>
			 <table>
        <tr id="image1" >
            <td width="134" align="left" valign="top"><label class="labelname">Image 2:</label></td></tr>
        <tr id="image2" >
            <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
                    <td align="left" valign="top" width="349">
                        <?php $image = base_url("public/images/no_image.jpg");
                        
						if(!empty($details->glossary_image2) && is_file(file_upload_absolute_path()."glossary/".$details->glossary_image2))
						{
							$image =  base_url()."public/uploads/glossary/".$details->glossary_image2;
						}
						
						?>
                                <img id="gimage2"  src="<?php if(!empty($image)){ echo $image; }?>" style="width:130px;height:130px;"/>
                                
                                
                              <a class="fancybox fancybox.iframe upload removebtn" href="<?php echo base_url("kaizen/glossary/newcrop"); ?>?image_id=glossary_image2&image_val=<?php if(!empty($details->glossary_image2)){ echo $details->glossary_image2; }?>&folder_name=glossary&img_sceen=gimage2&prev_img=<?php if(!empty($details->glossary_image2)){ echo $details->glossary_image2; }?>&controller=glossary&height=296&width=232" >Upload</a>
                              <input type="hidden" id="glossary_image2" name="glossary_image2"  value="<?php if(!empty($details->glossary_image2)){ echo $details->glossary_image2; } ?>" />
                               </td></tr></table></td>
									</td>
                                                                        
            <td align="left" valign="top" height="12"></td>
        </tr>
        <?php if(!empty($details->glossary_image2)){ ?>
        <tr style="" id="image3">
          <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
                <td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>','glossary_image2','<?php echo !empty($language)?$language:''; ?>');" class="removebtn" >Remove</a></td>
              </tr>
            </table></td>
        </tr>
        <?php } ?>
	</table></td></tr>
        <!-- crop tool end -->
		
		
		
			<tr id="add_id3" style="display:<?php if((!empty($details->glossary_image3) && !empty($details->glossary_image2)) || (empty($details->glossary_image3) && empty($details->glossary_image2)) ){ ?> none; <?php } ?>"><td><a href="javascript:void(0);" onclick="call_hideshow('3');">Add Image</a></td></tr>
	         <!-- crop tool start -->
			 <tr id="glossary_img3" style="display:<?php if(empty($details->glossary_image3)){ ?> none; <?php } ?>">
				 <td>
				 <table>
	        <tr id="image1" >
	            <td width="134" align="left" valign="top"><label class="labelname">Image 3:</label></td></tr>
	        <tr id="image2" >
	            <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
	              <tr>
	                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
	                    <td align="left" valign="top" width="349">
	                        <?php $image = base_url("public/images/no_image.jpg");
                        
							if(!empty($details->glossary_image3) && is_file(file_upload_absolute_path()."glossary/".$details->glossary_image3))
							{
								$image =  base_url()."public/uploads/glossary/".$details->glossary_image3;
							}
						
							?>
	                                <img id="gimage3"  src="<?php if(!empty($image)){ echo $image; }?>" style="width:130px;height:130px;"/>
                                
                                
	                              <a class="fancybox fancybox.iframe upload removebtn" href="<?php echo base_url("kaizen/glossary/newcrop"); ?>?image_id=glossary_image3&image_val=<?php if(!empty($details->glossary_image3)){ echo $details->glossary_image3; }?>&folder_name=glossary&img_sceen=gimage3&prev_img=<?php if(!empty($details->glossary_image3)){ echo $details->glossary_image3; }?>&controller=glossary&height=296&width=232" >Upload</a>
	                              <input type="hidden" id="glossary_image3" name="glossary_image3"  value="<?php if(!empty($details->glossary_image3)){ echo $details->glossary_image3; } ?>" />
	                               </td></tr></table></td>
										</td>
                                                                        
	            <td align="left" valign="top" height="12"></td>
	        </tr>
	        <?php if(!empty($details->glossary_image3)){ ?>
	        <tr style="" id="image3">
	          <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
	              <tr>
	                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
	                <td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>','glossary_image3','<?php echo !empty($language)?$language:''; ?>');" class="removebtn" >Remove</a></td>
	              </tr>
	            </table></td>
	        </tr>
	        <?php } ?>
		</table></td></tr>
	        <!-- crop tool end -->
                               
	 			<tr id="add_id4" style="display:<?php if((!empty($details->glossary_image4) && !empty($details->glossary_image3)) || (empty($details->glossary_image4) && empty($details->glossary_image3))){ ?> none; <?php } ?>"><td><a href="javascript:void(0);" onclick="call_hideshow('4');">Add Image</a></td></tr>
	 	         <!-- crop tool start -->
	 			 <tr id="glossary_img4" style="display:<?php if(empty($details->glossary_image4)){ ?> none; <?php } ?>">
	 				 <td>
	 				 <table>
	 	        <tr id="image1" >
	 	            <td width="134" align="left" valign="top"><label class="labelname">Image 4:</label></td></tr>
	 	        <tr id="image2" >
	 	            <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
	 	              <tr>
	 	                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
	 	                    <td align="left" valign="top" width="349">
	 	                        <?php $image = base_url("public/images/no_image.jpg");
                        
	 							if(!empty($details->glossary_image4) && is_file(file_upload_absolute_path()."glossary/".$details->glossary_image4))
	 							{
	 								$image =  base_url()."public/uploads/glossary/".$details->glossary_image4;
	 							}
						
	 							?>
	 	                                <img id="gimage4"  src="<?php if(!empty($image)){ echo $image; }?>" style="width:130px;height:130px;"/>
                                
                                
	 	                              <a class="fancybox fancybox.iframe upload removebtn" href="<?php echo base_url("kaizen/glossary/newcrop"); ?>?image_id=glossary_image2&image_val=<?php if(!empty($details->glossary_image4)){ echo $details->glossary_image4; }?>&folder_name=glossary&img_sceen=gimage4&prev_img=<?php if(!empty($details->glossary_image4)){ echo $details->glossary_image4; }?>&controller=glossary&height=296&width=232" >Upload</a>
	 	                              <input type="hidden" id="glossary_image4" name="glossary_image4"  value="<?php if(!empty($details->glossary_image4)){ echo $details->glossary_image4; } ?>" />
	 	                               </td></tr></table></td>
	 										</td>
                                                                        
	 	            <td align="left" valign="top" height="12"></td>
	 	        </tr>
	 	        <?php if(!empty($details->glossary_image4)){ ?>
	 	        <tr style="" id="image3">
	 	          <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
	 	              <tr>
	 	                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
	 	                <td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>','glossary_image4','<?php echo !empty($language)?$language:''; ?>');" class="removebtn" >Remove</a></td>
	 	              </tr>
	 	            </table></td>
	 	        </tr>
	 	        <?php } ?>
	 		</table></td></tr>
	 	        <!-- crop tool end -->                   
		  			<tr id="add_id5" style="display:<?php if((!empty($details->glossary_image5) && !empty($details->glossary_image4)) || (empty($details->glossary_image5) && empty($details->glossary_image4))){ ?> none; <?php } ?>"><td><a href="javascript:void(0);" onclick="call_hideshow('5');">Add Image</a></td></tr>
		  	         <!-- crop tool start -->
		  			 <tr id="glossary_img5" style="display:<?php if(empty($details->glossary_image5)){ ?> none; <?php } ?>">
		  				 <td>
		  				 <table>
		  	        <tr id="image1" >
		  	            <td width="134" align="left" valign="top"><label class="labelname">Image 5:</label></td></tr>
		  	        <tr id="image2" >
		  	            <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
		  	              <tr>
		  	                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
		  	                    <td align="left" valign="top" width="349">
		  	                        <?php $image = base_url("public/images/no_image.jpg");
                        
		  							if(!empty($details->glossary_image5) && is_file(file_upload_absolute_path()."glossary/".$details->glossary_image5))
		  							{
		  								$image =  base_url()."public/uploads/glossary/".$details->glossary_image5;
		  							}
						
		  							?>
		  	                                <img id="gimage5"  src="<?php if(!empty($image)){ echo $image; }?>" style="width:130px;height:130px;"/>
                                
                                
		  	                              <a class="fancybox fancybox.iframe upload removebtn" href="<?php echo base_url("kaizen/glossary/newcrop"); ?>?image_id=glossary_image5&image_val=<?php if(!empty($details->glossary_image5)){ echo $details->glossary_image5; }?>&folder_name=glossary&img_sceen=gimage5&prev_img=<?php if(!empty($details->glossary_image5)){ echo $details->glossary_image5; }?>&controller=glossary&height=296&width=232" >Upload</a>
		  	                              <input type="hidden" id="glossary_image5" name="glossary_image5"  value="<?php if(!empty($details->glossary_image5)){ echo $details->glossary_image5; } ?>" />
		  	                               </td></tr></table></td>
		  										</td>
                                                                        
		  	            <td align="left" valign="top" height="12"></td>
		  	        </tr>
		  	        <?php if(!empty($details->glossary_image5)){ ?>
		  	        <tr style="" id="image3">
		  	          <td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
		  	              <tr>
		  	                <td width="150" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
		  	                <td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onClick="confirmdel('<?php echo $details->id;?>','glossary_image5','<?php echo !empty($language)?$language:''; ?>');" class="removebtn" >Remove</a></td>
		  	              </tr>
		  	            </table></td>
		  	        </tr>
		  	        <?php } ?>
		  		</table></td></tr>
		  	        <!-- crop tool end -->              
                                
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
										<td align="left" valign="top" height="12"></td>
								</tr>
								<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top" ><label class="labelname">Content:</label></td>
																<td align="left" valign="top" width="349">&nbsp;</td>
														</tr>
														<tr>
																<td colspan="2"><?php

				if(!empty($details->content)){
					$cont_txt = $details->content;
				}
				else{
					$cont_txt = "";
				}?>
						<textarea id="contents" name="content" rows="3" cols="60" ><?php echo ($cont_txt);?></textarea></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="15"></td>
								</tr>
						</table>
						<div class="bottonportion" style="height:auto">
								<div class="bottonserleft" style="float:none">
										<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
										</table>
								</div>
						</div>
						<div class="bottonserright" style="padding-bottom:20px;"> <a href="javascript:void(0);" title="Delete" onClick="confirmdel_glossary('<?php echo $details->id;?>','<?php echo rawurlencode(site_url("kaizen/glossary/dolist"));?>');" class="darkgreybtn" <?php if(isset($details->id) && $details->id >0){}else{echo 'style="display:none;"';}?> id="btndelete"> <span>Delete</span> </a> 
							 <a href="javascript:void(0);" class="darkgreybtn" onClick="form_submit('edit');" id="btnsave"><span>Save</span></a> 
							<!-- <input class="btn-primary darkgreybtn" name="commit" type="submit"  value="Save" onClick="form_submit('edit');"> -->
						&nbsp;&nbsp;&nbsp;&nbsp;
						<!-- <input class="btn-primary darkgreybtn" name="commit_back" type="submit" value="Save and Go-Back" onClick="form_submit('<?php echo $pgs.'#'.$details->id; ?>');"> -->
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
	 var editor = CKEDITOR.replace( 'contents' );			
}
   if ( typeof CKEDITOR == 'undefined' )
{

}
else
{
	 var editor = CKEDITOR.replace( 'glossary_caption',{
             toolbar :
    [
   
    ['Bold','Italic','Underline','Strike'],
    
    ]   
         } );			
}

function confirmdel(id,glossary_image,language){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/glossary/dodeleteimg/");?>?deleteid="+id+"&glossary_image="+glossary_image+"&language="+language;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>

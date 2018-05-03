<?php $this->load->view($header); ?>
<?php $this->load->view($left); ?>
<script type="text/javascript" src="<?php echo site_url("public/ckeditor/ckeditor.js");?>"></script>
<link rel="stylesheet" href="<?php echo site_url("public/kaizen/validator/css/validationEngine.jquery.css");?>" type="text/css"/>
<script src="<?php echo site_url("public/kaizen/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#cont").validationEngine();
	});
function form_submit(){
$('#cont').submit();
}
function goto_page(){
document.location.href = "<?php echo site_url("kaizen/keys/");?>";

}


function confirmdel_keys(id,page){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/keys/dodelete/");?>?deleteid="+id+"&ref="+page;
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
            
            <a href="<?php echo site_url("kaizen/keys/doedit/".$details->id."?language=french"); ?>">
            French
            </a></div>
            
            <?php }else{ ?>
            
            <div style="float:right;">
            
            <a href="<?php echo site_url("kaizen/keys/doedit/".$details->id); ?>">
            English
            </a></div>
            
            <?php } } ?>
		<div class="bodytop"> </div>
		<div class="bodymid">
				<div class="midarea">
						<?php 
		  $attributes = array('name' => 'cont', 'id' => 'cont');
		  echo form_open_multipart('kaizen/keys/addedit/'.$details->id,$attributes);
		  echo form_hidden('keys_id', $details->id);
		  
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
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
								<tr>
										<td align="left" valign="top" height="5"></td>
								</tr>
								<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Species key : <span>*</span></label></td>
																<td align="left" valign="top" width="349"><input type="text" name="keys_title" id="keys_title" value="<?php if(isset($details->title)){echo $details->title;}?>" class="inputinpt validate[required]" /></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
								
								
								
                    			
                                
                                <tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Button Text:</label></td>
																<td align="left" valign="top" width="349"><input type="text" id="banner_url_title" name="banner_url_title" value="<?php if(isset($details->button_text)){echo $details->button_text;}?>"  class="inputinpt"/></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="15"></td>
								</tr>
                                
                    
                                                                <?php /*
								<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Button URL:</label></td>
																<td align="left" valign="top" width="349"><input type="text" id="banner_url" name="banner_url" value="<?php if(isset($details->button_url)){echo $details->button_url;}?>"  class="inputinpt validate[optional,custom[url]]"/></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="15"></td>
								</tr> */ ?>
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
                                                                
                                                                
                                                                <tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top"><label class="labelname">Species Key Script:</label></td>
																<td align="left" valign="top" width="349">
                                                                                                                                   
                                                                                                                                    <textarea id="embeded_script" name="embeded_script" style="width:100%;height: 200px;"><?php if(isset($details->embeded_script)){echo $details->embeded_script;}?></textarea>
                                                                                                                                </td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="12"></td>
								</tr>
                                                                
                                                                
								<tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top" ><label class="labelname">Species Description:</label></td>
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
						<div class="bottonserright" style="padding-bottom:20px;"> <a href="javascript:void(0);" title="Delete" onClick="confirmdel_keys('<?php echo $details->id;?>','<?php echo rawurlencode(site_url("kaizen/keys/dolist"));?>');" class="darkgreybtn" <?php if(isset($details->id) && $details->id >0){}else{echo 'style="display:none;"';}?> id="btndelete"> <span>Delete</span> </a> <a href="javascript:void(0);" class="darkgreybtn" onClick="form_submit();" id="btnsave"><span>Save</span></a> <?php echo form_close();?> </div>
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

function confirmdel(id){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/keys/dodeleteimg/");?>?deleteid="+id;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>

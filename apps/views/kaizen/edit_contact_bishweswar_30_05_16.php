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
document.location.href = "<?php echo site_url("kaizen/contact/");?>";

}


function confirmdel_contact(id,page){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/contact/dodelete/");?>?deleteid="+id+"&ref="+page;
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
		  echo form_open_multipart('kaizen/contact/addedit/'.$details->id,$attributes);
		  echo form_hidden('contact_id', $details->id);
		  
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
																<td width="134" align="left" valign="top"><label class="labelname">Enter Phone : <span>*</span></label></td>
																<td align="left" valign="top" width="349"><input type="text" name="phone" id="phone" value="<?php if(isset($details->phone)){echo $details->phone;}?>" class="inputinpt validate[required,custom[phone]]" /></td>
														</tr>
												</table></td>
								</tr>
								<tr>
										<td align="left" valign="top" height="13"></td>
								</tr>
                                <tr>
										<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
														<tr>
																<td width="134" align="left" valign="top" ><label class="labelname">Address:</label></td>
																<td align="left" valign="top" width="349">&nbsp;</td>
														</tr>
														<tr>
																<td colspan="2"><?php

				if(!empty($details->address)){
					$cont_txt = $details->address;
				}
				else{
					$cont_txt = "";
				}?>
						<textarea id="address" name="address" rows="3" cols="60" ><?php echo ($cont_txt);?></textarea></td>
														</tr>
												</table></td>
								</tr>
                       
                                <tr>
										<td align="left" valign="top" height="12"></td>
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
						</table>
						<div class="bottonportion" style="height:auto">
								<div class="bottonserleft" style="float:none">
										<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
										</table>
								</div>
						</div>
						<div class="bottonserright" style="padding-bottom:20px;"><!-- <a href="javascript:void(0);" title="Delete" onClick="confirmdel_contact('<?php echo $details->id;?>','<?php echo rawurlencode(site_url("kaizen/contact/dolist"));?>');" class="darkgreybtn" <?php if(isset($details->id) && $details->id >0){}else{echo 'style="display:none;"';}?>> <span>Delete</span> </a>--> <a href="javascript:void(0);" class="darkgreybtn" onClick="form_submit();"><span>Save</span></a> <?php echo form_close();?> </div>
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
	 var editor = CKEDITOR.replace( 'address' );			
}

function confirmdel(id){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/contact/dodeleteimg/");?>?deleteid="+id;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>

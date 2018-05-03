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
$('#selected_id option').prop('selected', true);
$('#cont').submit();
}
function goto_page(){
document.location.href = "<?php echo site_url("kaizen/common_banner/");?>";
}
function confirmdel_common_banner(id,page){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/common_banner/dodelete/");?>?deleteid="+id+"&ref="+page;
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
		  echo form_open_multipart('kaizen/common_banner/addedit/'.$details->id,$attributes);
		  echo form_hidden('common_banner_id', $details->id);
		  
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
								<td align="left" valign="top" width="349"><input type="text" name="common_banner_title" id="common_banner_title" value="<?php if(isset($details->title)){echo $details->title;}?>" class="inputinpt validate[required]" /></td>
							</tr>
						</table></td>
				</tr>
				<tr>
					<td align="left" valign="top" height="13"></td>
				</tr>
                
                
                
                <!-----------------Tapan---------------->
                
                <table>
                <tr >
					<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="134" align="left" valign="top">
                                <label class="labelname"><?php if(empty($add_for)){ ?>Select Page  : <?php }else{  ?> Select Page  <?php } ?><span>*</span></label></td>
								<td align="left" valign="top" width="349">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><table>
										<tr>
											<td><select name="page_id[]" id="cat_id" size="10" multiple="multiple" style="width:200px; height:200px;"  >
													<option value="0" disabled="disabled"><?php if(empty($add_for)){ ?>Page : <?php }else{  ?> Page <?php } ?></option>
													<?php 	echo $pageList; 	?>
												</select></td>
											<td valign="middle" nowrap="nowrap" style="padding:8px;"><input type="button" name="left" value="=>" id="MoveRight"/>
												<br />
												<br />
												<input type="button" name="right" value="<=" id="MoveLeft" /></td>
											<td><select name="selected_id[]" id="selected_id" style="width:200px; height:200px;" 
                    multiple="multiple" size="10" class="inplogin validate[required]">
                    
                    <?php 	echo $selectedprg; 	?>
													
												</select></td>
										</tr>
									</table>
							</tr>
						</table></td>
						
				</tr>
				<tr><td></td><td >
               
                <tr>
					<td align="left" valign="top" height="13"></td>
				</tr>
				<tr>
					<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="134" align="left" valign="top"><label class="labelname">Common Banner Photo : <span>*</span></label></td>
								<td align="left" valign="top" width="349"><div class="formFields">
										<div class="fileinputs">
											<input type="file" class="file" name="htmlfile" onChange="document.getElementById('fakefilepc1').value = this.value;" style="width:350px;"/>
											<div class="fakefile">
												<input id="fakefilepc1" type="text" disabled="disabled" name="newsletterfile" />
												<img src="<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>" alt="" height="31" width="84" onMouseOver="this.src='<?php echo site_url("public/kaizen/images/browsebtn-ho.jpg");?>'" onMouseOut="this.src='<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>'" /> </div>
										</div>
									</div>
									<div class="spacer"></div>
									<p class="sizetxt">Size Requirement: 2000 x 250 pixels</p></td>
							</tr>
						</table></td>
				</tr>
				<tr>
					<td align="left" valign="top" height="15"></td>
				</tr>
				<?php						
					if(!empty($details->common_banner_photo)){						
					?>
				<tr>
					<td align="left" valign="top"><table width="483" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="134" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
								<td align="left" valign="top" width="349"><?php
		
									if($details->common_banner_photo!='' && is_file(file_upload_absolute_path()."common_banner_photo/".$details->common_banner_photo))	
									{
										$image_thumb = substr_replace($details->common_banner_photo,'_thumb',-4,0);
										$image_thumb=file_upload_base_url()."common_banner_photo/".$details->common_banner_photo;
										
									}
									else
									{
										$image_thumb=file_upload_base_url()."noimage_thumb.jpg";
									}?>
									<img src="<?php echo $image_thumb;?>" width="150" height="100"/></td>
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
					<td align="left" valign="top" height="13"></td>
				</tr>
				<?php
					}
					?>
                 
				<tr>
					<td align="left" valign="top" height="13"></td>
				</tr>
			</table>
			<div class="bottonportion" style="height:auto">
				<div class="bottonserleft" style="float:none">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
						<tr>
							<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
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
							<td align="left" valign="top" height="13"></td>
						</tr>
						
						
						<tr style="display:none;">
							<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="134" align="left" valign="top"><label class="labelname">Sequence:</label></td>
										<td align="left" valign="top" width="349"><input type="text" id="display_order" name="display_order" value="<?php if(isset($details->display_order)){echo $details->display_order;}?>" class="inputinpt"/></td>
									</tr>
								</table></td>
						</tr>
						<tr>
							<td align="left" valign="top" height="12"></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="bottonserright" style="padding-bottom:20px;"> <a href="javascript:void(0);" title="Delete" onClick="confirmdel_common_banner('<?php echo $details->id;?>','<?php echo rawurlencode(site_url("kaizen/common_banner/dolist"));?>');" class="darkgreybtn" <?php if(isset($details->id) && $details->id >0){}else{echo 'style="display:none;"';}?>> <span>Delete</span> </a> <a href="javascript:void(0);" class="darkgreybtn" onClick="form_submit();"><span>Save</span></a> <?php echo form_close();?> </div>
		</div>
	</div>
	<div class="bodybottom"> </div>
</div>



<script type="text/javascript">
       $(function() {
					
					
					
					$("#MoveRight,#MoveLeft").click(function(event) {
						var id = $(event.target).attr("id");
						var selectFrom = id == "MoveRight" ? "#cat_id" : "#selected_id";
						var moveTo = id == "MoveRight" ? "#selected_id" : "#cat_id";

						var selectedItems = $(selectFrom + " :selected").toArray();
						$(moveTo).append(selectedItems);
					   

					});
					$("#MoveRightR,#MoveLeftR").click(function(event) {
						var id = $(event.target).attr("id");
						var selectFrom = id == "MoveRightR" ? "#related_prod" : "#selected_related_prod";
						var moveTo = id == "MoveRightR" ? "#selected_related_prod" : "#related_prod";

						var selectedItems = $(selectFrom + " :selected").toArray();
						$(moveTo).append(selectedItems);
					   

					});
				});
    </script>
    



<script type="text/javascript">
function confirmdel(id){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/common_banner/dodeleteimg/");?>?deleteid="+id;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>

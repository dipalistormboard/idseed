<?php $this->load->view($header); ?>
<?php 
//$this->load->view($left); 
echo link_tag("public/kaizen/validator/css/validationEngine.jquery.css")."\n";
?>
<script type="text/javascript" src="<?php echo site_url("public/ckeditor/ckeditor.js");?>"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/js/jquery.maxlength.js");?>"></script>
<script type="text/javascript">
$(document).ready(function(){
	checkcharcount('meta_title','count1','bar1',72);
	checkcharcount('meta_keyword','count2','bar2',200);
	checkcharcount('meta_desc','count3','bar3',200);
	$("#cont").validationEngine();
});	

function form_submit()
{
	$('#cont').submit();
	return true;
}

</script>

<style>
#bar1 {
	background-color:#5fbbde;
	width:0px;
	height:16px;
}
#barbox1 {
	float:right;
	height:16px;
	background-color:#FFFFFF;
	width:100px;
	border:solid 1px #000;
	margin-right:3px;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
}
#count1 {
	float:right;
	margin-right:8px;
	font-family:'Georgia', Times New Roman, Times, serif;
	font-size:11px;
	font-weight:bold;
	color:#666666
}
#bar2 {
	background-color:#5fbbde;
	width:0px;
	height:16px;
}
#barbox2 {
	float:right;
	height:16px;
	background-color:#FFFFFF;
	width:100px;
	border:solid 1px #000;
	margin-right:3px;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
}
#count2 {
	float:right;
	margin-right:8px;
	font-family:'Georgia', Times New Roman, Times, serif;
	font-size:11px;
	font-weight:bold;
	color:#666666
}
#bar3 {
	background-color:#5fbbde;
	width:0px;
	height:16px;
}
#barbox3 {
	float:right;
	height:16px;
	background-color:#FFFFFF;
	width:100px;
	border:solid 1px #000;
	margin-right:3px;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
}
#count3 {
	float:right;
	margin-right:8px;
	font-family:'Georgia', Times New Roman, Times, serif;
	font-size:11px;
	font-weight:bold;
	color:#666666
}
</style>
<div class="bodyright">
	<div class="bodytop"> </div>
	<div class="bodymid">
		<div class="midarea" id="showcms">
			<h3>Edit Site Setting Details</h3>
            
            <?php if(empty($language)){ ?>
            
            <div style="float:right;">
            
            <a href="<?php echo site_url("kaizen/settings"); ?>?language=french">
            French
            </a></div>
            
            <?php }else{ ?>
            
            <div style="float:right;">
            
            <a href="<?php echo site_url("kaizen/settings"); ?>">
            English
            </a></div>
            
            <?php } ?>
			<br/>
			<font color="#ff0000">All * marked fields are mandatory</font> <br/>
			<br/>
			<?php 
		  $attributes = array('name' => 'cont', 'id' => 'cont');
		  echo form_open_multipart('kaizen/settings/save',$attributes);
		  //echo form_hidden('cms_id', $details->id);
		  
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
					<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="134" align="left" valign="top"><label class="labelname">Site Name:</label></td>
								<td align="left" valign="top" width="349"><input type="text" name="site_name" id="site_name" value="<?php if(isset($details->site_name)){echo $details->site_name;}?>" class="inputinpt validate[required]" /></td>
							</tr>
							<tr>
								<td height="15" colspan="2"></td>
							</tr>
							
							
							
							
							<tr>
    <td align="left" valign="top" colspan="2"><table width="96%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="134" align="left" valign="top"><label class="labelname">Header Logo :</label></td>
          <td align="left" valign="top" width="349"><div class="formFields">
              <div class="fileinputs" style="width:350px;">
                <input type="file" class="file" name="htmlfile" onchange="document.getElementById('fakefilepc1').value = this.value;" />
                <div class="fakefile">
                  <input id="fakefilepc1" type="text" disabled="disabled" name="newsletterfile" />
                  <img src="<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>" alt="" height="31" width="84" onmouseover="this.src='<?php echo site_url("public/kaizen/images/browsebtn-ho.jpg");?>'" onmouseout="this.src='<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>'" /> </div>
              </div>
            </div>
            <div class="spacer"></div>
            <p class="sizetxt">Size recommended : 197 X 78 pixels</p></td>
        </tr>
      </table></td>
  </tr>
						
							<tr>
								<td height="15" colspan="2"></td>
							</tr>
							
							<?php						
					if(!empty($details->logo)){						
					?>
  <tr>
    <td align="left" valign="top" colspan="2"><table width="483" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="134" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
          <td align="left" valign="top" width="349"><img src="<?php echo file_upload_base_url()."settings/".$details->logo;?>" width="200"  alt="" /></td>
        </tr>
      </table></td>
  </tr>
 <tr>
																<td height="15" colspan="2"></td>
														</tr>
  <tr>
    <td align="left" valign="top" colspan="2"><table width="483" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="134" align="left" valign="top"><label class="labelname">&nbsp;</label></td>
          <td align="left" valign="top" width="349"><a href="javascript:void(0);" title="Remove" onclick="confirmdel('<?php echo $details->id;?>');" class="removebtn" >Remove</a></td>
        </tr>
      </table></td>
  </tr>
  <?php
					}
					?>
							
							
							
							
							<tr>
								<td width="134" align="left" valign="top"><label class="labelname">Contact Email:*</label></td>
								<td align="left" valign="top" width="349"><input type="text" name="contact_email" id="contact_email" value="<?php if(isset($details->contact_email)){echo $details->contact_email;}?>" class="inputinpt validate[required,custom[email]]" /></td>
							</tr>
							<tr>
								<td height="15" colspan="2"></td>
							</tr>
                            
                            <tr style="display:none;">
								<td width="134" align="left" valign="top"><label class="labelname">Email:</label></td>
								<td align="left" valign="top" width="349">
                               
                                <textarea name="email" id="email" class="validate[custom[email]]"><?php if(isset($details->email)){echo $details->email;}?></textarea>
                                </td>
							</tr>
							<tr style="display:none;">
								<td height="15" colspan="2"></td>
							</tr>
                            
							<tr>
								<td width="134" align="left" valign="top"><label class="labelname">Copyright:</label></td>
								<td align="left" valign="top" width="349"><input type="text" name="copyright" id="copyright" value="<?php if(isset($details->copyright)){echo $details->copyright; }?>" class="inputinpt " /></td>
							</tr>
							<tr>
								<td height="15" colspan="2"></td>
							</tr>
							<tr>
								<td width="134" align="left" valign="top"><label class="labelname">Edition:</label></td>
								<td align="left" valign="top" width="349"><input type="text" name="edition" id="edition" value="<?php if(isset($details->edition)){echo $details->edition; }?>" class="inputinpt " /></td>
							</tr>
							<tr>
								<td height="15" colspan="2"></td>
							</tr>
							
							
							
							
							<tr>
								<td width="134" align="left" valign="top"><label class="labelname">Site URL:</label></td>
								<td align="left" valign="top" width="349"><input type="text" name="url" id="url" value="<?php if(isset($details->url)){echo $details->url;}?>" class="inputinpt validate[required]" /></td>
							</tr>
							<tr>
								<td height="15" colspan="2"></td>
							</tr>
							<tr>
								<td width="134" align="left" valign="top"><label class="labelname">Password:</label></td>
								<td align="left" valign="top" width="349"><input type="text" name="pwd_hint" id="pwd_hint" value="<?php if(isset($pwd_hint)){echo $pwd_hint;}?>" class="inputinpt validate[required]" /></td>
							</tr>
							<tr>
								<td height="15" colspan="2"></td>
							</tr>
						</table></td>
				</tr>
				<tr>
					<td align="left" valign="top" height="13"></td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2"></td>
				</tr>
			</table>
			<br />
			<!--seo panel -->
			<div class="seopan">
				<h2><a href="javascript:void(0);" class="expandable">SEO</a></h2>
				<div class="droplists">
					<table width="512" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="135" align="left" valign="top">Meta Title:</td>
							<td width="349" align="left" valign="top"><input name="meta_title" id="meta_title" type="text" value="<?php if(isset($details->meta_title)){echo $details->meta_title;}?>" class="titlefiled"  onkeyup="checkcharcount('meta_title','count1','bar1',72);"/>
								<div id="barbox1">
									<div id="bar1"></div>
								</div>
								<div id="count1">72</div>
								<p class="chartxt"> Character Limit</p>
								<div class="showhide1" style="display:none;">
									<div class="seoimgdiv" style="top:57px;"> <a href="#" class="cross close"><img src="<?php echo site_url("public/kaizen/images/cross-butt.jpg");?>" alt="" /></a>
										<h2>Meta Title</h2>
										<p> - Page titles should be descriptive and concise<br />
											- Avoid keyword stuffing<br />
											- Avoid repeated or boilerplate titles<br />
											- Brand your titles, but concisely <br />
										</p>
									</div>
								</div></td>
							<td width="28" align="right" valign="top"><a href="javaScript:void(0);" onmouseover="showdiv(1)" onmouseout="hidediv(1);" class="newshow_hide"><img src="<?php echo site_url("public/kaizen/images/q-icon.jpg");?>" alt="" width="22" height="22" /></a></td>
						</tr>
						<tr style="display:none;">
							<td align="left" valign="top">Meta Keyword:</td>
							<td align="left" valign="top"><textarea name="meta_keyword" id="meta_keyword" class="description"><?php if(isset($details->meta_keyword)){echo html_entity_decode(stripslashes($details->meta_keyword), ENT_QUOTES,'UTF-8');}?>
</textarea>
								<div id="barbox2">
									<div id="bar2"></div>
								</div>
								<div id="count2">200</div>
								<p class="chartxt" style="float:left;">Character Limit</p>
								<div class="showhide2" style="display:none;">
									<div class="seoimgdiv" style="top:107px;"> <a href="#" class="cross close"><img src="<?php echo site_url("public/kaizen/images/cross-butt.jpg");?>" alt="" /></a>
										<h2>SEO Heading</h2>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
									</div>
								</div></td>
							<td align="right" valign="top"><a href="javaScript:void(0);" onmouseover="showdiv(2)" onmouseout="hidediv(2);" class="newshow_hide"><img src="<?php echo site_url("public/kaizen/images/q-icon.jpg");?>" alt="" width="22" height="22" /></a></td>
						</tr>
						<tr>
							<td align="left" valign="top">Meta Description:</td>
							<td align="left" valign="top"><textarea name="meta_desc" id="meta_desc" class="description" onkeyup="checkcharcount('meta_desc','count3','bar3',200)"><?php if(isset($details->meta_description)){echo html_entity_decode(stripslashes($details->meta_description), ENT_QUOTES,'UTF-8');}?>
</textarea>
								<div id="barbox3">
									<div id="bar3"></div>
								</div>
								<div id="count3">200</div>
								<p class="chartxt" style="float:left;">Character Limit</p>
								<div class="showhide3" style="display:none;">
									<div class="seoimgdiv" style="top:107px;"> <a href="#" class="cross close"><img src="<?php echo site_url("public/kaizen/images/cross-butt.jpg");?>" alt="" /></a>
										<h2>Meta Description</h2>
										<p> - This will only be shown in search results if the search engine can not come up with a better description.<br />
											- Differentiate the descriptions for different pages. Identical or similar descriptions on every page of a site aren't helpful when individual pages appear in the web results.<br />
											- Use quality descriptions.<br />
										</p>
									</div>
								</div></td>
							<td align="right" valign="top"><a href="javaScript:void(0);" onmouseover="showdiv(3)" onmouseout="hidediv(3);" class="newshow_hide"><img src="<?php echo site_url("public/kaizen/images/q-icon.jpg");?>" alt="" width="22" height="22" /></a></td>
						</tr>
					</table>
					<?php echo form_hidden("sbmt","1");?> </div>
			</div>
            <!--<div class="seopan">
                        <h2><a href="javascript:showseopanel('droplistsocialmedia');" class="expandable">Social Media</a></h2>
                        <div class="droplists" id="droplistsocialmedia" style="display:none;">
                            <a onclick="addAnotherFile('','')" href="javascript:void(0);" class="temp-btn" style="width:20%"><img style="float: left;margin-top: 3px;margin-left: 10px;width: 22px;" src="<?php echo base_url(); ?>public/images/plus-icon.png">Add Social Media</a>
                            
                            <input type="hidden" name="count" id="count" value="1" />	
                            
                            
                           
                            <div id="socialdiv">
                                
                            </div>
                            
                            
                            
                        </div>
                    </div>-->
                        <div class="seopan">
                    <h2><a class="expandable" href="javascript:void(0);" headerindex="1h"><span class="accordprefix"></span>Google Analytics<span class="accordsuffix"></span></a></h2>
                    <div class="droplists" contentindex="1c" style="display: none;">
                                        <table width="512" cellspacing="0" cellpadding="0" border="0">
                                        <tbody><tr>
                                          <td width="135" valign="top" align="left">Google Site Verification:</td>
                                          <td width="349" valign="top" align="left">
                                              <input type="text" class="titlefiled" value="<?php if(isset($details->site_verification)){echo $details->site_verification;}?>" id="site_verification" name="site_verification">
                                          </td>

                                        </tr>
                                        <tr>
                                          <td valign="top" height="13" align="left"></td>
                                        </tr>
                                        <tr>
                                          <td valign="top" align="left">Google Analytics Code:</td>
                                          <td valign="top" align="left"><textarea class="description" id="analytics_code" name="analytics_code"><?php if(isset($details->analytics_code)){echo $details->analytics_code;}?></textarea></td>
                                        </tr>
                                      </tbody></table>

                            <input type="hidden" value="1" name="sbmt">
                                </div>
                </div>
			<!--seo panel -->
			<div class="bottonportion">
				<div class="bottonserleft"> </div>
				<div class="bottonserright" style="padding-bottom:20px;"> <a href="javascript:void(0);" class="darkgreybtn" onclick="form_submit();"><span>UPDATE</span></a> </div>
			</div>
			<input type="hidden" name="save_draft" id="save_draft" value="0" />
			<?php echo form_close();?> </div>
	</div>
	<div class="bodybottom"> </div>
</div>
<script type="text/javascript">
function showdiv(id){
	$('.showhide'+id).fadeIn('slow');
}

function hidediv(id){
	$('.showhide'+id).fadeOut('slow');
}
function checkcharcount(id,id2,id3,id4){
	var box=$("#"+id).val();
	var main = box.length *100;
	var value= (main / id4);
	var count= id4 - box.length;
	if(box.length <= id4){
		$('#'+id2).html(count);
		$('#'+id3).animate({"width": value+'%',}, 1);
	}
	else{
		$(this).attr('maxlength',id4);
		$('#'+id).maxlength({max:id4});
	}
	return true;
}

function confirmdel(id){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/settings/dodeleteimg/");?>?deleteid="+id;
	}
	else{
		return false;
	}
}
		
</script>
<script>
function addAnotherFile(url,predifine_link,sequence,social_settings_id){
	var count = $('#count').val();
	var count_val = parseInt(count)+1;
	$('#count').val(count_val);
	$.ajax({
			   type: "POST",
				url : '<?php echo site_url("kaizen/settings/add_file/");?>',
				data: { count:count,url:url,predifine_link:predifine_link,social_settings_id:social_settings_id,sequence:sequence},
				dataType : "html",
				success: function(data)
				{
					if(data)
					{
						
							$("#socialdiv").prepend(data);
						
						
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
<?php if(!empty($social_settings_arr)){ ?>
    <?php foreach($social_settings_arr as $ssa){ ?>
            addAnotherFile('<?php echo $ssa->link ; ?>','<?php echo $ssa->social_menus_id ; ?>','<?php echo $ssa->sequence ; ?>','<?php echo $ssa->id ; ?>');
    <?php } ?>
<?php } ?>
</script>
<?php $this->load->view($footer); ?>

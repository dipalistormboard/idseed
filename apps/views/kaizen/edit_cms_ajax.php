<?php 
	if(isset($details->title)){echo '<h3>'.$details->title.'</h3>';}
	else{echo '<h3>Add New Page</h3>';}
	?>
   <script>
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
	    $("#btnhide").click(function() {
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
<?php if(!empty($details->title)){ if(empty($language)){ ?>
            
            <div style="float:right;">
            
            <a href="javascript:openpage('<?php echo site_url("kaizen/cms/doeditajax/".$details->id."?language=french"); ?>');">
            French
            </a></div>
            
            <?php }else{ ?>
            
            <div style="float:right;">
            
            <a href="javascript:openpage('<?php echo site_url("kaizen/cms/doeditajax/".$details->id); ?>');">
            English
            </a></div>
            
            <?php } } ?>
            
            
<br />
<?php 
		  $attributes = array('name' => 'cont', 'id' => 'cont');
		  echo form_open_multipart('kaizen/cms/addedit',$attributes);
		  echo form_hidden('cms_id', $details->id);
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
	<?php if($details->id>0 ) { ?>
	<tr>
		<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="134" align="left" valign="top"><label class="labelname">Page Link:</label></td>
					<td align="left" valign="top" width="349"><?php 
					$page_array=array('services','home','projects');
					if(!in_array($details->page_link,$page_array))
					{
						echo site_url("pages/".$details->page_link.'.html');
					}
					else
					{
						$page_array2=array('home');
						if(!in_array($details->page_link,$page_array2))
						{
							echo site_url($details->page_link.'.html');
						}
						else
						{
							echo site_url();
						}
					}
				?></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td align="left" valign="top" height="5"></td>
	</tr>
	<?php } ?>
	<?php 
		$new_parent_id = $this->input->get('parent_id', TRUE);
		if(!empty($new_parent_id)){$parent_id=$new_parent_id;}
		elseif(!empty($details->parent_id)){$parent_id=$details->parent_id;}else{$parent_id=0;}
		if(($parent_id>0) || $details->id==0 ) { ?>
	<tr>
		<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="134" align="left" valign="top"><label class="labelname">Select location:</label></td>
					<td align="left" valign="top" width="349"><select name="parent_id" id="parent_id" style="width:268px;" tabindex="1">
					<option value=""  <?php echo ((!isset($details->parent_id))?'selected="selected"':'')?> >-TOP-</option>
							<?php 
					
					$OPT_MENU = '';
					$menus_array = array();
					foreach ($cms_list as $rs_menu_id){	
					$menus_array[$rs_menu_id->id] = array('id' => $rs_menu_id->id,'title' => $rs_menu_id->title,'parent_id' => $rs_menu_id->parent_id,'page_link' => $rs_menu_id->page_link);
					}
	    			$optmenu = generate_opt_menu(0,$menus_array, $OPT_MENU, 0,$parent_id);
					echo $optmenu;
					  ?>
						</select></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td align="left" valign="top" height="13"><?php
		  echo link_tag("public/kaizen/css/dd.css")."\n";
		  ?>
			<script type="text/javascript" src="<?php echo site_url("public/kaizen/js/jquery.dd.js");?>"></script> 
			<script type="text/javascript">
            $(document).ready(function() {
            try {
                oHandler = $("#parent_id").msDropDown({mainCSS:'dd2'}).data("dd");
                //alert($.msDropDown.version);
                //$.msDropDown.create("body select");
                $("#ver").html($.msDropDown.version);
                } catch(e) {
                    alert("Error: "+e.message);
                }
            })
        </script></td>
	</tr>
	<?php }else{echo form_hidden('parent_id', $details->parent_id);} ?>
	<tr>
		<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="134" align="left" valign="top"><label class="labelname">Enter Title : <span>*</span></label></td>
					<td align="left" valign="top" width="349"><input type="text" name="page_title" id="page_title" value="<?php if(isset($details->title)){echo $details->title;}?>" class="inputinpt validate[required]" /></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td align="left" valign="top" height="13"></td>
	</tr>
    <tr>
		<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
			</table></td>
	</tr>
	<tr>
		<td align="left" valign="top" height="13"></td>
	</tr>
	<tr style="display:none;">
		<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="134" align="left" valign="top"><label class="labelname">Banner URL: </label></td>
					<td align="left" valign="top" width="349"><input type="text" id="banner_url" name="banner_url" value="<?php if(isset($details->banner_url)){echo outputEscapeString($details->banner_url);}?>" class="inputinpt validate[optional,custom[url]]" /></td>
				</tr>
			</table></td>
	</tr>
	<tr style="display:none;">
		<td align="left" valign="top" height="13"></td>
	</tr>
	<?php	#if(($parent_id>0) || $details->id==0 ) { ?>
	<tr>
		<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="134" align="left" valign="top"><label class="labelname">Position:</label></td>
					<td align="left" valign="top" width="349"><input type="text" name="display_order" id="display_order" value="<?php if(isset($details->display_order)){echo $details->display_order;}?>" class="inputinpt" /></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td align="left" valign="top" height="13"></td>
	</tr>
        	 <?php  if($details->id==4)
			      $class=' style="display:none;"';
				  else
				   $class='';
			 ?>
	<tr <?php echo $class;?>>
		<td align="left" valign="top">
       
        
        <table width="96%" border="0" cellspacing="0" cellpadding="0">
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
						<textarea id="contents" name="contents" class="editor"><?php echo ($cont_txt);?></textarea></td>
				</tr>
			</table>
            </td>
	   </tr>
   
   

         <tr>
        <td align="left" valign="top" height="12"></td>
	    </tr>
                               
                                
                                   
   
</table>
<br />
<div class="bottonportion">
	<div class="bottonserleft">
		<a href="javascript:void(0);" class="lightgreybtn" onclick="openpage('<?php echo site_url("kaizen/cms/doeditajax/".$details->id);?>')"><span>Cancel</span></a> <a href="javascript:void(0);" class="lightgreybtn">
		<input name="is_active" type="checkbox" value="0" <?php if(empty($details->is_active)){echo 'checked="checked"';}?> class="chkbox" onclick="setPublish('<?php echo $details->id;?>');" id="publish" id="btnhide"/>
		<span>Hide</span></a> <a href="javascript:void(0);" class="lightgreybtn" onclick="form_submit2(<?php echo $details->id;?>);" id="btndelete"><span>Delete</span></a>
		<div id="publish_msg" style="display:none;color:green;"></div>
	</div>
	<div class="bottonserright" style="padding-bottom:20px;">
		<a href="javascript:void(0);" class="darkgreybtn" onclick="form_submit('publish');" id="btnsave"><span>Publish</span></a> </div>
</div>

<!--seo panel -->
<div class="seopan">
	<h2><a href="javascript:void(0);" onclick="javascript:showseopanel1('droplistseo');" class="expandable">SEO</a></h2>
	<div class="droplists" id="droplistseo">
		<table width="512" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="135" align="left" valign="top">Meta Title:</td>
				<td width="349" align="left" valign="top"><input name="meta_title" id="meta_title" type="text" value="<?php if(isset($details->meta_title)){echo $details->meta_title;}?>" class="titlefiled" onkeyup="checkcharcount('meta_title','count1','bar1',72);"/>
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
				<td align="left" valign="top"><textarea name="meta_desc" id="meta_desc" class="description" onkeyup="checkcharcount('meta_desc','count3','bar3',200);"><?php if(isset($details->meta_description)){echo html_entity_decode(stripslashes($details->meta_description), ENT_QUOTES,'UTF-8');}?>
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
<!--seo panel -->

<input type="hidden" name="content" id="content" value="" />
<input type="hidden" name="banner_text" id="banner_text" value="" />
<input type="hidden" name="save_draft" id="save_draft" value="0" />
<?php echo form_close();?> 
<script type="text/javascript">

  var editor, html = '';
	if (editor ){
   	editor.destroy();
	editor = null;
	}

    CKEDITOR.replace( 'contents' ,{
		contentsCss : '<?php echo site_url("public/kaizen/css/style_ck.css");?>',	
		 filebrowserBrowseUrl : '<?php echo site_url("public/ckfinder/ckfinder.html");?>',
        filebrowserUploadUrl : '<?php echo site_url("public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files");?>',
        filebrowserImageUploadUrl : '<?php echo site_url("public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images");?>',
        filebrowserFlashUploadUrl : '<?php echo site_url("public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash");?>'
		}
	);
   
  

function showseopanel(){
	$('.droplists').slideToggle('slow');
	
}
function showseopanel1(x){
	$('#'+x).slideToggle('slow');
	
}
function form_submit2(val){
if(confirm("Are you sure want to delete?")){
			window.location.href="<?php echo site_url("kaizen/cms/dodelete/");?>?deleteid="+val+"&ref=<?php echo site_url("kaizen/cms/doedit/1");?>";
		}
		else{
			return false;
		}
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

checkcharcount('meta_title','count1','bar1',72);
checkcharcount('meta_keyword','count2','bar2',200);
checkcharcount('meta_desc','count3','bar3',200);
$("#cont").validationEngine();

function confirmdelGallery(event_id,gallery_id){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/cms/dodeleteimggallery/");?>?deleteid="+gallery_id+'&event_id='+event_id;
	}
	else{
		return false;
	}
}

$(document).ready(function() { 
	// bind 'myForm' and provide a simple callback function 
	$('#cont').ajaxForm(function() { 
		<?php
			if(empty($details->id)){
			?>
			window.location.href='<?php echo site_url('kaizen/cms/doadd/0/');?>';
			<?php
			}
			else if(!empty($language)){
			?>
			openpage('<?php echo site_url("kaizen/cms/doeditajax/".$details->id."?language=".$language);?>');
			<?php
			}else{
			?>
			openpage('<?php echo site_url("kaizen/cms/doeditajax/".$details->id);?>');
			<?php } ?>
	}); 
}); 
</script> 

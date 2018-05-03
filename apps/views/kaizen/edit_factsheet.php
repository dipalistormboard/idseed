<?php $this->load->view($header); ?>
<?php $this->load->view($left); ?>
<script type="text/javascript" src="<?php echo site_url("public/ckeditor/ckeditor.js");?>"></script>
<link rel="stylesheet" href="<?php echo site_url("public/kaizen/validator/css/validationEngine.jquery.css");?>" type="text/css"/>
<script src="<?php echo site_url("public/kaizen/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/jquery.jcarousel.min.js'); ?>"></script>
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
	document.location.href = "<?php echo site_url("kaizen/factsheet/");?>";

}


function confirmdel_factsheet(id,page){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/factsheet/dodelete/");?>?deleteid="+id+"&ref="+page;
	}
	else{
		return false;
	}
}
function addgallery(file,caption,title){
	var count_gal = $('#count_img_gal').val();
	var count_val_gal = parseInt(count_gal)+1;
	$('#count_img_gal').val(count_val_gal);

	$.ajax({
		type: "POST",
		url : '<?php echo site_url("kaizen/factsheet/add_gallery/");?>',
		data: { count_gal:count_gal,file:file,caption:caption,title:title},
		dataType : "html",
		success: function(data)
		{
			if(data)
			{

				$("#galleryfile_gal").prepend(data);

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

<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/jquery.fancybox.css?v=2.1.5');?>" media="screen" />
<script type="text/javascript" src="<?php echo base_url('public/js/jquery.fancybox.js?v=2.1.5');?>"></script>


<!--<script src="<?php echo base_url('public/js/image-picker.js');?>"></script>
<link rel="stylesheet" href="<?php echo base_url('public/css/image-picker.css');?>" />

<script type="text/javascript">
$(document).ready(function () {

$("select.image-picker").imagepicker({
show_label:   true,
});
});



</script>-->
<style>
.jcarousel-wrapper {
	margin: 20px auto;
	position: relative;
	border: 10px solid #fff;
	width: 543px;
	height: auto;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	-webkit-box-shadow: 0 0 2px #999;
	-moz-box-shadow: 0 0 2px #999;
	box-shadow: 0 0 2px #999;
}


.jcarousel-wrapper .photo-credits {
	position: absolute;
	right: 15px;
	bottom: 0;
	font-size: 13px;
	color: #fff;
	text-shadow: 0 0 1px rgba(0, 0, 0, 0.85);
	opacity: .66;
}

.jcarousel-wrapper .photo-credits a {
	color: #fff;
}

/** Carousel **/

.jcarousel {
	position: relative;
	overflow: hidden;
}

.jcarousel ul {
	width: 20000em;
	position: relative;
	list-style: none;
	margin: 0;
	padding: 0;
}

.jcarousel li {
	float: left;
}

/** Carousel Controls **/

.jcarousel-control-prev,
.jcarousel-control-next {
	position: absolute;
	top: 120px;
	width: 30px;
	height: 30px;
	text-align: center;
	background: #4E443C;
	color: #fff;
	text-decoration: none;
	text-shadow: 0 0 1px #000;
	font: 24px/27px Arial, sans-serif;
	-webkit-border-radius: 30px;
	-moz-border-radius: 30px;
	border-radius: 30px;
	-webkit-box-shadow: 0 0 2px #999;
	-moz-box-shadow: 0 0 2px #999;
	box-shadow: 0 0 2px #999;
}

.jcarousel-control-prev {
	left: -50px;
}

.jcarousel-control-next {
	right: -50px;
}

.jcarousel-control-prev:hover span,
.jcarousel-control-next:hover span {
	display: block;
}

.jcarousel-control-prev.inactive,
.jcarousel-control-next.inactive {
	opacity: .5;
	cursor: default;
}

/** Carousel Pagination **/

.jcarousel-pagination {
	position: absolute;
	bottom: 0;
	left: 15px;
}

.jcarousel-pagination a {
	text-decoration: none;
	display: inline-block;

	font-size: 11px;
	line-height: 14px;
	min-width: 14px;

	background: #fff;
	color: #4E443C;
	border-radius: 14px;
	padding: 3px;
	text-align: center;

	margin-right: 2px;

	opacity: .75;
}

.jcarousel-pagination a.active {
	background: #4E443C;
	color: #fff;
	opacity: 1;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.75);
}
.wrapper1 {
	max-width: 570px;
	padding: 0 0 0 15px;
	margin: auto;
}
.jcarousel li img{
	max-width:172px;
	margin:0 5px;
}
</style>
<div class="bodyright">
	<div class="bodytop"> </div>
	<div class="bodymid">
		<div class="midarea">

			<?php if(empty($language)){ ?>

				<div style="float:right;">

					<a href="<?php echo site_url("kaizen/factsheet/doedit/".$details->id."?language=french&page=".$pgs); ?>">
						Go to French
					</a></div>

					<?php }else{ ?>

						<div style="float:right;">

							<a href="<?php echo site_url("kaizen/factsheet/doedit/".$details->id."?page=".$pgs); ?>">
								Go to English
							</a></div>

							<?php } ?>
							<br/>

							<?php
							$attributes = array('name' => 'cont', 'id' => 'cont');
							echo form_open_multipart('kaizen/factsheet/addedit/'.$details->id,$attributes);
							//echo form_hidden('factsheet_id', $details->id,array('id'=>'factsheet_id'));

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
							<input type="hidden" id="factsheet_id" name="factsheet_id" value="<?php echo $details->id; ?>">
							<input type="hidden" id="hdngalleryid" name="hdngalleryid" value="<?php echo $details->gallery_id; ?>">
							<input type="hidden" id="hdnvar" name="hdnvar" value="">
							<input type="hidden" name="returnval" id="returnval" value=""/>

							<input type="hidden" id="hdngalleryid_similar" name="hdngalleryid_similar" value="<?php echo $details->similar_species_id; ?>">
							<input type="hidden" id="hdnvar_similar" name="hdnvar_similar" value="">

							<input type="hidden" name="from" id="from" value="edit"/>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" >
								<tr>
									<td align="left" valign="top" height="5"></td>
								</tr>
								<tr>
									<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="22" align="left" valign="top"><label>Enter Title : <span>*</span></label></td>
											<td align="left" valign="top" width="349">
												<input type="text" name="title" id="title" value="<?php if(isset($details->title)){echo $details->title;}?>" class="inputinpt validate[required]" />
											</td>
											<?php /* ?>     <td colspan="2"><?php
											if(!empty($details->title)){
											$cont_txt1 = $details->title;
										}
										else{
										$cont_txt1 = "";
									} ?>
									<textarea id="title" class="inputinpt validate[required]" name="title" style="width:99% !important; height:100px; resize:none;"><?php echo ($cont_txt1);?></textarea></td><?php */ ?>
								</tr>
							</table></td>
						</tr>
						<tr>
							<td align="left" valign="top" height="13"></td>
						</tr>


						<tr>
							<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="22" align="left" valign="top"><label>Family : <span>*</span></label></td>
									<td align="left" valign="top" width="349"><input type="text" name="family" id="family" value="<?php if(isset($details->family)){echo $details->family;}?>" class="inputinpt validate[required]" /></td>
								</tr>
								<tr>
									<td align="left" valign="top" height="13"></td>
									<td align="left" valign="top" height="13">All "family name" will be italicized</td>
								</tr>
							</table></td>
						</tr>


						<tr>
							<td align="left" valign="top" height="13"></td>
						</tr>

						<tr>
							<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="22" align="left" valign="top"><label>Synonyms : </label></td>
									<?php /* ?><td align="left" valign="top" width="349"><input type="text" name="synonyms" id="synonyms" value="<?php if(isset($details->synonyms)){echo $details->synonyms;}?>" class="inputinpt" /></td><?php */ ?>
									<td colspan="2"><?php
									if(!empty($details->synonyms)){
										$synonyms = $details->synonyms;
									}
									else{
										$synonyms = "";
									} ?>
									<textarea id="synonyms" class="inputinpt " name="synonyms" style="width:99% !important; height:100px; resize:none;"><?php echo ($synonyms);?></textarea></td>
								</tr>

							</table></td>
						</tr>
						<tr>
							<td align="left" valign="top" height="13"></td>
						</tr>

						<tr>
							<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="22" align="left" valign="top"><label>Common Name : <span>*</span></label></td>
									<td align="left" valign="top" width="349"><input type="text" name="common_name" id="common_name" value="<?php if(isset($details->common_name)){echo $details->common_name;}?>" class="inputinpt validate[required]" /></td>
								</tr>
							</table></td>
						</tr>
						<tr>
							<td align="left" valign="top" height="13"></td>
						</tr>
						<tr>
							<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="22" align="left" valign="top"><label>Regulation Keyword : <span>*</span></label></td>
									<td align="left" valign="top" width="349">
										<?php
										$arr= explode(',',$details->regulation_keyword);
										$a1 = '';
										$a2= '';
										$a3= '';
										$a4= '';
										$a5 = '';
										for($i=0;$i<count($arr);$i++){

											if($arr[$i] == '1'){	$a1 = 'selected'; }
											if($arr[$i] == '2'){	$a2 = 'selected'; }
											if($arr[$i] == '3'){	$a3 = 'selected'; }
											if($arr[$i] == '4'){	$a4 = 'selected'; }
											if($arr[$i] == '5'){	$a5 = 'selected'; }
										}
										?>
										<select name="regulation_keyword[]" id="regulation_keyword" multiple>
											<option value="1" <?php echo $a1; ?>>Class 1: Prohibited Noxious Weed Seeds</option>
											<option value="2" <?php echo $a2; ?>>Class 2: Primary Noxious Weed Seeds</option>
											<option value="3" <?php echo $a3; ?>>Class 3: Secondary Noxious Weed Seeds</option>
											<option value="4" <?php echo $a4; ?>>Class 4: Secondary Noxious Weed Seeds</option>
											<option value="5" <?php echo $a5; ?>>Class 5: Noxious Weed Seeds</option>
										</select>

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
									<td height="22" align="left" valign="top"><label>Regulation : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->regulation)){
											$regulation = $details->regulation;
										}
										else{
											$regulation = "";
										}?>
										<textarea id="regulation" name="regulation" rows="3" cols="60" ><?php echo ($regulation);?></textarea>
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
									<td height="22" align="left" valign="top"><label>Distribution (Canadian) : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->distribution_canadian)){
											$distribution_canadian = $details->distribution_canadian;
										}
										else{
											$distribution_canadian = "";
										}?>
										<textarea id="distribution_canadian" name="distribution_canadian" rows="3" cols="60" ><?php echo ($distribution_canadian);?></textarea>
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
									<td height="22" align="left" valign="top"><label>Distribution (Worldwide) : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->distribution_worldwide)){
											$distribution_worldwide = $details->distribution_worldwide;
										}
										else{
											$distribution_worldwide = "";
										}?>
										<textarea id="distribution_worldwide" name="distribution_worldwide" rows="3" cols="60" ><?php echo ($distribution_worldwide);?></textarea>
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
									<td height="22" align="left" valign="top"><label>Duration of Life Cycle : </label></td>

									<td align="left" valign="top" width="349"><input type="text" name="duration_of_lifecycle" id="duration_of_lifecycle" value="<?php if(isset($details->duration_of_lifecycle)){echo $details->duration_of_lifecycle;}?>" class="inputinpt" /></td>
								</tr>
							</table></td>
						</tr>
						<tr>
							<td align="left" valign="top" height="13"></td>
						</tr>
						<tr>
							<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="22" align="left" valign="top"><label>Seed/Fruit Type : </label></td>
									<td align="left" valign="top" width="349"><input type="text" name="seed_type" id="seed_type" value="<?php if(isset($details->seed_type)){echo $details->seed_type;}?>" class="inputinpt" /></td>
								</tr>
							</table></td>
						</tr>
						<tr>
							<td align="left" valign="top" height="13"></td>
						</tr>
						<tr>
							<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="22" align="left" valign="top"><label>Average Seed Size : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->average_seed_size)){
											$average_seed_size = $details->average_seed_size;
										}
										else{
											$average_seed_size = "";
										}?>
										<textarea id="average_seed_size" name="average_seed_size" rows="3" cols="60" ><?php echo ($average_seed_size);?></textarea>
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
									<td height="22" align="left" valign="top"><label>Seed Shape : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">

										<?php

										if(!empty($details->seed_shape)){
											$seed_shape = $details->seed_shape;
										}
										else{
											$seed_shape = "";
										}?>
										<textarea id="seed_shape" name="seed_shape" rows="3" cols="60" ><?php echo ($seed_shape);?></textarea>
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
									<td height="22" align="left" valign="top"><label>Seed Surface Texture : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->seed_surface_texture)){
											$seed_surface_texture = $details->seed_surface_texture;
										}
										else{
											$seed_surface_texture = "";
										}?>
										<textarea id="seed_surface_texture" name="seed_surface_texture" rows="3" cols="60" ><?php echo ($seed_surface_texture);?></textarea>
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
									<td height="22" align="left" valign="top"><label>Seed Colour : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->seed_colour)){
											$seed_colour = $details->seed_colour;
										}
										else{
											$seed_colour = "";
										}?>
										<textarea id="seed_colour" name="seed_colour" rows="3" cols="60" ><?php echo ($seed_colour);?></textarea>
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
									<td height="22" align="left" valign="top"><label>Other Seed Features : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->other_seed_features)){
											$other_seed_features = $details->other_seed_features;
										}
										else{
											$other_seed_features = "";
										}?>
										<textarea id="other_seed_features" name="other_seed_features" rows="3" cols="60" ><?php echo ($other_seed_features);?></textarea>
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
									<td height="22" align="left" valign="top"><label>Habitat and Crop Association : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->habitat_and_corp_association)){
											$habitat_and_corp_association = $details->habitat_and_corp_association;
										}
										else{
											$habitat_and_corp_association = "";
										}?>
										<textarea id="habitat_and_corp_association" name="habitat_and_corp_association" rows="3" cols="60" ><?php echo ($habitat_and_corp_association);?></textarea>
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
									<td height="22" align="left" valign="top"><label>General Information : </label></td>
								</tr>
								<tr>
									<td align="left" valign="top" width="349">
										<?php

										if(!empty($details->general_info)){
											$general_info = $details->general_info;
										}
										else{
											$general_info = "";
										}?>
										<textarea id="general_info" name="general_info" rows="3" cols="60" ><?php echo ($general_info);?></textarea>
									</td>
								</tr>
							</table></td>
						</tr>


						<tr>
							<td align="left" valign="top" height="13"></td>
						</tr>

						<tr><td>
							<table width="95%" border="0" cellspacing="0" cellpadding="0">
								<hr><h2>Factsheet Gallery</h2>
								<tr>
									<td align="left" valign="top">
										<label >Select Existing Gallery Images  : <span>*</span></label></td>
										<td align="left" valign="top" width="349">
											<a id="target"  class="fancybox" data-fancybox-group="gallery" href="javascript:void(0);" >View Galleries</a></td>

										</tr>

										<tr id="sel_gal_tr"><td  colspan="2">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td  align="left" valign="top" colspan="2">
														<label >Selected Gallery Images  : </label></td>
													</tr>
													<tr>
														<td colspan="2">

															<div class="wrapper1">
																<div class="jcarousel-wrapper">
																	<div class="jcarousel">

																		<ul id="resultgallery" class="logoCarousel">
																			<?php if(!empty($details->gallery_id)){ ?>
																				<?php

																				$arr_gal = explode(',',$details->gallery_id);
																				for($i=0;$i<count($arr_gal);$i++){
																					$data_row_gallery = $this->modelfactsheet->get_factsheet_gallery($arr_gal[$i]);

																					?>
																					<li><img class="image_picker_image" src="<?php echo base_url('public/uploads/gallery_photo/'.$data_row_gallery->gallery_photo);?>"><p><?php echo $data_row_gallery->title; ?></p></li>
																					<?php } ?>  <?php } ?>
																				</ul>




																			</div>
																			<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
																			<a href="#" class="jcarousel-control-next">&rsaquo;</a>
																		</div>
																	</div>
																</td>
															</tr>
														</table>
													</td></tr>

												</table>
											</td></tr>
											<tr>
												<td align="left" valign="top" height="13"></td>
											</tr>
											<!-- Crop tool start  (Gallery)    -->
											<input type="hidden" id="count_gal" name="count_gal" value="1">

											<tr>
												<td align="left" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="134" align="left" valign="top">
															<label class="labelname"><a href="javascript:void(0);" class="addpagebutt" onclick="addgallery('','','');">Add Gallery:</a></label></td>

														</tr>
													</table></td>
												</tr>
												<tr >
													<td align="left" valign="top" height="13"></td>
												</tr>

												<tr id="galleryfile_gal">

												</tr>

												<input type="hidden" id="count_img_gal" name="count_img_gal" value="1"/>
												<input type="hidden" id="main_image_gal" name="main_image_gal" value="1"/>

												<!-- Crop tool end (Gallery)       -->



												<!-- Crop tool start  (Species)    -->
												<input type="hidden" id="count" name="count" value="1">
												<!-- New species section by hardik -->

												<tr>
													<td>
														<table width="95%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<tdalign="left" valign="top" height="20">&nbsp;</td>
															</tr>
															<hr>
															<h2>Similar Species Gallery</h2>
															<tr>
																<td align="left" valign="top">
																	<label >Select Existing Gallery Images  : <span>*</span></label></td>
																	<td align="left" valign="top" width="349">
																		<a id="target_similar"  class="fancybox" data-fancybox-group="gallery" href="javascript:void(0);" >View Galleries</a></td>

																	</tr>

																	<tr id="sel_gal_tr_similar">
																		<td  colspan="2">
																			<table width="100%" border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					<td  align="left" valign="top" colspan="2">
																						<label >Selected Gallery Images  : </label></td>
																					</tr>
																					<tr>
																						<td colspan="2">

																							<div class="wrapper1">
																								<div class="jcarousel-wrapper">
																									<div class="jcarousel">

																										<ul id="resultgallery_similar" class="logoCarousel">
																											<?php if(!empty($details->similar_species_id)){ ?>
																												<?php

																												$arr_gal = explode(',',$details->similar_species_id);
																												for($i=0;$i<count($arr_gal);$i++){
																													$data_row_gallery = $this->modelfactsheet->get_factsheet_gallery($arr_gal[$i]);

																													?>
																													<li><img class="image_picker_image" src="<?php echo base_url('public/uploads/gallery_photo/'.$data_row_gallery->gallery_photo);?>"><p><?php echo $data_row_gallery->title; ?></p></li>
																													<?php } ?>  <?php } ?>
																												</ul>




																											</div>
																											<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
																											<a href="#" class="jcarousel-control-next">&rsaquo;</a>
																										</div>
																									</div>
																								</td>
																							</tr>
																						</table>
																					</td></tr>

																				</table>
																			</td></tr>


																			<!-- New species section by hardik -->

																			<!--   <tr>
																			<td align="left" valign="top">
																			<table width="96%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																			<tdalign="left" valign="top" height="20">&nbsp;</td>
																		</tr>
																		<hr>

																		<tr>
																		<td width="134" align="left" valign="top">
																		<label class="labelname"><a href="javascript:void(0);" class="addpagebutt" onclick="addspecies('','','');">Similar Species:</a></label></td>

																	</tr>
																</table></td>
															</tr>
															<tr >
															<td align="left" valign="top" height="13"></td>
														</tr>

														<tr id="galleryfile">

													</tr>
													<input type="hidden" id="count_img" name="count_img" value="1"/>
													<input type="hidden" id="main_image" name="main_image" value="1"/>   -->

													<!-- Crop tool end (Species)       -->

													<tr>
														<td align="left" valign="top" height="13"></td>
													</tr>
													<tr>
														<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="22" align="left" valign="top"><label>Similar Species : </label></td>
															</tr>
															<tr>
																<td align="left" valign="top" width="349">
																	<?php

																	if(!empty($details->similar_species)){
																		$similar_species = $details->similar_species;
																	}
																	else{
																		$similar_species = "";
																	}?>
																	<textarea id="similar_species" name="similar_species" rows="3" cols="60" ><?php echo ($similar_species);?></textarea>
																	<span style="display:none;">
																		<textarea id="test" name="test" rows="3" cols="60" style="display:none;"></textarea>
																	</span>
																</td>
															</tr>
														</table></td>
													</tr>
													<tr >
														<td align="left" valign="top" height="13"></td>
													</tr>





													<tr>
														<td align="left" valign="top" height="13"></td>
													</tr>
													<tr>
														<td align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="22" align="left" valign="top"><label>Status:</label></td>
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

													</table>
													<div class="bottonportion" style="height:auto">
														<div class="bottonserleft" style="float:none">
															<table width="100%" border="0" cellspacing="0" cellpadding="0" class="midtable">
															</table>
														</div>
													</div>


													<div class="bottonserright" style="padding-bottom:20px;">
														<a href="javascript:void(0);" title="Delete" id="btndelete" onClick="confirmdel_factsheet('<?php echo $details->id;?>','<?php echo rawurlencode(site_url("kaizen/factsheet/dolist"));?>');" class="darkgreybtn" <?php if(isset($details->id) && $details->id >0){}else{echo 'style="display:none;"';}?>> <span>Delete</span> </a>
															<a href="javascript:void(0);" class="darkgreybtn" onClick="form_submit('edit');" id="btnsave"><span>Save</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
															<a href="javascript:void(0);" class="darkgreybtn" id="btnsave_back" onClick="form_submit('<?php echo $pgs.'#'.$details->id; ?>');"><span>Save and Go-Back</span></a>

															<?php if(empty($language)){ ?>

																<div style="float:right;">

																	<a href="<?php echo site_url("kaizen/factsheet/doedit/".$details->id."?language=french&page=".$pgs); ?>">
																		Go to French
																	</a></div>

																	<?php }else{ ?>

																		<div style="float:right;">

																			<a href="<?php echo site_url("kaizen/factsheet/doedit/".$details->id."?page=".$pgs); ?>">
																				Go to English
																			</a></div>

																			<?php } ?>
																			<br/>

																			<?php echo form_close();?> </div>
																		</div>
																	</div>
																	<div class="bodybottom"> </div>
																</div>

																<script>
																/*   $(document).ready(function() {
																var max_fields      = 10; //maximum input boxes allowed
																var wrapper         = $(".input_fields_wrap"); //Fields wrapper
																var add_button      = $(".add_field_button"); //Add button ID

																var x = 1; //initlal text box count
																$(add_button).click(function(e){ //on add input button click
																e.preventDefault();
																if(x < max_fields){ //max input box allowed
																x++; //text box increment
																$(wrapper).append('<div style="margin-top:20px;border-style: solid;border-width: 1px;padding: 10px 10px 10px;"><a href="#" class="remove_field" style="float: right;">X</a><label>Gallery Image:</label>  <input name="factsheet_image[]" type="file"  /><br/><br/><label>Image Caption: </label>  <input id="factsheet_caption'+x+'" name="factsheet_caption[]" class="inputinpt" type="text" /></div>'); //add input box
															}
														});

														$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
														e.preventDefault(); $(this).parent('div').remove(); x--;
													})



													var max_fields1      = 3; //maximum input boxes allowed
													var wrapper1         = $(".input_fields_wrap1"); //Fields wrapper
													var add_button1      = $(".add_field_button1"); //Add button ID

													var x = 1; //initlal text box count
													$(add_button1).click(function(e){ //on add input button click
													e.preventDefault();
													if(x < max_fields1){ //max input box allowed
													x++; //text box increment
													$(wrapper1).append('<div style="margin-top:20px;border-style: solid;border-width: 1px;padding: 10px 10px 10px;"><a href="#" class="remove_field1" style="float: right;">X</a><label>Species Image:</label>  <input name="factsheet_similar_species_image[]" type="file"  /><br/><br/><label>Species Caption: </label>  <input id="factsheet_similar_species_image_caption'+x+'" name="factsheet_similar_species_image_caption[]" class="inputinpt" type="text" /></div>'); //add input box
												}
											});

											$(wrapper1).on("click",".remove_field1", function(e){ //user click on remove text
											e.preventDefault(); $(this).parent('div').remove(); x--;
										})


									});*/


									<?php /* if(!empty($details_species)) {

										//	foreach($details_species as $row_details_species){

										?>
										addspecies('<?php echo $row_details_species->factsheet_similar_species_image; ?>','<?php echo $row_details_species->factsheet_similar_species_image_caption; ?>','<?php echo $row_details_species->factsheet_similar_species_image_title; ?>');
										<?php

									}
								} */
								?>


								/*function addspecies(file,caption,species_title){
								var count = $('#count_img').val();
								var count_val = parseInt(count)+1;
								$('#count_img').val(count_val);

								$.ajax({
								type: "POST",
								url : '<?php echo site_url("kaizen/factsheet/add_species/");?>',
								data: { count:count,file:file,caption:caption,species_title:species_title},
								dataType : "html",
								success: function(data)
								{
								if(data)
								{

								$("#galleryfile").prepend(data);

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
		}*/



		<?php if(!empty($details_gallery)){

			foreach($details_gallery as $row_details_gallery){

				?>
				addgallery('<?php echo $row_details_gallery->factsheet_image; ?>','<?php echo strip_tags(preg_replace('/\s\s+/', ' ', $row_details_gallery->factsheet_image_caption)); ?>','<?php echo $row_details_gallery->factsheet_image_title; ?>');
				<?php

			}
		}
		?>



		</script>
		<script type="text/javascript">
		$(function() {

			<?php if(empty($details->gallery_id)){ ?>
				jQuery("#sel_gal_tr").hide();
				<?php  }else{ ?>
					jQuery("#sel_gal_tr").show();


					<?php } ?>
					$('.jcarousel').jcarousel({
						auto: 0,
						scroll: 1
					});
					$('.jcarousel-control-prev')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						target: '-=1'
					});

					$('.jcarousel-control-next')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						target: '+=1'
					});
					$('#hdnvar').val('1');


				});
				</script>



				<script type="text/javascript">
				$(function() {

					<?php if(empty($details->similar_species_id)){ ?>
						jQuery("#sel_gal_tr_similar").hide();
						<?php  }else{ ?>
							jQuery("#sel_gal_tr_similar").show();


							<?php } ?>
							$('.jcarousel').jcarousel({
								auto: 0,
								scroll: 1
							});
							$('.jcarousel-control-prev')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								target: '-=1'
							});

							$('.jcarousel-control-next')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								target: '+=1'
							});
							$('#hdnvar_similar').val('1');


						});
						</script>


						<script>
						$('.fancybox_crop').fancybox({
							width:'1200',
							height: '800'
						});
						</script>
						<script>

						$(document).ready(function(){

							$("#target").click(function() {
								var hdngalleryid = $('#hdngalleryid').val();
								// console.log("main :- "+hdngalleryid);
								var factsheet_id = $('#factsheet_id').val();
								var language = $('#language').val();

								$.fancybox.open({
									href: "<?php echo base_url('kaizen/factsheet/selectimagefactsheet/'); ?>",
									type: "ajax",
									width:'1200',
									ajax: {
										type: "POST",
										data: { factid:factsheet_id,hdngalleryid:hdngalleryid,language:language},
									},
									beforeClose: function() {
										$('#selected_pages_id option').prop('selected', true);
										var values_arr = [];
										$('#selected_pages_id option').each(function() {
											values_arr.push( $(this).attr('value') );

										});
										var str1 = values_arr.toString();
										$('#hdngalleryid').val(str1);
										var hdngalleryid = $('#hdngalleryid').val();
										// console.log("after close :- "+hdngalleryid);

										$.ajax({
											type: "GET",
											url : '<?php echo base_url('kaizen/factsheet/test2?language='.$language.'&hdngalleryid='); ?>'+hdngalleryid,
											dataType : "html",
											success: function(data)
											{
												if(data)
												{

													$("#resultgallery").html(data);
													jQuery("#sel_gal_tr").show();
													$('.jcarousel').jcarousel('reload');
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
								});
							});



							$("#target_similar").click(function() {
								var hdngalleryid = $('#hdngalleryid_similar').val();
								// console.log("main :- "+hdngalleryid);
								var factsheet_id = $('#factsheet_id').val();
								var language = $('#language').val();

								$.fancybox.open({
									href: "<?php echo base_url('kaizen/factsheet/selectimagefactsheet_similar/'); ?>",
									type: "ajax",
									width:'1200',
									ajax: {
										type: "POST",
										data: { factid:factsheet_id,hdngalleryid:hdngalleryid,language:language},
									},
									beforeClose: function() {
										$('#selected_pages_id option').prop('selected', true);
										var values_arr = [];
										$('#selected_pages_id option').each(function() {
											values_arr.push( $(this).attr('value') );

										});
										var str1 = values_arr.toString();
										$('#hdngalleryid_similar').val(str1);
										var hdngalleryid = $('#hdngalleryid_similar').val();
										// console.log("after close :- "+hdngalleryid);

										$.ajax({
											type: "GET",
											url : '<?php echo base_url('kaizen/factsheet/test2_similar?language='.$language.'&hdngalleryid='); ?>'+hdngalleryid,
											dataType : "html",
											success: function(data)
											{
												if(data)
												{

													$("#resultgallery_similar").html(data);
													jQuery("#sel_gal_tr_similar").show();
													$('.jcarousel').jcarousel('reload');
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
								});
							});



						});



						//fancybx();
						function fancybx(){
							/*

							console.log(hdngalleryid);
							$('.fancybox').fancybox({
							width:'1200',
							height: '800',
							href: '',
							type: 'ajax',
							afterClose: 	function() {
							fancybx();
						},
						beforeClose: function() {
						$('#selected_pages_id option').prop('selected', true);
						var values_arr = [];
						$('#selected_pages_id option').each(function() {
						values_arr.push( $(this).attr('value') );

					});
					var str1 = values_arr.toString();
					$('#hdngalleryid').val(str1);


					var hdngalleryid = $('#hdngalleryid').val();

					$.ajax({
					type: "GET",
					url : '<?php //echo base_url('kaizen/factsheet/test2?hdngalleryid='); ?>'+hdngalleryid,
					dataType : "html",
					success: function(data)
					{
					if(data)
					{

					$("#resultgallery").html(data);

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



//console.log(str1);

$('.jcarousel').jcarousel('reload');

}
});
*/
}

</script>

<script type="text/javascript">
if ( typeof CKEDITOR == 'undefined' )
{

}
else
{
	//  var editor = CKEDITOR.replace( 'title',{ toolbar :[['Bold','Italic','Underline','Strike'],] } );
	var editor = CKEDITOR.replace( 'synonyms',{ toolbar :[['Bold','Italic','Underline','Strike'],] } );

	var editor = CKEDITOR.replace( 'regulation' );
	var editor = CKEDITOR.replace( 'distribution_canadian' );
	var editor = CKEDITOR.replace( 'distribution_worldwide' );
	var editor = CKEDITOR.replace( 'average_seed_size' );
	var editor = CKEDITOR.replace( 'seed_surface_texture' );
	var editor = CKEDITOR.replace( 'seed_colour' );
	var editor = CKEDITOR.replace( 'seed_shape' );
	var editor = CKEDITOR.replace( 'other_seed_features' );
	var editor = CKEDITOR.replace( 'habitat_and_corp_association' );
	var editor = CKEDITOR.replace( 'general_info' );
	var editor = CKEDITOR.replace( 'similar_species' );
	var editor = CKEDITOR.replace( 'test' );

}

function confirmdel(id){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/factsheet/dodeleteimg/");?>?deleteid="+id;
	}
	else{
		return false;
	}
}

function closedivimage(div_id){
	$('#'+div_id).remove();

}
function closedivimage_gal(div_id_gal){

	$('#'+div_id_gal).remove();

}
</script>
<?php $this->load->view($footer); ?>

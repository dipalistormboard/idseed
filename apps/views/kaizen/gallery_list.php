<?php $this->load->view($header); ?>
<?php $this->load->view($left);
$ppp=''; if($this->uri->segment(3)=='dosearch') { 
 $ppp = $this->uri->segment(4); } ?>
<link rel="stylesheet" href="<?php echo site_url("public/kaizen/validator/css/validationEngine.jquery.css");?>" type="text/css"/>
<script src="<?php echo site_url("public/kaizen/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

$(document).ready(function(){
		$("#search_frm").validationEngine();
	$('.newshow_hide').click(
	function () {
		$('.showhide').fadeIn('slow');
		}
	);
	$('.close').click(
	function () {
		$('.showhide').fadeOut('slow');
		}
	);
});



</script>
<div class="bodyright">
  <div class="bodytop"> </div>
  <div class="bodymid"> 

    <div class="midarea">
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
      <h3 class="tableheading">Gallery List </h3>
      
      <div class="searchpanel">
                <form action="<?php echo base_url("kaizen/gallery"); ?>" id="search_frm">
                    <input type="hidden" name="postform" value="list" />
                    <div style="float:left;"> 
       <input type="text" value="<?php if(isset($_GET['q'])) {echo $_GET['q'];}else{echo $ppp;}?>" name="q" id="q"  class="searchl validate[required]"/></div>
            <a class="darkgreybtn" onclick="resetsearch();" title="Reset" href="javascript:void(0);" style="float:right;"> <span>Reset</span> </a>
            <button onclick="showdata();" style="" class="searchbut"></button>
            </form>
            <script>
				
				function resetsearch(){
  $("#criteria_div").html('');
  $('#q option:eq(0)').attr('selected','selected');
  window.location.href="<?php echo site_url("kaizen/gallery/dolist/");?>?q=&criteria=";
}
            </script>

          </div>
          
  <ul class="pagination">
        <?php echo $pagination; ?>
      </ul>
      <div class="spacer"> </div>
      <div class="tabelmiddle">
        <div class="tabelTop">
          <div class="tabelbottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="120" height="39" align="center" valign="top">Title</th>
                      <th width="153" align="center" valign="top">Logo</th>
                      <th width="89" align="center" valign="top">Family</th>
                       <th width="89" align="center" valign="top">Status</th>
                      <th width="65" align="center" valign="top">Edit</th>
                      <th width="65" align="center" valign="top" class="nobr">Delete</th>
                    </tr>
                  </table></td>
              </tr>
              <?php
			  if(isset($empty_msg)){
				  ?>
              <tr>
                <td align="center" valign="top"><b><?php echo $empty_msg;?></b><br /></td>
              </tr>
              <?php
			  }
			  else{
			  $i=0;
			  foreach($records as $row){
				  $i++;				  
			  ?>
              <tr id="<?php echo $row->id;?>">
                <td align="left" valign="top" <?php if($i%2==0){echo 'class="graybg"';}?>><table width="100%" border="0" cellspacing="0" cellpadding="0" class="withbr">
                    <tr >
                      <td width="228" height="100" align="center" valign="middle"><?php echo $row->title;?></td>
                      <td width="304" align="center" valign="middle"><?php
		
		if($row->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/".$row->gallery_photo))	
		{
			
		$image_thumb=file_upload_base_url()."gallery_photo/".$row->gallery_photo;
			
		}
		else
		{
			$image_thumb = base_url('public/kaizen/images/image-box.gif');
		}?>
                        <img src="<?php echo $image_thumb;?>" width="150" height="80"/> </td>
                      <td width="224" align="center" valign="middle">
                        <?php echo $row->sub_title;?>
						 </td>
                         <th width="229" align="center"><?php if($row->is_active==1){ ?>
												<a href="<?php echo site_url("kaizen/".$this->router->fetch_class()."/statusChange/".$row->id."/gallery");?>" title="Active"> <img src="<?php echo site_url("public/images/unlock_icon.gif");?>" alt="Active"/> </a>
												<?php } else{ ?>
												<a href="<?php echo site_url("kaizen/".$this->router->fetch_class()."/statusChange/".$row->id."/gallery");?>" title="Inactive"> <img src="<?php echo site_url("public/images/locked_icon.gif");?>" alt="Inactive"/></a>
												<?php } ?>
													</th>
<td width="167" align="center" valign="middle">
<a href="<?php echo site_url("kaizen/gallery/doedit/".$row->id);?>?page=<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?><?php if(!empty($this->uri->segment(5))){?>/<?php echo $this->uri->segment(5);} ?>" title="Edit" class="edit3"></a></td>
                      <td width="188" align="center" valign="middle" class="nobr"><a href="javascript:void(0);" title="Delete" onClick="confirmdel('<?php echo $row->id;?>','<?php echo rawurlencode(current_url());?>','');" class="delete3"></a></td>
                    </tr>
                  </table></td>
              </tr>
             
              <?php
			  }
			  }
			  ?>
            </table>
          </div>
        </div>
      </div>
      <ul class="pagination" style="margin-bottom:20px;">
        <?php echo $pagination; ?>
      </ul>
      <div class="spacer"></div>
    </div>
  </div>
  <div class="bodybottom"> </div>
</div>
<script type="text/javascript">
function confirmdel(id,page,pos){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/gallery/dodelete/");?>?deleteid="+id+"&pos="+pos+"&ref="+page;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>
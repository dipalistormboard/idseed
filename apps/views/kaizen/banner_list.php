<?php $this->load->view($header); ?>
<?php $this->load->view($left); ?>
<script type="text/javascript">

$(document).ready(function(){
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
      <h3 class="tableheading">Banners List </h3>
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
                      <th width="89" align="center" valign="top">Sequence</th>
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
              <tr>
                <td align="left" valign="top" <?php if($i%2==0){echo 'class="graybg"';}?>><table width="100%" border="0" cellspacing="0" cellpadding="0" class="withbr">
                    <tr>
                      <td width="297" height="100" align="center" valign="middle"><?php echo $row->title;?></td>
                      <td width="231" align="center" valign="middle"><?php
		
		if($row->banner_photo!='' && is_file(file_upload_absolute_path()."banner_photo/".$row->banner_photo))	
		{
			
		$image_thumb=file_upload_base_url()."banner_photo/".$row->banner_photo;
			
		}
		else
		{
			$image_thumb = base_url('public/kaizen/images/image-box.gif');
		}?>
                        <img src="<?php echo $image_thumb;?>" width="150" height="80"/> </td>
                      <td width="270" align="center" valign="middle"><?php echo $row->display_order;?> </td>
                      <th width="211" align="center"><?php if($row->is_active==1){ ?>
												<a href="<?php echo site_url("kaizen/".$this->router->fetch_class()."/statusChange/".$row->id."/banner");?>" title="Active"> <img src="<?php echo site_url("public/images/unlock_icon.gif");?>" alt="Active"/> </a>
												<?php } else{ ?>
												<a href="<?php echo site_url("kaizen/".$this->router->fetch_class()."/statusChange/".$row->id."/banner");?>" title="Inactive"> <img src="<?php echo site_url("public/images/locked_icon.gif");?>" alt="Inactive"/></a>
												<?php } ?>
													</th>
                      <td width="206" align="center" valign="middle"><a href="<?php echo site_url("kaizen/banner/doedit/".$row->id);?>" title="Edit" class="edit3"></a></td>
                      <td width="125" align="center" valign="middle" class="nobr"><a href="javascript:void(0);" title="Delete" onClick="confirmdel('<?php echo $row->id;?>','<?php echo rawurlencode(current_url());?>','');" class="delete3"></a></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"></td>
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
		window.location.href="<?php echo site_url("kaizen/banner/dodelete/");?>?deleteid="+id+"&pos="+pos+"&ref="+page;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>

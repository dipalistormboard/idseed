<?php $this->load->view($header); ?>
<?php $this->load->view($left); ?>

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
<b>


	  <h3 class="tableheading">Comment List</h3>
      <?php /*<div class="searchpanel">
        <form action="<?php echo site_url("kaizen/comments/");?>" method="get">
          <input name="q" value="<?php echo $q;?>" type="text" class="search" />
          <input name="" type="submit" class="searchbut" />
          <br class="spacer" />
        </form>
      </div>*/?>
      <ul class="pagination">
        <?php echo $pagination; ?>
      </ul>
	  <?php if($pagination != ""){echo '<br /><br />';}?>
      <div class="spacer"> </div>
      <div class="tabelmiddle">
        <div class="tabelTop">
          <div class="tabelbottom">
		        <?php 
		$attributes = array('name' => 'save_pos', 'id' => 'save_pos');
		echo form_open('kaizen/blog_cmnts_drp/changestatus/',$attributes);
		if($this->session->userdata('ERROR_MSG')==TRUE){
			echo '<div class="notific_error">
					<h2 align="center" style="color:#fff;">'.$this->session->userdata('ERROR_MSG').'</h1></div>';
			$this->session->unset_userdata('ERROR_MSG');
		}
		if($this->session->userdata('SUCC_MSG')==TRUE){
			echo '<div class="notific_suc"><h2 align="center" style="color:#000;">'.$this->session->userdata('SUCC_MSG').'</h1></div>';
			$this->session->unset_userdata('SUCC_MSG');
		}
		echo form_hidden('page', $this->uri->segment(4));
		?>
		 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"></td>
              </tr>
              <tr>
			   
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
					 <th width="65" align="center" valign="top">Approve</th>
                      <th width="120" height="39" align="center" valign="top">Author</th>
					  <th width="120" height="39" align="center" valign="top">Dated</th>
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
				  $date = new DateTime($row->add_dt);
				$e = $date->format('F j, Y \a\t g:i A');			  
			  ?>
              <tr>
                <td align="left" valign="top" <?php if($i%2==0){echo 'class="graybg"';}?>><table width="100%" border="0" cellspacing="0" cellpadding="0" class="withbr">
                    <tr>
					 <tD width="65" align="center" valign="middle">
					 <input type="checkbox" name="chk[<?php echo $row->id;?>]" id="chk_'<?php echo $row->id;?>'" value="1" <?php if($row->is_active=='1'){ echo 'checked="checked"';}?> />
					  <input type="hidden" name="name[<?php echo $row->id;?>]" id="name_'<?php echo $row->id;?>'" value="<?php echo $row->post_id;?>" />
					 </tD>
                      <td width="120" height="100" align="center" valign="middle">
					  	<?php echo $row->fname.'&nbsp;'.$row->lname;?>
					  </td>
					  <td width="120" height="100" align="center" valign="middle"><?php echo $e;?></td>
						<td width="65" align="center" valign="middle">
							<a href="<?php echo site_url("kaizen/blog_cmnts_drp/doedit/".$row->id."/?post_id=".$row->post_id);?>" title="Edit" class="edit3"></a>
						</td>
                      <td width="65" align="center" valign="middle" class="nobr"><a href="javascript:void(0);" title="Delete" onClick="confirmdel('<?php echo $row->id;?>','<?php echo $row->is_active;?>','<?php echo rawurlencode(current_url());?>','');" class="delete3"></a></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"></td>
              </tr>
              <?php
			  }
			  ?>
			  <tr>
                <td align="center" valign="top">
				<input type="submit" name="chng_status" id="chng_status" value="Save"/>
				</td>
              </tr>
			  <?php 
			  }
			  ?>
            </table>
			<?php echo form_close();?>
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
function confirmdel(id,is_active,page,pos){
	if(confirm("Are you sure want to delete?")){
		window.location.href="<?php echo site_url("kaizen/blog_cmnts_drp/dodelete/");?>?deleteid="+id+"&is_active="+is_active+"&pos="+pos+"&ref="+page;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>

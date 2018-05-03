<?php $this->load->view($header); ?>
<link rel="stylesheet" href="<?php echo site_url("public/kaizen/validator/css/validationEngine.jquery.css");?>" type="text/css"/>
<script src="<?php echo site_url("public/kaizen/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>
<?php $this->load->view($left); ?>
<script type="text/javascript">

$(document).ready(function(){
    $("#search").validationEngine();
    
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
      <h3 class="tableheading">Factsheet List </h3>
      <form action="<?php echo base_url('kaizen/factsheet'); ?>" method="get" name="search" id="search">
          <select name="field" id="field" onchange="validate(this.value);">
              <option value="">Select</option>
              <option value="title">Title</option>
              <option value="family">Family</option>
              <option value="synonyms">Synonyms</option>
              <option value="common_name">Common Name</option>
              <option value="duration_of_lifecycle">Duration of Life Cycle</option>
              <option value="seed_type">Seed/Fruit Type</option>
              <option value="active">Active</option>
              <option value="inactive">In Active</option>
          </select>
          <script>
              $('#field').val('<?php echo $field; ?>');
          </script>   
      <input type="textbox" name="q" value="<?php if(!empty($q)) echo $q; ?>" class="validate[required]" id="q"/>
      <input type="submit" value="Search"/>
      </form>
      <script>
      function validate(id){
          if(id!=''){
              if(id=='active'||id=='inactive'){
                  $("#q").removeAttr("class");
              }else{
                  $("#q").attr("class","validate[required]");
              }
          }
      }
      </script>
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
                    <tr>
                      <td width="457" height="100" align="center" valign="middle"><?php echo $row->title;?></td>
                       <td width="356" align="center"><?php if($row->is_active==1){ ?>
												<a href="<?php echo site_url("kaizen/".$this->router->fetch_class()."/statusChange/".$row->id."/factsheet");?>" title="Active"> <img src="<?php echo site_url("public/images/unlock_icon.gif");?>" alt="Active"/> </a>
												<?php } else{ ?>
												<a href="<?php echo site_url("kaizen/".$this->router->fetch_class()."/statusChange/".$row->id."/factsheet");?>" title="Inactive"> <img src="<?php echo site_url("public/images/locked_icon.gif");?>" alt="Inactive"/></a>
												<?php } ?>
													</td>
                      <td width="343" align="center" valign="middle"><a href="<?php echo site_url("kaizen/factsheet/doedit/".$row->id);?>?page=<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?><?php if(!empty($this->uri->segment(5))){?>/<?php echo $this->uri->segment(5);} ?>" title="Edit" class="edit3"></a></td>
                      <td width="184" align="center" valign="middle" class="nobr"><a href="javascript:void(0);" title="Delete" onClick="confirmdel('<?php echo $row->id;?>','<?php echo rawurlencode(current_url());?>','');" class="delete3"></a></td>
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
		window.location.href="<?php echo site_url("kaizen/factsheet/dodelete/");?>?deleteid="+id+"&pos="+pos+"&ref="+page;
	}
	else{
		return false;
	}
}
</script>
<?php $this->load->view($footer); ?>

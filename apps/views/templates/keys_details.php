<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
//$print_r($sub_page);
//pre($sub_page);
//echo $sub->page; exit;
?>
<style>
iframe{
	height:600px;
	}
</style>
<!--banner section start -->
<div class="content">
    	<div class="wrapper">
            <h2><?php if(!empty($keys_details->title)){ echo outputEscapeString($keys_details->title);} ?></h2>
            <?php //print_r($keys_details);?>
            	<?php if(!empty($keys_details->embeded_script)){ echo outputEscapeString($keys_details->embeded_script);} ?>
             
            
        </div>
</div>
<?php $this->load->view($footer);
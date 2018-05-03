<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
?>
<!--banner section start -->
<div class="home-content">
    	<div class="wrapper">
            <?php if(!empty($this->data['hooks_meta']->content)){ echo outputEscapeString($this->data['hooks_meta']->content);} ?>
        </div>
</div>
<?php $this->load->view($footer); ?>



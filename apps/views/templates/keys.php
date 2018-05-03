<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
//$print_r($sub_page);
//pre($sub_page);
//echo $sub->page; exit;
?>
<!--banner section start -->
<div class="content">
    	<div class="wrapper">
            
            	<?php if(!empty($this->data['hooks_meta']->content)){ echo outputEscapeString($this->data['hooks_meta']->content);} ?>
            
            <?php
                    if(!empty($keys)){
                        ?>
            <ul class="keys-tabmenu">
            <?php
                $i = 0;
                        foreach($keys as $ke){
                            
            ?>
                    <li <?php if(empty($i)){ ?> class="active" <?php } ?>><a href="javascript:void(0)"><?php echo $ke->title; ?></a></li>
            <?php
                       $i++; }
                        ?>
            </ul>
                <?php
                    }
            ?>
            <?php
                    if(!empty($keys)){
                        ?>
            <?php
                $i = 0;
                        foreach($keys as $ke){
                            
            ?>
            <div class="keys-tabcont" <?php if(empty($i)){ ?> style="display: block;" <?php } ?>>
                <?php echo outputEscapeString($ke->content); ?>
                <?php if(!empty($ke->button_text)){ ?>
                            <a class="key-button" href="<?php echo site_url("keys/details/".$ke->page_link); ?>"><?php echo $ke->button_text; ?></a>
                <?php } ?>
            </div>
            <?php
                       $i++; }
                        ?>
            <?php
                    }
            ?>
            
        </div>
</div>
<?php $this->load->view($footer);
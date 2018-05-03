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
            <?php if(!empty($sub_page)){ ?>
            <div class="inner-left">
            	<?php if(!empty($this->data['hooks_meta']->content)){ echo outputEscapeString($this->data['hooks_meta']->content);} ?>
            </div>
            <div class="inner-right">
                <ul>
                    <?php foreach($sub_page as $sub_p){ ?>
                        <li><a href="<?php echo site_url('pages/'.$sub_p->page_link);?>"><?php echo $sub_p->title; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php }else{?>
            <?php if(!empty($this->data['hooks_meta']->content)){ echo outputEscapeString($this->data['hooks_meta']->content);} 
            } ?>
            
        </div>
</div>
<?php $this->load->view($footer);
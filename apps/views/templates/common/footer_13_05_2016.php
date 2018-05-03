<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- Footer Section Start-->
	<div class="footer">
    	<div class="ftnav">
        	<div class="wrapper">
                <?php 	echo $this->data['hooks_footerpages_list'];?>
            </div>
        </div>
        <div class="ftlogo-section">
        	<div class="wrapper">
                <div class="ftleft">
            		<p><?php if(!empty($this->data['site_settings']->edition)){ echo $this->data['site_settings']->edition; } ?></p>
                </div>
                <?php if(!empty($this->data['footer_logo'])){ ?>
                <ul class="ftlogos">
                    <?php foreach($this->data['footer_logo'] as $footer_logo){ 
                        if(!empty($footer_logo->footer_logo) && is_file(file_upload_absolute_path()."footer_logo_photo/".$footer_logo->footer_logo)) { ?>
                	<li><img src="<?php echo base_url("public/uploads/footer_logo_photo/".$footer_logo->footer_logo); ?>" alt="" title="" /></li>
                    
                    <?php   } 
                        }?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="copyright">
    	<div class="wrapper">
        	<ul class="ftsocial">
                <?php echo socialLinks(); ?>
            </ul>
        	<p class="copytext">&copy; <?php echo date("Y"); ?> <?php echo $this->data['site_settings']->copyright; ?></p>
            <p class="designby">Website Designed & Developed by <a href="https://www.2webdesign.com/" rel="nofollow" target="_blank">2 Web Design</a></p>
        </div>
    </div>
<!-- Footer Sectio End-->

</body>
</html>

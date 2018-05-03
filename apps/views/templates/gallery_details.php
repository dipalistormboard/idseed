<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
?>
<?php //pre($gallery); ?>
<!--banner section start -->
<div class="content">
    	<div class="wrapper">
        	<div id="" class="">
        <?php 
                    $image1 = base_url('public/noiphoto.png');
                    if($gallery->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/resize_".$gallery->gallery_photo)){
                        $image1 = base_url("public/uploads/gallery_photo/resize_".$gallery->gallery_photo);
                    }	
                    ?>
            <div class="">
                <img src="<?php echo $image1; ?>" alt="" title="" />
            </div>
            <h2><?php echo $gallery->title; ?></h2>
            <h3><?php if(!empty($gallery->sub_title)){ echo $gallery->sub_title; }?></h3>
            <p><?php if(!empty($gallery->excerpt)){ echo $gallery->excerpt; }?></p>
            
        </div>
        </div>
    </div>

<?php $this->load->view($footer); ?>



<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
?>
<!--banner section start -->
<div class="content">
    	<div class="wrapper">
        	<h2>Gallery</h2>
            <div class="gallery-top">
            	<p>Starred images are non-FNW taxa.</p>
                <form method="post">
                	<div class="gallery-select">
                    	<label>Include (keywords):</label>
                        <select>
                        	<option>Select Multiple:</option>
                        </select>
                    </div>
                    <div class="gallery-select">
                    	<label>Exclude (keywords):</label>
                        <select>
                        	<option>Select Multiple:</option>
                        </select>
                    </div>
                    <div class="gallery-select-right">
                    	<label>Exclude (keywords):</label>
                        <div class="gallery-pagination">
                            <select>
                                <option>1</option>
                            </select>
                            <p>of 15</p>
                            <span class="next"></span>
                        </div>
                    </div>
                </form>
            </div>
            <?php if(!empty($gallery_list)){ ?>
            <ul class="gallery-list">
                <?php foreach ($gallery_list as $gallery){ ?>
            	<li>
                    <?php 
                    $image = base_url('public/noiphoto.png');
                    if($gallery->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/".$gallery->gallery_photo)){
                        $image = base_url("public/uploads/gallery_photo/".$gallery->gallery_photo);
                    }	
                    ?>
                	<img src="<?php echo $image; ?>" alt="" title="" />
                    <div class="gallery-info">
                    	<h5><?php echo $gallery->title; ?></h5>
                        <p><?php if(!empty($gallery->excerpt)){ echo $gallery->excerpt; }?></p>
                    </div>
                    <div class="gallery-overlay">
                    	<h5><?php echo $gallery->title; ?></h5>
                        <?php if(!empty($gallery->description)){ echo $gallery->description; }?>
                        <div class="gallery-icons">
                        	<a href="#" class="search"></a>
                            <a href="#" class="link"></a>
                        </div>
                    </div>
                </li>
            <?php } ?>
            </ul>
            <?php } ?>
            <span class="loading"></span>
        </div>
    </div>
<?php $this->load->view($footer); ?>



 <ul class="gallery-list" >
<?php $i=0;


                foreach ($gallery_list as $gallery){ ?>
            	<li>
                    <?php 
                    $image = base_url('public/noiphoto.png');
                    
                    if(!empty($gallery->photo_gif)){
                        if($gallery->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/".$gallery->gallery_photo)){
                            $image = base_url("public/uploads/gallery_photo/".$gallery->gallery_photo);
                        }
                    }else{
                            if($gallery->gif_image!='' && is_file(file_upload_absolute_path()."gallery_photo/".$gallery->gif_image)){
                                $image = base_url("public/uploads/gallery_photo/".$gallery->gif_image);
                            }
                    }
                 
                    
                    
                    
                    ?>
                	<img src="<?php echo $image; ?>" alt="" title="" />
                    <div class="gallery-info">
                    	<h5><?php echo $gallery->title; ?></h5>
                        <p><?php if(!empty($gallery->sub_title)){ echo $gallery->sub_title; }?></p>
                    </div>
                    <div class="gallery-overlay">
                    <a href="#inline<?php echo $i; ?>" class="search fancybox" data-fancybox-group="gallery">
                    	<h5><?php echo $gallery->title; ?></h5>
                        <p><?php if(!empty($gallery->excerpt)){ echo $gallery->excerpt; }?></p>
                        <div class="gallery-icons">
                        	
                            <!--<a href="javascript:void(0)"  onclick="window.open('http://www.w3schools.com', 'newwindow', 'width=300, height=250'); return false;" class="link"></a>-->
                            <span class="search"></span>
                        </div>
                    </a>
                    </div>
                </li>
            <?php $i++; } ?>
            </ul>
            <?php if(!empty($gallery_list)){ ?>
<?php $j=0;
    foreach ($gallery_list as $gallery){  ?>
    <div id="inline<?php echo $j; ?>" class="fancy-content">
        <?php 
                    $image1 = base_url('public/noiphoto.png');
                    if(!empty($gallery->photo_gif)){
                        if($gallery->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/resize_".$gallery->gallery_photo)){
                            $image1 = base_url("public/uploads/gallery_photo/resize_".$gallery->gallery_photo);
                        }
                    }else{
                            if($gallery->gif_image!='' && is_file(file_upload_absolute_path()."gallery_photo/".$gallery->gif_image)){
                                $image1 = base_url("public/uploads/gallery_photo/".$gallery->gif_image);
                            }
                    }	
                    ?>
            <div class="fancy-img">
                <img src="<?php echo $image1; ?>" alt="" title="" />
            </div>
            <h2><?php echo $gallery->title; ?></h2>
            <h3><?php if(!empty($gallery->sub_title)){ echo $gallery->sub_title; }?></h3>
            <p><?php if(!empty($gallery->excerpt)){ echo $gallery->excerpt; }?></p>
            <a href="javascript:void(0)"  onclick="window.open('<?php echo $image1; ?>','name<?php echo $j; ?>','width=600,height=600, location=0');" class="link"><?=$title_opennew_window?></a>
        </div>
<?php $j++;
        }
    } ?>
           <?php if(!empty($pagination)){ ?>
		<br style="clear:both;" />
		<div class="clear"></div>
		<div class="pagination">
			<ul>
				<?php echo $pagination; ?>
			</ul>
		</div>
<?php } ?>

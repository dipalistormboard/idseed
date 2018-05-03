<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);

?>
<?php
  if($this->session->userdata('language_version') == "french"){
	  $gallery_txt = 'Galerie';
	  $no_data = 'Aucune donnée disponible.';
	  }else{
		  $gallery_txt = 'Gallery';
	  $no_data = 'No Data Found.';
	  }
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/jpages_style.css'); ?>" />
<!--banner section start -->
<div class="content">
    	
    	<div class="wrapper">
        	<h2><?php echo $this->data['hooks_meta']->title; ?> for <?php echo $search; ?></h2>
           <!-- <ul>
            	<li>Side view of bracted disseminule showing one outer bract edge.</li>
                <li>Family feature and glossary aid seed identification and analyst training</li>
                <li>Front and back views of a bracted disseminule showing outer bract .</li>
                <li>Branched grass disseminule.</li>
                <li>Side view of bracted disseminule showing one outer bract edge.</li>
            </ul>-->
            <?php if(!empty($search_result)){ ?>
				<?php //echo '<pre>'; print_r($search_result); ?>
					<?php if(!empty($search_result['pages'])){ ?>
                    	<h3>Pages</h3>
                        <ul>
							<?php 
								foreach($search_result['pages'] as $page){ 
								if($page->page_link == "factsheet"){
									$url = site_url("factsheet/index");
								}
								else if($page->page_link == "keys" || $page->page_link == "gallery"){
									$url = site_url($page->page_link);
								}else{
									$url = site_url("pages/".$page->page_link);
								}
							?>
                            	<li><a target="_blank" href="<?php echo $url; ?>"><?php echo $page->title; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <?php if(!empty($search_result['gallery'])){ $gallery_list = $search_result['gallery']; ?>
                    
                    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/jquery.fancybox.css?v=2.1.5');?>" media="screen" />
					<script type="text/javascript" src="<?php echo base_url('public/js/jquery.fancybox.js?v=2.1.5');?>"></script>
                    <script>
                        $('.fancybox').fancybox();
                    </script>
                    <script type="text/javascript" src="<?php echo base_url("public/js/highlight.pack.js");?>"></script>
					<script type="text/javascript" src="<?php echo base_url("public/js/tabifier.js");?>"></script>
                    <script src="<?php echo base_url("public/js/jPages.js");?>"></script>
                    <script>
                      $(function() {    
                        $("ul.all").jPages({
                            containerID: "itemContainerAll",	
                            perPage : 8,
                            previous : 'Previous',
                            next : 'Next',
                            first: 'First',
                            last: 'Last',
                            minHeight: false,
                            
                            
                            callback : function(pages, items ){
                                var aid='scrollto';
                                var aTag = $("a[name='"+ aid +"']");
                                var scrollpagi =$("#scrollpagi").val();
                                if(scrollpagi!=1) {
                                $('html,body').animate({scrollTop: aTag.offset().top},'slow');
                                }
                                $("#scrollpagi").val(2);
                            }
                        });
                      });
                      </script>
  
                    	<h3><?php echo $gallery_txt; ?></h3>
                         <a name="scrollto"/></a>
                         <input type="hidden" value="1" name="scrollpagi" id="scrollpagi"/>
            <ul class="gallery-list" id="itemContainerAll">
                <?php $i=0;
                foreach ($gallery_list as $gallery){ ?>
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
                    
                    
                                <div id="inline<?php echo $i; ?>" class="fancy-content">
                                <?php 
                                            $image1 = base_url('public/noiphoto.png');
                                            if($gallery->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/resize_".$gallery->gallery_photo)){
                                                $image1 = base_url("public/uploads/gallery_photo/resize_".$gallery->gallery_photo);
                                            }	
                                            ?>
                                    <div class="fancy-img">
                                        <img src="<?php echo $image1; ?>" alt="" title="" />
                                    </div>
                                    <h2><?php echo $gallery->title; ?></h2>
                                    <h3><?php if(!empty($gallery->sub_title)){ echo $gallery->sub_title; }?></h3>
                                    <p><?php if(!empty($gallery->excerpt)){ echo $gallery->excerpt; }?></p>
                                    <a href="javascript:void(0)"  onclick="window.open('<?php echo $image1; ?>','name','width=600,height=600, location=0');" class="link">Open New Window</a>
                                </div>
        
        
        
                </li>
            <?php $i++; } ?>
            </ul>
            <?php if(!empty($gallery_list) && count($gallery_list)>8){ ?>
               <ul class="pagination all">
               </ul>
            <?php } ?>
            <?php  } ?>
                    
                    
                    
            <?php }else{ ?>
            	<?php echo $no_data; ?>
            <?php } ?>
            
            
            
			
        
    </div>
    
</div>
<?php $this->load->view($footer);
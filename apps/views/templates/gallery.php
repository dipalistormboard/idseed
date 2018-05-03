<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/jquery.fancybox.css?v=2.1.5');?>" media="screen" />
<script type="text/javascript" src="<?php echo base_url('public/js/jquery.fancybox.js?v=2.1.5');?>"></script>
<script>
    $('.fancybox').fancybox();
</script>
<script type="text/javascript" src="<?php echo base_url("public/js/highlight.pack.js");?>"></script>
<script type="text/javascript" src="<?php echo base_url("public/js/tabifier.js");?>"></script>
<!--<script src="<?php echo base_url("public/js/jPages.js");?>"></script>-->
<script>
/*  $(function() {    
    $("ul.all").jPages({
        containerID: "itemContainerAll",	
        perPage : 24,
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
  });*/
  
  function toggle_div(drop_val){
      if(drop_val=='size'){
          $('#size').show();
          $('#all').hide();
      }else{
          $('#all').show();
          $('#size').hide();
      }
  }
</script>
<input type="hidden" value="1" name="scrollpagi" id="scrollpagi"/>
<!--banner section start -->
<div class="content">
    	<div class="wrapper">
        <?
          if($this->session->userdata('language_version') == "french"){
            $title_size='Dimensions';
            $title_Shape='Forme';
            $title_Color='Couleur';
            $title_Family='Famille';
            $title_Keyword='Mot-clé';
            $title_searchtype='Sélectionner un type de recherche';
            $title_searchby='Recherche par :';
            $title_searchplaceholder='Recherche';
            $title_Length='Longueur';
            $title_Width='Largeur';
            $title_Breadth='Breadth';
            $title_opennew_window = 'Ouvrez une nouvelle fenêtre';
          }
          else{
            $title_size='Size';
            $title_Shape='Shape';
            $title_Color='Color';
            $title_Family='Family';
            $title_Keyword='Keyword';
            $title_searchtype='Select Search Type';
            $title_searchby='Search By :';
            $title_searchplaceholder='Search';
            $title_Length='Length';
            $title_Width='Width';
            $title_Breadth='Breadth';
            $title_opennew_window = 'Open New Window';
          }
            
        ?>
        	<h2><?=$this->data['hooks_meta']->title;?></h2>
            <div class="gallery-top">
                <?php if(!empty($this->data['hooks_meta']->content)){ ?>
            	<p><?php echo outputEscapeString($this->data['hooks_meta']->content); ?></p>
                <?php } ?>
                <form method="get" action="<?php echo site_url('gallery'); ?>">
                	<div class="gallery-select">
                    	<label><?=$title_searchby?></label>
                        <select name="search" id="search" onchange="toggle_div(this.value)">
                        	<option value=""><?=$title_searchtype?></option>
                            <option value="size" <?php if(!empty($search) && $search=='size'){echo 'selected';} ?>><?=$title_size?></option>
                        	<option value="shape" <?php if(!empty($search) && $search=='shape'){echo 'selected';} ?>><?=$title_Shape?></option>
                        	<option value="colour" <?php if(!empty($search) && $search=='colour'){echo 'selected';} ?>><?=$title_Color?></option>
                        	<option value="sub_title" <?php if(!empty($search) && $search=='sub_title'){echo 'selected';} ?>><?=$title_Family?></option>
                        	<option value="keyword" <?php if(!empty($search) && $search=='keyword'){echo 'selected';} ?>><?=$title_Keyword?></option>
                        </select>
                        
                        
                         
                    </div>
                    <div class="search_frm">
                        <div id="all" <?php if($search=='size'){ ?> style="display:none"<?php }else{ ?>style="display:block"<?php } ?>>
                            <input type="text" name="search_val" id="search_val" value="<?php if(isset($search_val) && !empty($search_val)){ echo $search_val; }?>" placeholder="<?=$title_searchplaceholder?>">
                        </div>
                        <div id="size" <?php if($search=='size'){ ?> style="display:block"<?php }else{ ?>style="display:none"<?php } ?>>
                            <input type="text" name="length" id="length" value="<?php if(isset($length) && !empty($length)){ echo $length; }?>" placeholder="<?=$title_Length?>">
                            <input type="text" name="width" id="width" value="<?php if(isset($width) && !empty($width)){ echo $width; }?>" placeholder="<?=$title_Width?>">
                           <?php /*?> <input type="text" name="breadth" id="breadth" value="<?php if(isset($breadth) && !empty($breadth)){ echo $breadth; }?>" placeholder="<?=$title_Breadth?>"><?php */?>
                        </div>
                         <input type="submit">
                         </div>
                    <!--<div class="gallery-select">
                    	<label>Search Value:</label>
                        <input type="text" name="search_val" id="search_val" value="">
                    </div>-->
<!--                    <div class="gallery-select-right">
                    	<label>Exclude (keywords):</label>
                        <div class="gallery-pagination">
                            <select>
                                <option>1</option>
                            </select>
                            <p>of 15</p>
                            <span class="next"></span>
                        </div>
                    </div>-->
                    <!--<div class="gallery-select">
                        <input type="submit" value="Search">
                    </div>-->
                </form>
            </div>
		    
	       
            <a name="scrollto"/></a>
        <?php //pre($gallery_list); echo '</pre>'; ?>
            <?php if(!empty($gallery_list)){ ?>
           <div id="loader">
   		    <?php if(!empty($pagination)){ ?>
	
   			<div class="clear"></div>
   			<div class="pagination">
   				<ul>
   					<?php echo $pagination; ?>
   				</ul>
   			</div>
   			<?php } ?>
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
                   // }
                    
                    
                    
                    ?>
                	<img src="<?php echo $image; ?>" alt="" title="" />
                    <div class="gallery-info">
                        <h5 class="itlc"><?php echo $gallery->title; ?></h5>
                        <p class="itlc"><?php if(!empty($gallery->sub_title)){ echo $gallery->sub_title; }?></p>
                    </div>
                    <div class="gallery-overlay">
                    <a href="#inline<?php echo $i; ?>" class="search fancybox" data-fancybox-group="gallery">
                    	<h5 class="itlc"><?php echo $gallery->title; ?></h5>
                        <p class="itlc"><?php if(!empty($gallery->excerpt)){ echo $gallery->excerpt; }?></p>
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
            <h2 class="itlc"><?php echo $gallery->title; ?></h2>
            <h3 class="itlc"><?php if(!empty($gallery->sub_title)){ echo $gallery->sub_title; }?></h3>
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
        </div>
            <?php }else{ 
                if($this->session->userdata('language_version') == "french"){
                    echo "On n'a trouvê aucune galerie";
                }else{
                    echo "No Gallery found";
                }
                 } ?>
            <!--<span class="loading"></span>-->
        </div>
    </div>
<script>
    $(function() {
    applyPagination();
/*	$(".model").keypress(function(event) {
    if (event.which == 13) {
        event.preventDefault();
        ajax_search('');
    }
	});*/
	 //ajax_search('');
 });
  
function applyPagination() {
      $(".pagination ul li a").click(function() {
	  $('html,body').animate({ scrollTop: 0 }, 'slow', function () { });

		 var url = $(this).attr("href");
		var ajax_load2 = "<div align='center'><br style='clear:both;'/><img src='<?php echo base_url("public/images/loading_icon.png");?>' alt=''/><br/><strong>Loading.....</strong></div>";
		$("#loader").html(ajax_load2);
        $.ajax({
          type: "GET",
          data: "ajax=1",
          url: url,
          success: function(msg) {
			
            $("#loader").html(msg);              
            applyPagination();       
            //setInterval(function(){matchColHeights1('.innerContentList .proLast')},5000);
            //matchColHeights1('.innerContentList .proLast');                           
          }          
        });
        return false;
      });
     return false;
	
 }
    </script>
<?php $this->load->view($footer); ?>



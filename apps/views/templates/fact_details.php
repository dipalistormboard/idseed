<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);

?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/jquery.fancybox.css?v=2.1.5');?>" media="screen" />
<script type="text/javascript" src="<?php echo base_url('public/js/jquery.fancybox.js?v=2.1.5');?>"></script>
<script>
    $('.fancybox').fancybox();
</script>
<?php
//echo $page_link;
$a = file_get_contents(base_url()."/fact/factsheet/".$page_link);

$img = explode('<div id="image-bar">',$a);
if(!empty($img)){
$img_b = explode('<div id="header">',$img[1]);
}
//print_r($b);

$b = explode('<div id="content">',$a);
//print_r($a);
$c = explode('<div id="footer">',$b[1]);


//echo $a;


?>

<script>

function printContent(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
</script>

<link href="<?php echo base_url('public/css/skin.css'); ?>" rel="stylesheet" type="text/css" />
<?
          if($this->session->userdata('language_version') == "french"){
           
            $title_opennew_window = 'Ouvrez une nouvelle fenêtre';
            $backbutton = "Retour à l'index";
            $nextbutton = 'Page suivante';
            $prevbutton = 'Page précédent';
          }
          else{
           
            $title_opennew_window = 'Open New Window';
            $backbutton = 'Back to Index';
            $nextbutton = 'Next';
            $prevbutton = 'Previous';
          }
            
        ?>
<div class="content" id="div1">
  <div class="wrapper">
  <div style="float:right;margin-right: 20px;">
  <a href="<?php echo base_url('factsheet/index/'.$this->uri->segment(3)); ?>" style="color: #000;font-weight: bold;"><?=$backbutton?></a>
  &nbsp; | &nbsp;<a class="fact_print" href="javascript:printContent('div1')"> <img width="16" height="16" alt="" src="<?php echo base_url('public/images/print-icon.png'); ?>" ></a>
  </div>
   <!--carousel section start-->
   
   <?php $s=1;
   if(!empty($factsheet_image_gallery) || !empty($factsheet_detail->gallery_id)){ ?>
   <div class="factsheet-carousel">
            	<ul class="jcarousel-skin-tango" id="myCarousel"> 
    <?php 
	if(!empty($factsheet_image_gallery)){
	foreach($factsheet_image_gallery as $row_factsheet_image_gallery){ ?>
    <li>
		<div class="factsheet-pic">
			<a class="fancybox" href="#inline<?php echo $s; ?>"><img class="thumbnail" alt="" src="<?php echo base_url('public/uploads/factsheet_image/'.$row_factsheet_image_gallery->factsheet_image); ?>" id="image_1"></a>
          
       </div>
        <?php /* if(!empty($row_factsheet_image_gallery->factsheet_image_title)){ ?><p><strong><?php echo $row_factsheet_image_gallery->factsheet_image_title; ?></strong></p><?php } */?>
   	    <?php if(!empty($row_factsheet_image_gallery->factsheet_image_caption)){ ?><p><?php echo $row_factsheet_image_gallery->factsheet_image_caption; ?></p><?php } ?>
      
    </li>
<?php $s++;} } ?>
<?php 


$arr_gal = explode(',',$factsheet_detail->gallery_id);

if(!empty($factsheet_detail->gallery_id)){
for($i=0;$i<count($arr_gal);$i++){
	
	$factsheet_gallery_exist =	$this->model_factsheet->get_factsheet_gallery($arr_gal[$i]);
	
	 ?>
     <li>
		<div class="factsheet-pic">
            <a class="fancybox" href="#inline<?php echo $s; ?>" href="<?php echo base_url('public/uploads/gallery_photo/'.$factsheet_gallery_exist->gallery_photo); ?>">
            <img class="thumbnail" alt="" src="<?php echo base_url('public/uploads/gallery_photo/'.$factsheet_gallery_exist->gallery_photo); ?>" id="image_1">
            </a>
        </div>
        <p class="ImageCaption"><?php echo $factsheet_gallery_exist->excerpt; ?></p>
	</li>
<?php $s++;} } ?>
</ul>
</div>
<?php } ?>
<!--Factsheet gallery fancybox content starts here --- -->
 <?php if(!empty($factsheet_image_gallery) || !empty($factsheet_detail->gallery_id)){ ?>
<?php $m=1;
    foreach ($factsheet_image_gallery as $row_factsheet_image_gallery){  ?>
    <div id="inline<?php echo $m; ?>" class="fancy-content">
        <?php 
                    $image1 = base_url('public/noiphoto.png');
                    if(!empty($row_factsheet_image_gallery->factsheet_image)){
                        if($row_factsheet_image_gallery->factsheet_image!='' && is_file(file_upload_absolute_path()."factsheet_image/resize_".$row_factsheet_image_gallery->factsheet_image)){
                            $image1 = base_url("public/uploads/factsheet_image/resize_".$row_factsheet_image_gallery->factsheet_image);
                        }
						 else if($row_factsheet_image_gallery->factsheet_image!='' && is_file(file_upload_absolute_path()."factsheet_image/".$row_factsheet_image_gallery->factsheet_image)){
                            $image1 = base_url("public/uploads/factsheet_image/".$row_factsheet_image_gallery->factsheet_image);
                        }
                    }                  	
                    ?>
            <div class="fancy-img">
                <img src="<?php echo $image1; ?>" alt="" title="" />
            </div>
            <h2><?php echo $row_factsheet_image_gallery->factsheet_image_title; ?></h2>
            <p><?php if(!empty($row_factsheet_image_gallery->factsheet_image_caption)){ echo $row_factsheet_image_gallery->factsheet_image_caption; }?></p>
            <a href="javascript:void(0)"  onclick="window.open('<?php echo $image1; ?>','name<?php echo $m; ?>','width=600,height=600, location=0');" class="link"><?=$title_opennew_window?></a>
        </div>
<?php $m++;
        }
    } ?>  
  <?php  $arr_gal = explode(',',$factsheet_detail->gallery_id);

if(!empty($factsheet_detail->gallery_id)){
for($i=0;$i<count($arr_gal);$i++){
	
	$factsheet_gallery_exist =	$this->model_factsheet->get_factsheet_gallery($arr_gal[$i]);
	
	 ?>
     <div id="inline<?php echo $m; ?>" class="fancy-content">
        <?php 
                    $image1 = base_url('public/noiphoto.png');
                    if(!empty($factsheet_gallery_exist->gallery_photo)){
                        if($factsheet_gallery_exist->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/resize_".$factsheet_gallery_exist->gallery_photo)){
                            $image1 = base_url("public/uploads/gallery_photo/resize_".$factsheet_gallery_exist->gallery_photo);
                        }
						else if($factsheet_gallery_exist->gallery_photo!='' && is_file(file_upload_absolute_path()."gallery_photo/".$factsheet_gallery_exist->gallery_photo)){
                            $image1 = base_url("public/uploads/gallery_photo/".$factsheet_gallery_exist->gallery_photo);
                        }
                    }                  	
                    ?>
            <div class="fancy-img">
                <img src="<?php echo $image1; ?>" alt="" title="" />
            </div>
            <h2><?php echo ucfirst($factsheet_gallery_exist->title); ?></h2>
            <p><?php if(!empty($factsheet_gallery_exist->excerpt)){ echo $factsheet_gallery_exist->excerpt; }?></p>
            <a href="javascript:void(0)"  onclick="window.open('<?php echo $image1; ?>','name<?php echo $m; ?>','width=600,height=600, location=0');" class="link"><?=$title_opennew_window?></a>
        </div>

<?php $m++;} } ?>
    <!--Factsheet gallery fancybox content ends here --- -->
<!--carousel section end-->
            
            <?
            if($this->session->userdata('language_version') == "french"){
          	    $family_txt = 'Famille';
          	    $synonyms = 'Synonyme';
          		  $common_name = 'Nom commun';
                $regulation = 'Réglementation';
          		  $Distribution = 'Répartition';
                $Canadian = 'Répartition au Canada';
                $Worldwide = 'Répartition mondiale';
                $duration = 'Durée du cycle vital';
                $seed_type = 'Type de graine ou de fruit';
                $average_seed_size = 'Dimensions moyennes';
                $seed_shape =  'Forme';
                $seed_surface_texture =  'Texture de la surface';
                $seed_colour =  'Couleur';
                $other_seed_features =  'Autres structures';
                $habitat_and_corp_association =  'Habitat et espèces associées';
                $general_info =  'Renseignements généraux';
                $similar_species =  'Espèce semblable';
                $seed_identification_features ="Caractéristiques d'identification";
          	  }else{
          		  $family_txt = 'Family';
                $synonyms = 'Synonym(s)';
          		  $common_name = 'Common Name';
                $regulation = 'Regulation';
          		  $Distribution = 'Distribution';
                $Canadian = 'Canadian';
                $Worldwide = 'Worldwide';
                $duration = 'Duration of Life Cycle';
                $seed_type = 'Seed or Fruit Type';
                $average_seed_size = 'Average Size';
                $seed_shape =  'Shape';
                $seed_surface_texture =  'Surface Texture';
                $seed_colour =  'Colour';
                $other_seed_features =  'Other Features';
                $habitat_and_corp_association =  'Habitat and Crop Association';
                $general_info =  'General Information';
                $similar_species =  'Similar Species';
                $seed_identification_features ='Identification Features';
          	  }
              
            ?>
            
            
            
            <!--right section start-->
    <div class="factsheet-right">
        <h1 class="itlat"><?php echo ucfirst($factsheet_detail->title); ?></h1>
      <div class="columnize1">
		  <div class="first column" style="width:48%; float: left;">
      <?php if(!empty($factsheet_detail->family)){ ?>
        <h3 class="dontend"><?= $family_txt?></h3>
        <p><i><?php echo $factsheet_detail->family; ?></i></p>
      <?php } ?>
      
      <?php if(!empty($factsheet_detail->synonyms)){ ?>
        <h3 class="dontend"><?= $synonyms?></h3>
        <p><i><?php echo $factsheet_detail->synonyms; ?></i></p>
      <?php } ?>
      <?php if(!empty($factsheet_detail->common_name)){ ?>
        <h3 class="dontend"><?= $common_name?></h3>
        <p><?php echo $factsheet_detail->common_name; ?></p>
      <?php } ?>
      
	  <?php if(!empty($factsheet_detail->regulation)){ ?>
        <h3 class="dontend"><?= $regulation?></h3>
        <p><?php echo $factsheet_detail->regulation; ?></p>
       <?php } ?>       
       
         <?php if(!empty($factsheet_detail->distribution_canadian) || !empty($factsheet_detail->distribution_worldwide)){ ?>
        <h3 class="dontend"><?= $Distribution?></h3> 
        <?php } ?>
      
      <?php if(!empty($factsheet_detail->distribution_canadian)){ ?>
        <p><strong><?= $Canadian?></strong> <?php echo $factsheet_detail->distribution_canadian; ?></p>
       <?php } ?>
       
       
      <?php if(!empty($factsheet_detail->distribution_worldwide)){ ?>
        <p><strong><?= $Worldwide?></strong> <?php echo $factsheet_detail->distribution_worldwide; ?></p>
        <?php } ?>
        
        
      <?php if(!empty($factsheet_detail->duration_of_lifecycle)){ ?>
        <h3 class="dontend"><?= $duration?></h3>
        <p><?php echo $factsheet_detail->duration_of_lifecycle; ?></p>
       <?php } ?>
       
       
      <?php if(!empty($factsheet_detail->seed_type)){ ?>
        <h3 class="dontend"><?= $seed_type?></h3>
          <p class="MsoPlainText"><?php echo $factsheet_detail->seed_type; ?></p>
         <?php } ?>
       
  
        
       </div>
	   <div class="last column" style="width:48%; float: left;"> 
      <h3 class="dontend"><?= $seed_identification_features?></h3>
     
      <?php if(!empty($factsheet_detail->average_seed_size)){ ?>
        <p class="MsoPlainText"><strong><?= $average_seed_size?> </strong></p>
        <p><?php echo $factsheet_detail->average_seed_size; ?></p>
        <?php } ?>
        
      <?php if(!empty($factsheet_detail->seed_shape)){ ?>
        <p><strong><?= $seed_shape?></strong></p>
        <p><?php echo $factsheet_detail->seed_shape; ?></p>
       <?php } ?>
       
       
      <?php if(!empty($factsheet_detail->seed_surface_texture)){ ?>
        <p class="MsoPlainText"><strong><?= $seed_surface_texture?></strong></P>
        <p><?php echo $factsheet_detail->seed_surface_texture; ?></p>
       <?php } ?>
       
       
      <?php if(!empty($factsheet_detail->seed_colour)){ ?>
        <p class="MsoPlainText"><strong><?= $seed_colour?></strong></P>
        <p><?php echo $factsheet_detail->seed_colour; ?></p>
        <?php } ?>
        
        
      <?php if(!empty($factsheet_detail->other_seed_features)){ ?>
        <p><strong><?= $other_seed_features?></strong></P>
        <p><?php echo $factsheet_detail->other_seed_features; ?>
        <?php } ?>
        
        
      <?php if(!empty($factsheet_detail->habitat_and_corp_association)){ ?>
        <h3 class="dontend"><?= $habitat_and_corp_association?></h3>
        <p><?php echo $factsheet_detail->habitat_and_corp_association; ?></p>
       <?php } ?>
       
       
      
  </div>
      </div>
      <div class="clear"></div>
   <?php if(!empty($factsheet_detail->general_info)){ ?>
        <h3 class="dontend"><?= $general_info?></h3>
        <p><?php echo $factsheet_detail->general_info; ?></p>
      <?php } ?>  
   <!-- Related Species Starts-->
  <?php   if(!empty($factsheet_detail->similar_species_id) || !empty($factsheet_detail->similar_species)){ ?>
      <div id="related-species">
       
        <h2><?= $similar_species?></h2>
         <?php if(!empty($factsheet_detail->similar_species)){ ?>
          <p><?php echo OutputEscapeString($factsheet_detail->similar_species); ?></p>
         <?php } ?>
        
        <div class="clear"></div>
       
       <!--- hardik start -->
       <?php 
       $sim=1;
       if(!empty($factsheet_detail->similar_species_id)){
         $arr_gal = explode(',',$factsheet_detail->similar_species_id);
         echo '<ul class="jcarousel-skin-tango" id="myCarousel2">';
       for($i=0;$i<count($arr_gal);$i++){
	
       	$factsheet_gallery_exist =	$this->model_factsheet->get_factsheet_gallery($arr_gal[$i]);
	
       	 ?>
             <li>  
         <div class="thumbnail-group" >
         <div class="thumbnail"><a class="fancybox" href="#inline_sim<?php echo $sim; ?>">
         <img class="thumbnail" alt="" src="<?php echo base_url('public/uploads/gallery_photo/'.$factsheet_gallery_exist->gallery_photo); ?>" id="image_1"></a></div>
         <div class="caption">
         <?php /* if(!empty($factsheet_gallery_exist->title)){ ?><p class="ImageCaption"><strong><?php echo $factsheet_gallery_exist->title; ?></strong></p><?php } */?>
         <?php if(!empty($factsheet_gallery_exist->excerpt)){ ?><p class="ImageCaption"><?php echo $factsheet_gallery_exist->excerpt; ?></p><?php } ?>
         </div>
         </div>
         </li>
         
       <?php 
       $sim++;
     } 
       echo '</ul>';
     } ?>
     
     <?php 
     $sim=1;
     if(!empty($factsheet_detail->similar_species_id)){
       $arr_gal = explode(',',$factsheet_detail->similar_species_id);
       
     for($i=0;$i<count($arr_gal);$i++){
       $factsheet_gallery_exist =	$this->model_factsheet->get_factsheet_gallery($arr_gal[$i]);
       $image1 = base_url("public/uploads/gallery_photo/resize_".$factsheet_gallery_exist->gallery_photo);
       ?>
       <div id="inline_sim<?php echo $sim; ?>" class="fancy-content">
               <div class="fancy-img">
                   <img src="<?php echo $image1; ?>" alt="" title="" />
               </div>
               <h2><?php //echo $factsheet_gallery_exist->title ?></h2>
               <p><?php if(!empty($factsheet_gallery_exist->excerpt)){ ?><p class="ImageCaption"><?php echo $factsheet_gallery_exist->excerpt; ?></p><?php } ?></p>
               <a href="javascript:void(0)"  onclick="window.open('<?php echo $image1; ?>','name<?php echo $sim; ?>','width=600,height=600, location=0');" class="link"><?=$title_opennew_window?></a>
           </div>
       
     <?php 
     $sim++;
   } 
   } ?>
     
     
     
     
       <!--- hardik end -->       
       
        
       <?php /*
	if(!empty($factsheet_species_images)){ ?>
     <ul class="jcarousel-skin-tango" id="myCarousel2">
    <?php 
	foreach($factsheet_species_images as $row_factsheet_species_images){ ?>  
    <li>  
<div class="thumbnail-group" >
<div class="thumbnail"><a class="fancybox" href="#inline<?php echo $row_factsheet_species_images->id; ?>">
<img class="thumbnail" alt="" src="<?php echo base_url('public/uploads/factsheet_species_image/'.$row_factsheet_species_images->factsheet_similar_species_image); ?>" id="image_1"></a></div>
<div class="caption">
<?php if(!empty($row_factsheet_species_images->factsheet_similar_species_image_title)){ ?><p class="ImageCaption"><strong><?php echo $row_factsheet_species_images->factsheet_similar_species_image_title; ?></strong></p><?php } ?>
<?php if(!empty($row_factsheet_species_images->factsheet_similar_species_image_caption)){ ?><p class="ImageCaption"><?php echo $row_factsheet_species_images->factsheet_similar_species_image_caption; ?></p><?php } ?>
</div>
</div>
</li>
<?php } ?> </ul><?php } ?>

              <?php if(!empty($factsheet_species_images)){ ?>
<?php $j=0;
    foreach ($factsheet_species_images as $row_factsheet_species_images){  ?>
    <div id="inline<?php echo $row_factsheet_species_images->id; ?>" class="fancy-content">
        <?php 
                    $image1 = base_url('public/noiphoto.png');
                    if(!empty($row_factsheet_species_images->factsheet_similar_species_image)){
                        if($row_factsheet_species_images->factsheet_similar_species_image!='' && is_file(file_upload_absolute_path()."factsheet_species_image/resize_".$row_factsheet_species_images->factsheet_similar_species_image)){
                            $image1 = base_url("public/uploads/factsheet_species_image/resize_".$row_factsheet_species_images->factsheet_similar_species_image);
                        }
						elseif($row_factsheet_species_images->factsheet_similar_species_image!='' && is_file(file_upload_absolute_path()."factsheet_species_image/".$row_factsheet_species_images->factsheet_similar_species_image)){
                            $image1 = base_url("public/uploads/factsheet_species_image/".$row_factsheet_species_images->factsheet_similar_species_image);
                        }
                    }                  	
                    ?>
            <div class="fancy-img">
                <img src="<?php echo $image1; ?>" alt="" title="" />
            </div>
            <h2><?php echo $row_factsheet_species_images->factsheet_similar_species_image_title; ?></h2>
            <p><?php if(!empty($row_factsheet_species_images->factsheet_similar_species_image_caption)){ echo $row_factsheet_species_images->factsheet_similar_species_image_caption; }?></p>
            <a href="javascript:void(0)"  onclick="window.open('<?php echo $image1; ?>','name<?php echo $j; ?>','width=600,height=600, location=0');" class="link"><?=$title_opennew_window?></a>
        </div>
<?php $j++;
        }
    } */?>  
         <div class="clear"></div>
      </div>
      <?php } ?>
       <div class="clear"></div>
     <!-- Related Species Ends-->
    <div class="fact_navi"> 
    <?php if($prevval != ''){ ?>
     <a style="float:left;" href="<?php echo base_url('factsheet/'.$prevval.'/'.$tabval); ?>"><?=$prevbutton?></a> 
    <?php } if($nextval != ''){ ?>
     <a style="float:right;" href="<?php echo base_url('factsheet/'.$nextval.'/'.$tabval); ?>"><?=$nextbutton?></a>
      <?php } ?>
    </div>  
    </div>
  </div>
</div>

 <script type="text/javascript" src="<?php echo base_url('public/js/jquery.jcarousel.min_front.js'); ?>"></script> 
<script>
	$(function() {
		$('#myCarousel').jcarousel({
			vertical: true,
			scroll: 1
		});
		<?php if(!empty($factsheet_detail->similar_species_id)){ ?>
		$('#myCarousel2').jcarousel({
			horizontal: true,
			scroll: 1
		});
		<?php } ?>
  	});
	
</script>
    <!--content section end-->
    <?php $this->load->view($footer);
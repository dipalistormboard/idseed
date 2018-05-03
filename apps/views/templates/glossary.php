<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/jquery.fancybox.css?v=2.1.5');?>" media="screen" />
<script type="text/javascript" src="<?php echo base_url('public/js/jquery.fancybox.js?v=2.1.5');?>"></script>
<script>
    $('.fancybox').fancybox();
</script>
<?php
  if($this->session->userdata('language_version') == "french"){
	  $open_new_window = 'Ouvrez une nouvelle fenêtre';
	  }else{$open_new_window = 'Open New Window';}
 ?>
<?php /*?>?>

<?php

$a = file_get_contents(base_url()."/fact/factsheet/glossary.htm");
$b = explode('<div id="content">',$a);
//print_r($b);
$c = explode('<div id="footer">',$b[1]);


//echo $a;


?>
<style>
.extdiv{margin:20px;}
</style>


<div class="content">
<div class="wrapper">
<div class="extdiv">
<?php echo $c[0]; ?>
</div><?php */?>
<script>
/*function totop(totopele){

  $("html, body").animate({ scrollTop: $('#' + totopele ).offset().top }, 1500);
}*/
	
</script>
<div class="content">
    	<div class="wrapper">
        	<h2><?php echo $this->data['hooks_meta']->title; ?></h2>
        </div>
        <?php if(!empty($glossary_dist)){ ?>
                <div class="fact-alphabets glossary-alphabets">
                    <div class="wrapper">
                        <ul>	
                        	<?php 
								foreach($glossary_dist as $glo){ 
								 
							?>
                            	<li><a href="#<?php echo strtolower($glo->letter); ?>" class="alpha"><?php echo $glo->letter; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
        <?php } ?>
        <?php if(!empty($glossary_dist)){ ?>
                <div class="wrapper">
                    
                    <ul class="glossary-list">
                    <?php $i = 1;
							foreach($glossary_dist as $glo){
								$glossary = $this->model_home->getglossarycontent($glo->letter);
								$image = '';
								$image2 = '';
								$image3 = '';
								$image4 = '';
								$image5 = '';
								
					
					?>
                            <li id="<?php echo strtolower($glo->letter); ?>">
                                <h3>
                                	
										<?php echo strtoupper($glo->letter); ?>
                                    
                                </h3>
                                <?php if(!empty($glossary)){ ?>
                                	<?php foreach($glossary as $gls){ 
											if($gls->glossary_image!='' && is_file(file_upload_absolute_path()."glossary/".$gls->glossary_image)){
												$image = base_url("public/uploads/glossary/".$gls->glossary_image);
											}
											if($gls->glossary_image2!='' && is_file(file_upload_absolute_path()."glossary/".$gls->glossary_image2)){
												$image2 = base_url("public/uploads/glossary/".$gls->glossary_image2);
											}
											if($gls->glossary_image3!='' && is_file(file_upload_absolute_path()."glossary/".$gls->glossary_image3)){
												$image3 = base_url("public/uploads/glossary/".$gls->glossary_image3);
											}
											if($gls->glossary_image4!='' && is_file(file_upload_absolute_path()."glossary/".$gls->glossary_image4)){
												$image4 = base_url("public/uploads/glossary/".$gls->glossary_image4);
											}
											if($gls->glossary_image5!='' && is_file(file_upload_absolute_path()."glossary/".$gls->glossary_image5)){
												$image5 = base_url("public/uploads/glossary/".$gls->glossary_image5);
											}
									?>
                                        <div>
                                            <strong>
                                            <?php 
                                                       if(!empty($image)){          
                                                    ?>
                                                <a href="#inline<?php echo $i; ?>" class="search fancybox" > 
                                                <?php } ?>
                                                	<?php echo $gls->title; ?>
                                                  <?php 
                                                       if(!empty($image)){          
                                                    ?>  
                                                </a>
                                                <?php } ?>
                                            </strong> 
                                        <ul class="glossary-images">
                                            <?php if(!empty($image)){ ?>
												<li><a href="#inline<?php echo $i; ?>" class="search fancybox" >
												<img src="<?php echo $image; ?>" width="150" />
											</a></li><?php } ?>
                                            <?php if(!empty($image2)){ ?><li><a href="#inline2<?php echo $i; ?>" class="search fancybox" >
												<img src="<?php echo $image2; ?>" width="150" />
											</a></li><?php } ?>
                                            <?php if(!empty($image3)){ ?><li><a href="#inline3<?php echo $i; ?>" class="search fancybox" >
												<img src="<?php echo $image3; ?>" width="150" />
											</a></li><?php } ?>
                                            <?php if(!empty($image4)){ ?><li><a href="#inline4<?php echo $i; ?>" class="search fancybox" >
												<img src="<?php echo $image4; ?>" width="150" />
											</a></li><?php } ?>
                                            <?php if(!empty($image5)){ ?><li><a href="#inline5<?php echo $i; ?>" class="search fancybox" >
												<img src="<?php echo $image5; ?>" width="150" />
											</a></li><?php } ?>
										</ul>
												<?php echo outputEscapeString($gls->content) ?> 
                                        </div>
                                                    <div id="inline<?php echo $i; ?>" class="fancy-content">
                                                    <?php 
                                                       if(!empty($image)){          
                                                    ?>
                                                        <div class="fancy-img">
                                                            <img src="<?php echo $image; ?>" alt="<?php echo $gls->glossary_image; ?>" title="" />
                                                        </div>
                                                        <?php } ?>
                                                        <h2><?php echo $gls->letter; ?></h2>
                                                        <h4><?php if(!empty($gls->caption)){ echo $gls->caption; } ?></h4>
                                                        <div class="clear"></div><br>
                                                        <?php echo outputEscapeString($gls->content) ?>
                                                        <a href="javascript:void(0)"  onclick="window.open('<?php echo $image; ?>','name<?php echo $i; ?>','width=600,height=600, location=0');" class="link"><?php echo $open_new_window; ?></a>
                                                    </div>
                                                    <div id="inline2<?php echo $i; ?>" class="fancy-content">
                                                    <?php 
                                                       if(!empty($image2)){          
                                                    ?>
                                                        <div class="fancy-img">
                                                            <img src="<?php echo $image2; ?>" alt="<?php echo $gls->glossary_image2; ?>" title="" />
                                                        </div>
                                                        <?php } ?>
                                                        <h2><?php echo $gls->letter; ?></h2>
                                                        <h4><?php if(!empty($gls->caption)){ echo $gls->caption; } ?></h4>
                                                        <div class="clear"></div><br>
                                                        <?php echo outputEscapeString($gls->content) ?>
                                                        <a href="javascript:void(0)"  onclick="window.open('<?php echo $image2; ?>','name<?php echo $i; ?>','width=600,height=600, location=0');" class="link"><?php echo $open_new_window; ?></a>
                                                    </div>
													
                                                    <div id="inline3<?php echo $i; ?>" class="fancy-content">
                                                    <?php 
                                                       if(!empty($image3)){          
                                                    ?>
                                                        <div class="fancy-img">
                                                            <img src="<?php echo $image3; ?>" alt="<?php echo $gls->glossary_image3; ?>" title="" />
                                                        </div>
                                                        <?php } ?>
                                                        <h2><?php echo $gls->letter; ?></h2>
                                                        <h4><?php if(!empty($gls->caption)){ echo $gls->caption; } ?></h4>
                                                        <div class="clear"></div><br>
                                                        <?php echo outputEscapeString($gls->content) ?>
                                                        <a href="javascript:void(0)"  onclick="window.open('<?php echo $image3; ?>','name<?php echo $i; ?>','width=600,height=600, location=0');" class="link"><?php echo $open_new_window; ?></a>
                                                    </div>
													
                                                    <div id="inline4<?php echo $i; ?>" class="fancy-content">
                                                    <?php 
                                                       if(!empty($image4)){          
                                                    ?>
                                                        <div class="fancy-img">
                                                            <img src="<?php echo $image4; ?>" alt="<?php echo $gls->glossary_image4; ?>" title="" />
                                                        </div>
                                                        <?php } ?>
                                                        <h2><?php echo $gls->letter; ?></h2>
                                                        <h4><?php if(!empty($gls->caption)){ echo $gls->caption; } ?></h4>
                                                        <div class="clear"></div><br>
                                                        <?php echo outputEscapeString($gls->content) ?>
                                                        <a href="javascript:void(0)"  onclick="window.open('<?php echo $image4; ?>','name<?php echo $i; ?>','width=600,height=600, location=0');" class="link"><?php echo $open_new_window; ?></a>
                                                    </div>
													
                                                    <div id="inline5<?php echo $i; ?>" class="fancy-content">
                                                    <?php 
                                                       if(!empty($image5)){          
                                                    ?>
                                                        <div class="fancy-img">
                                                            <img src="<?php echo $image5; ?>" alt="<?php echo $gls->glossary_image5; ?>" title="" />
                                                        </div>
                                                        <?php } ?>
                                                        <h2><?php echo $gls->letter; ?></h2>
                                                        <h4><?php if(!empty($gls->caption)){ echo $gls->caption; } ?></h4>
                                                        <div class="clear"></div><br>
                                                        <?php echo outputEscapeString($gls->content) ?>
                                                        <a href="javascript:void(0)"  onclick="window.open('<?php echo $image5; ?>','name<?php echo $i; ?>','width=600,height=600, location=0');" class="link"><?php echo $open_new_window; ?></a>
                                                    </div>
                                     <?php $i++; $image = ''; $image2 = ''; $image3 = ''; $image4 = ''; $image5 = ''; } ?>
                                <?php  } ?>
                                
        
                            </li>
                     <?php
							}
					 ?>
                     </ul>
                </div>
        <?php } ?>
</div>
</div>

<?php 
$this->load->view($footer);
/*end*/

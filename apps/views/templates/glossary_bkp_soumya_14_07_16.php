<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/jquery.fancybox.css?v=2.1.5');?>" media="screen" />
<script type="text/javascript" src="<?php echo base_url('public/js/jquery.fancybox.js?v=2.1.5');?>"></script>
<script>
    $('.fancybox').fancybox();
</script>

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
<div class="content">
    	<div class="wrapper">
        	<h2>Glossary</h2>
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
                    <span class="back-to-top"></span>
                    <ul class="glossary-list">
                    <?php $i = 1;
							foreach($glossary_dist as $glo){
								$glossary = $this->model_home->getglossarycontent($glo->letter);
								$image = '';
								
					
					?>
                            <li id="<?php echo strtolower($glo->letter); ?>">
                                <h3>
                                	
										<?php echo strtoupper($glo->letter); ?>
                                    
                                </h3>
                                <?php if(!empty($glossary)){ ?>
                                	<?php foreach($glossary as $gls){ 
											if($gls->picture!='' && is_file(file_upload_absolute_path()."glossary/".$gls->picture)){
												$image = base_url("public/uploads/glossary/".$gls->picture);
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
                                        
                                        	<?php echo outputEscapeString($gls->content) ?>
                                        </div>
                                                    <div id="inline<?php echo $i; ?>" class="fancy-content">
                                                    <?php 
                                                       if(!empty($image)){          
                                                    ?>
                                                        <div class="fancy-img">
                                                            <img src="<?php echo $image; ?>" alt="<?php echo $gls->picture; ?>" title="" />
                                                        </div>
                                                        <?php } ?>
                                                        <h2><?php echo $gls->letter; ?></h2>
                                                        
                                                        <?php echo outputEscapeString($gls->content) ?>
                                                        <a href="javascript:void(0)"  onclick="window.open('<?php echo $image; ?>','name<?php echo $i; ?>','width=600,height=600, location=0');" class="link">Open New Window</a>
                                                    </div>
                                     <?php $i++; $image = ''; } ?>
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

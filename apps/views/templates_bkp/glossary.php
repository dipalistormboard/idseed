<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);

?>
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
                    <?php 
							foreach($glossary_dist as $glo){
								$glossary = $this->model_home->getglossarycontent($glo->letter);
								 
					?>
                            <li id="<?php echo strtolower($glo->letter); ?>">
                                <h3><?php echo strtoupper($glo->letter); ?></h3>
                                <?php if(!empty($glossary)){ ?>
                                	<?php foreach($glossary as $gls){ ?>
                                        <div>
                                            <strong><?php echo $gls->title; ?> :</strong> 
                                        
                                        	<?php echo outputEscapeString($gls->content) ?>
                                        </div>
                                     <?php } ?>
                                <?php } ?>
                            </li>
                     <?php
							}
					 ?>
                     </ul>
                </div>
        <?php } ?>
</div>
<?php 
$this->load->view($footer);
/*end*/

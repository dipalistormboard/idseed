<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
echo doctype('xhtml1-trans')."\n"; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if(!empty($meta_title)){ echo '<title>'.$meta_title.'</title>'."\n"; }
else if(!empty($this->data['hooks_meta']->meta_title)){
	echo '<title>'.$this->data['hooks_meta']->meta_title.'</title>'."\n"; }
else{
	echo '<title>'.$this->data['site_settings']->meta_title.'</title>'."\n"; }

if(!empty($meta_keyword)){
	$meta_keywords= $meta_keyword;
}
else if(!empty($this->data['hooks_meta']->meta_keyword)){
	$meta_keywords= $this->data['hooks_meta']->meta_keyword;
}
else{
	$meta_keywords= $this->data['site_settings']->meta_keyword;
}

if(!empty($meta_description)){
	$meta_descriptions= $meta_description;
}
else if(!empty($this->data['hooks_meta']->meta_description)){
	$meta_descriptions= $this->data['hooks_meta']->meta_description;
}
else{
	$meta_descriptions= $this->data['site_settings']->meta_description;
}
	
$meta = array(
        array('name' => 'robots', 'content' => 'index, follow, all'),
        array('name' => 'description', 'content' => $meta_descriptions),
        array('name' => 'keywords', 'content' => $meta_keywords),
		    array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
        array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1'),        
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
    );

$page_link = xss_clean($this->uri->segment(1));
$banner_text  = '';
echo meta($meta);
?>
<?php if(!empty($this->data['site_settings']->site_verification)){ ?>
<meta name="google-site-verification" content="<?php echo $this->data['site_settings']->site_verification; ?>" />
<?php } ?>
<!--font section start-->
<link href='https://fonts.googleapis.com/css?family=Merriweather:400,700,300|Roboto:400,300Italic,300,500,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
<!--font section end-->
<!--css section start-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("public/css/style.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("public/css/slider.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("public/css/media.css"); ?>" />
<!--css section end-->
<!--script section start-->
<script src="<?php echo base_url("public/js/jquery-1.8.3.min.js"); ?>"></script>
<script src="<?php echo base_url("public/js/responsiveslides.min.js"); ?>"></script>
<script>
  $(function() {
    $(".rslides").responsiveSlides({
		pager: true,
		nav: false
		});
  });
</script>
<script type='text/javascript' src='<?php echo base_url("public/js/custom.js"); ?>'></script>
<!-- calendar js section end -->
</head>
<?php
$page_link='';
		$page_link = xss_clean($this->uri->segment(1));
		if(empty($page_link))
		{ $page_link="home"; }
		elseif($page_link=="pages"){
			$page_link = xss_clean($this->uri->segment(2));
		}		
?>
<body <?php if($this->session->userdata('language_version') == "french"){ ?>class="french-cont" <?php } ?>>
	<!--header section start-->
    <div class="header">
    	<div class="wrapper">
        <?php
      $header_logo = base_url("public/images/logo.png");
      if(!empty($this->data['site_settings']->logo) && is_file(file_upload_absolute_path()."settings/".$this->data['site_settings']->logo))
	  {
      $header_logo = base_url("public/uploads/settings/".$this->data['site_settings']->logo);	
      }
      ?>      
        	<a href="<?php echo site_url(); ?>"><img src="<?php echo $header_logo;?>" alt="Seed Identification Guide" title="Seed Identification Guide" class="logo" /></a>
            <div class="top-right"> 
                <div class="navigation-section">
                <?php echo $this->data['hooks_cmspages_list']; ?>
                    
                    <!--<form action="<?php echo site_url("common/changelanguage"); ?>">-->
                        <ul class="languadge">
                            <?php if($this->session->userdata('language_version') == "french"){ ?>
                                <li><a href="<?php echo site_url("common/changelanguage/english"); ?>?current_url=<?php echo current_url(); ?>" class="eng">English</a></li>
                            <?php } ?>
                            <?php if($this->session->userdata('language_version') == "english"){ ?>
                                <li>
                                    <a href="<?php echo site_url("common/changelanguage/french"); ?>?current_url=<?php echo current_url(); ?>" class="french">Français</a>
                                </li>
                            <?php } ?>
                        </ul>
                        
                    <!--</form>-->
            </div>
               <div class="clear"></div>
                <?php
				//echo '<pre>';print_r($this->data);
				?>
                	
                    <div class="search-section">
                    <?php if(!empty($this->data['footer_logo'])){ //pre($this->data['footer_logo']); ?>
                <ul class="top-logos">
                    <?php foreach($this->data['footer_logo'] as $footer_logo){ //pre($footer_logo);
                        if(!empty($footer_logo->footer_logo) && is_file(file_upload_absolute_path()."footer_logo_photo/".$footer_logo->footer_logo)) { ?>
                    
                    <li><a target="<?php if(!empty($footer_logo->url)){ ?>_blank<?php } ?>" href="<?php if(!empty($footer_logo->url)){ echo $footer_logo->url;}else{ ?>javascript:void(0)<?php } ?>"><img src="<?php echo base_url("public/uploads/footer_logo_photo/".$footer_logo->footer_logo); ?>" alt="" title="" /></a></li>
                   
                    <?php   } 
                        }?>
                </ul>
                <?php } ?>
               <?php  echo link_tag("public/validator/css/validationEngine.jquery.css")."\n"; ?>
               <?php if($this->session->userdata('language_version') == "french"){ ?>
               <script src="<?php echo base_url("public/validator/js/languages/jquery.validate.translations.fr-FR.js");?>" type="text/javascript" charset="utf-8"></script> 
               <?php } else if($this->session->userdata('language_version') == "english"){?>
			     <script src="<?php echo base_url("public/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script> 
			   <?php } ?>
<script src="<?php echo base_url("public/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>

                	<input type="submit" class="search-icon" />
                    <div class="top-search-outer">
                    <div class="top-search">
                        <form method="post" action="<?php echo site_url("searchresult"); ?>" id="searchfrm">
                        <?php if($this->session->userdata('language_version') == "french"){ $searchtxt = "Recherche"; ?>
                        <?php } ?>
                        <?php if($this->session->userdata('language_version') == "english"){ $searchtxt = "Search"; ?>
                        <?php } ?>
                            <input type="text" placeholder="<?php echo $searchtxt; ?>" id="search" name="search" class="validate[required]" value="<?php echo !empty($search)?$search:''; ?>" />
                        </form>
                        <script type="text/javascript">
							$(document).ready(function(){
								$("#searchfrm").validationEngine('attach',{ promptPosition: "centerLeft" });
								});
						</script>
                    </div>
                    </div>
                    <div class="clear"></div>
            	</div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <!--header section end-->
<?php if($page_link == "home"){ if(!empty($banner)){  ?>
    <?php 
			foreach($banner as $ban){ 
				$img = '';
				if(!empty($ban->banner_photo) && is_file(file_upload_absolute_path()."banner_photo/".$ban->banner_photo))
				{ 
						$img =  base_url("public/uploads/banner_photo/".$ban->banner_photo);	
				}
		?>
    <div class="banner" style="background: url('<?php echo $img; ?>') no-repeat scroll center center / cover ">
        <span class="banner-overlay"></span>
        <div class="wrapper">
        	<div class="banner-cont-outer">
                <div class="banner-cont">
                <?php 
				$banner_icon = base_url()."public/images/banner_icon.png";
				if($this->session->userdata('language_version') == "french"){ 
					$banner_icon = base_url()."public/images/GIS-Logo-White.png";
				}
				?>
            		<span class="banner-icon" style="background: rgba(0, 0, 0, 0) url('<?php echo $banner_icon; ?>') no-repeat scroll 0 0 !important;"></span>
                    
                    
                	<h1><?php echo $ban->title; ?></h1>
                    <?php echo outputEscapeString($ban->content); ?>
                    <?php if(!empty($ban->banner_url) && !empty($ban->banner_url_title)){ ?>
                    <a href="<?php echo $ban->banner_url; ?>" class="more"><?php echo $ban->banner_url_title; ?></a>
                    <?php } ?>
                </div>
                <div class="clear"></div>
            </div>
    	</div>
    </div>
<?php } }
}elseif(!empty($common_banner)){ 
    if(!empty($common_banner->common_banner_photo) && is_file(file_upload_absolute_path()."common_banner_photo/".$common_banner->common_banner_photo)){
    $image=base_url("public/uploads/common_banner_photo/".$common_banner->common_banner_photo); ?>
<div class="inner-banner" style="background: url('<?php echo $image; ?>') no-repeat scroll center center / cover ">
    	<div class="wrapper">
            <h1><?php echo $this->data['hooks_meta']->title; ?></h1>
        </div>
    </div>
<?php } } ?>
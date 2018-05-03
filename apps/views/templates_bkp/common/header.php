<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
echo doctype('xhtml1-trans')."\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<?php
if(!empty($meta_title)){
	echo '<title>'.$meta_title.'</title>'."\n";
}
else if(!empty($this->data['hooks_meta']->meta_title)){
	echo '<title>'.$this->data['hooks_meta']->meta_title.'</title>'."\n";
}
else{
	echo '<title>'.$this->data['site_settings']->meta_title.'</title>'."\n";
}

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
		{
			$page_link="home";
		}
		elseif($page_link=="pages"){
			$page_link = xss_clean($this->uri->segment(2));
		}		
?>

<body>
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
            	
                <?php 	echo $this->data['hooks_cmspages_list'];?>
                <div class="top-search">
                	<form method="post">
                    	<input type="text" value="Search Fact Sheets" id="search" name="search" />
                        <input type="submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--header section end-->
<?php if($page_link == "home"){ if(!empty($banner)){  ?>
    <div class="banner">
    	<ul class="rslides">
        <?php 
			foreach($banner as $ban){ 
				$img = '';
				if(!empty($ban->banner_photo) && is_file(file_upload_absolute_path()."banner_photo/".$ban->banner_photo))
				{ 
						$img =  base_url("public/uploads/banner_photo/".$ban->banner_photo);	
				}
		?>
        	<li>
            	<?php if(!empty($img)){ ?><img src="<?php echo $img; ?>" alt="" title="" /><?php } ?>
                <div class="wrapper">
                	<div class="banner-cont-outer">
                    	<span class="banner-icon"></span>
                    	<div class="banner-cont">
                        	<h1><?php echo $ban->title; ?></h1>
                            <?php echo outputEscapeString($ban->content); ?>
                            <?php if(!empty($ban->banner_url) && !empty($ban->banner_url_title)){ ?>
                            	<a href="<?php echo $ban->banner_url; ?>" class="more"><?php echo $ban->banner_url_title; ?></a>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </li>
         <?php } ?>
        </ul>
    </div>
<?php } }else{ ?>

<div class="inner-banner">
    	<div class="wrapper">
        	<img title="" alt="" src="<?php echo base_url("public/images/banner_icon.png");?>">
            <h1><?php echo $this->data['hooks_meta']->title; ?></h1>
        </div>
    </div>
<?php } ?>






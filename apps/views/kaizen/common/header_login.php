<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
echo doctype('xhtml1-trans')."\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php
if(strstr(uri_string(),'kaizen')){
	echo '<title>'.$this->config->item("COMPANY_NAME").' Control Panel</title>';
	$meta = array(
        array('name' => 'robots', 'content' => 'noindex, nofollow'),
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
    );
}
else{
	if(!empty($meta_title)){
		echo '<title>'.$meta_title.'</title>'."\n";
	}
	else{
		echo '<title>'.$this->data['hooks_meta']->meta_title.'</title>'."\n";
	}
	
	if(!empty($meta_keyword)){
		$meta_keywords= $meta_keyword;
	}
	else{
		$meta_keywords= $this->data['hooks_meta']->meta_keyword;
	}
	
	if(!empty($meta_description)){
		$meta_descriptions= $meta_description;
	}
	else{
		$meta_descriptions= $this->data['hooks_meta']->meta_description;
	}
	

$meta = array(
        array('name' => 'robots', 'content' => 'index, follow, all'),
        array('name' => 'description', 'content' => $meta_descriptions),
        array('name' => 'keywords', 'content' => $meta_keywords),
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
    );
}

echo meta($meta);
echo link_tag("public/kaizen/css/style.css")."\n";
echo link_tag('favicon.ico', 'shortcut icon', 'image/ico')."\n";
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:700' rel='stylesheet' type='text/css'>
<!--[if IE 9]>
<style>
.headrgt {
float:right;
width:425px;
margin:0 12px 0 0;
padding:39px 0 0 0;
}
</style>
<![endif]-->
</head>

<body class="pra_topbg">
<div class="wrapper"> 
  <!-- header starts-->
  <div class="headerlogin">
    <div class="logo"><a href="<?php echo site_url("");?>"><img src="<?php echo site_url("public/kaizen/images/logo.png");?>" alt="" border="0" /></a></div>
    <div class="headrgt">
      
      <div class="socialicons"> <a href="#" target="_blank" class="ficon">&nbsp;</a> <a href="#" target="_blank" class="ticon">&nbsp;</a> <a href="#" class="inicon">&nbsp;</a> <a href="#" class="rssicon">&nbsp;</a> </div>
      
    </div>
  </div>
  <!-- header ends--> 
  
  <!-- bodypanel starts -->
  <div class="bodypanellogin">
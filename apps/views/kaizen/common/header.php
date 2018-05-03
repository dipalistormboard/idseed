<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
echo doctype('xhtml1-trans')."\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo  $this->config->item("COMPANY_NAME");?>Control Panel</title>
  <?php
  $meta = array(
    array('name' => 'robots', 'content' => 'noindex, nofollow'),
    array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
  );
  echo meta($meta);
  echo link_tag("public/kaizen/css/style.css")."\n";
  echo link_tag('favicon.ico', 'shortcut icon', 'image/ico')."\n";
  ?>

  <link href='http://fonts.googleapis.com/css?family=Lato:400,700,900,900italic,400italic,300,300italic' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo site_url("public/kaizen/js/scriptbreaker-multiple-accordion-1.js");?>" ></script>
  <script type="text/javascript" src="<?php echo site_url("public/kaizen/js/scw.js");?>" ></script>
  <script language="JavaScript">

  $(document).ready(function() {
    $(".topnav").accordion({
      accordion:false,
      speed: 500,
      closedSign: '',
      openedSign: ''
    });
  });

  </script>
  <script type="text/javascript" src="<?php echo site_url("public/kaizen/js/dropdown.js");?>" ></script>
  <script type="text/javascript">

  $(document).ready(function(){
    $('.newshow_hide').click(
      function () {
        $('.showhide').fadeIn('slow');
      }
    );
    $('.close').click(
      function () {
        $('.showhide').fadeOut('slow');
      }
    );
  });

  </script>
  <script type="text/javascript" src="<?php echo site_url("public/kaizen/js/ddaccordion.js");?>"></script>
  <script type="text/javascript">

  ddaccordion.init({
    headerclass: "expandable", //Shared CSS class name of headers group that are expandable
    contentclass: "droplists", //Shared CSS class name of contents group
    collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
    defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
    animatedefault: true, //Should contents open by default be animated into view?
    persiststate: true, //persist state of opened contents within browser session?
    toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
    togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively ["position", "html1", "html2"] (see docs)
    animatespeed: "normal" //speed of animation: "fast", "normal", or "slow"
  })
  </script>
  <script type="application/javascript">
  $(document).ready(function() {
    $('#language_id').change(function() {
      var form_data = {
        prefered_language : $('#language_id').val(),
        ajax : '1'
      };
      $.ajax({
        url: "<?php echo site_url('kaizen/main/ajax_language'); ?>",
        type: 'POST',
        async : false,
        data: form_data,
        success: function(msg) {
          window.location.href='<?php echo site_url('kaizen/main'); ?>';
        }
      });
      return false;
    });
  });
  </script>
</head>
<body class="inner_pra_topbg">
  <div class="topheader">
    <div class="wrapper">

      <div class="header">
        <div class="logo" style="padding-top: 2px;"><a href="<?php echo site_url();?>"><img src="<?php echo site_url("public/kaizen/images/logo.png");?>" alt="" title="" border="0" width="200"/></a></div>

        <?php /*?><select style="width:150px;margin:40px 0px 0px 483px; !important;" id="language_id" size="1" name="language_id">
        <option  value="english" <?php if($this->session->userdata('prefered_language') == "english"){ ?>selected="selected"<?php } ?> >English</option>
        <option value="french" <?php if($this->session->userdata('prefered_language') == "french"){ ?>selected="selected"<?php } ?> >Français</option>
        </select><?php */?>

        <div class="headrgt">
          <ul>
            <li style="display:none;"> </li>
            <li><a href="<?php echo site_url("kaizen/settings/");?>">Settings</a></li>
            <li><a href="<?php echo site_url("kaizen/logout/");?>">Logout</a></li>
          </ul>
          <br/>
        </div>
      </div>
      <?php //print_r($this->session->userdata('prefered_language')); ?>
      <div class="menu">
        <ul class="menulink">
          <li><a href="<?php echo site_url("kaizen/main/");?>" <?php if(strstr(uri_string(),'main')){echo 'class="active"';}?>>Dashboard</a></li>
          <li><a href="<?php echo site_url("kaizen/cms/doedit/".$this->session->userdata('SITE_ID'));?>" <?php if(strstr(uri_string(),'cms')){echo 'class="active"';}?>>Pages</a>
            <!--										<ul class="drop">
            <li><a href="<?php echo site_url("kaizen/other_cms/")?>">Inner Pages</a></li>
          </ul>-->
        </li>
        <?php
        $sel_menu =array('banner','careers','news','');
        $sel_menu_name=$this->uri->segment(2);
        ?>
        <li> <a href="#" <?php if (in_array($sel_menu_name,$sel_menu)){
          echo 'class="active"';}?> >Components</a>
          <ul class="drop">
            <li><a href="<?php echo site_url("kaizen/contact/dolist/")?>">Contact</a></li>
            <li><a href="<?php echo site_url("kaizen/banner/dolist/")?>">Banner</a></li>
            <li><a href="<?php echo site_url("kaizen/gallery/dolist/")?>">Gallery</a></li>
            <li><a href="<?php echo site_url("kaizen/footer_logo/dolist/")?>">Logos</a></li>
            <li><a href="<?php echo site_url("kaizen/glossary/dolist/")?>">Glossary</a></li>
            <li><a href="<?php echo site_url("kaizen/keys/dolist/")?>">Keys</a></li>
            <li><a href="<?php echo site_url("kaizen/factsheet/dolist/")?>">Factsheet</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</div>
<div class="wrapper">
  <div class="bodypanel">
    <?php /*end*/

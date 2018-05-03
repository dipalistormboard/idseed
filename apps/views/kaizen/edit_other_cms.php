<?php 
$this->load->view($header); 
$this->load->view($left); 
echo link_tag("public/kaizen/validator/css/validationEngine.jquery.css")."\n";
?>
<script type="text/javascript" src="<?php echo site_url("public/ckeditor/ckeditor.js");?>"></script>
<script type="text/javascript" src="<?php echo site_url("public/ckeditor/adapters/jquery.js");?>"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url("public/kaizen/js/jquery.maxlength.js");?>"></script>
<script src="<?php echo site_url("public/kaizen/js/jquery.form.js");?>"></script>
<div class="bodyright">
  <div class="bodytop"> </div>
  <div class="bodymid">
    <div class="midarea" id="showcms">
	</div>
  </div>
  <div class="bodybottom"> </div>
</div>
<input type="hidden" name="content_show" id="content_show" value="" />

<?php 
$val_array = array("\n","\r\n");
?>
<script type="text/javascript">

function getParentValue(){
  return $("#content_show").val();
}

function previewget(){
	var val2 = CKEDITOR.instances['contents'].getData();
	
	//alert(val2);
	var contents = $('#content_show').val(val2);
	var mywin = window.open("<?php echo site_url("draft/index");?>/"+ids, "ckeditor_preview", "location=0,status=0,scrollbars=1,width=1024,height=768");
	//$(mywin.document.body).html(contents);

}

function confirmdel(id){
	if(confirm("Are you sure want to delete image?")){
		window.location.href="<?php echo site_url("kaizen/other_cms/dodeleteimg/");?>?deleteid="+id;
	}
	else{
		return false;
	}
}

function showdiv(id){
	$('.showhide'+id).fadeIn('slow');
}

function hidediv(id){
	$('.showhide'+id).fadeOut('slow');
}
function openpage(x)
{
	$.ajaxSetup ({cache: false});
	var ajax_load2 = "<div align='center'><br style='clear:both;' />Processing.....</div>";
	$("#showcms").html(ajax_load2);
	$.ajax({
	  type: "GET",
	  cache: false,
	  url: x,
	  dataType:"html",
	  data:'',
	  success:function(responseText){			
		  $("#showcms").html(responseText);			
	  },
	  error:function (request, status, error)	{
		  $("#showcms").html(error);
	  }    
  });
}



function changecls(x){
	$("#"+x).addClass("active1").siblings().removeClass("active1");
	$('.topnav>li>ul>li.active1 a').attr('style', 'background: #F3F3F3 !important');
	$('.topnav>li>ul>li>ul>li a').attr('style', 'background: #F3F3F3 !important');	
}



$(document).ready(function(){
	<?php
	if(!empty($details->id)){
	?>
	openpage('<?php echo site_url("kaizen/other_cms/doeditajax/".$details->id);?>');
	<?php
	}
	else{
	?>
	openpage('<?php echo site_url("kaizen/other_cms/doeditajax/0/");?>');
	<?php
	}
	?>
	
	function checkcharcount(id,id2,id3,id4){
		var box=$("#"+id).val();
		var main = box.length *100;
		var value= (main / id4);
		var count= id4 - box.length;
		if(box.length <= id4){
			$('#'+id2).html(count);
			$('#'+id3).animate({"width": value+'%',}, 1);
		}
		else{
			$(this).attr('maxlength',id4);
			$('#'+id).maxlength({max:id4});
		}
	
	}
	
	
	
});	

function form_submit(val){
	var ContentFromEditor = CKEDITOR.instances.contents.getData();
	$("#content").val(ContentFromEditor);	
	
		var BContentFromEditor = CKEDITOR.instances.banner_texts.getData();
	$("#banner_text").val(BContentFromEditor);	
	
	
	if(val=="del"){
		if(confirm("Are you sure want to delete?")){
			window.location.href="<?php echo site_url("kaizen/other_cms/dodelete/");?>?deleteid=<?php echo $details->id;?>&ref=<?php echo site_url("kaizen/other_cms/");?>";
		}
		else{
			return false;
		}
	}
	else if(val=="draft"){
		$("#save_draft").val(1);
		$('#cont').submit();
	}
	else{
		$('#cont').submit();
	}
	return true;
}
function goto_page(url){
	if(url==""){
		window.location.href = "<?php echo site_url("kaizen/other_cms/listing/0/");?>";
	}
	else{
		window.location.href = url;
	}
}

	function setPublish(id)
	{
		document.getElementById('publish_msg').innerHTML = "";
		var publish	=	document.getElementById('publish').checked+"";
		if(publish != "")
		{
			$.ajax({
			   type: "POST",
				url : '<?php echo site_url("kaizen/other_cms/set_publish/");?>',
				data: 'id='+id,
				dataType : "html",
				success: function(data)
				{
					if(data)
					{
						document.getElementById('publish_msg').style.display = "";
						document.getElementById('publish_msg').innerHTML = data;
					}
					else
					{
						//alert("Sorry, Some problem is there. Please try again.");
					}
				},
				error : function() 
				{
		
					alert("Sorry, The requested property could not be found.");		
				}
			});
		}
	}
</script>
<style type="text/css">
#bar1 {
	background-color:#5fbbde;
	width:0px;
	height:16px;
}
#barbox1 {
	float:right;
	height:16px;
	background-color:#FFFFFF;
	width:100px;
	border:solid 1px #000;
	margin-right:3px;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
}
#count1 {
	float:right;
	margin-right:8px;
	font-family:'Georgia', Times New Roman, Times, serif;
	font-size:11px;
	font-weight:bold;
	color:#666666
}
#bar2 {
	background-color:#5fbbde;
	width:0px;
	height:16px;
}
#barbox2 {
	float:right;
	height:16px;
	background-color:#FFFFFF;
	width:100px;
	border:solid 1px #000;
	margin-right:3px;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
}
#count2 {
	float:right;
	margin-right:8px;
	font-family:'Georgia', Times New Roman, Times, serif;
	font-size:11px;
	font-weight:bold;
	color:#666666
}
#bar3 {
	background-color:#5fbbde;
	width:0px;
	height:16px;

}
#barbox3 {
	float:right;
	height:16px;
	background-color:#FFFFFF;
	width:100px;
	border:solid 1px #000;
	margin-right:3px;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
}
#count3 {
	float:right;
	margin-right:8px;
	font-family:'Georgia', Times New Roman, Times, serif;
	font-size:11px;
	font-weight:bold;
	color:#666666
}
</style>
<?php $this->load->view($footer); ?>

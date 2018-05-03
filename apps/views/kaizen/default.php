<?php $this->load->view($header); ?>
<?php 
$profileid = '123204016';
?>

<div class="bodyright">
	<div class="bodytop"> </div>
	<div class="bodymid" style="padding:0px;">
		<div class="midarea" style="min-height:400px;">
			<div>
				<h2 align="center">Dash Board</h2>
			</div>
			<div style="width:100%; text-align:left; border:0px solid red;">
            	<iframe src="http://2webdesign.com/2webanalytics/analytics.php?profile=<?php echo $profileid;?>" scrolling="0" frameborder="0" align="middle" width="95%" height="900" style="margin-left:25px;"></iframe>
			</div>
		</div>
	</div>
	<div class="bodybottom"></div>
</div>
<?php $this->load->view($footer); ?>

<?php $this->load->view($header); ?>

<div class="bodycontent">
  <div class="loginContainer">
    <h2>Login</h2>
    <div class="spacer"></div>
    <!--login form starts -->
    <div class="lgoinForm">
      <div class="left"><img src="<?php echo site_url("public/kaizen/images/login.jpg");?>" alt="" /></div>
      <div class="right">
        <?php if($error != "") {  echo "<p align='center' class='redtext'>".$error."</p>";} ?>
        <?php echo form_open('login/authentication');?>
        <div class="txtPlaceholder">
          <label>Email:</label>
          <input name="uname" id="uname" maxlength="100" autocomplete="off" value="" type="text" />
        </div>
        <div class="txtPlaceholder">
          <label>Password:</label>
          <input name="pwd" id="pwd" type="password" />
        </div>
        <input name="" type="submit" class="submitBtn" />
        <?php echo form_close();?> </div>
    </div>
    <!--login form ends --> 
  </div>
</div>
<script type="text/javascript"> 
// <![CDATA[
function PMA_focusInput()
{
	var input_username = document.getElementById('uname');
	var input_password = document.getElementById('pwd');
	if (input_username.value == '') {
		input_username.focus();
	} else {
		input_password.focus();
	}
}
 
window.setTimeout('PMA_focusInput()', 500);
// ]]>
</script>
<?php $this->load->view($footer); ?>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<script type="text/javascript">
   function changeshow(val,count){
    if(val=='1'){
        $('#imagepart'+count).show();
        $('#videopart'+count).hide();
    }else if(val=='2'){
        $('#videopart'+count).show();
        $('#imagepart'+count).hide();
    }
}
</script>
<div style="margin-top:20px;border-style: solid;border-width: 1px;padding: 10px 10px 10px;" id="div_<?php echo $count ?>" >
<a href="javascript:void(0);" onclick="closediv1('div_<?php echo $count ?>');" style="margin-left: 500px;">X</a>
<h2 style="margin-bottom:10px;">Gallery</h2>

<div class="spacer" style="margin-top: 10px;"></div>
    <div id = "imagepart<?php echo $count; ?>" >
            <div>				

                <div class="formFields">
                <label class="labelname">Gallery Image: <span>*</span></label>
                    <div class="fileinputs">
                        <input type="file" class="file" name="htmlfile<?php echo $count; ?>" onChange="document.getElementById('fakefilepc<?php echo $count; ?>').value = this.value;" style="width:350px;"/>
                        <div class="fakefile">
                        <input id="fakefilepc<?php echo $count; ?>" type="text" disabled="disabled" name="newsletterfile" />
                        <img src="<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>" alt="" height="31" width="84" onMouseOver="this.src='<?php echo site_url("public/kaizen/images/browsebtn-ho.jpg");?>'" onMouseOut="this.src='<?php echo site_url("public/kaizen/images/browsebtn.jpg");?>'" /> </div>
                    </div>
                            <div class="spacer"></div>
                <p class="sizetxt">Size Requirement:  569 x 328 pixels</p>
                </div>
                <div class="spacer"></div>
                <div class="spacer"></div>
                            <?php if(!empty($file) ){  ?>
                            <img src="<?php echo file_upload_base_url()."product/".$file;?>" width="200" height="200"  alt="" style="margin-top:5px;margin-bottom:5px;" />
                            <?php } ?>
            </div>
    <input type="hidden" id="image_name<?php echo $count; ?>" name="image_name<?php echo $count; ?>" value="<?php echo !empty($file)?$file:''; ?>" />
            <div class="spacer" style="margin-top: 10px;"></div>

              <div class="spacer" style="margin-top: 10px;"></div>
            <div>				
                <label class="labelname">Sequence: </label>
                            <input class="inputinpt" type="text" name="sequence_image<?php echo $count ?>" id="sequence<?php echo $count ?>" value="<?php if(!empty($sequence) ){echo $sequence; }else{echo '';} ?>"  >
            </div>
             <div class="spacer" style="margin-top: 10px;"></div>
            <div>				
                <label class="labelname">Main Image: </label>
                            <input type="radio" name="main_image" id="main_image<?php echo $count ?>" <?php if(!empty($main_image)){ ?>checked="checked"<?php } ?> value="<?php echo $count; ?>" >

            </div>
    </div>
</div>


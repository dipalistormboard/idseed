
<div style="margin-top:20px;border-style: solid;border-width: 1px;padding: 10px;margin-right: 50px;" id="div_<?php echo $count_gal ?>_gal" >
  <a href="javascript:void(0);" onclick="closedivimage_gal('div_<?php echo $count_gal ?>_gal');" style="margin-left: 500px;">X</a>
  <td align="left" valign="top">
    <table width="96%" border="0" cellspacing="0" cellpadding="0">


      <tr id="imggal_<?php echo $count_gal ?>" >
        <td width="134" align="left" valign="top"><label class="labelname">Factsheet Image:</label></td>
        <td align="left" valign="top" width="349">
          <?php $image = base_url("public/images/no_image.jpg");
          if(!empty($factsheet_image) ){$image =  base_url()."public/uploads/factsheet_image/".$factsheet_image;
          }?>
          <img id="imagegal_<?php echo $count_gal ?>"  src="<?php if(!empty($image)){ echo $image; }?>" style="width:130px;height:130px;"/>

            <a class="fancybox_crop fancybox.iframe upload removebtn" href="<?php echo base_url("kaizen/factsheet/newcrop"); ?>?image_id=factsheet_image_<?php echo $count_gal; ?>&image_val=<?php if(!empty($factsheet_image)){ echo $factsheet_image; }?>&folder_name=factsheet_image&img_sceen=imagegal_<?php echo $count_gal; ?>&prev_img=<?php if(!empty($factsheet_image)){ echo $factsheet_image; }?>&controller=factsheet&height=296&width=232" >Upload</a>

            <input type="hidden" id="factsheet_image_<?php echo $count_gal; ?>" name="factsheet_image_<?php echo $count_gal; ?>"  value="<?php if(!empty($factsheet_image)){ echo $factsheet_image; } ?>" />
          </td>

          <td align="left" valign="top" height="12"></td>
        </tr>
        <tr>
          <td align="left" valign="top" height="10"></td>
        </tr>
        <tr>

          <td width="134" align="left" valign="top"><label class="labelname">Caption:</label></td>

          <td align="left" valign="top" width="349">
            <textarea id="factsheet_caption_<?php echo $count_gal ?>" name="factsheet_caption_<?php echo $count_gal ?>" class="inputinpt"><?php if(!empty($factsheet_caption)){ echo $factsheet_caption; } ?></textarea>
            <!--                                   <input type="Text" id="factsheet_caption_<?php //echo $count_gal ?>" name="factsheet_caption_<?php //echo $count_gal ?>" value="<?php //if(!empty($factsheet_caption)){ echo $factsheet_caption; } ?>" class="inputinpt" />-->
          </td>
        </tr>
        <tr>
          <td align="left" valign="top" height="10"></td>
        </tr>
        <tr>

          <td width="134" align="left" valign="top"><label class="labelname">Title:</label></td>

          <td align="left" valign="top" width="349">

            <input type="Text" id="factsheet_image_title_<?php echo $count_gal ?>" name="factsheet_image_title_<?php echo $count_gal ?>" value="<?php if(!empty($factsheet_image_title)){ echo $factsheet_image_title; } ?>" class="inputinpt" />
          </td>
        </tr>

      </table>
    </td>

  </table>

  <div class="spacer"></div>
</div>
<script>


var editor, html = '';
if (editor ){
  editor.destroy();
  editor = null;
}

CKEDITOR.replace( 'factsheet_caption_<?php echo $count_gal ?>' ,{
  toolbar :
  [

    ['Bold','Italic','Underline','Strike'],

  ]
}
);
</script>

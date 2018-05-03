<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="A basic demo of Cropper.">
  <meta name="keywords" content="HTML, CSS, JS, JavaScript, jQuery plugin, image cropping, image crop, image move, image zoom, image rotate, image scale, front-end, frontend, web development">
  <meta name="author" content="Fengyuan Chen">
  <title>Cropper</title>
  <link rel="stylesheet" href="<?php echo base_url("croptool/css/font-awesome.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("croptool/css/bootstrap.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("croptool/css/cropper.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("croptool/css/main.css");?>">
  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>


            
            
  <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

  <!-- Header -->
  <!--<header class="navbar navbar-static-top docs-header" id="top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-target="#navbar-collapse" data-toggle="collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./">Cropper</a>
      </div>
      <nav class="collapse navbar-collapse" id="navbar-collapse" role="navigation">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="https://github.com/fengyuanchen/cropper/blob/master/README.md">Docs</a></li>
          <li><a href="https://github.com/fengyuanchen/cropper">GitHub</a></li>
          <li><a href="//fengyuanchen.github.io">More</a></li>
          <li><a href="http://chenfengyuan.com">About</a></li>
        </ul>
      </nav>
    </div>
  </header>-->

  <!-- Jumbotron -->
 <!-- <div class="jumbotron docs-jumbotron">
    <div class="container">
      <h1>Cropper</h1>
      <p class="lead">A simple jQuery image cropping plugin.</p>
    </div>
  </div>-->

  <!-- Content -->
  <div class="container" style="margin-top:20px;">
    <div class="row">
      <div class="col-md-9">
        <!-- <h3 class="page-header">Demo:</h3> -->
        <div class="img-container">
        <?php 
			if(!empty($prev_img) && is_file(file_upload_absolute_path().$folder_name."/resize_".$prev_img))
			{
				$image =  base_url()."public/uploads/".$folder_name."/resize_".$prev_img;
			}
      
      if(!empty($image)){
        $bigimageavlue = base64_encode($image);
      }
      
			/*if(!empty($prev_img) && is_file(file_upload_absolute_path().$folder_name."/".$prev_img))
			{
				$image =  base_url()."public/uploads/".$folder_name."/".$prev_img;
			}*/
			
		?>
          <img id="image" src="<?php if(!empty($image)){ echo $image;}?>" alt="Picture">
          
          <!--<img id="image" src="" alt="">-->
          
        </div>
        
        <textarea id="result_img" name="result_img" style="display:none;"></textarea>
        
        <textarea id="big_image_str" name="big_image_str" style="display:none;"></textarea>
        
        <input id="folder_name" type="hidden" value="<?php echo !empty($folder_name)?$folder_name:''; ?>" />
        <input id="image_id" type="hidden" value="<?php echo !empty($image_id)?$image_id:''; ?>" />
          <input id="image_val" type="hidden" value="<?php echo !empty($image_val)?$image_val:''; ?>" />
      
        <input id="img_sceen" type="hidden" value="<?php echo !empty($img_sceen)?$img_sceen:''; ?>" />
        <input id="big_image_id" type="hidden" value="<?php echo !empty($big_image_id)?$big_image_id:''; ?>" />
      </div>
      <div class="col-md-3">
        <!-- <h3 class="page-header">Preview:</h3> -->
        <!--<div class="docs-preview clearfix">
          <div class="img-preview preview-lg"></div>
          <div class="img-preview preview-md"></div>
          <div class="img-preview preview-sm"></div>
          <div class="img-preview preview-xs"></div>
        </div>-->

        <!-- <h3 class="page-header">Data:</h3> -->
        <!--<div class="docs-data">
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataX">X</label>
            <input type="text" class="form-control" id="dataX" placeholder="x">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataY">Y</label>
            <input type="text" class="form-control" id="dataY" placeholder="y">
            <span class="input-group-addon">px</span>
          </div>-->
            <!--<div class="input-group input-group-sm">
              <label class="input-group-addon" for="dataRotate">Rotate</label>
              <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
              <span class="input-group-addon">deg</span>
            </div>
            <div class="input-group input-group-sm">
              <label class="input-group-addon" for="dataScaleX">ScaleX</label>
              <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
            </div>
            <div class="input-group input-group-sm">
              <label class="input-group-addon" for="dataScaleY">ScaleY</label>
              <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
            </div>
          </div>-->
         <!--     
          <div class="input-group input-group-sm" style="color:#286090;">
            <b>Selected Width and Height</b>
          </div>
          </br>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataWidth">Width</label>
            <input type="text" class="form-control" id="dataWidth" placeholder="width" value="">
            <span class="input-group-addon">px</span>
          </div>
          <div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataHeight">Height</label>
            <input type="text" class="form-control" id="dataHeight" placeholder="height" value="">
            <span class="input-group-addon">px</span>
          </div>
          
          <button type="button" class="btn btn-primary setcrop" data-method="setCropBoxData" data-target="#putData">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.setCropBoxData(data)">
                Set Crop Width Height
              </span>
            </button>
        
          </br>
          <div class="input-group input-group-sm" style="color:#F00;">
          <?php
		  		$inc_width = $height;
				$inc_height = $width;
		  ?>
            <b>Recommended Size :- <?php echo $height; ?>px * <?php echo $width; ?>px</b>
           <input type="hidden" id="height_inc" name="height_inc" value="<?php echo $inc_height; ?>" />
            <input type="hidden" id="width_inc" name="width_inc" value="<?php echo $inc_width; ?>" />
          </div>
          </br>
        -->
      </div>
      
      <div class="col-md-3 docs-buttons" style="padding-top:40px">
        <!-- <h3 class="page-header">Toolbar:</h3> -->
        <div class="btn-group">
           
            <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Move" style="float:left;">
            <button title="Move" data-option="move" data-method="setDragMode" class="btn btn-primary" type="button">
              <span class="fa fa-arrows"></span>
              </button>
            </span>
          
          
            <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Crop" style="float:left;">
            <button title="Crop" data-option="crop" data-method="setDragMode" class="btn btn-primary" type="button">
              <span class="fa fa-crop"></span>
              </button>
            </span>
          
        </div>

        <div class="btn-group">
          
            <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Zoom In" style="float:left;">
            <button title="Zoom In" data-option="0.1" data-method="zoom" class="btn btn-primary" type="button">
              <span class="fa fa-search-plus"></span>
              </button>
            </span>
          
          
            <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Zoom Out" style="float:left;">
            <button title="Zoom Out" data-option="-0.1" data-method="zoom" class="btn btn-primary" type="button">
              <span class="fa fa-search-minus"></span>
              </button>
            </span>
          
        </div>

        
        <div class="btn-group">
        <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Rotate Left" style="float:left;">
          <button title="Rotate Left" data-option="-45" data-method="rotate" class="btn btn-primary" type="button">
            
              <span class="fa fa-rotate-left"></span>
            
          </button>
          </span>
          <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Rotate Right" style="float:left;">
          <button title="Rotate Right" data-option="45" data-method="rotate" class="btn btn-primary" type="button">
            
              <span class="fa fa-rotate-right"></span>
            
          </button>
          </span>
        </div>

        <div class="btn-group">
        <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Flip Horizontal" style="float:left;">
          <button title="Flip Horizontal" data-option="-1" data-method="scaleX" class="btn btn-primary" type="button">
            
              <span class="fa fa-arrows-h"></span>
            
          </button>
          </span>
          <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Flip Vertical" style="float:left;">
          <button title="Flip Vertical" data-option="-1" data-method="scaleY" class="btn btn-primary" type="button">
            
              <span class="fa fa-arrows-v"></span>
            
          </button>
          </span>
        </div>

        
        <div class="btn-group">
        <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Reset" style="float:left;">
          <button title="Reset" data-method="reset" class="btn btn-primary" type="button" >
            
              <span class="fa fa-refresh"></span>
            
          </button>
          </span>
          <label title="Upload image file" for="inputImage" class="btn btn-primary btn-upload">
            <input type="file" accept="image/*" name="file" id="inputImage" class="sr-only">
            <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Image Upload">
              <span class="fa fa-upload"></span>
            </span>
          </label>
                  </div>

        <div class="btn-group btn-group-crop">
          
            <span title="" data-toggle="tooltip" class="docs-tooltip" data-original-title="Crop" style="float:left;">
            <button data-method="getCroppedCanvas" class="btn btn-primary" type="button">
              Crop 
               </button>
            </span>
         
                  </div>

        <!-- Show the cropped image in modal -->
        <div tabindex="-1" role="dialog" aria-labelledby="getCroppedCanvasTitle" aria-hidden="true" id="getCroppedCanvasModal" class="modal fade docs-cropped">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 id="getCroppedCanvasTitle" class="modal-title">Cropped</h4>
              </div>
              <div class="modal-body"></div>
              <div style="display:none;" class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <a download="cropped.jpg" href="javascript:void(0);" id="download" class="btn btn-primary">Download</a>
              </div>
              
              
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <a onclick="saveimage();" href="javascript:void(0);" id="save" class="btn btn-primary">Save</a>
              </div>
              
              
            </div>
          </div>
        </div><!-- /.modal -->

                <!--<input type="text" class="form-control" id="putData" placeholder="Get data to here or set data with this value">-->

      </div>
      
      
      
      
    </div>
    <?php /*?><div class="row">
      <div class="col-md-9 docs-buttons">
        <!-- <h3 class="page-header">Toolbar:</h3> -->
        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
              <span class="fa fa-arrows"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
              <span class="fa fa-crop"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
          </button>
        </div>

        <?php /*?><div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, -10, 0)">
              <span class="fa fa-arrow-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 10, 0)">
              <span class="fa fa-arrow-right"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 0, -10)">
              <span class="fa fa-arrow-up"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 0, 10)">
              <span class="fa fa-arrow-down"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, -45)">
              <span class="fa fa-rotate-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, 45)">
              <span class="fa fa-rotate-right"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;scaleX&quot;, -1)">
              <span class="fa fa-arrows-h"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;scaleY&quot;-1)">
              <span class="fa fa-arrows-v"></span>
            </span>
          </button>
        </div>

        <?php /*?><!--<div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;crop&quot;)">
              <span class="fa fa-check"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;clear&quot;)">
              <span class="fa fa-remove"></span>
            </span>
          </button>
        </div>-->

        <!--<div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;disable&quot;)">
              <span class="fa fa-lock"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;enable&quot;)">
              <span class="fa fa-unlock"></span>
            </span>
          </button>
        </div>-->

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;reset&quot;)">
              <span class="fa fa-refresh"></span>
            </span>
          </button>
          <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
            <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
            <span class="docs-tooltip" data-toggle="tooltip" title="Image Upload">
              <span class="fa fa-upload"></span>
            </span>
          </label>
          <?php /*?><!--<button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;destroy&quot;)">
              <span class="fa fa-power-off"></span>
            </span>
          </button>-->
        </div>

        <div class="btn-group btn-group-crop">
          <button type="button" class="btn btn-primary" data-method="getCroppedCanvas">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;)">
              Crop
            </span>
          </button>
          <?php /*?><!--<button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 160, height: 90 })">
              160&times;90
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 320, height: 180 })">
              320&times;180
            </span>
          </button>-->
        </div>

        <!-- Show the cropped image in modal -->
        <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
              </div>
              <div class="modal-body"></div>
              <div class="modal-footer" style="display:none;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
              </div>
              
              
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-primary" id="save" href="javascript:void(0);" onClick="saveimage();" >Save</a>
              </div>
              
              
            </div>
          </div>
        </div><!-- /.modal -->

        <?php /*?><!--<button type="button" class="btn btn-primary" data-method="getData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getData&quot;)">
            Get Data
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="setData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setData&quot;, data)">
            Set Data
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="getContainerData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getContainerData&quot;)">
            Get Container Data
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="getImageData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getImageData&quot;)">
            Get Image Data
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="getCanvasData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCanvasData&quot;)">
            Get Canvas Data
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="setCanvasData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setCanvasData&quot;, data)">
            Set Canvas Data
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="getCropBoxData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCropBoxData&quot;)">
            Get Crop Box Data
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="setCropBoxData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setCropBoxData&quot;, data)">
            Set Crop Box Data
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="moveTo" data-option="0">
          <span class="docs-tooltip" data-toggle="tooltip" title="cropper.moveTo(0)">
            0,0
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="zoomTo" data-option="1">
          <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoomTo(1)">
            100%
          </span>
        </button>
        <button type="button" class="btn btn-primary" data-method="rotateTo" data-option="180">
          <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotateTo(180)">
            180°
          </span>
        </button>-->
        <!--<input type="text" class="form-control" id="putData" placeholder="Get data to here or set data with this value">-->

      </div><!-- /.docs-buttons -->

      <?php /*?><div class="col-md-3 docs-toggles">
        <!-- <h3 class="page-header">Toggles:</h3> -->
        <div class="btn-group btn-group-justified" data-toggle="buttons">
          <label class="btn btn-primary ">
            <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">
              16:9
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">
              4:3
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">
              1:1
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">
              2:3
            </span>
          </label>
          <label class="btn btn-primary active">
            <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">
              Free
            </span>
          </label>
        </div>

        <div class="btn-group btn-group-justified" data-toggle="buttons">
          <label class="btn btn-primary active">
            <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
              VM0
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
              VM1
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
              VM2
            </span>
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
              VM3
            </span>
          </label>
        </div>

        <div class="dropdown dropup docs-options">
          <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
            Toggle Options
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="responsive" checked>
                responsive
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="restore" checked>
                restore
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="checkCrossOrigin" checked>
                checkCrossOrigin
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="checkOrientation" checked>
                checkOrientation
              </label>
            </li>

            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="modal" checked>
                modal
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="guides" checked>
                guides
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="center" checked>
                center
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="highlight" checked>
                highlight
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="background" checked>
                background
              </label>
            </li>

            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="autoCrop" checked>
                autoCrop
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="movable" checked>
                movable
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="rotatable" checked>
                rotatable
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="scalable" checked>
                scalable
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="zoomable" checked>
                zoomable
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="zoomOnTouch" checked>
                zoomOnTouch
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="zoomOnWheel" checked>
                zoomOnWheel
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="cropBoxMovable" checked>
                cropBoxMovable
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="cropBoxResizable" checked>
                cropBoxResizable
              </label>
            </li>
            <li role="presentation">
              <label class="checkbox-inline">
                <input type="checkbox" name="toggleDragModeOnDblclick" checked>
                toggleDragModeOnDblclick
              </label>
            </li>
          </ul>
        </div><!-- /.dropdown -->
      </div><!-- /.docs-toggles -- >
    </div><?php */?>
  </div>

  <!-- Footer -->
  <!--<footer class="docs-footer">
    <div class="container">
      <p class="heart"></p>
    </div>
  </footer>-->

  <!-- Scripts -->
  <script>
  		function saveimage(){
			window.parent.$('#overlaysave').show();
			var result_img = $('#result_img').val();
			var folder_name = $('#folder_name').val();
			var inputImage = $('#inputImage').val();
			
			var image_id = $('#image_id').val();
			var image_val = $('#image_val').val();
			
			var img_sceen = $('#img_sceen').val();
			var big_image = $('#big_image_str').val();
			
			var big_image_id = $('#big_image_id').val();
			$.ajax({
					type: "POST",
					url : "<?php echo base_url(); ?>kaizen/<?php echo $controller; ?>/saveimage/",
					data: { result_img:result_img,folder_name:folder_name,big_image:big_image,image_id:image_id,image_val:image_val},
					dataType : "html",
					success: function(data)
					{
						var data_arr = data.split("~");
						$url = "<?php echo base_url(); ?>public/uploads/<?php echo $folder_name; ?>/"+data_arr[0];
						window.parent.$('#'+img_sceen).attr("src",$url+"?timestamp="+ new Date().getTime());
						window.parent.$('#'+image_id).val(data_arr[0]);
						
						
						window.parent.$('#'+big_image_id).val(data_arr[1]);
						window.parent.$('#overlaysave').hide();
						parent.$.fancybox.close();
					},
    			});
		}
  </script>
  
  <script src="<?php echo base_url("croptool/js/jquery.min.js");?>"></script>
  <script src="<?php echo base_url("croptool/js/bootstrap.min.js");?>"></script>
  <script src="<?php echo base_url("croptool/js/cropper.js");?>"></script>
  <script src="<?php echo base_url("croptool/js/main.js");?>"></script>
</body>
<script type="text/javascript">
      /*$('.fancybox-iframe').contents().find('body').css({
            overflow: hidden;
        }); */
        $('.fancybox-iframe').load(function(){ 
    $(this).contents().find('body').css({
        overflow: hidden
    });
})
  </script>
</html>

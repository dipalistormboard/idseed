$(function () {

  'use strict';

  var console = window.console || { log: function () {} };
  var $image = $('#image');
  var $download = $('#download');
  var $dataX = $('#dataX');
  var $dataY = $('#dataY');
  var $dataHeight = $('#dataHeight');
  var $dataWidth = $('#dataWidth');
  var $dataRotate = $('#dataRotate');
  var $dataScaleX = $('#dataScaleX');
  var $dataScaleY = $('#dataScaleY');
  var options = {
        aspectRatio: NaN,
        preview: '.img-preview',
        crop: function (e) {
          $dataX.val(Math.round(e.x));
          $dataY.val(Math.round(e.y));
          $dataHeight.val(Math.round(e.height));
          $dataWidth.val(Math.round(e.width));
          $dataRotate.val(e.rotate);
          $dataScaleX.val(e.scaleX);
          $dataScaleY.val(e.scaleY);
        }
      };


  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();


  // Cropper
  $image.on({
    'build.cropper': function (e) {
      //console.log(e.type);
    },
    'built.cropper': function (e) {
      //console.log(e.type);
    },
    'cropstart.cropper': function (e) {
      //console.log(e.type, e.action);
    },
    'cropmove.cropper': function (e) {
      //console.log(e.type, e.action);
    },
    'cropend.cropper': function (e) {
      //console.log(e.type, e.action);
    },
    'crop.cropper': function (e) {
      //console.log(e.type, e.x, e.y, e.width, e.height, e.rotate, e.scaleX, e.scaleY);
    },
    'zoom.cropper': function (e) {
      //console.log(e.type, e.ratio);
    }
  }).cropper(options);


  // Buttons
  if (!$.isFunction(document.createElement('canvas').getContext)) {
    $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
  }

  if (typeof document.createElement('cropper').style.transition === 'undefined') {
    $('button[data-method="rotate"]').prop('disabled', true);
    $('button[data-method="scale"]').prop('disabled', true);
  }


  // Download
  if (typeof $download[0].download === 'undefined') {
    $download.addClass('disabled');
  }


  // Options
  $('.docs-toggles').on('change', 'input', function () {
    var $this = $(this);
    var name = $this.attr('name');
    var type = $this.prop('type');
    var cropBoxData;
    var canvasData;

    if (!$image.data('cropper')) {
      return;
    }

    if (type === 'checkbox') {
      options[name] = $this.prop('checked');
      cropBoxData = $image.cropper('getCropBoxData');
      canvasData = $image.cropper('getCanvasData');

      options.built = function () {
        $image.cropper('setCropBoxData', cropBoxData);
        $image.cropper('setCanvasData', canvasData);
      };
    } else if (type === 'radio') {
      options[name] = $this.val();
    }

    $image.cropper('destroy').cropper(options);
  });


  // Methods
  $('.docs-buttons').on('click', '[data-method]', function () {
      window.parent.$('#overlay').show();
    var $this = $(this);
    var data = $this.data();
    var $target;
    var result;

    if ($this.prop('disabled') || $this.hasClass('disabled')) {
        window.parent.$('#overlay').hide();
      return;
    }

    if ($image.data('cropper') && data.method) {
      data = $.extend({}, data); // Clone a new one

      if (typeof data.target !== 'undefined') {
        $target = $(data.target);

        if (typeof data.option === 'undefined') {
          try {
            data.option = JSON.parse($target.val());
          } catch (e) {
              window.parent.$('#overlay').hide();
            //console.log(e.message);
          }
        }
      }
	  
	  

      result = $image.cropper(data.method, data.option, data.secondOption);

      switch (data.method) {
        case 'scaleX':
        case 'scaleY':
          $(this).data('option', -data.option);
          break;

        case 'getCroppedCanvas':
          if (result) {

            // Bootstrap's Modal
            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
            
            $('#result_img').html(result.toDataURL('image/jpeg'));
            /* commented by hardik as it was not working on IE */
            
           /* if (!$download.hasClass('disabled')) {
              //$download.attr('href', result.toDataURL('image/jpeg'));
			        console.log("test");
			  
			        $('#result_img').html(result.toDataURL('image/jpeg'));
            }*/
            /* commented by hardik as it was not working on IE */            
          }

          break;
      }

      if ($.isPlainObject(result) && $target) {
        try {
          $target.val(JSON.stringify(result));
        } catch (e) {
          console.log(e.message);
        }
      }

    }
    window.parent.$('#overlay').hide();
  });
$('.setcrop').on('click', function () {
	var height_inc = $('#height_inc').val();
	var width_inc = $('#width_inc').val();
	
	var data = $image.cropper('getData');
	
	data.width = parseInt(width_inc);
	data.height = parseInt(height_inc);
	
	$image.cropper('setData', data);
       
});
  // Keyboard
  $(document.body).on('keydown', function (e) {

    if (!$image.data('cropper') || this.scrollTop > 300) {
      return;
    }

    switch (e.which) {
      case 37:
        e.preventDefault();
        $image.cropper('move', -1, 0);
        break;

      case 38:
        e.preventDefault();
        $image.cropper('move', 0, -1);
        break;

      case 39:
        e.preventDefault();
        $image.cropper('move', 1, 0);
        break;

      case 40:
        e.preventDefault();
        $image.cropper('move', 0, 1);
        break;
    }

  });


  // Import image
  var $inputImage = $('#inputImage');
  var URL = window.URL || window.webkitURL;
  var blobURL;

  if (URL) { 
    $inputImage.change(function () {
        
      
      
      window.parent.$('#overlay').show();
      
      
      
      var files = this.files;
      var file;
      
      if (!$image.data('cropper')) {
        return;
      }

      if (files && files.length) {
          var big_size = false;
        file = files[0];
        //alert(file.size);
        var file_size = bytesToSize(file.size); 
        if(file_size !== "0 Byte"){
            var res = {};
            var res = file_size.split("/");
            if(res[1] == "MB"){
                var org_size = parseInt(res[0]);
                if(org_size > 5){
                    big_size = true;
                }
            }
        }
        if (/^image\/\w+$/.test(file.type) && (big_size == false)) {
          blobURL = URL.createObjectURL(file);
          $image.one('built.cropper', function () {
			 var reader  = new FileReader();
			 reader.addEventListener("load", function () {
				$('#big_image_str').html(reader.result);
			  }, false);
			  reader.readAsDataURL(file);
            // Revoke when load complete
            URL.revokeObjectURL(blobURL);
          }).cropper('reset').cropper('replace', blobURL);
          $inputImage.val('');
          window.parent.$('#overlay').hide();
        } else if(big_size == true){
            window.parent.$('#overlay').hide();
          window.alert('no images bigger than 5 MB');
          
        } else {
            window.parent.$('#overlay').hide();
          window.alert('Please choose an image file.');
        }
      }
      
    });
  } else {
    $inputImage.prop('disabled', true).parent().addClass('disabled');
  }
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Byte';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2)+ '/' + sizes[i];;
};
});

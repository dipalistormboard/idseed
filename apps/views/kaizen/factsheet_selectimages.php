     <script>
     	$(function() {
					$("#MoveRightP,#MoveLeftP").click(function(production) {
						var id = $(production.target).attr("id");
						var selectFrom = id == "MoveRightP" ? "#gallery_id" : "#selected_pages_id";
						var moveTo = id == "MoveRightP" ? "#selected_pages_id" : "#gallery_id";
						var selectedItems = $(selectFrom + " :selected").toArray();
						$(moveTo).append(selectedItems);
					});
					});
     </script>
          
              <?php
        	  echo '<div id="inline" class="fancy-content" style="width: 1074px !important;">
            <select class="image-picker1" name="allgallery_id[]" id="gallery_id" multiple="multiple" style="width: 495px;  height: 400px; ">';
        	
				
        				echo $galleryList;         
        			 echo '</select>';
        			 
			 
        			  echo ' <input type="button" name="left" value="=>" id="MoveRightP" style="vertical-align: top;"/> 
                                         <input type="button" name="right" value="<=" id="MoveLeftP" style="vertical-align: top;" />
               <select name="gallery_id[]" id="selected_pages_id" style="width:495px; height:400px;vertical-align: top;" multiple="multiple" size="10" class="inplogin">';
                            echo $selectedpages; 	
                              echo '</select></div>
					
							  ';
                              ?>
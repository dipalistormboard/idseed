<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header);
//$print_r($sub_page);
//pre($sub_page);
//echo $sub->page; exit;
?>
<?php
$dir = base_url()."/fact/factsheet/";
/*$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
*/
/*sort($files);

print_r($files);

rsort($files);

print_r($files);*/

//$a = file_get_contents(base_url()."/fact/factsheet/index.htm");
$a = file_get_contents(base_url()."/fact/factsheet/index.htm");
$b = explode('<div id="content">',$a);
//print_r($b);
$c = explode('<div id="footer">',$b[1]);


//echo $a;


?>
<script>
$(function() {
	<?php if(!empty($this->uri->segment(3))){ ?>
		$("#li_<?php echo $this->uri->segment(3); ?>").addClass('active');
		$("#div_<?php echo $this->uri->segment(3); ?>").show();
	<?php }
	else{ ?>
		$("#li_tab_1").addClass('active');
		$("#div_tab_1").show();
	<?php 	} ?>
});
</script>


<div class="content">
<div class="wrapper">
<div class="extdiv">
<?php //echo $c[0];
//$letters = range('A', 'Z');
 ?>
<?
          if($this->session->userdata('language_version') == "french"){
           
            $list = 'Liste de Fiches de Renseignements';
            $family = 'Nom Famille';
            $scientific = 'Nom Scientifique';
            $commonname = 'Nom Commun';
             $Regulation = 'Réglementation';
          }
          else{
           
            $list = 'List of Fact Sheets';
            $family = 'Family Name';
            $scientific = 'Scientific Name';
            $commonname = 'Common Name';
             $Regulation = 'Regulation';
          }
            
        ?>



<h1><?=$list?></h1>
			<ul class="fact-tabmenu">
            	<li id="li_tab_1"><a href="#"><?=$family?></a></li>
                 <li id="li_tab_2"><a href="#"><?=$scientific?></a></li>
                <li id="li_tab_3"><a href="#"><?=$commonname?></a></li>
                 <li id="li_tab_4"><a href="#"><?=$Regulation?></a></li>
            </ul>


<div class="fact-tabcont" id="div_tab_1">
<div id="alphabet">
<ul>
<?php 
$letters_family = array();

for($i=0; $i < count($details_family); $i++){
    $first_char = substr(ucfirst($details_family[$i]->family), 0, 1); 
    $letters_family[] = $first_char;
}
$letters_family = array_unique($letters_family);
$letters_family_arr = array_values($letters_family);

for($i=0;$i<count($letters_family_arr);$i++){ ?>
<li><a class="alphabet" href="#<?php echo 'f_'.$letters_family_arr[$i]; ?>"><?php echo $letters_family_arr[$i]; ?> </a></li>
<?php } ?>
</ul>
</div>

<?php
$j=1;
$k= $letters_family_arr[0];
 ?>

<?php 
foreach($details_family as $row_details){
	 $first_char_fam = substr(ucfirst($row_details->family), 0, 1);
	if($j%2==0){$cls = 'fact-block-grey';}else{$cls = 'fact-block';}
	$details_family_title = $this->model_factsheet->getfactsheets_family_title($row_details->family);
	?>
   <div class="<?php echo $cls; ?>" id="<?php echo 'f_'.$first_char_fam; ?>">  <h2><?php echo $row_details->family; ?></h2>
    <?php
foreach($details_family_title as $row_details_title){
	
	//if((substr(ucfirst($row_details->family), 0, 1)) != $k ){
		//$k = substr(ucfirst($row_details->family), 0, 1);
		?>
        
      
        <?php 
		//$j++;}
	?>
    <div class="fact-link "><a href="<?php echo base_url('factsheet/'.$row_details_title->page_link.'/tab_1'); ?>"><?php echo $row_details_title->title; ?></a></div>
	
	<?php
	} ?>
    </div>
    <?php $j++;}
	?>



</div>
<!--Scientific name start-->


<div class="fact-tabcont" id="div_tab_2">


<div id="alphabet">
<ul>
<?php 
$letters_sci = array();

for($i=0; $i < count($details_scientific); $i++){
	$stripped_vals = strip_tags($details_scientific[$i]->title);
  $first_char = substr(ucfirst($stripped_vals), 0, 1); 
    $letters_sci[] = $first_char;
}
//echo "gggg:";print_r($letters_sci);
$letters_sci = array_unique($letters_sci);

$letters_sci_arr = array_values($letters_sci);
//print_r($letters_sci);


for($i=0;$i<count($letters_sci_arr);$i++){ ?>
<li><a class="alphabet" href="#<?php echo 's_'.$letters_sci_arr[$i]; ?>"><?php echo $letters_sci_arr[$i]; ?> </a></li>
<?php } ?>
</ul>
</div>


<?php
$j=1;
//print_r($details_scientific);
$k= $letters_sci_arr[0];
 ?>
<div class="fact-block-grey" id="<?php echo 's_'.$k; ?>"><h2><?php echo $k; ?></h2>
<?php $stripped_values = '';
include '../database.php';

foreach($details_scientific as $row_details_sci){
	if($j%2==0){$cls = 'fact-block-grey';}else{$cls = 'fact-block';}
	
	$stripped_values = trim(strip_tags(outputEscapeString($row_details_sci->title)));
	
	if((substr(ucfirst($stripped_values), 0, 1)) != $k ){
		 $k = substr(ucfirst($stripped_values), 0, 1);
		?>
        
       </div><div class="<?php echo $cls;?>"  id="<?php echo 's_'.$k; ?>"> <h2><?php echo $k; ?></h2>
        <?php 
		$j++;}
	?>
    <div class="fact-link "><a href="<?php echo base_url('factsheet/'.$row_details_sci->page_link.'/tab_2'); ?>"><?php echo $row_details_sci->title; ?></a></div>
	
	<?php
	}
	?>

</div>

</div>


<!--Common name Start-->

<div class="fact-tabcont" id="div_tab_3">


<div id="alphabet">
<ul>
<?php 
$letters_comm = array();

for($i=0; $i < count($details_comm); $i++){
    $first_char = substr(ucfirst($details_comm[$i]->common_name), 0, 1); 
    $letters_comm[] = $first_char;
}
$letters_comm = array_unique($letters_comm);
$letters_comm_arr = array_values($letters_comm);

for($i=0;$i<count($letters_comm_arr);$i++){ 
  if(!empty($letters_comm_arr[$i])){
  ?>
<li><a class="alphabet" href="#<?php echo 'c_'.$letters_comm_arr[$i]; ?>"><?php echo $letters_comm_arr[$i]; ?> </a></li>
<?php } } ?>
</ul>
</div>


<?php
$j=1;
$k= $letters_comm_arr[0];
 ?>
<div class="fact-block-grey" ><a id="<?php echo 'c_'.$k; ?>"></a><h2><?php echo $k; ?></h2>
<?php 
foreach($details_comm as $row_details_comm){
	if($j%2==0){$cls = 'fact-block-grey';}else{$cls = 'fact-block';}
	if((substr(ucfirst($row_details_comm->common_name), 0, 1)) != $k ){
		$k = substr(ucfirst($row_details_comm->common_name), 0, 1);
		?>
        
       </div><div class="<?php echo $cls; ?>" id="<?php echo 'c_'.$k; ?>"><h2><?php echo $k; ?></h2>
        <?php 
		$j++;}
	?>
    <div class="fact-link "><a href="<?php echo base_url('factsheet/'.$row_details_comm->page_link.'/tab_3'); ?>"><?php echo $row_details_comm->common_name; ?></a></div>
	
	<?php
	}
	?>

</div>
</div>

<!--Regulation Starts-->

<div class="fact-tabcont" id="div_tab_4">

<?php /*?>
<div id="alphabet">
<ul>
<?php 
$letters_reg = array();

for($i=0; $i < count($details_regulation); $i++){
    $first_char = substr(ucfirst($details_regulation[$i]->regulation_keyword), 0, 1); 
    $letters_reg[] = $first_char;
}
$letters_reg = array_unique($letters_reg);
$letters_reg_arr = array_values($letters_reg);

for($i=0;$i<count($letters_reg_arr);$i++){ ?>
<li><a class="alphabet" href="#<?php echo $letters_reg_arr[$i]; ?>"><?php echo $letters_reg_arr[$i]; ?> </a></li>
<?php } ?>
</ul>
</div><?php */?>


<?php
$j=1;
$k= $letters_reg_arr[0];
$flag_available = 0;
 ?>

<?php 
$arr = array('1','2','3','4','5');
//$arr = explode(',',$details_all->regulation_keyword);
//print_r($arr1);
for($i=0;$i<count($arr);$i++){
if($j%2==0){$cls = 'fact-block-grey';}else{$cls = 'fact-block';}

if($arr[$i] == '1'){
   if($this->session->userdata('language_version') == "french"){
     $arr_title = 'Catégorie 1: Graines de mauvaises herbes nuisibles interdites';
   }
   else{
     $arr_title = 'Class 1: Prohibited Noxious Weed Seeds';
   }
}
if($arr[$i] == '2'){
  if($this->session->userdata('language_version') == "french"){
    $arr_title = 'Catégorie 2: Graines de mauvaises herbes nuisibles principales';
  }
  else{
    $arr_title = 'Class 2: Primary Noxious Weed Seeds';
  }

}
if($arr[$i] == '3'){
  if($this->session->userdata('language_version') == "french"){
    $arr_title = 'Catégorie 3: Graines de mauvaises herbes nuisibles secondaires';
  }
  else{
    $arr_title = 'Class 3: Secondary Noxious Weed Seeds';
  }  
}
if($arr[$i] == '4'){
  if($this->session->userdata('language_version') == "french"){
    $arr_title = 'Catégorie 4: Graines de mauvaises herbes nuisibles secondaires';
  }
  else{
    $arr_title = 'Class 4: Secondary Noxious Weed Seeds';
  }  
}
if($arr[$i] == '5'){
  if($this->session->userdata('language_version') == "french"){
    $arr_title = 'Catégorie 5: Graines de mauvaises herbes nuisibles';
  }
  else{
    $arr_title = 'Class 5: Noxious Weed Seeds';
  }  
}

foreach($details_all as $row_details_reg1){
	//echo ";".$row_details_reg->regulation_keyword;
	$arr_reg1 = explode(',',$row_details_reg1->regulation_keyword);
	if (in_array($arr[$i], $arr_reg1)) {
		$flag_available = 1;
		
	}
}

if($flag_available == 1){
?>
<div class="<?php echo $cls; ?>" >
<h2><?php echo $arr_title; ?></h2>
<?php
foreach($details_all as $row_details_reg){
	//echo ";".$row_details_reg->regulation_keyword;
	$arr_reg = explode(',',$row_details_reg->regulation_keyword);
	if (in_array($arr[$i], $arr_reg)) {
		?>
        
       
    <div class="fact-link "><a href="<?php echo base_url('factsheet/'.$row_details_reg->page_link.'/tab_4'); ?>"><?php echo $row_details_reg->title; ?></a></div>
	
	<?php
	}
	}
	?>
    </div>
    <?php
}
$flag_available = 0;
$j++;}
	?>

</div>

<!--Regulation Ends-->

</div>
<!--<iframe id="ifrm" src="ftp://ftp.agr.gc.ca/pub/outgoing/cfia-rwa/FINAL%20FACT%20SHEETS%20600px%20(May%2027%202016)/index.htm" style="width:100%;height:3150px;" frameBorder="0">
 
</iframe>
<!--<script type="text/javascript">
var iframes = document.getElementsByTagName('iframe');
var list = document.getElementById("header");
    for (var i = 0; i < iframes.length; i++) {
        list.parentNode.removeChild(list);
    }
</script>-->

    	<!--<div class="wrapper">
        	<h2>Fact sheet index</h2>
            <ul class="fact-tabmenu">
            	<li class="active"><a href="#">Family Name</a></li>
                <li><a href="#">Scientific Name</a></li>
            </ul>
        </div>-->
        <!--<div class="fact-tabcont" style="display:block;">
        	<div class="fact-alphabets">
            	<div class="wrapper">
                	<ul>	
                    	<li><a href="#a" class="alpha">a</a></li>
                        <li><a href="#b" class="alpha">b</a></li>
                        <li><a href="#c" class="alpha">c</a></li>
                        <li><a href="#e" class="alpha">e</a></li>
                        <li><a href="#f" class="alpha">f</a></li>
                        <li><a href="#h" class="alpha">h</a></li>
                        <li><a href="#i" class="alpha">i</a></li>
                        <li><a href="#l" class="alpha">l</a></li>
                        <li><a href="#m" class="alpha">m</a></li>
                        <li><a href="#o" class="alpha">o</a></li>
                        <li><a href="#p" class="alpha">p</a></li>
                        <li><a href="#r" class="alpha">r</a></li>
                        <li><a href="#s" class="alpha">s</a></li>
                    </ul>
                </div>
            </div>
            <div class="wrapper">
            	<span class="back-to-top"></span>
            	<div id="a">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Acanthaceae</h4>
                            <ul>
                                <li><a href="#">Hygrophila polysperma</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Alismataceae</h4>
                            <ul>
                                <li><a href="#">Sagittaria sagittifolia</a></li>
                            </ul>
                        </li>
                        <li>
                            <h4>Amaranthaceae</h4>
                            <ul>
                                <li><a href="#">Alternanthera sessilis</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Apiaceae</h4>
                            <ul>
                                <li><a href="#">Heracleum mantegazzianum</a></li>
                            </ul>
                        </li>
                        <li>
                            <h4>Asteraceae</h4>
                            <ul>
                                <li><a href="#">Acroptilon repens</a></li>
                                <li><a href="#">Senecio inaequidens</a></li>
                                <li><a href="#">Mikania micrantha</a></li>
                                <li><a href="#">Ageratina riparia</a></li>
                                <li><a href="#">Sonchus arvensis</a></li>
                                <li><a href="#">Onopordum illyricum</a></li>
								<li><a href="#">Carthamus oxyacantha</a></li>
                                <li><a href="#">Ageratina adenophora</a></li>
                                <li><a href="#">Senecio madagascariensis</a></li>
								<li><a href="#">Crupina vulgaris</a></li>
                                <li><a href="#">Arctotheca calendula</a></li>
                                <li><a href="#">Tridax procumbens</a></li>
								<li><a href="#">Mikania cordata</a></li>
                                <li><a href="#">Cirsium arvense</a></li>
                                <li><a href="#">Onopordum acaulon</a></li>
                                <li><a href="#">Inula britannica</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="b">
                    <ul class="fact-family-names">
                        <li class="grey">
                            <h4>Brassicaceae</h4>
                            <ul>
                                <li><a href="#">Cardaria chalepensis</a></li>
                                <li><a href="#">Cardaria pubescens</a></li>
                                <li><a href="#">Cardaria draba</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="c">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Cactaceae</h4>
                            <ul>
                                <li><a href="#">Opuntia aurantiaca</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Caryophyllaceae</h4>
                            <ul>
                                <li><a href="#">Drymaria arenarioides</a></li>
                            </ul>
                        </li>
                        <li>
                            <h4>Caulerpaceae</h4>
                            <ul>
                                <li><a href="#">Caulerpa taxifolia</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Chenopodiaceae</h4>
                            <ul>
                                <li><a href="#">Salsola vermiculata</a></li>
                            </ul>
                        </li>
                        <li>
                            <h4>Commelinaceae</h4>
                            <ul>
                                <li><a href="#">Commelina benghalensis</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Convolvulaceae</h4>
                            <ul>
                                <li><a href="#">Convolvulus arvensis</a></li>
                                <li><a href="#">Ipomoea aquatica</a></li>
                                <li><a href="#">Cuscuta spp.</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="e">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Euphorbiaceae</h4>
                            <ul>
                                <li><a href="#">Euphorbia esula</a></li>
                                <li><a href="#">Euphorbia terracina</a> </li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="f">
                    <ul class="fact-family-names">
                        <li class="grey">
                            <h4>Fabaceae</h4>
                            <ul>
                                <li><a href="#">Acacia nilotica</a></li>
                                <li><a href="#">Prosopis pallida</a></li>
                                <li><a href="#">Prosopis castellanosii</a></li>
                                <li><a href="#">Mimosa diplotricha</a></li>
                                <li><a href="#">Prosopis reptans</a></li>
                                <li><a href="#">Prosopis elata</a></li>
                                <li><a href="#">Prosopis alpataco</a></li>
                                <li><a href="#">Prosopis ruizlealii</a></li>
                                <li><a href="#">Prosopis ferox</a></li>
                                <li><a href="#">Prosopis articulata</a></li>
                                <li><a href="#">Prosopis sericantha</a></li>
                                <li><a href="#">Prosopis hassleri</a></li>
								<li><a href="#">Prosopis caldenia</a></li>
                                <li><a href="#">Prosopis torquata</a></li>
                                <li><a href="#">Prosopis kuntzei</a></li>
								<li><a href="#">Prosopis campestris</a></li>
                                <li><a href="#">Galega officinalis</a></li>
                                <li><a href="#">Prosopis palmeri</a></li>
								<li><a href="#">Prosopis denudans</a></li>
                                <li><a href="#">Mimosa pigra</a></li>
                                <li><a href="#">Prosopis rojasiana</a></li>
								<li><a href="#">Prosopis farcta</a></li>
                                <li><a href="#">Prosopis argentina</a></li>
                                <li><a href="#">Prosopis ruscifolia</a></li>
								<li><a href="#">Prosopis fiebrigii</a></li>
                                <li><a href="#">Prosopis burkartii</a></li>
                                <li><a href="#">Prosopis strombulifera</a></li>
								<li><a href="#">Prosopis humilis</a></li>
                                <li><a href="#">Prosopis calingastana</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="h">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Hydrocharitaceae</h4>
                            <ul>
                                <li><a href="#">Hydrilla verticillata</a></li>
                                <li><a href="#">Ottelia alismoides</a></li>
                                <li><a href="#">Lagarosiphon major</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="i">
                    <ul class="fact-family-names">
                        <li class="grey">
                            <h4>Iridaceae</h4>
                            <ul>
                                <li><a href="#">Moraea spp.</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="l">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Liliaceae</h4>
                            <ul>
                                <li><a href="#">Asphodelus fistulosus</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Lygodiaceae</h4>
                            <ul>
                                <li><a href="#">Lygodium flexuosum </a></li>
                                <li><a href="#">Lygodium microphyllum</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="m">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Melastomataceae</h4>
                            <ul>
                                <li><a href="#">Melastoma malabathricum</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Myrtaceae</h4>
                            <ul>
                                <li><a href="#">Melaleuca quinquenervia</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="o">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Orobanchaceae</h4>
                            <ul>
                                <li><a href="#">Aeginetia spp.</a></li>
                                <li><a href="#">Orobanche and Phelipanche spp.</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="p">
                    <ul class="fact-family-names">
                        <li class="grey">
                            <h4>Poaceae</h4>
                            <ul>
                                <li>Avena sterilis</li>
                                <li>Pennisetum pedicellatum</li>
                                <li>Nassella trichotoma</li>
                                <li>Digitaria abyssinica</li>
                                <li>Rottboellia cochinchinensis</li>
                                <li>Oryza punctata</li>
                                <li>Elytrigia repens</li>
                                <li>Setaria pumila ssp. pallidefusca</li>
                                <li>Paspalum scrobiculatum</li>
                                <li>Imperata cylindrica</li>
                                <li>Urochloa panicoides</li>
                                <li>Pennisetum macrourum</li>
                                <li>Leptochloa chinensis</li>
                                <li>Chrysopogon aciculatis</li>
                                <li>Pennisetum polystachion</li>
                                <li>Oryza longistaminata</li>
                                <li>Digitaria velutina</li>
                                <li>Saccharum spontaneum</li>
                                <li>Oryza rufipogon</li>
                                <li>Imperata brasiliensis</li>
                                <li>Sorghum halepense</li>
                                <li>Pennisetum clandestinum</li>
                                <li>Ischaemum rugosum</li>
                            </ul>
                        </li>
                        <li>
                            <h4>Polygonaceae</h4>
                            <ul>
                                <li>Emex australis</li>
                                <li>Emex spinosa</li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Pontederiaceae</h4>
                            <ul>
                                <li>Eichhornia azurea</li>
                                <li>Monochoria vaginalis</li>
                                <li>Monochoria hastata</li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="r">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Rosaceae</h4>
                            <ul>
                                <li><a href="#">Rubus fruticosus complex</a></li>
                                <li><a href="#">Rubus moluccanus</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Rubiaceae</h4>
                            <ul>
                                <li><a href="#">Spermacoce alata</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
                <div id="s">
                    <ul class="fact-family-names">
                        <li>
                            <h4>Salviniaceae</h4>
                            <ul>
                                <li><a href="#">Azolla pinnata</a></li>
                                <li><a href="#">Salvinia auriculata complex</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Scrophulariaceae</h4>
                            <ul>
                                <li><a href="#">Alectra spp.</a></li>
                                <li><a href="#">Striga spp.</a></li>
                                <li><a href="#">Limnophila sessiliflora</a></li>
                            </ul>
                        </li>
                        <li>
                            <h4>Solanaceae</h4>
                            <ul>
                                <li><a href="#">Lycium ferocissimum</a></li>
                                <li><a href="#">Solanum tampicense</a></li>
                                <li><a href="#">Solanum viarum</a></li>
                                <li><a href="#">Solanum torvum</a></li>
                            </ul>
                        </li>
                        <li class="grey">
                            <h4>Sparganiaceae</h4>
                            <ul>
                                <li><a href="#">Sparganium erectum</a></li>
                            </ul>
                        </li>
                    </ul>
            	</div>
            </div>
    	</div>
        <div class="fact-tabcont">
        	<div class="fact-alphabets">
            	<div class="wrapper">
                	<ul>	
                    	<li><a href="#asc" class="alpha">a</a></li>
                        <li><a href="#csc" class="alpha">c</a></li>
                        <li><a href="#dsc" class="alpha">d</a></li>
                        <li><a href="#esc" class="alpha">e</a></li>
                        <li><a href="#gsc" class="alpha">g</a></li>
                        <li><a href="#hsc" class="alpha">h</a></li>
                        <li><a href="#isc" class="alpha">i</a></li>
                        <li><a href="#lsc" class="alpha">l</a></li>
                        <li><a href="#msc" class="alpha">m</a></li>
                        <li><a href="#nsc" class="alpha">n</a></li>
                        <li><a href="#osc" class="alpha">o</a></li>
                        <li><a href="#psc" class="alpha">p</a></li>
                        <li><a href="#rsc" class="alpha">r</a></li>
                        <li><a href="#ssc" class="alpha">s</a></li>
                        <li><a href="#tsc" class="alpha">t</a></li>
                        <li><a href="#usc" class="alpha">u</a></li>
                    </ul>
                </div>
            </div>
            <div class="wrapper">
            	<span class="back-to-top"></span>
            	<div id="asc">
                    <ul class="fact-family-names fact-sc-names">
                        <li>
                            <h4>A</h4>
                            <ul>
                                <li><a href="#"><strong>Acacia niloticaFabaceae</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Acroptilon repens</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Aeginetia spp.</strong></a> <span>Orobanchaceae</span></li>
								<li><a href="#"><strong>Ageratina adenophora</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Ageratina riparia</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Alectra spp.</strong></a> <span>Scrophulariaceae</span></li>
								<li><a href="#"><strong>Alternanthera sessilis</strong></a> <span>Amaranthaceae</span></li>
								<li><a href="#"><strong>Arctotheca calendula</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Asphodelus fistulosus</strong></a> <span>Liliaceae</span></li>
								<li><a href="#"><strong>Avena sterilis</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Azolla pinnata</strong></a> <span>Salviniaceae </span></li>
                            </ul>
                        </li>
                    </ul>
                </div>  
                <div id="csc">
                    <ul class="fact-family-names fact-sc-names">
                        <li class="grey">
                            <h4>C</h4>
                            <ul>
								<li><a href="#"><strong>Cardaria chalepensis</strong></a> <span>Brassicaceae</span></li>
								<li><a href="#"><strong>Cardaria draba</strong></a> <span>Brassicaceae</span></li>
								<li><a href="#"><strong>Cardaria pubescens</strong></a> <span>Brassicaceae</span></li>
								<li><a href="#"><strong>Carthamus oxyacantha</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Caulerpa taxifolia</strong></a> <span>Caulerpaceae</span></li>
								<li><a href="#"><strong>Chrysopogon aciculatis</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Cirsium arvense</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Commelina benghalensis</strong></a> <span>Commelinaceae</span></li>
								<li><a href="#"><strong>Convolvulus arvensis</strong></a> <span>Convolvulaceae</span></li>
								<li><a href="#"><strong>Crupina vulgaris</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Cuscuta spp.</strong></a> <span>Convolvulaceae </span></li>
                            </ul>
                        </li>
                    </ul>
                </div> 
                <div id="dsc">
                    <ul class="fact-family-names fact-sc-names">
                        <li>
                            <h4>D</h4>
                            <ul>
								<li><a href="#"><strong>Digitaria abyssinica</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Digitaria velutina</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Drymaria arenarioides</strong></a> <span>Caryophyllaceae</span></li> 
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="esc">
                    <ul class="fact-family-names fact-sc-names">
                        <li class="grey">
                            <h4>E</h4>
                            <ul>
								<li><a href="#"><strong>Eichhornia azurea</strong></a> <span>Pontederiaceae</span></li>
								<li><a href="#"><strong>Elytrigia repens</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Emex australis</strong></a> <span>Polygonaceae</span></li>
								<li><a href="#"><strong>Emex spinosa</strong></a> <span>Polygonaceae</span></li>
								<li><a href="#"><strong>Euphorbia esula</strong></a> <span>Euphorbiaceae</span></li>
								<li><a href="#"><strong>Euphorbia terracina</strong></a> <span>Euphorbiaceae</span></li>  
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="gsc">
                    <ul class="fact-family-names fact-sc-names">
                        <li>
                            <h4>G</h4>
                            <ul>
								<li><a href="#"><strong>Galega officinalis</strong></a> <span>Fabaceae</span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="hsc">
                    <ul class="fact-family-names fact-sc-names">
                        <li class="grey">
                            <h4>H</h4>
                            <ul>
								<li><a href="#"><strong>Heracleum mantegazzianum</strong></a> <span>Apiaceae</span></li>
								<li><a href="#"><strong>Hydrilla verticillata</strong></a> <span>Hydrocharitaceae</span></li>
								<li><a href="#"><strong>Hygrophila polysperma</strong></a> <span>Acanthaceae</span></li> 
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="isc">
                    <ul class="fact-family-names fact-sc-names">
                        <li>
                            <h4>I</h4>
                            <ul>
								<li><a href="#"><strong>Imperata brasiliensis</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Imperata cylindrica</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Inula britannica</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Ipomoea aquatica</strong></a> <span>Convolvulaceae</span></li>
								<li><a href="#"><strong>Ischaemum rugosum</strong></a> <span>Poaceae </span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="lsc">
                    <ul class="fact-family-names fact-sc-names">
                        <li class="grey">
                            <h4>L</h4>
                            <ul>
								<li><a href="#"><strong>Lagarosiphon major</strong></a> <span>Hydrocharitaceae</span></li>
								<li><a href="#"><strong>Leptochloa chinensis</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Limnophila sessiliflora</strong></a> <span>Scrophulariaceae</span></li>
								<li><a href="#"><strong>Lycium ferocissimu</strong></a> <span>Solanaceae</span></li>
								<li><a href="#"><strong>Lygodium flexuosum</strong></a> <span>Lygodiaceae</span></li>
								<li><a href="#"><strong>Lygodium microphyllum</strong></a> <span>Lygodiaceae </span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="msc">
                    <ul class="fact-family-names fact-sc-names">
                        <li>
                            <h4>M</h4>
                            <ul>
								<li><a href="#"><strong>Melaleuca quinquenervia</strong></a> <span>Myrtaceae</span></li>
								<li><a href="#"><strong>Melastoma malabathricum</strong></a> <span>Melastomataceae</span></li>
								<li><a href="#"><strong>Mikania cordata</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Mikania micrantha</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Mimosa diplotricha</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Mimosa pigra</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Monochoria hastata</strong></a> <span>Pontederiaceae</span></li>
								<li><a href="#"><strong>Monochoria vaginalis</strong></a> <span>Pontederiaceae</span></li>
								<li><a href="#"><strong>Moraea spp.</strong></a> <span>Iridaceae </span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="nsc">
                    <ul class="fact-family-names fact-sc-names">
                        <li class="grey">
                            <h4>N</h4>
                            <ul>
								<li><a href="#"><strong>Nassella trichotoma</strong></a> <span>Poaceae</span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="osc">
                    <ul class="fact-family-names fact-sc-names">
                        <li>
                            <h4>O</h4>
                            <ul>
								<li><a href="#"><strong>Onopordum acaulon</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Onopordum illyricum</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Opuntia aurantiaca</strong></a> <span>Cactaceae</span></li>
								<li><a href="#"><strong>Orobanche and Phelipanche spp.</strong></a> <span>Orobanchaceae</span></li>
								<li><a href="#"><strong>Oryza longistaminata</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Oryza punctata</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Oryza rufipogon</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Ottelia alismoides</strong></a> <span>Hydrocharitaceae </span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="psc">
                    <ul class="fact-family-names fact-sc-names">
                        <li class="grey">
                            <h4>P</h4>
                            <ul>
								<li><a href="#"><strong>Paspalum scrobiculatum</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Pennisetum clandestinum</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Pennisetum macrourum</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Pennisetum pedicellatum</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Pennisetum polystachion</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Prosopis alpataco</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis argentina</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis articulata</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis burkartii</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis caldenia</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis calingastana</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis campestris</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis castellanosii</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis denudans</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis elata</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis farcta</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis ferox</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis fiebrigii</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis hassleri</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis humilis</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis kuntzei</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis pallida</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis palmeri</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis reptans</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis rojasiana</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis ruizlealii</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis ruscifolia</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis sericantha</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis strombulifera</strong></a> <span>Fabaceae</span></li>
								<li><a href="#"><strong>Prosopis torquata</strong></a> <span>Fabaceae </span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="rsc">
                    <ul class="fact-family-names fact-sc-names">
                        <li>
                            <h4>R</h4>
                            <ul>
								<li><a href="#"><strong>Rottboellia cochinchinensis</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Rubus fruticosus complex</strong></a> <span>Rosaceae</span></li>
								<li><a href="#"><strong>Rubus moluccanus</strong></a> <span>Rosaceae </span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="ssc">
                    <ul class="fact-family-names fact-sc-names">
                        <li class="grey">
                            <h4>S</h4>
                            <ul>
								<li><a href="#"><strong>Saccharum spontaneum</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Sagittaria sagittifolia</strong></a> <span>Alismataceae</span></li>
								<li><a href="#"><strong>Salsola vermiculata</strong></a> <span>Chenopodiaceae</span></li>
								<li><a href="#"><strong>Salvinia auriculata complex</strong></a> <span>Salviniaceae</span></li>
								<li><a href="#"><strong>Senecio inaequidens</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Senecio madagascariensis</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Setaria pumila ssp. pallidefusca</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Solanum tampicense</strong></a> <span>Solanaceae</span></li>
								<li><a href="#"><strong>Solanum torvum</strong></a> <span>Solanaceae</span></li>
								<li><a href="#"><strong>Solanum viarum</strong></a> <span>Solanaceae</span></li>
								<li><a href="#"><strong>Sonchus arvensis</strong></a> <span>Asteraceae</span></li>
								<li><a href="#"><strong>Sorghum halepense</strong></a> <span>Poaceae</span></li>
								<li><a href="#"><strong>Sparganium erectum</strong></a> <span>Sparganiaceae</span></li>
								<li><a href="#"><strong>Spermacoce alata</strong></a> <span>Rubiaceae</span></li>
								<li><a href="#"><strong>Striga spp.</strong></a> <span>Scrophulariaceae</span></li> 
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="tsc">
                    <ul class="fact-family-names fact-sc-names">
                        <li>
                            <h4>T</h4>
                            <ul>
								<li><a href="#"><strong>Tridax procumbens</strong></a> <span>Asteraceae</span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="usc">
                    <ul class="fact-family-names fact-sc-names">
                        <li class="grey">
                            <h4>U</h4>
                            <ul>
								<li><a href="#"><strong>Urochloa panicoides</strong></a> <span>Poaceae</span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
    	</div>-->
        </div>
    </div>
   
    <!--content section end-->
    <?php $this->load->view($footer);
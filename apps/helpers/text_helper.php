<?php 
function limit_to_numwords($string, $numwords){
  $excerpt = explode(' ', $string, $numwords + 1);
  if (count($excerpt) >= $numwords) {
    array_pop($excerpt);
  }
  $excerpt = implode(' ', $excerpt);
  $excerpt = $excerpt . '...';
  return $excerpt;
}

function output($msg) {
  if (!empty($msg)) {
    echo $msg;
  }
}

function output_a($msgs) {
  if (!empty($msgs)) {
    foreach ($msgs as $key => $msg) {
      echo $msg;
    }
  }
}

function output_modules() {
  if (isset($module_views)) {
    foreach ($module_views as $view) {
      $this->load->view('templates/modules/' . $view);
    }
  } 
}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
if(strstr($_SERVER['REQUEST_URI'],'kaizen')){

}
else{
$hook['post_controller_constructor'][] = array(
                                'class'    => 'Menu_class',
                                'function' => 'get_menu',
                                'filename' => 'Menu_class.php',
                                'filepath' => 'hooks',
								'params'   => array()   
                                );
$hook['post_controller_constructor'][] = array(
                                'class'    => 'Metalist',
                                'function' => 'get_meta',
                                'filename' => 'Metalist.php',
                                'filepath' => 'hooks',
								'params'   => array()   
                                );

}



/* End of file hooks.php */
/* Location: ./application/config/hooks.php */
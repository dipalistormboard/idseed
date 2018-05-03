<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#error_reporting(0);
class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		
		if( ! $this->session->userdata('web_admin_logged_in')) {redirect('kaizen/welcome','refresh');
		}
		$this->load->vars( array(
		  'global' => 'Available to all views',
		  'header' => 'kaizen/common/header',
		  'left' => 'kaizen/common/left',
		  'footer' => 'kaizen/common/footer'
		));
	}

	function index()
	{
		if($this->session->userdata('web_admin_logged_in'))
		{
			if(!$this->session->userdata('SITE_ID'))
			{
			$this->session->set_userdata(array('SITE_ID'=>'1'));
			}
			$this->load->view('kaizen/default');
		}
		else
		{
			redirect('kaizen/welcome','refresh');
		}
	}
	function ajax_site()
	{
		if($this->session->userdata('web_admin_logged_in'))
		{

			$site	=	$this->input->post('site',TRUE);
			if(!empty($site))
			{
				$this->session->set_userdata(array('SITE_ID'=>$site));
			}
			else
			{
				$this->session->set_userdata(array('SITE_ID'=>'1'));			
			}
			
		echo $this->session->userdata('SITE_ID');
		}
		else
		{
			redirect('kaizen/welcome','refresh');
		}
	}
	
	
	function ajax_language()
	{
		if($this->session->userdata('prefered_language'))
		{

			$prefered_language	=	$this->input->post('prefered_language',TRUE);
			if(!empty($prefered_language))
			{
				$this->session->set_userdata(array('prefered_language'=>$prefered_language));
			}
			else
			{
				$this->session->set_userdata(array('prefered_language'=>'english'));			
			}
			
		echo $this->session->userdata('prefered_language');
		}
		else
		{
			redirect('kaizen/welcome','refresh');
		}
	}
	
	
}
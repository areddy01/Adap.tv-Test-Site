<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		
		$this->load->database();
		
		$this->load->helper(array('form','url','file','number'));
		$this->load->library('form_validation');			
		
		//$this->LoadSetup();
	}

	function index()
	{
		$this->load->view('pages/main');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
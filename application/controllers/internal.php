<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Internal extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();			
		$this->load->helper(array('form','url','file','number'));
	}
	
	function view($page="error") {
		$this->load->view('pages/internalheader', array('section'=>'internal'));		
		$this->load->view('pages/internal/'.$page);
		$this->load->view('pages/footer', array('section'=>'internal'));	
	}
	
}

/* End of file internal.php */
/* Location: ./application/controllers/internal.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
	public function index()
	{
		$this->load->library('session');
		$user = $this->session->USER;
		if (isset($user)){
			$this->load->view('home');
		}else{
			$this->load->view('login', array("loginError"=> ""));
		}
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model("Home_Model");
    }
	public function index()
	{
		$this->load->library('session');
		$user = $this->session->USER;
		if (isset($user)){
			$data = array(
				"completed_customers" => $this->Home_Model->getCompletedCustomer(),
				"not_completed_customers" => $this->Home_Model->getNotCompletedCustomer(),
			);
			$this->load->view('home', $data);
		}else{
			$this->load->view('login', array("loginError"=> ""));
		}
	}
	public function new_customer()
	{
		$customer_name = $this->input->post("customer_name");
        $device = $this->input->post("device");
        $description = $this->input->post("description");
		$data = array(
			"customer_name"=> $this->input->post("customer_name"),
			"device"=> $this->input->post("device"),
			"description"=> $this->input->post("description")
		);
		$insert = $this->Home_Model->addCustomer($data);
		if($insert){
			redirect(base_url());
		}else{
			redirect(base_url());
		}
	}
}

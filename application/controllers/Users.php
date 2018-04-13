<?php   
if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
Class Users extends CI_Controller {  
	public function __construct()
	{
		parent::__construct();
	//	$this->load->helper('url');
		$this->load->model('users_model');  
	}
    public function index(){  
        // load model gusetbook  
       // $this->load->model('users_model');  
      
        // get data  
        $data['titolo'] = 'Users';  
        $data['users'] = $this->users_model->GetUsers();  
        $data['number_users'] = count($data['users']);  
  
        // show view  
        $this->load->view('users_view', $data);  
	}  
  
    public function newuser(){  
		
		$data = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),   
			'password' => md5($this->input->post('password'))
		);
		
		$this->load->library('form_validation');   
		$this->form_validation->set_rules('username', 'username', 'trim|required|htmlspecialchars|is_unique[users.username]');   
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');  
		$this->form_validation->set_rules('password', 'Password', 'required');		
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		if($this->form_validation->run()==TRUE){  
			//$this->load->model('users_model');  
			echo json_encode(array("status" => TRUE));
			$this->users_model->AddUser($data);
		/*$this->load->model('users_model');  
			$this->users_model->AddUser(  
					$this->input->post('username'),   
					$this->input->post('email'),   
					md5($this->input->post('password'))
					);  
			*/
			//redirect('/users');  
		}else{  
			echo validation_errors();  
		}   
	}  
	public function ajax_edit()
	{
		$link_id = $this->uri->segment(3);
		//$this->load->model('users_model');  
		$data = $this->users_model->GetUsers($link_id);
		echo json_encode($data);
	}
	public function deleteUsers(){  
		$link_id = $this->uri->segment(3);
		//$this->load->model('users_model');  
		$this->users_model->DeleteUserById($link_id);  
	}
	public function updateUsers()
	{
		$data = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),   
			'password' => md5($this->input->post('password'))
		);
		$link_id =$this->input->post('user_id');
		//$this->load->model('users_model');  
		$this->users_model->update($link_id, $data);
		echo json_encode(array("status" => TRUE));
	}
}  
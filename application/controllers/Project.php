<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project extends CI_Controller
{
	public $post;
	public $form_validation;
	public $session;
	public $input;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Post_model', 'post');
	}

	public function listData()
	{
		$list = $this->post->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $value) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->title;
			$row[] = $value->description;
			$row[] = $value->content;
			$row[] = $value->is_status == 1 ? 'Active' : 'Inactive';
			$row[] = '
			
                  <a class="btn  btn-danger removeItem" data-id="' . $value->id . '" href="javascript:void(0)" title="Hapus" > Delete</a>
				  <button type="button" class="btn btn-success editItem" data-id="' . $value->id . '"  >
				  Edit
			  		</button>
				  ';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->post->count_all(),
			"recordsFiltered" => $this->post->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function index($id = NULL)
	{
		// print_r(1);
		$data['posts'] = $this->post->get_all();
		//get one
		if ($id) {

			$data['post'] = $this->post->get($id);
		}
		$this->load->view('layout/header');
		$this->load->view('project/index', $data);
		$this->load->view('layout/footer');
	}
	public function validateForm()
	{
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required');
		$this->form_validation->set_rules('is_status', 'Status', 'required');
	}
	public function create()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$this->validateForm();
		if ($this->form_validation->run() == FALSE) {
			$message = array(
				'response' => 'errors',
				'errors' => $this->form_validation->error_array()
			);
		} else {
			$ajax_data = $this->input->post();
			if ($this->post->store($ajax_data)) {
				$message = array(
					'response' => 'success',
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'content' => $this->input->post('content'),
					'is_status' => $this->input->post('is_status'),
					'message' => 'Post created successfully'
				);
			} else {
				$message = array(
					'response' => 'error',
					'message' => 'Something went wrong'
				);
			}
		}
		echo json_encode($message);
	}
	public function edit($id)
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$data = $this->post->get($id);
		echo json_encode($data);
	}
	public function update($id){
		$this->validateForm();
		if ($this->form_validation->run() == FALSE) {
			$message = array(
				'response' => 'errors',
				'errors' => $this->form_validation->error_array()
			);
		} else {
			$ajax_data = $this->input->post();
			if ($this->post->update($id, $ajax_data)) {
				$message = array(
					'response' => 'success',
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'content' => $this->input->post('content'),
					'is_status' => $this->input->post('is_status'),
					'message' => 'Post updated successfully'
				);
			} else {
				$message = array(
					'response' => 'error',
					'message' => 'Something went wrong'
				);
			}
		}
		echo json_encode($message);
	}
	public function show($id)
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$data = $this->post->get($id);
		echo json_encode($data);
	}
	public function delete($id)
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		if ($this->post->delete($id)) {
			$data = array('response' => 'success', 'message' => 'Post deleted successfully');
		} else {
			$data = array('response' => 'error', 'message' => 'Something went wrong');
		}
		echo json_encode($data);
	}
}

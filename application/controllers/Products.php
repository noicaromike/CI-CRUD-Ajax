<?php

class Products extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
        $this->load->model('Product_model');
    }
    public function index(){
        
        $this->load->view('products/index');
    }
    public function insert()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('stock', 'Stock', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			if ($this->form_validation->run() == FALSE) {
				$data = array('responce' => 'error', 'message' => validation_errors());
			} else {
				$ajax_data = $this->input->post();
				if ($this->Product_model->insert_entry($ajax_data)) {
					$data = array('responce' => 'success', 'message' => 'Record added Successfully');
				} else {
					$data = array('responce' => 'error', 'message' => 'Failed to add record');
				}
			}

			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
        $this->load->view('products/insert');
	}

    public function fetch()
	{
		if ($this->input->is_ajax_request()) {
			if ($posts = $this->Product_model->get_entries()) {
				$data = array('responce' => 'success', 'posts' => $posts);
			}else{
				$data = array('responce' => 'error', 'message' => 'Failed to fetch data');
			}
			$posts = $this->Product_model->get_entries();
			$data = array('responce' => 'success', 'posts' => $posts);
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
    public function delete()
	{
		if ($this->input->is_ajax_request()) {
			$del_id = $this->input->post('del_id');

			if ($this->Product_model->delete_entry($del_id)) {
				$data = array('responce' => 'success');
			} else {
				$data = array('responce' => 'error');
			}

			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
    public function edit()
	{
		if ($this->input->is_ajax_request()) {
			$edit_id = $this->input->post('edit_id');

			if ($post = $this->Product_model->edit_entry($edit_id)) {
				$data = array('responce' => 'success', 'post' => $post);
			} else {
				$data = array('responce' => 'error', 'message' => 'failed to fetch record');
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
    public function update()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('edit_name', 'Name', 'required');
			$this->form_validation->set_rules('edit_stock', 'Stock', 'required');
			$this->form_validation->set_rules('edit_status', 'Status', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('responce' => 'error', 'message' => validation_errors());
			} else {
				$data['id'] = $this->input->post('edit_record_id');
				$data['name'] = $this->input->post('edit_name');
				$data['stock'] = $this->input->post('edit_stock');
				$data['status'] = $this->input->post('edit_status');


				if ($this->Product_model->update_entry($data)) {
					$data = array('responce' => 'success', 'message' => 'Record update Successfully');
				} else {
					$data = array('responce' => 'error', 'message' => 'Failed to update record');
				}
			}

			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
}

?>
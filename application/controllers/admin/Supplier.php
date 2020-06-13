<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SupplierModel');
	}

	public function index()
	{
		$supplier = $this->SupplierModel->getAll();
		$data = [
			'supplier' => $supplier,
		];

        $content['body'] = $this->load->view('admin/produksi/supplier/index.php', $data, true);

		$this->load->view('admin/layout/container', $content);
	}

	public function action_insert()
	{
		$data = [
			'name' => $this->input->post('name'),
			'telephone' => $this->input->post('telephone'),
			'address' => $this->input->post('address'),
		];	

		$this->SupplierModel->insert($data);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/supplier');
	}

	public function action_edit()
	{
		$data = [
			'name' => $this->input->post('name'),
			'telephone' => $this->input->post('telephone'),
			'address' => $this->input->post('address'),
		];	

		$this->SupplierModel->update($this->input->post('id'), $data);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/supplier');
	}

	public function action_delete($id)
	{
		$this->SupplierModel->delete($id);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil dihapus'
		]);
	
		redirect('/admin/supplier');
	}
}
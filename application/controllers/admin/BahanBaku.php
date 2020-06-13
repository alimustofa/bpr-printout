<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BahanBaku extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('BahanBakuModel');
		$this->load->model('SupplierModel');
	}

	public function index()
	{
		$bahanBaku = $this->BahanBakuModel->getAll();
		$supplier = $this->SupplierModel->getAll();
		$data = [
			'bahanBaku' => $bahanBaku,
			'supplier' => $supplier,
		];

        $content['body'] = $this->load->view('admin/produksi/bahanbaku/index.php', $data, true);

		$this->load->view('admin/layout/container', $content);
	}

	public function action_insert()
	{
		#upload image
		$imageName = date("YmdHis").preg_replace('/\s/', '', $_FILES['image']['name']);
		$config['upload_path'] = './assets/uploads/bahanbaku/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['maintain_ratio'] = TRUE;
		$config['file_name'] = $imageName;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->upload->do_upload('image');

		$data = [
			'name' => $this->input->post('name'),
			'stock' => $this->input->post('stock'),
			'min_stock' => $this->input->post('min_stock'),
			'unit' => $this->input->post('unit'),
			'price' => $this->input->post('price'),
			'supplier_id' => $this->input->post('supplier_id'),
			'image' => $imageName,
		];	

		$this->BahanBakuModel->insert($data);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/bahanbaku');
	}

	public function action_edit()
	{
		$imageName = '';
		if (file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
			#upload image
			$imageName = date("YmdHis").preg_replace('/\s/', '', $_FILES['image']['name']);
			$config['upload_path'] = './assets/uploads/bahanbaku/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['maintain_ratio'] = TRUE;
			$config['file_name'] = $imageName;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('image');
		}

		$data = [
			'name' => $this->input->post('name'),
			'stock' => $this->input->post('stock'),
			'min_stock' => $this->input->post('min_stock'),
			'unit' => $this->input->post('unit'),
			'price' => $this->input->post('price'),
			'supplier_id' => $this->input->post('supplier_id'),
		];	

		if (!empty($imageName)) {
			$data['image'] = $imageName;
		}

		$this->BahanBakuModel->update($this->input->post('id'), $data);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/bahanbaku');
	}

	public function action_delete($id)
	{
		$this->BahanBakuModel->delete($id);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil dihapus'
		]);
	
		redirect('/admin/bahanbaku');
	}
}
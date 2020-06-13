<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inbound extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('BahanBakuModel');
		$this->load->model('InboundModel');
	}

	public function index()
	{
		$bahanBaku = $this->BahanBakuModel->getAll();
		$inbound = $this->InboundModel->getAll();
		$data = [
			'bahanBaku' => $bahanBaku,
			'inbound' => $inbound,
		];

        $content['body'] = $this->load->view('admin/produksi/inbound/index.php', $data, true);

		$this->load->view('admin/layout/container', $content);
	}

	public function action_insert()
	{
		$dataBahanBaku = $this->BahanBakuModel->get($this->input->post('bahan_baku_id'));
		$totalPrice = (int) $dataBahanBaku->price * (int) $this->input->post('amount');

		$data = [
			'status' => 'Pending',
			'bahan_baku_id' => $this->input->post('bahan_baku_id'),
			'amount' => $this->input->post('amount'),
			'total_price' => $totalPrice,
		];	

		$this->InboundModel->insert($data);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/inbound');
	}

	public function action_edit()
	{
		$imageName = '';
		if (file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
			#upload image
			$imageName = date("YmdHis").preg_replace('/\s/', '', $_FILES['image']['name']);
			$config['upload_path'] = './assets/uploads/faktur/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['maintain_ratio'] = TRUE;
			$config['file_name'] = $imageName;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('image');
		}

		$data = [];

		if (!empty($this->input->post('status'))) {
			$data['status'] = $this->input->post('status');
		}

		if (!empty($this->input->post('bahan_baku_id'))) {
			$data['bahan_baku_id'] = $this->input->post('bahan_baku_id');
		}

		if (!empty($this->input->post('no_faktur'))) {
			$data['no_faktur'] = $this->input->post('no_faktur');
		}

		if (!empty($imageName)) {
			$data['image_faktur'] = $imageName;
		}

		$this->InboundModel->update($this->input->post('id'), $data);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/inbound');
	}

	public function action_delete($id)
	{
		$this->InboundModel->delete($id);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil dihapus'
		]);
	
		redirect('/admin/inbound');
	}

	public function action_accept($id)
	{
		$this->InboundModel->update($id, ['status' => 'Accepted']);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/inbound');
	}

	public function action_reject($id)
	{
		$this->InboundModel->update($id, ['status' => 'Rejected']);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/inbound');
	}

	public function action_done($id)
	{
		$dataInbound = $this->InboundModel->get($id);
		$dataBahanBaku = $this->BahanBakuModel->get($dataInbound->bahan_baku_id);

		$updatedStock = (int) $dataBahanBaku->stock + (int) $dataInbound->amount;

		$this->InboundModel->update($id, ['status' => 'Done']);
		$this->BahanBakuModel->update($dataInbound->bahan_baku_id, ['stock' => $updatedStock]);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/inbound');
	}
}
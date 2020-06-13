<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Outbound extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('OutboundModel');
		$this->load->model('BahanBakuModel');
	}

	public function index()
	{
		$bahanBaku = $this->BahanBakuModel->getAll();
		$outbound = $this->OutboundModel->getAll();
		$data = [
			'bahanBaku' => $bahanBaku,
			'outbound' => $outbound,
		];

        $content['body'] = $this->load->view('admin/produksi/outbound/index.php', $data, true);

		$this->load->view('admin/layout/container', $content);
	}

	public function action_insert()
	{
		$data = [
			'amount' => $this->input->post('amount'),
			'bahan_baku_id' => $this->input->post('bahan_baku_id'),
		];	

		$dataBahanBaku = $this->BahanBakuModel->get($data['bahan_baku_id']);
		$updatedStock = (int) $dataBahanBaku->stock - (int) $data['amount'];

		$this->OutboundModel->insert($data);
		$this->BahanBakuModel->update($data['bahan_baku_id'], ['stock' => $updatedStock]);

		$this->session->set_flashdata('response', [
			'error' => false,
			'msg' => 'Data berhasil disimpan'
		]);
	
		redirect('/admin/outbound');
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('InboundModel');
		$this->load->model('OutboundModel');
		$this->load->model('BahanBakuModel');
		$this->load->model('SupplierModel');
	}

	public function index()
	{
		$supplier = count($this->SupplierModel->getAll());
		$inbound = count($this->InboundModel->getAll());
		$outbound = count($this->OutboundModel->getAll());
		$bahanBaku = count($this->BahanBakuModel->getAll());
		$data = [
			'supplier' => $supplier,
			'bahanBaku' => $bahanBaku,
			'inbound' => $inbound,
			'outbound' => $outbound,
		];

        $content['body'] = $this->load->view('admin/dashboard', $data, true);

		$this->load->view('admin/layout/container', $content);
	}
}
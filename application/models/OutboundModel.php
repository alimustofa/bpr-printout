<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OutboundModel extends CI_Model {

	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}

	public function insert($data)
	{
		return $this
			->db
			->insert('outbound', $data);
	}

	public function getAll()
	{
		$data = $this
			->db
			->query("
				select outbound.*, bahan_baku.name as bahanBakuName 
				from outbound
				inner join bahan_baku on bahan_baku.id = outbound.bahan_baku_id
				order by outbound.id desc
			")
			->result();

		return $data;
	}
}
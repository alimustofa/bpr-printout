<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InboundModel extends CI_Model {

	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}

	public function insert($data)
	{
		return $this
			->db
			->insert('inbound', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('inbound', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('inbound', [
			'is_removed' => 1
		]);
	}

	public function get($id)
	{
		$data = $this->db->query("select * from inbound where id = " . $id)->row();

		return $data;
	}

	public function getAll()
	{
		$data = $this
			->db
			->query("
				select inbound.*, supplier.name as supplierName, bahan_baku.name as bahanBakuName 
				from inbound
				inner join bahan_baku on bahan_baku.id = inbound.bahan_baku_id 
				inner join supplier on supplier.id = bahan_baku.supplier_id
				order by inbound.id desc
			")
			->result();

		return $data;
	}
}
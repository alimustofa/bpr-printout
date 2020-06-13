<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BahanBakuModel extends CI_Model {

	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}

	public function insert($data)
	{
		return $this
			->db
			->insert('bahan_baku', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('bahan_baku', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('bahan_baku', [
			'is_removed' => 1
		]);
	}

	public function get($id)
	{
		$data = $this->db->query("select * from bahan_baku where id = " . $id)->row();

		return $data;
	}

	public function getAll()
	{
		$data = $this
			->db
			->query("select bahan_baku.*, supplier.name as supplierName from bahan_baku inner join supplier on supplier.id = bahan_baku.supplier_id where bahan_baku.is_removed = 0")
			->result();

		return $data;
	}
}
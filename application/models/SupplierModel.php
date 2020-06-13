<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SupplierModel extends CI_Model {

	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}

	public function insert($data)
	{
		return $this
			->db
			->insert('supplier', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('supplier', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('supplier', [
			'is_removed' => 1
		]);
	}

	public function getAll()
	{
		$data = $this
			->db
			->get_where('supplier', [
				'is_removed' => 0
			])
			->result();

		return $data;
	}
}
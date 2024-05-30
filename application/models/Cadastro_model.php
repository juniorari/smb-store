<?php

class Cadastro_model extends CI_Model
{
//	/** @var CI_DB_query_builder */
//	protected $db;
	public function buscaTodos()
	{
		$order = $this->input->get('order') ?? 'id';
		$this->db->order_by($order, 'ASC');
		$query = $this->db->get('cadastro');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function adicionaCadastro($data)
	{
		return $this->db->insert('cadastro', $data);
	}

	public function atualizaCadastro($id, $field)
	{
		$this->db->trans_start();

		try {
			$this->db->select('foto');
			$this->db->from('cadastro');
			$this->db->where('id', $id);
			$row = $this->db->get();
			$fotoAnt = '';
			if ($row->num_rows() > 0) {
				$fotoAnt = $row->row()->foto;
			}

			$this->db->where('id', $id);
			$this->db->update('cadastro', $field);
			if ($this->db->affected_rows() > 0) {
				if (isset($field['foto']) && $fotoAnt && ($field['foto'] != $fotoAnt)) {
					$delete = FCPATH . $fotoAnt;
					unlink($delete);
				}
				$this->db->trans_complete();
				return true;
			}

		} catch (Exception $e) {
		}


		$this->db->trans_rollback();
		return false;
	}

	public function removeCadastro($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cadastro');
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}

	}

	public function searchCadastro($match)
	{
		$field = array('nome', 'sobrenome', 'sexo', 'nascimento', 'email', 'fone', 'foto');
		$this->db->like('concat(' . implode(',', $field) . ')', $match);
		$query = $this->db->get('cadastro');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}

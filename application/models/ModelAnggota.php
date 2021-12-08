<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ModelAnggota extends CI_Model
{
    //manajemen buku
    public function getAnggota()
    {
        $this->db->where('role_id',2);
        return $this->db->get('user');
    }

    public function anggotaWhere($where)
    {
        return $this->db->get_where('user', $where);
    }

    public function simpanAnggota($data = null)
    {
        $this->db->insert('user', $data);
    }

    public function updateAnggota($data = null, $where = null)
    {
        $this->db->update('user', $data, $where);
    }

    public function hapusAnggota($where = null)
    {
        $this->db->delete('user', $where);
    }

    public function total($field, $where)
    {
        $this->db->select_sum($field);
        if (!empty($where) && count($where) > 0) {
            $this->db->where($where);
        }
        $this->db->from('user');
        return $this->db->get()->row($field);
    }

    //manajemen kategori
    public function getKategori()
    {
        return $this->db->get('kategori');
    }

    public function kategoriWhere($where)
    {
        return $this->db->get_where('kategori', $where);
    }

    public function simpanKategori($data = null)
    {
        $this->db->insert('kategori', $data);
    }

    public function getLimitAnggota()
    {
        $this->db->limit(5);
        return $this->db->get('user');
    }  
}

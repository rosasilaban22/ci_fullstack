<?php
class mProduk extends CI_Model {
    public function getData() {
        $this->db->select('p.*, k.nama_kategori, s.nama_satuan');
        $this->db->from('tbl_m_produk p');
        $this->db->join('tbl_m_kategori k', 'p.id_kategori = k.id_kategori');
        $this->db->join('tbl_m_satuan s', 'p.id_satuan = s.id_satuan');
        return $this->db->get()->result();
    }

    public function insertData($data) {
        return $this->db->insert('tbl_m_produk', $data);
    }

    // Menampilkan Data berdasarkan ID (Read)
    public function getDataById($id) {
        $this->db->where('id_produk', $id);
        return $this->db->get('tbl_m_produk')->row();
    }

    // Update Data berdasarkan ID (Update)
    public function updateData($id, $data) {
        $this->db->where('id_produk', $id);
        return $this->db->update('tbl_m_produk', $data);
    }

    // Menghapus data berdasarkan ID (Delete)
    public function deleteData($id) {
        $this->db->where('id_produk', $id);
        return $this->db->delete('tbl_m_produk');
    }

    // Validasi Data Duplikat
    public function cekDuplicate($kategori) {
        $this->db->where('nama_produk', $kategori);
        $query = $this->db->get('tbl_m_produk');
        return $query->num_rows();
    }

    // Membuat Kode Barang otomatis berdasarkan kategori
    public function getCode($id_kategori) {
        $query = $this->db->query("SELECT MAX(RIGHT(id_produk,6)) AS kd_max FROM tbl_m_produk WHERE id_kategori='$id_kategori'");
        $isCode = "";
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $isCode = sprintf("%06s", $tmp);
            }
        } else {
            $isCode = "000001";
        }
        return $id_kategori . $isCode;
}
}
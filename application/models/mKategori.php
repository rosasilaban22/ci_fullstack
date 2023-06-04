<?php
class mKategori extends CI_Model {

    public function getData() {
        return $this->db->get('tbl_m_kategori')->result();
    }

    // Menambahkan data (Create)
    public function insertData($data) {
        return $this->db->insert('tbl_m_kategori', $data);
    }

    // Untuk menampilkan data berdasarkan id (Read)
    public function getDataById($id) {
        $this->db->where('id_kategori', $id);
        return $this->db->get('tbl_m_kategori')->row();
    }

    // Update data berdasarkan id (Update)
    public function updateData($id, $data) {
        $this->db->where('id_kategori', $id);
        return $this->db->update('tbl_m_kategori', $data);
    }

    // Menghapus data berdasarkan id (Delete)
    public function deleteData($id) {
        $this->db->where('id_kategori', $id);
        return $this->db->delete('tbl_m_kategori');
    }

    // Validasi data duplikat
    public function cekDuplicate($kategori) {
        $this->db->where('nama_kategori', $kategori);
        $query = $this->db->get('tbl_m_kategori');
        return $query->num_rows();
    }

}

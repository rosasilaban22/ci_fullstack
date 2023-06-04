<?php
class mSatuan extends CI_Model {

    public function getData() {
        return $this->db->get('tbl_m_satuan')->result();
    }

    // Menambahkan data (Create)
    public function insertData($data) {
        return $this->db->insert('tbl_m_satuan', $data);
    }

    // Untuk menampilkan data berdasarkan id (Read)
    public function getDataById($id) {
        $this->db->where('id_satuan', $id);
        return $this->db->get('tbl_m_satuan')->row();
    }

    // Update data berdasarkan id (Update)
    public function updateData($id, $data) {
        $this->db->where('id_satuan', $id);
        return $this->db->update('tbl_m_satuan', $data);
    }
    // Menghapus data berdasarkan id (Delete)
    public function deleteData($id) {
        $this->db->where('id_satuan', $id);
        return $this->db->delete('tbl_m_satuan');
    }

    // Validasi data duplikat
    public function cekDuplicate($satuan) {
        $this->db->where('nama_satuan', $satuan);
        $query = $this->db->get('tbl_m_satuan');
        return $query->num_rows();
    }

}

<?php
class Kategori extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('mKategori');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['page'] = "Kategori";
        $data['judul'] = "Data Kategori";
        $data['deskripsi'] = "Manage Data Kategori";
        $data['data'] = $this->mKategori->getData();
        $this->template->views('view_kategori', $data);
    }

    public function tambahData() {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');
        if ($this->form_validation->run() == FALSE) {
            $response = array('response' => 'error', 'message' => validation_errors());
        } else {
            $nama_kategori = $this->input->post('nama_kategori');
            $validData = $this->mKategori->cekDuplicate($nama_kategori);
            if ($validData >= 1) {
                $response = array('response' => 'error', 'message' => 'Nama Kategori Barang Sudah Terdaftar..');
            } else {
                $data = ['nama_kategori' => $nama_kategori];
                if ($this->mKategori->insertData($data)) {
                    $response = array('response' => 'success', 'message' => 'Record added Successfully');
                } else {
                    $response = array('response' => 'error', 'message' => 'Terjadi Kesalahan, Data GAGAL di Simpan');
                }
            }
        }
        echo json_encode($response);
    }

    public function perbaruiData() {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');
        $this->form_validation->set_rules('id_kategori', 'ID Kategori', 'required');
        if ($this->form_validation->run() == FALSE) {
            $response = array('response' => 'error', 'message' => validation_errors());
        } else {
            $nama_kategori = $this->input->post('nama_kategori');
            $id_kategori = $this->input->post('id_kategori');
            $validData = $this->mKategori->cekDuplicate($nama_kategori);
            if ($validData >= 1) {
                $response = array('response' => 'error', 'message' => 'Nama Kategori Barang Sudah Terdaftar..');
            } else {
                $data = ['nama_kategori' => $nama_kategori];
                if ($this->mKategori->updateData($id_kategori, $data)) {
                    $response = array('response' => 'success', 'message' => 'Record update Successfully');
                } else {
                    $response = array('response' => 'error', 'message' => 'Terjadi Kesalahan, Data GAGAL di Simpan');
                }
            }
        }
        echo json_encode($response);
    }

    public function tampilkanData() {
        $data = $this->mKategori->getData();
        echo json_encode($data);
    }

    public function tampilkanDataByID() {
        $id_kategori = $this->input->post('id_kategori');
        $data = $this->mKategori->getDataById($id_kategori);
        echo json_encode($data);
    }

    public function hapusData() {
        if ($this->input->is_ajax_request()) {
            $id_kategori = $this->input->post('id_kategori');
            if ($this->mKategori->deleteData($id_kategori)) {
                $response = array('response' => 'success', 'message' => 'Record deleted Successfully');
            } else {
          $response = array('response' => 'error', 'message' => 'Terjadi Kesalahan, Data GAGAL di Hapus');
            }
 

 echo json_encode($response);
        } else {
            redirect('kategori');
        }
    }
}
<?php
class Satuan extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('mSatuan');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['page'] = "Satuan";
        $data['judul'] = "Data Satuan";
        $data['deskripsi'] = "Manage Data Satuan";
        $data['data'] = $this->mSatuan->getData();
        $this->template->views('view_satuan', $data);
    }

    public function tambahData() {
        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required');
        if ($this->form_validation->run() == FALSE) {
            $response = array('response' => 'error', 'message' => validation_errors());
        } else {
            $nama_satuan = $this->input->post('nama_satuan');
            $validData = $this->mSatuan->cekDuplicate($nama_satuan);
            if ($validData >= 1) {
                $response = array('response' => 'error', 'message' => 'Nama Satuan Barang Sudah Terdaftar..');
            } else {
                $data = ['nama_satuan' => $nama_satuan];
                if ($this->mSatuan->insertData($data)) {
                    $response = array('response' => 'success', 'message' => 'Record added Successfully');
                } else {
                    $response = array('response' => 'error', 'message' => 'Terjadi Kesalahan, Data GAGAL di Simpan');
                }
            }
        }
        echo json_encode($response);
    }

    public function perbaruiData() {
        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required');
        $this->form_validation->set_rules('id_satuan', 'ID Satuan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $response = array('responce' => 'error', 'message' => validation_errors());
        } else {
            $nama_satuan = $this->input->post('nama_satuan');
            $id_satuan = $this->input->post('id_satuan');

            $validData = $this->mSatuan->cekDuplicate($nama_satuan);
            if ($validData >= 1) {
                $response = array('responce' => 'error', 'message' => 'Nama Satuan Barang Sudah Terdaftar..');
            } else {
                $data = ['nama_satuan' => $nama_satuan];
                if ($this->mSatuan->updateData($id_satuan, $data)) {
                    $response = array('response' => 'success', 'message' => 'Record update Successfully');
                } else {
                    $response = array('response' => 'error', 'message' => 'Terjadi Kesalahan, Data GAGAL di Simpan');
                }
            }
        }
        echo json_encode($response);
    }

    public function tampilkanData() {
        $data = $this->mSatuan->getData();
        echo json_encode($data);
    }

    public function tampilkanDataByID() {
        $id_satuan = $this->input->post('id_satuan');
        $data = $this->mSatuan->getDataById($id_satuan);
        echo json_encode($data);
    }

    public function hapusData() {
        if ($this->input->is_ajax_request()) {
            $id_satuan = $this->input->post('id_satuan');
            if ($this->mSatuan->deleteData($id_satuan)) {
                $response = array('response' => 'success', 'message' => 'Record deleted Successfully');
            } else {
          $response = array('response' => 'error', 'message' => 'Terjadi Kesalahan, Data GAGAL di Hapus');
            }
 

 echo json_encode($response);
        } else {
            redirect('satuan');
        }
    }
}
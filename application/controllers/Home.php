<?php
class Home extends CI_Controller
{
    public function index()
    {
        $this->load->view('home');
        $data['page'] = "home";
        $data['judul'] = "Beranda";
        $data['deskripsi'] = "full stack web developmemt";
        $this->template->views('home', $data);
    }
}
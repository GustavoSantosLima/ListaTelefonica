<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Sistema_Model');
    }

    public function index(){
        $this->load->view('index');
    }

    public function contatos(){
        $result = $this->Sistema_Model->get_contatos()->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function operadoras(){
        $result = $this->Sistema_Model->get_operadoras()->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}

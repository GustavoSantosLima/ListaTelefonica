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
        if(file_get_contents('php://input') != NULL){
            $dados = file_get_contents('php://input');
            echo "<pre>";
            print_r($dados[0]->nome);
            echo "</pre>";
//            $contato = array(
//                $dados->nome,
//                $dados->telefone,
//                intval($dados->operadora)
//            );
            $this->Sistema_Model->add_contato($contato);
        }else{
            $data = $this->Sistema_Model->get_contatos();
            foreach($data as $i => $item){
                $result[$i] = (object)[
                    'id' => $item->id,
                    'nome' => $item->nome,
                    'telefone' => $item->telefone,
                    'operadora' => array(
                        'name' => $item->name,
                        'codigo' => $item->codigo,
                        'categoria' => $item->categoria
                    )
                ];
            };

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    public function operadoras(){
        $result = $this->Sistema_Model->get_operadoras()->result();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}

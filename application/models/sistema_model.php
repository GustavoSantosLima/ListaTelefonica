<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Sistema_Model extends CI_Model {

        function __construct(){
            parent::__construct();
        }

        function get_contatos(){
            $this->db->select('*');
            $this->db->join('operadoras as op', 'op.id = ctt.operadoraId');
            $this->db->from('contatos as ctt');
            return $this->db->get()->result();
        }

        function add_contato($data = NULL){
            if($data != NULL) {
                $this->db->insert('contatos', $data);
            }else{
                echo "erro";
            }
        }

        function get_operadoras(){
            return $this->db->get('operadoras');
        }
    }
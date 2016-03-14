<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Sistema_Model extends CI_Model {

        function __construct(){
            parent::__construct();
        }

//        function add($data){
//            $this->db->insert('tabela_webmeetings', $data);
//        }
//
        function get_contatos(){
            return $this->db->get('contatos');
        }

        function get_operadoras(){
            return $this->db->get('operadoras');
        }
    }
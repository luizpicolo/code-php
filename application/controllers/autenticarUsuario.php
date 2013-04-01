<?php

/**
 * AutenticaController é o controlador para o promover a autenticação do usuário.
 * 
 * @author Luiz Picolo <luizpicolo@ibest.com.br>
 * @version 0.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright 2013, Sistema para Gestão de ALunos* (http://www.luizpicolo.com.br/)
 * 
 * Documentação do Framework Codeigniter
 * @see http://ellislab.com/codeigniter/user-guide/index.html
 */

// Verifica se o BASEPATH está definido, caso contrário não carrega o controlador
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AutenticarUsuario extends CI_Controller
{
    private $usuario;
    private $senha;
    private $dadosAutenticados;

    /**
     * Seta o usuario
     * @param String
     * @return NULL
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Seta a senha
     * @param String
     * @return NULL
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * Retorno da autenticacao do usuario
     * @return boolean
     */
    public function getDadosAutenticados()
    {
        $this->autenticaUsuario();
        return $this->dadosAutenticados;
    }

    /**
     * @return Boolean
     */
    private function autenticaUsuario()
    {
        // Verica se o usuário e senha foram digitados
        if ($this->usuario && $this->senha)
        {
            // Parâmetros para a busca do usuário mediante os dados passados
            $parametros = array(
                "select" => "*",
                "table" => "usuarios",
                "where" => array("status" => "1", "usuario" => md5($this->anti_injection($this->usuario)), "senha" => md5($this->anti_injection($this->senha))),
                "order_by" => "",
                "like" => "",
                "limit" => "",
                "group_by" => "",
                "join" => ""
            );

            // Carrega a classe de transação de dados
            $this->load->model("crud");
            $dados = $this->crud->select($parametros);
            
            if ($dados)
            {
                $array = array(
                    'id' => $dados[0]->id,
                    'dataAcesso' => date("Y-m-d H:i:s")
                );
                
                $this->crud->update("usuarios", "id", $array);
                $this->dadosAutenticados = $dados;
            }
        }
    }
    
    // remove palavras que contenham sintaxe sql
    private function anti_injection($sqlinj)
    {
        $sqlinj = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|hi|'|´|\*|--|\\\\)/i", '', $sqlinj);
        $sqlinj = trim($sqlinj); //limpa espaços vazio
        $sqlinj = strip_tags($sqlinj); //tira tags html e php
        return $sqlinj;
    }
}


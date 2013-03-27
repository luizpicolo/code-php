<?php

/**
 * LoginEscolarController é o controlador para efetuar o login do usuário
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

class LoginController extends CI_Controller {

    /**
     * Método construtor 
     */
    public function index()
    {
        $this->load->view('login');
    }

    public function autenticacao()
    {
        // Classe para a autenticação
        // @pach /application/controller/autenticarUsuario.php
        require 'autenticarUsuario.php';

        $AutenticarUsuario = new AutenticarUsuario();
        $AutenticarUsuario->setEmail($_POST['email']);
        $AutenticarUsuario->setSenha($_POST['senha']);
        $dados = $AutenticarUsuario->getDadosAutenticados();

        if ($dados)
        {
            $array = array(
                'id' => $dados[0]->id,
                'nome' => $dados[0]->nome,
                'nivel' => $dados[0]->nivel,
                'logado' => true
            );

            $this->session->set_userdata($array);
            
            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/".$dados[0]->nome."/"); 
            $logs->write_log('info', "O usuário ". $dados[0]->nome . " logou no sistema");
                                   
            print "<script>window.location = '" . base_url() . "index.php/principal'</script>";
        }
        else
        {
            echo '<br><div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Alerta!</strong> Usuário ou senha não cadastrados.
                  </div>';
        }
    }

}
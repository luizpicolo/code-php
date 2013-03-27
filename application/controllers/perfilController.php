<?php

/**
 *  PerfilController é o controlador para o gerenciamento dos dados dos usuarios.
 * Aqui o usuário pode trocar sua senha e outras informações relevantes
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

class PerfilController extends CI_Controller {

    // Aqui é feito a reescrita da classe construtora e a verificação
    // da autenticidade do usuário
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logado'))
        {
            redirect('', 'refresh');
        }
    }

    /**
     * Método invocado depois do método construtor 
     */
    public function index()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de atualizacao de dados de seu perfil");

        $this->load->view('principal');
    }

    /*
      Método para chamar a pagina de atualização
      Aqui são recebidos os dados e atulizados
     */

    public function atualizar()
    {
        $data = array(
            "pagina" => "perfilAtualizar"
        );

        $this->load->model("crud");

        $parametros = array(
            "select" => "*",
            "table" => "usuarios",
            "where" => array("id" => $this->session->userdata('id')),
            "order_by" => "",
            "limit" => "",
        );

        $data['dados'] = $this->crud->select($parametros);

        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de atualizacao de dados de seu perfil");

        $this->load->view('principal', $data);
    }

}
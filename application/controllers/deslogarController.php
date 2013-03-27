<?php

/**
 * DeslogarController é o controlador para deslogar o usuário
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
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Classe principal.
 * Esta será chamada quando o sistema for carregada a primeira vez
 */

class DeslogarController extends CI_Controller
{
    public function index()
    {
    	// Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario deslogou do sistema");

    	// Destroi a sessão vigente e enviao o usuário para a tela de login
        $this->session->sess_destroy();
        print "<script>self.location = '" . base_url() . "index.php'</script>";
    }

}

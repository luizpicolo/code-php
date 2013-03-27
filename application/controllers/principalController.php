<?php

/**
 *  PrincipalController é o controlador principal do sistema.
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

class PrincipalController extends CI_Controller
{
    
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
        // Página que contem o formulário de cadastro
        $data['pagina'] = 'inicio';
        
        $this->load->view('principal', $data);
    }

}
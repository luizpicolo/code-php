<?php

/**
 * UsuarioController é o controlador para o gerenciamento dos usuário
 * Aqui são, cadastrados, listados, excluidos e atualizados.
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

class UsuariosController extends CI_Controller {

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
        $this->load->view('principal');
    }

    /*
      Metodo para chamar a pagina de cadastro
     */

    public function cadastrar()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de cadastro de usuarios");

        $data['pagina'] = 'usuariosCadastrar';
        $this->load->view("principal", $data);
    }

    /*
      Método para chamar a pagina de atualização de dados
     */

    public function atualizar($id)
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de atualizacao de usuarios");


        $data['pagina'] = 'usuariosAtualizar';

        $this->load->model("crud");

        $parametros = array(
            "select" => "*",
            "table" => "usuarios",
            "where" => array("id" => $id),
        );

        $data['dados'] = $this->crud->select($parametros);

        $this->load->view('principal', $data);
    }

    /*
      Metodo para listar os dados
     */

    public function gerenciar()
    {
        // Redireciona URL para a busca
        if ($_POST["busca"])
        {
            redirect('usuarios/gerenciar/' . strtolower(url_title(convert_accented_characters($_POST["busca"]))), 'refresh');
        }

        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de listagem de usuarios");


        // Quantidade de registro a serem mostrados por páginma
        $qtd = 10;

        /**
         * Bibliotecas e ajudantes carregados
         * @filesource system/libraries/pagination.php
         * @filesource application/model/crud.php
         */
        $this->load->library('pagination');
        $this->load->model("crud");

        $data['pagina'] = 'usuariosGerenciar';

        /**
         * Dados passados por Get, para busca
         * Se o segmento 3 existir, o mesmo será passado àos parãmetros
         */
        if ($this->uri->segment(3) == "null")
        {
            $dadosBusca = null;
        }
        else
        {
            $dadosBusca = $this->uri->segment(3);
        }

        /**
         * Dados passados por Get, para gerar a paginação
         * Se o segmento 4 existir, o mesmo será passado àos parãmetros
         */
        if ($this->uri->segment(4) == "")
        {
            $inicio = 0;
        }
        else
        {
            $inicio = $this->uri->segment(4);
        }

        /*
         * Parâmetros para a busca e retorno dos 
         * dados
         */
        if ($this->uri->segment(3) != "null")
        {
            $parametros = array(
                "select" => "*",
                "table" => "usuarios",
                "where" => "",
                "like" => array("nome" => str_replace("-", " ", $this->uri->segment(3))),
                "limit" => "$qtd, $inicio"
            );
        }
        else
        {
            $parametros = array(
                "select" => "*",
                "table" => "usuarios",
                "where" => "",
                "limit" => "$qtd, $inicio"
            );
        }

        // Metodo para selecionar e retornar os dados 
        // mediante os parametros passados
        $dados = $this->crud->select($parametros, false);

        // Parâmetros para a biblioteca de paginação
        $config['base_url'] = base_url() . "index.php/" . $this->uri->segment(1) . "/" . $this->uri->segment(2) . "/" . $this->uri->segment(3) . "/";
        $config['total_rows'] = count($dados);
        $config['uri_segment'] = 4;
        $config['per_page'] = $qtd;
        $config['first_tag_open'] = '<li>';
        $config['first_link'] = '<<';
        $config['first_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='marcado'><a href='javascript:void(0)'>";
        $config['cur_tag_close'] = '</a></li>';
        $config['last_tag_open'] = '<li>';
        $config['last_link'] = '>>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_link'] = '>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_link'] = '<';
        $config['prev_tag_close'] = '</li>';
        $config['full_tag_open'] = '<div class="pagination pagination-right"><ul>';
        $config['full_tag_close'] = '</ul></div>  ';
        $this->pagination->initialize($config);
        $data['paginacao'] = $this->pagination->create_links();
        $data['dadosbusca'] = $dados;

        $this->load->view("principal", $data);
    }

    public function cadastrarDadosUsuario()
    {
        // Comparar se as senhas são iguais
        if ($_POST['senha'] != $_POST['repetirSenha'] && count($_POST['repetirSenha']) < 6)
        {
            echo '<div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Alerta!</strong> Suas senhas não são iguais ou contém menos de 6 dígitos.
                  </div>';
            exit;
        }

        // Organizar array contendo os dados do usuário
        $dados = array(
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha' => md5($_POST['senha']),
            'nivel' => $_POST['nivel'],
            'dataCadastro' => date("Y-m-s H:i:s"),
            'dataAcesso' => date("Y-m-s H:i:s"),
            'status' => 1
        );

        $this->load->model("crud");
        $retorno = $this->crud->insert("usuarios", $dados);
        if ($retorno)
        {
            // Mensagem de erro para cadastro duplicado
            if ((int) $retorno == 1062)
            {
                echo '<div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Alerta!</strong> Usuário já cadastrado no sistema. Por favor, cadastre um usuário diferente.
                      </div>';
                exit;
            }

            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
            $logs->write_log('info', "O usuario cadastrou um novo usuário com o nome: " . $_POST['nome']);

            echo '<br><div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Sucesso!</strong> Usuário cadastrado com sucesso.
                  </div>';
            echo '<script>$("#form").resetForm();</script>';
        }
    }

    public function atualizarDadosUsuario()
    {
        $this->load->model("crud");

        // Comparar se as senhas são iguais
        if ($_POST['senha'] != $_POST['repetirSenha'] && count($_POST['repetirSenha']) < 6)
        {
            echo '<div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Alerta!</strong> Suas senhas não são iguais ou contém menos de 6 dígitos.
                  </div>';
            exit;
        }

        if ($_POST['senha'])
        {
            $array = array(
                'id' => $_POST['id'],
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => md5($_POST['senha'])
            );
        }
        else
        {
            $array = array(
                'id' => $_POST['id'],
                'nome' => $_POST['nome'],
                'email' => $_POST['email']
            );
        }
        
        $retorno = $this->crud->update("usuarios", "id", $array);
        if ($retorno)
        {
            // Mensagem de erro para cadastro duplicado
            if ((int) $retorno == 1062)
            {
                echo '<div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Alerta!</strong> Usuário já cadastrado no sistema. Por favor, cadastre um usuário diferente.
                      </div>';
                exit;
            }

            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
            $logs->write_log('info', "O usuario atualizou os dados do usuário: " . $_POST['nome']);

            echo '<br><div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Sucesso!</strong> Usuário atualizado com sucesso.
                  </div>';
        }
    }

    /**
     * Método para excluir os dados do alunos
     * @access Administrador
     */
    public function excluir($id)
    {
        if ($id == $this->session->userdata('id'))
        {
            $mensagem = array(
                'mensagem' => '<br><div class="alert">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <strong>Alerta!</strong> Você não pode excluir seu próprio usuário.
                           </div>'
            );
        }
        else
        {

            /**
             * Bibliotecas e ajudantes carregados
             * @filesource application/model/crud.php
             */
            $this->load->model("crud");

            /**
             * Somente administradores podem excluir os dados dos alunos
             */
            if (!$this->session->userdata('nivel') == 1)
            {
                exit;
            }

            /*
             * Descriptografa o id
             */
            $retorno = $this->crud->delete("usuarios", "id", array("id" => $id));

            if ((int) $retorno == 1451)
            {
                $mensagem = array(
                    'mensagem' => '<br><div class="alert alert-error">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                               <strong>Erro!</strong> Usuário não pode ser excluido pois esta vinculado a ocorrências ou desempenhos escolares cadastrados. Utilize a função "ativo ou inativo" para impedir o acesso deste usuário.
                               </div>'
                );
            }
            else if ($retorno == true)
            {
                // Gerar Logs
                $this->load->library('my_log');
                $logs = new MY_Log();
                $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
                $logs->write_log('info', "O usuario excluiu um usuário com ID: " . $id);

                $mensagem = array(
                    'mensagem' => '<br><div class="alert alert-success">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                               <strong>Sucesso!</strong> Usuário excluido com sucesso.
                               </div>'
                );
            }
        }

        // Sessão para mensagem
        $this->session->set_userdata($mensagem);
        redirect('usuarios/gerenciar/null', 'refresh');
    }

    public function status($id, $tipo)
    {
        if ($id == $this->session->userdata('id'))
        {
            $mensagem = array(
                'mensagem' => '<br><div class="alert">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <strong>Alerta!</strong> Você não pode desativar seu próprio usuário.
                           </div>'
            );
        }
        else
        {

            /**
             * Bibliotecas e ajudantes carregados
             * @filesource application/model/crud.php
             */
            $this->load->model("crud");

            if ($tipo == 1)
            {
                $status = 2;
            }
            else
            {
                $status = 1;
            }

            /*
             * Descriptografa o id
             */
            $this->crud->update("usuarios", "id", array("id" => $id, "status" => $status));

            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
            $logs->write_log('info', "O usuario mudou o status do usuário com ID: " . $id);

            $mensagem = array(
                'mensagem' => '<br><div class="alert alert-success">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <strong>Sucesso!</strong> Status atualizado.
                           </div>'
            );
        }

        // Sessão para mensagem
        $this->session->set_userdata($mensagem);
        redirect('usuarios/gerenciar/null', 'refresh');
    }

}
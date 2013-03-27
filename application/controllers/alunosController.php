<?php

/**
 * AlunosController é o controlador para o gerenciamento dos dados dos alunos.
 * Aqui são feitas os cadastros, edições e exclusões dos dados cadastrados.
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

class AlunosController extends CI_Controller {

    /**
     * Método construtor
     * 
     * Aqui são carregadas algumas configurações do Framework
     * A razão para esta linha é necessário é porque seu construtor local irá 
     * sobrepor um na classe controller pai então precisamos chamá-la manualmente.
     * 
     * @see http://ellislab.com/codeigniter/user-guide/general/controllers.html#constructors
     */
    public function __construct()
    {
        parent::__construct();

        /**
         * Verifa se o usuário está logado
         * Caso não esteja logado, direciona o usuário para á página de login
         */
        if (!$this->session->userdata('logado'))
        {
            redirect('', 'refresh');
        }
    }

    /**
     * Este é o segundo método chamado após o Construtor
     * Aqui é carregada a página inicial do controlador
     * @return void
     */
    public function index()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou o cadastre de alunos");

        $this->load->view('principal');
    }

    /**
     * Metodo invocado ao se acessar a pagina de cadastro
     * @example www.site.com.br/alunos/cadastrar
     */
    public function cadastrar()
    {
        // Página que contem o formulário de cadastro
        $data['pagina'] = 'alunosCadastrar';

        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou o cadastro de alunos");

        $this->load->view('principal', $data);
    }

    /**
     * Metodo invocado ao se acessar a pagina de atualização
     * @example www.site.com.br/alunos/editar
     */
    public function atualizar($id)
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de atualização dos dados dos alunos");

        // Pagina com o formulario para atualização
        $data['pagina'] = 'alunosAtualizar';

        $this->load->model("crud");

        $parametros = array(
            "select" => "*, DATE_FORMAT(dataMatricula,'%d/%m/%Y') as dataMatricula, DATE_FORMAT(dataTerminoEstudos,'%d/%m/%Y') as dataTerminoEstudos",
            "table" => "alunos",
            "where" => array("id" => $id),
        );

        $data['dados'] = $this->crud->select($parametros, false);

        $this->load->view('principal', $data);
    }

    /**
     * Metodo para cadastrar os dados do Aluno
     */
    public function cadastrarDadosAluno()
    {
        if (formata_data($_POST['dataMatricula'], 1) > formata_data($_POST['dataTerminoEstudos'], 1))
        {
            echo '<div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> A data de matrícula é maior que a data do término dos estudos.
                  </div>';
            exit;
        }

        /**
         * Bibliotecas e ajudantes carregados
         * @filesource applicatin/model/crud.php
         */
        $this->load->model("crud");
        
        // Upload imagem
        if ($_FILES['file']['name'])
        {
            // Uploads de arquivos, configurações
            $config['upload_path'] = 'assets/fotosAlunos/';
            $config['allowed_types'] = "jpg";
            $config['max_size'] = 0;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['overwrite'] = false;
            $config['encrypt_name'] = true;
            $config['file_name'] = 2;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file'))
            {
                echo '<div class="alert alert-error">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Alerta!</strong> '.utf8_encode($this->upload->display_errors()).'.
                      </div>';
                exit;
            }
            else
            {
                // Armazena os dados de retorno
                $imagem = $this->upload->data();
            }
        }

        /**
         * Vetor contendo os dados a serem cadastrados no banco de dados
         * @example array = {"Filds" => "dados"}
         * Filds = Campo contido nas tabelas
         */
        $dadosAluno = array(
            "aluno" => $_POST['aluno'],
            "responsavel" => $_POST['responsavel'],
            "contatoResponsavel" => $_POST['contatoResponsavel'],
            "dataMatricula" => formata_data($_POST['dataMatricula'], 1),
            "dataTerminoEstudos" => formata_data($_POST['dataTerminoEstudos'], 1),
            "foto" => $imagem['file_name']
        );

        /**
         * Insere os dados na tabela aluno
         */
        $retorno = $this->crud->insert("alunos", $dadosAluno);
        if ($retorno)
        {
            // Mensagem de erro para cadastro duplicado
            if ((int) $retorno == 1062)
            {
                echo '<div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Alerta!</strong> Aluno já cadastrado no sistema. Por favor, cadastre um aluno diferente.
                      </div>';
                exit;
            }

            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
            $logs->write_log('info', "O usuario cadastrou o aluno: " . $_POST['aluno']);

            echo '<div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Sucesso!</strong> Aluno cadastrado com Sucesso.
                  </div>';
            echo '<script>$("#form").resetForm();</script>';
        }
        else
        {
            echo '<div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> Dados não cadastrados. Tente Novamente.
                  </div>';
        }
    }

    /**
     * Metdo para lista os usuários
     */
    public function gerenciar()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a área para a listagem dos dados dos alunos");

        // Redireciona URL para a busca
        if ($_POST["busca"])
        {
            redirect('alunos/gerenciar/' . strtolower(url_title(convert_accented_characters($_POST["busca"]))), 'refresh');
        }

        // Quantidade de registro a serem mostrados por páginma
        $qtd = 10;

        /**
         * Bibliotecas e ajudantes carregados
         * @filesource system/libraries/pagination.php
         * @filesource application/model/crud.php
         */
        $this->load->library('pagination');
        $this->load->model("crud");

        $data['pagina'] = 'alunosGerenciar';

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
                "table" => "alunos",
                "where" => "",
                "like" => array("aluno" => str_replace("-", " ", $this->uri->segment(3))),
                "limit" => "$qtd, $inicio"
            );
        }
        else
        {
            $parametros = array(
                "select" => "*",
                "table" => "alunos",
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

    /**
     * Metodo para cadastrar os dados do Aluno
     */
    public function atualizarDadosAluno()
    {
        /**
         * Bibliotecas e ajudantes carregados
         * @filesource applicatin/model/crud.php
         */
        $this->load->model("crud");
        
        // Seleciona dados para retornar o nome da imagem já cadastrada
        // Esse procedimento é neceessário para não gerar duplicidade ou imagens
        // não utilizadas no repositório de cadastro de imagens
        $parametros = array (
                "select" => "foto",
                "table" => "alunos",
                "where" => array("id"=>$_POST['id']),
                "like" => "",
                "limit" => ""
        );
        
        $retorno = $this->crud->select($parametros);
        $imagem = explode(".", $retorno[0]->foto);
        
        // Upload imagem
        if ($_FILES['file']['name'])
        {
            // Uploads de arquivos, configurações
            $config['upload_path'] = 'assets/fotosAlunos/';
            $config['allowed_types'] = "jpg";
            $config['max_size'] = 0;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['overwrite'] = true;
            //$config['encrypt_name'] = false;
            $config['file_name'] = $imagem[0];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file'))
            {
                echo '<div class="alert alert-error">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Alerta!</strong> '.utf8_encode($this->upload->display_errors()).'.
                      </div>';
                exit;
            }
            else
            {
                // Armazena os dados de retorno
                $imagem = $this->upload->data();
            }
        }

        /**
         * Vetor contendo os dados a serem cadastrados no banco de dados
         * @example array = {"Filds" => "dados"}
         * Filds = Campo contido nas tabelas
         */
        $dadosAluno = array(
            "id" => $_POST['id'],
            "aluno" => $_POST['aluno'],
            "responsavel" => $_POST['responsavel'],
            "contatoResponsavel" => $_POST['contatoResponsavel'],
            "dataMatricula" => formata_data($_POST['dataMatricula'], 1),
            "dataTerminoEstudos" => formata_data($_POST['dataTerminoEstudos'], 1)
        );

        /**
         * Insere os dados na tabela aluno
         */
        $retorno = $this->crud->update("alunos", "id", $dadosAluno);
        if ($retorno)
        {
            // Mensagem de erro para cadastro duplicado
            if ((int) $retorno == 1062)
            {
                echo '<div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Alerta!</strong> Aluno já cadastrado no sistema. Por favor, cadastre um aluno diferente.
                      </div>';
                exit;
            }

            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
            $logs->write_log('info', "O usuario atualizaou os dados do alunos: " . $_POST['aluno']);

            echo '<div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Sucesso!</strong> Dados do Aluno atualizados com Sucesso.
                  </div>';
        }
        else
        {
            echo '<div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> Dados não cadastrados. Tente Novamente.
                  </div>';
        }
    }

    /**
     * Método para excluir os dados do alunos
     * @access Administrador
     */
    public function excluir($id)
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
        
        // Seleciona dados para retornar o nome da imagem já cadastrada
        // Esse procedimento é neceessário para deletar as imagens
        // utilizadas no repositório de cadastro de imagens
        $parametros = array (
                "select" => "foto, id",
                "table" => "alunos",
                "where" => array("id"=>$id),
                "like" => "",
                "limit" => ""
        );
        
        $retorno = $this->crud->select($parametros);
        if (file_exists("assets/fotosAlunos/".$retorno[0]->foto))
        @unlink("assets/fotosAlunos/".$retorno[0]->foto);

        /*
         * Exclui os dados do aluno mediante o parâmetro ID
         */
        $retorno = $this->crud->delete("alunos", "id", array("id" => $id));

        if ((int) $retorno == 1451)
        {
            $mensagem = array(
                'mensagem' => '<br><div class="alert alert-error">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                               <strong>Erro!</strong> O aluno não pode ser excluido pois esta vinculado a ocorrências ou desempenhos escolares cadastrados. Utilize a função "ativo ou inativo" para impedir novos cadastros para este aluno.
                               </div>'
            );
        }
        else if ($retorno == true)
        {
            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
            $logs->write_log('info', "O usuario excluiu o alunos com ID: " . $id);

            $mensagem = array(
                'mensagem' => '<br><div class="alert alert-success">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                               <strong>Sucesso!</strong> Aluno excluido com sucesso.
                               </div>'
            );
        }

        // Sessão para mensagem
        $this->session->set_userdata($mensagem);
        redirect('alunos/gerenciar/null', 'refresh');
    }

    public function status($id, $tipo)
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
        $this->crud->update("alunos", "id", array("id" => $id, "status" => $status));

        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario mudou o status do alunos com ID: " . $id);

        $mensagem = array(
            'mensagem' => '<br><div class="alert alert-success">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <strong>Sucesso!</strong> Status atualizado.
                           </div>'
        );

        // Sessão para mensagem
        $this->session->set_userdata($mensagem);
        redirect('alunos/gerenciar/null', 'refresh');
    }

}

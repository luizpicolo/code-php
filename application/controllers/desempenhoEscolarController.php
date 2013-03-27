<?php

/**
 * DesempenhoEscolarController é o controlador para o gerenciamento dos dados do desempenho
 * escolar dos alunos.
 * Aqui são feitas os cadastros, edições e exclusões dos dados do Desempenho Escolar.
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

class DesempenhoEscolarController extends CI_Controller
{

    // Fazemos a reescrita da classe construtora
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logado'))
        {
            redirect('', 'refresh');
        }
    }

    /**
     * Método construtor 
     */
    public function index()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de cadastro de desempenho escolar");

        $this->load->view('principal');
    }

    // Método que chama a pagina para cadastrar o Desempenho Escolar
    public function Cadastrar()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de cadastro de desempenho escolar");

        // Página para o cadastro do desempenho escolar
        $data["pagina"] = "desempenhoEscolarCadastrar";

        $this->load->model("crud");

        $parametros = array(
            "select" => "*",
            "table" => "alunos",
            "where" => array("status" => "1", "dataTerminoEstudos >=" => date("Y-m-d H:i:s")),
            "order_by" => "aluno asc",
        );

        // Solução nada elegante, gambiarra nervosa : ( )
        $cont = 0;
        foreach ($this->crud->select($parametros) as $dados)
        {
            if ($cont == 0)
            {
                $array_alunos .= '"' . $dados->id . ' - ' . $dados->aluno . '"';
                $cont++;
            }
            else
            {
                $array_alunos .= ',"' . $dados->id . ' - ' . $dados->aluno . '"';
            }
        }

        // Retorna os dados do usuário em um vetor.
        $data["alunos"] = $array_alunos;

        $this->load->view('principal', $data);
    }

    // Metodo para chamar a página para atualiar os dados do usuário
    public function atualizar($id)
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de atualizacao de desempenho escolar");

        // Página para acessar o formulário de atualização do usuário
        $data["pagina"] = "desempenhoEscolarAtualizar";

        $this->load->model("crud");

        $parametros = array(
            "select" => "*",
            "table" => "alunos",
            "where" => array("status" => "1", "dataTerminoEstudos >=" => date("Y-m-d H:i:s")),
            "order_by" => "aluno asc",
        );

        // Solução nada elegante, gambiarra nervosa
        $cont = 0;
        foreach ($this->crud->select($parametros) as $dados)
        {
            if ($cont == 0)
            {
                $array_alunos .= '"' . $dados->id . ' - ' . $dados->aluno . '"';
                $cont++;
            }
            else
            {
                $array_alunos .= ',"' . $dados->id . ' - ' . $dados->aluno . '"';
            }
        }

        $data["alunos"] = $array_alunos;

        if ($this->session->userdata('nivel') > 1)
        {
            $parametros2 = array(
                "select" => "d.id as id, d.idAluno, d.idUsuario, DATE_FORMAT(d.dataInicio,'%d/%m/%Y') as dataInicio, DATE_FORMAT(d.dataFinal,'%d/%m/%Y') as dataFinal, a.aluno, d.desempenhoEscolar",
                "table" => "desempenho as d",
                "where" => array("d.idUsuario" => $this->session->userdata('id'), "d.id" => $id),
                "join" => array("alunos as a" => "a.id = d.idAluno")
            );
        }
        else
        {
            $parametros2 = array(
                "select" => "d.id as id, d.idAluno, d.idUsuario, DATE_FORMAT(d.dataInicio,'%d/%m/%Y') as dataInicio, DATE_FORMAT(d.dataFinal,'%d/%m/%Y') as dataFinal, a.aluno, d.desempenhoEscolar",
                "table" => "desempenho as d",
                "where" => array("d.id" => $id),
                "join" => array("alunos as a" => "a.id = d.idAluno")
            );
        }

        // Retorna os dados do usuário em um vetor.
        $data['dados'] = $this->crud->select($parametros2, false);

        $this->load->view('principal', $data);
    }

    // Método que cadastra os dados do desempenho escolar 
    public function cadastrarDesempenhoEscolar()
    {
        if (formata_data($_POST['dataInicio'], 1) > formata_data($_POST['dataFinal'], 1))
        {
            echo '<div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> A data do início é menor que a data do final da avaliação.
                  </div>';
            exit;
        }
        
        // ID do aluno
        $id = explode("-", $_POST["idAlunos"]);

        $this->load->model("crud");

        // Parâmetros paara a seleção do aluno
        $parametros = array(
            "select" => "id",
            "table" => "alunos",
            "where" => array("status" => "1", "id" => $id[0])
        );

        if ($this->crud->select($parametros))
        {
            $array = array(
                "idAluno" => $id[0],
                "idUsuario" => $this->session->userdata('id'),
                "dataInicio" => formata_data($_POST["dataInicio"], 1),
                "dataFinal" => formata_data($_POST["dataFinal"], 1),
                "desempenhoEscolar" => $_POST["desempenhoEscolar"]
            );

            if ($this->crud->insert("desempenho", $array))
            {
                // Gerar Logs
                $this->load->library('my_log');
                $logs = new MY_Log();
                $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
                $logs->write_log('info', "O usuario cadastrou os dados do desempenho escolar para o aluno: " . $_POST["idAlunos"]);

                echo '<br><div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Sucesso!</strong> Desempenho Escolar cadastrada com sucesso.
                      </div>';
                echo '<script>$("#form").resetForm();</script>';
            }
        }
        else
        {
            echo '<br><div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> Aluno não cadastrado ou com a data do período escolar findado.
                  </div>';
        }
    }

    // Método para atualizar os dados do usuário
    public function atualizarDesempenhoEscolar()
    {
        if (formata_data($_POST['dataInicio'], 1) > formata_data($_POST['dataFinal'], 1))
        {
            echo '<div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> A data do início é menor que a data do final da avaliação.
                  </div>';
            exit;
        }
        
        $id = explode("-", $_POST["idAlunos"]);

        $this->load->model("crud");

        $parametros = array(
            "select" => "id",
            "table" => "alunos",
            "where" => array("status" => "1", "id" => $id[0])
        );

        if ($this->crud->select($parametros))
        {
            $array = array(
                "id" => $_POST['id'],
                "idAluno" => $id[0],
                "idUsuario" => $this->session->userdata('id'),
                "dataInicio" => formata_data($_POST["dataInicio"], 1),
                "dataFinal" => formata_data($_POST["dataFinal"], 1),
                "desempenhoEscolar" => $_POST["desempenhoEscolar"]
            );

            if ($this->crud->update("desempenho", "id", $array))
            {
                // Gerar Logs
                $this->load->library('my_log');
                $logs = new MY_Log();
                $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
                $logs->write_log('info', "O usuario atualizou os dados do desempenho escolar para o aluno: " . $_POST["idAlunos"]);

                echo '<br><div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Sucesso!</strong> Dados do Desempenho Escolar atualizados.
                      </div>';
            }
        }
        else
        {
            echo '<br><div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> Desempenho não atualizado ou com a data do período escolar findado.
                  </div>';
        }
    }

    // Método que invoca a página para listar o usuario
    public function Gerenciar()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de listagem de desempenhos escolares");

        $data['pagina'] = 'desempenhoEscolarGerenciar';

        // Redireciona URL para a busca
        if ($_POST["busca"])
        {
            redirect('desempenho-escolar/gerenciar/' . strtolower(url_title(convert_accented_characters($_POST["busca"]))), 'refresh');
        }

        // Paginacao
        $this->load->model("crud");
        $this->load->library('pagination');

        // Dados para a busca
        if ($this->uri->segment(3) == "null")
        {
            $dadosBusca = null;
        }
        else
        {
            $dadosBusca = str_replace("-", " ", $this->uri->segment(3));
        }

        // Quantidade de registro a serem mostrados por páginma
        $qtd = 10;

        if ($this->uri->segment(4) == "")
        {
            $inicio = 0;
        }
        else
        {
            $inicio = $this->uri->segment(4);
        }

        if ($this->session->userdata('nivel') > 1)
        {
            $parametros = array(
                "select" => "d.id as id, d.idAluno, d.idUsuario, DATE_FORMAT(d.dataInicio,'%d/%m/%Y') as dataInicio, DATE_FORMAT(d.dataFinal,'%d/%m/%Y') as dataFinal, a.aluno, u.nome as usuario",
                "table" => "desempenho as d",
                "where" => array("d.idUsuario" => $this->session->userdata('id')),
                "limit" => "$qtd, $inicio",
                "like" => array("aluno" => $dadosBusca),
                "join" => array("usuarios as u" => "u.id = d.idUsuario", "alunos as a" => "a.id = d.idAluno")
            );
        }
        else
        {
            $parametros = array(
                "select" => "d.id as id, d.idAluno, d.idUsuario, DATE_FORMAT(d.dataInicio,'%d/%m/%Y') as dataInicio, DATE_FORMAT(d.dataFinal,'%d/%m/%Y') as dataFinal, a.aluno, u.nome as usuario",
                "table" => "desempenho as d",
                //"where" => array("d.idUsuario" => $this->session->userdata('id')),
                "limit" => "$qtd, $inicio",
                "like" => array("aluno" => $dadosBusca),
                "join" => array("usuarios as u" => "u.id = d.idUsuario", "alunos as a" => "a.id = d.idAluno")
            );
        }

        $dados = $this->crud->select($parametros, false);

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

        /*
         * Descriptografa o id
         */
        $retorno = $this->crud->delete("desempenho", "id", array("id" => $id));

        if ($retorno == true)
        {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario deletou os dados do desempenho escolar com ID: " . $id);
        
        $mensagem = array(
                'mensagem' => '<br><div class="alert alert-success">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <strong>Sucesso!</strong> Desempenho Escolar excluido com sucesso.
                           </div>'
            );
        }
        else
        {
            $mensagem = array(
                'mensagem' => '<br><div class="alert alert-error">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                               <strong>Erro!</strong> Os dados não puderam ser excluídos.
                               </div>'
            );
        }

        $this->session->set_userdata($mensagem);
        redirect('desempenho-escolar/gerenciar/null', 'refresh');
    }

}

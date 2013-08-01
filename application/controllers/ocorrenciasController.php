<?php

/**
 * OcorrenciasController é o controlador para gerenciar os dados das ocorrências cadastradas
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

class OcorrenciasController extends CI_Controller {

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
     * Método chamado após o Construtor
     */
    public function index()
    {
        $this->load->view('principal');
    }

    public function Cadastrar()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de cadastro de ocorrencias");

        $data["pagina"] = "ocorrenciasCadastrar";

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

        $this->load->view('principal', $data);
    }

    public function atualizar($id)
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de atualizacoes de ocorrencias");

        $data["pagina"] = "ocorrenciasAtualizar";

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
                "select" => "o.id as id, o.idAluno, o.idUsuario, DATE_FORMAT(o.dataOcorrencia,'%d/%m/%Y') as dataOcorrencia,  DATE_FORMAT(o.dataSolucao,'%d/%m/%Y') as dataSolucao, a.aluno, o.ocorrencia, o.solucao",
                "table" => "ocorrencias as o",
                "where" => array("o.idUsuario" => $this->session->userdata('id'), "o.id" => $id),
                "join" => array("alunos as a" => "a.id = o.idAluno")
            );
        }
        else
        {
            $parametros2 = array(
                "select" => "o.id as id, o.idAluno, o.idUsuario, DATE_FORMAT(o.dataOcorrencia,'%d/%m/%Y') as dataOcorrencia,  DATE_FORMAT(o.dataSolucao,'%d/%m/%Y') as dataSolucao, a.aluno, o.ocorrencia, o.solucao",
                "table" => "ocorrencias as o",
                "where" => array("o.id" => $id),
                "join" => array("alunos as a" => "a.id = o.idAluno")
            );
        }

        $data['dados'] = $this->crud->select($parametros2, false);

        $this->load->view('principal', $data);
    }

    public function cadastrarOcorrencia()
    {
        if (formata_data($_POST['dataOcorrencia'], 1) > formata_data($_POST['dataSolucao'], 1))
        {
            echo '<div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> A data da ocorrência é menor que a data da solução.
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
                "idAluno" => $id[0],
                "idUsuario" => $this->session->userdata('id'),
                "dataOcorrencia" => formata_data($_POST["dataOcorrencia"], 1),
                "ocorrencia" => $_POST["ocorrencia"],
                "dataSolucao" => formata_data($_POST["dataSolucao"], 1),
                "solucao" => $_POST["solucao"]
            );

            if ($this->crud->insert("ocorrencias", $array))
            {
                // Gerar Logs
                $this->load->library('my_log');
                $logs = new MY_Log();
                $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
                $logs->write_log('info', "O usuario cadastrou a ocorrencia para o aluno: " . $_POST["idAlunos"]);

                echo '<br><div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Sucesso!</strong> Ocorrência cadastrada com sucesso.
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

    public function atualizarOcorrencia()
    {
        if (formata_data($_POST['dataOcorrencia'], 1) > formata_data($_POST['dataSolucao'], 1))
        {
            echo '<div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Erro!</strong> A data da ocorrência é menor que a data da solução.
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
                "dataOcorrencia" => formata_data($_POST["dataOcorrencia"], 1),
                "ocorrencia" => $_POST["ocorrencia"],
                "dataSolucao" => formata_data($_POST["dataSolucao"], 1),
                "solucao" => $_POST["solucao"]
            );

            if ($this->crud->update("ocorrencias", "id", $array))
            {

                // Gerar Logs
                $this->load->library('my_log');
                $logs = new MY_Log();
                $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
                $logs->write_log('info', "O usuario atualizou a ocorrencia para o aluno: " . $_POST["idAlunos"]);

                echo '<br><div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Sucesso!</strong> Dados da ocorrência atualizados.
                      </div>';
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

    public function Gerenciar()
    {
        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de listagem de ocorrências");

        $data['pagina'] = 'ocorrenciasGerenciar';

        // Redireciona URL para a busca
        if ($_POST["busca"])
        {
            redirect('ocorrencias/gerenciar/' . strtolower(url_title(convert_accented_characters($_POST["busca"]))), 'refresh');
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
        $qtd = 20;

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
            $parametros = array (
                "select" => "o.id as id, o.idAluno, o.idUsuario, DATE_FORMAT(o.dataOcorrencia,'%d/%m/%Y') as dataOcorrencia, a.aluno, u.nome as usuario",
                "table" => "ocorrencias as o",
                "where" => array("o.idUsuario" => $this->session->userdata('id')),
                "limit" => "$qtd, $inicio",
                "like" => array("aluno" => $dadosBusca),
                "join" => array("usuarios as u" => "u.id = o.idUsuario", "alunos as a" => "a.id = o.idAluno")
            );
        }
        else
        {
            $parametros = array (
                "select" => "o.id as id, o.idAluno, o.idUsuario, DATE_FORMAT(o.dataOcorrencia,'%d/%m/%Y') as dataOcorrencia, a.aluno, u.nome as usuario",
                "table" => "ocorrencias as o",
                //"where" => array("o.idUsuario" => $this->session->userdata('id')),
                "limit" => "$qtd, $inicio",
                "like" => array("aluno" => $dadosBusca),
                "join" => array("usuarios as u" => "u.id = o.idUsuario", "alunos as a" => "a.id = o.idAluno")
            );

        }

        $dados = $this->crud->select($parametros, false);

        $config['base_url'] = base_url() . "index.php/" . $this->uri->segment(1) . "/" . $this->uri->segment(2) . "/" . $this->uri->segment(3) . "/";
        $config['total_rows'] = $this->crud->getCount("ocorrencias");
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
        $retorno = $this->crud->delete("ocorrencias", "id", array("id" => $id));

        if ($retorno == true)
        {
            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
            $logs->write_log('info', "O usuario excluio a ocorrências com ID: " . $id);

            $mensagem = array(
                'mensagem' => '<br><div class="alert alert-success">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           <strong>Sucesso!</strong> Ocorrência excluida com sucesso.
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
        redirect('ocorrencias/gerenciar/null', 'refresh');
    }

}
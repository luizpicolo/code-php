<?php

/**
 * RelatórioController é o controlador para geração de ralatórios.
 * Todos os relatórios serão gerados em PDF
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

class RelatorioController extends CI_Controller {

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
      Método para apresebtar a tela para gerar is relatórios em pdf
     */

    public function gerarRelatorio()
    {
        $this->load->model("crud");

        // Gerar Logs
        $this->load->library('my_log');
        $logs = new MY_Log();
        $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
        $logs->write_log('info', "O usuario acessou a area de geração de ralatórios");

        $parametros = array(
            "select" => "*",
            "table" => "alunos",
            "where" => array("status" => "1", "dataTerminoEstudos >=" => date("Y-m-d H:i:s")),
            "order_by" => "aluno asc",
        );

        $data['pagina'] = 'relatorioGerarEmPdf';

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

    /*
      Método para gerar os relatorios
      Este método faz a busca e após gera os relatórios e os
      salva no caminho especificado.
     */

    public function buscar()
    {
        $this->load->helper('file');
        $this->load->library("My_Dompdf");

        $this->load->model("crud");

        $id = explode("-", $_POST["idAlunos"]);

        /*
          Verifica o Tipo de relatório desejado
          1 = OCorrencias
          2 = Desempenho Escolar
         */
        if ($_POST["tipoDeRelatorio"] == 1)
        {
            $parametros = array(
                "select" => "o.id as id, 
                             o.idAluno, 
                             o.idUsuario, 
                             DATE_FORMAT(o.dataOcorrencia,'%d/%m/%Y') as dataOcorrencia, 
                             a.aluno as aluno, 
                             u.nome as usuario, 
                             o.ocorrencia, 
                             o.solucao, 
                             a.foto",
                "table" => "ocorrencias as o",
                "where" => array("o.idAluno" => $id[0],
                                 "o.dataOcorrencia >=" => formata_data($_POST["dataInicio"], 1),
                                 "o.dataOcorrencia <=" => formata_data($_POST["dataFinal"], 1)
                           ),
                "order_by" => "",
                "limit" => "",
                "like" => "",
                "group_by" => "",
                "join" => array("usuarios as u" => "u.id = o.idUsuario", 
                                "alunos as a" => "a.id = o.idAluno"
                          )
            );
        }
        else if ($_POST["tipoDeRelatorio"] == 2)
        {
            $parametros = array (
                "select" => "d.id as id, 
                             d.idAluno, 
                             d.idUsuario, 
                             DATE_FORMAT(d.dataInicio,'%d/%m/%Y') as dataInicio, 
                             DATE_FORMAT(d.dataFinal,'%d/%m/%Y') as dataFinal, 
                             a.aluno as aluno, 
                             u.nome as usuario, 
                             d.desempenhoEscolar, 
                             a.foto",
                "table" => "desempenho as d",
                "where" => array ("d.idAluno" => $id[0],
                                  "d.dataInicio >=" => formata_data($_POST["dataInicio"], 1),
                                  "d.dataFinal <=" => formata_data($_POST["dataFinal"], 1)
                           ),
                "order_by" => "",
                "limit" => "",
                "like" => "",
                "group_by" => "",
                "join" => array ("usuarios as u" => "u.id = d.idUsuario", 
                                 "alunos as a" => "a.id = d.idAluno"
                          )
            );
        }
//        else
//        {
//            $parametros = array(
//                "select" => "o.id as id, 
//                            o.idAluno, 
//                            o.idUsuario, 
//                            DATE_FORMAT(o.dataOcorrencia,'%d/%m/%Y') as dataOcorrencia, 
//                            a.aluno as aluno, 
//                            u.nome as usuario, 
//                            o.ocorrencia, 
//                            o.solucao, 
//                            a.foto, 
//                            DATE_FORMAT(d.dataInicio,'%d/%m/%Y') as dataInicio, 
//                            DATE_FORMAT(d.dataFinal,'%d/%m/%Y') as dataFinal, 
//                            d.desempenhoEscolar",
//                "table" => "ocorrencias_ as o",
//                "where" => array("o.idAluno" => $id[0],
//                                 "o.dataOcorrencia >=" => formata_data($_POST["dataInicio"], 1),
//                                 "o.dataOcorrencia <=" => formata_data($_POST["dataFinal"], 1),
//                                 "d.dataInicio >=" => formata_data($_POST["dataInicio"], 1),
//                                 "d.dataFinal <=" => formata_data($_POST["dataFinal"], 1)
//                            ),
//                "order_by" => "o.dataOcorrencia asc, d.dataInicio asc",
//                "limit" => "",
//                "like" => "",
//                "group_by" => "",
//                "join" => array("usuarios as u" => "u.id = o.idUsuario", 
//                                "alunos as a" => "a.id = o.idAluno", 
//                                "desempenho as d" => "a.id = d.idAluno"
//                          )
//            );
//        }

        $dados = $this->crud->select($parametros, false);

        // Dados HTMLs para gerar o formulário
        $html = '<!DOCTYPE html>
                 <html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
                 <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                 <title>Relatório</title><style type="text/css">
                 @page {margin: 2cm;}
                 body {font-family: sans-serif;margin: 0.5cm 0;text-align: justify;}
                 hr {page-break-after: always;border: 0;border: #FFF;}
                 </style></head><body><div>';
        $html .= '<img src="assets/pdf/logo.jpg" width="200">';
        $html .= '<br /><h1 style="margin: 20px 0 0 0; text-align: center; float: right">Relatório de Exemplo</h1><br /><br />';
        $html .= '<p style="margin: 0; padding: 0">';
        if (@$dados[0]->foto)
        {
            $html .= '<h1 id="nome"><img src="assets/fotosAlunos/' . @$dados[0]->foto . '" width="300"></h1>';
        }
        $html .= '<h2 id="foto">' . @$dados[0]->aluno . '</h2>';

        /*
          Aqui se verifica o tipo de relatório
          1 = OCorrencias
          2 = Desempenho Escolar
         */
        if ($_POST["tipoDeRelatorio"] == 1)
        {
            foreach ($dados as $inf):
                $html .= '<h4>Relator: ' . $inf->usuario . '<br />Data Ocorrência: ' . $inf->dataOcorrencia . '</h4>
                      <h4>Ocorrência</h4>
                      <p>' . $inf->ocorrencia . '</p>
                      <h4>Solução Adotada</h4>
                      <p>' . $inf->solucao . '</p>';
            endforeach;
        }
        else if ($_POST["tipoDeRelatorio"] == 2)
        {
            foreach ($dados as $inf):
                $html .= '<h4>Relator: ' . $inf->usuario . '<br />Período de Avaliação: ' . $inf->dataInicio . ' à ' . $inf->dataFinal . '</h4>
                      <h4>Desempenho Escolar</h4>
                      <p>' . $inf->desempenhoEscolar . '</p>';
            endforeach;
        }
//        else
//        {
//            foreach ($dados as $inf):
//                $html .= '<h4>Relator: ' . $inf->usuario . '<br />Data Ocorrência: ' . $inf->dataOcorrencia . '</h4>
//                      <h4>Ocorrência</h4>
//                      <p>' . $inf->ocorrencia . '</p>
//                      <h4>Solução Adotada</h4>
//                      <p>' . $inf->solucao . '</p>
//                      <h4>Relator: ' . $inf->usuario . '<br />Período de Avaliação: ' . $inf->dataInicio . ' à ' . $inf->dataFinal . '</h4>
//                      <h4>Desempenho Escolar</h4>
//                      <p>' . $inf->desempenhoEscolar . '</p>';
//            endforeach;
//        }

        $html .= '</p></div></body></html>';

        // Caso os dados seja retornados, da inicio a geração do PDF
        if ($dados)
        {
            /*
              Classe DOMPDF
              @pach /application/library/dompdf
              @see https://code.google.com/p/dompdf/
             */
            $dompdf = new DOMPDF();
            $dompdf->load_html(utf8_decode($html));
            $dompdf->set_paper("a4", "portrait");
            $dompdf->render();

            $dir = "temp/" . $this->encrypt->sha1($this->session->userdata('id')) . "/" . $this->encrypt->sha1(rand(111, 999)) . "/";

            delete_files("temp/" . $this->encrypt->sha1($this->session->userdata('id')) . "/", true);

            mkdir($dir, 0777, true);

            $dir .= "relatorio.pdf";

            file_put_contents($dir, $dompdf->output());

            // Gerar Logs
            $this->load->library('my_log');
            $logs = new MY_Log();
            $logs->setLogPath(APPPATH . "logs/" . $this->session->userdata('nome') . "/");
            $logs->write_log('info', "O usuario gerou um relatório do aluno: " . $_POST["idAlunos"]);

            echo '<div class="alert alert-success">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
            '<h4>Sucesso!</h4>' .
            '<p>Seu relatório foi gerado com sucesso. Clique no botão abaixo para salva-ló</p>' .
            '<p><a class="btn" target="blank" href="' . $dir . '"><i class="icon-download-alt"></i> Visualizaz Relatório</a>' .
            '</p></div>';
        }
        else
        {
            echo '<div class="alert alert-alert">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
            '<h4>Alerta!</h4>' .
            'Dados não encontrados mediante aos parâmetros passados' .
            '</p></div>';
        }
    }

}
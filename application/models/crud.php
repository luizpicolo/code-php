<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * @package Crud
 * @version 1.0
 * @author luizpicolo.com.br
 * @copyright Copyright (c) 2012, luizpicolo.com.br
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

class Crud extends CI_Model
{
    /*
     * Methodo construtor
     * Para mais informações acesso a documentação da linguagem 
     * http://php.net/manual/en/language.oop5.decon.php
     */

    public function __construct()
    {
        parent::__construct();
        /*
         * Configurações de conexão com banco
         * Para modificar alguma configuração acesso o caminho:
         * localização: ./config/config.php
         */
        $this->load->database();
    }

    /*
     * RETRIEVE
     * MÉthodo  resposável por fazer a seleção no banco de dados
     * e retornar os daods em forma de um array de objecto
     * 
     * @param array
     * @param array
     * @return object
     * 
     * Para mais informaçõs verificar a documentação do Codeigniter
     * http://codeigniter.com/user_guide/database/active_record.html#select
     * 
     * $paramentro = array {
     *      [select]    = campos ou string a ser selecionada: ex *, usuario, nome
     *      [table]     = tabela a ser selecionada: ex usuarios
     *      [where]     = Condições para a seleção: ex status = 1 and nome = luiz picolo
     *      [order_by]  = Condição para ordenação: ex data desc, nome asc
     *      [limit]     = 10 ou 10, 20
     *      [group_by]  = Condição de agrupamento: ex nome ou data
     *      [join]      =  array('comments'=>'comments.id = blogs.id') // Necessario ser array e nao string
     * 
     *  EXEMPLO DE USO COM PARAMETRO FALSE EM OPCOES
     * 
     *  $parametros = array(
     *      "select"    =>  "nome, usuario, senha, DATE_FORMAT(dataCadastro,'%d/%m/%Y')",
     *      "table"     =>  "usuario",
     *      "where"     =>  array("status"=>"1","usuario"=>"admin"),
     *      "order_by"  =>  "nome asc",
     *      "group_by"  =>  "nome",
     *      "limit"     =>  "1, 2",
     *      "join"      =>  array('comments'=>'comments.id = blogs.id')
     *   );
     *                   
     *   $this->crud->select($parametros, false);
     * 
     */

    public function select($parametros = array(), $opcao = TRUE)
    {
        /* ---------------------------------------------------------------------
         * VERIFICAÇÕES DE CAMPOS NULOS 
         * --------------------------------------------------------------------- */
        if (!$parametros['select'])
        {
            show_error("Por favor, informe um parâmetro para a seleção", 500, "Sem parâmetro para que a pesquisa seja realizada");
            exit;
        }

        if (!$parametros['table'])
        {
            show_error("Por favor, informe uma tabela para a seleção", 500, "Sem parâmetro para que a pesquisa seja realizada");
            exit;
        }
        /* ---------------------------------------------------------------------
         * FIM DA VERIFICAÇÕES DE CAMPOS NULOS 
         * --------------------------------------------------------------------- */
        
        // Seleciona os campos necessários mediante o parâmetro passado
        $this->db->select($parametros['select'], $opcao);

        //Seleciona a tabela para que os dados seja retornados
        $this->db->from($parametros['table']);

        /*
         * WHERE (CONDIÇÃO)
         * 
         * Se você configurá-lo para FALSE, CodeIgniter não vai tentar proteger 
         * o seu campo ou nomes de tabelas com acentos graves. 
         * Isso é útil se você precisar de uma declaração SELECT.
         */
        if ($parametros['where'])
        {
            $this->db->where($parametros['where']);
        }

        // Ordena os resultado segundo o parâmetro passado
        if ($parametros['order_by'])
        {
            $this->db->order_by($parametros['order_by']);
        }
        
        // Ordena os resultado segundo o parâmetro passado
        if ($parametros['like'])
        {
            $this->db->like($parametros['like']);
        }

        // Retorna os resultado limitados ao parâmetro passado
        if ($parametros['limit'])
        {
            $this->db->limit($parametros['limit']);
        }

        // Retorna os resultado limitados ao parâmetro passado
        if ($parametros['group_by'])
        {
            $this->db->group_by($parametros['group_by']);
        }

        // Permite que você para escrever a parte do JOIN de sua consulta:
        if ($parametros['join'])
        {
            foreach ($parametros['join'] as $key => $value)
            {
                $this->db->join($key, $value, "inner");
            }
        }

        // retorna o resultado em forma de um array de objeto
        $query = $this->db->get();
        if ($this->db->_error_number())
        {
           return $this->db->_error_number(); 
        }
        else
        {
            return $query->result();
        }
    }

    /*
     * Inserting Data
     * MÉthodo  resposável por inserir dados no banco
     * 
     * @param array
     * @param array
     * @return object
     * 
     * Para mais informaçõs verificar a documentação do Codeigniter
     * http://codeigniter.com/user_guide/database/active_record.html#insert
     * 
     * Ao contrário do select o insert e bem simples
     * EXEMPLO DE USO COM PARAMETRO FALSE EM OPCOES (Retirado da documentação do FW)
     * 
     * $data = array(
     *  'title' => 'My title' ,
     *   'name' => 'My Name' ,
     *   'date' => 'My date'
     *   );
     *
     *   $this->db->insert('mytable', $data);
     *
     *   // Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')
     * 
     */

    public function insert($table, $array)
    {
        $this->db->insert($table, $array);
        
	// retorna o id a inserção
        if ($this->db->_error_number())
        {
           return $this->db->_error_number(); 
        }
        else
        {
            return $this->db->insert_id();
        }   
    }

    /*
     * Updating Data
     * MÉthodo  resposável por atualizar dados no banco
     * 
     * @param array
     * @param array
     * @return object
     * 
     * Para mais informaçõs verificar a documentação do Codeigniter
     * http://codeigniter.com/user_guide/database/active_record.html#update
     * 
     * Ao contrário do select o update e bem simples
     * EXEMPLO DE USO COM PARAMETRO FALSE EM OPCOES (Retirado da documentação do FW)
     * 
     * $data = array(
     *  'id' => 3
     *  'title' => 'My title' ,
     *   'name' => 'My Name' ,
     *   'date' => 'My date'
     *   );
     *
     * $this->db->update('mytable', 'id', $data);
     * 
     * Caso o ID não exista no segundo parâmetro o update será feito na tabela completa
     * 
     */

    public function update($table, $id_name = "", $array)
    {
        if ($id_name != "")
        {
            $this->db->where($id_name, $array[$id_name]);
        }
        $this->db->update($table, $array);
        if ($this->db->_error_number())
        {
           return $this->db->_error_number(); 
        }
        else
        {
            return true;
        }
    }

    /*
     * Deleting Data
     * Méthodo  resposável por atualizar dados no banco
     * 
     * @param array
     * @param array
     * @return object
     * 
     * Para mais informaçõs verificar a documentação do Codeigniter
     * http://codeigniter.com/user_guide/database/active_record.html#delete
     * 
     * Ao contrário do select o delete e bem simples
     * EXEMPLO DE USO COM PARAMETRO (Retirado da documentação do FW)
     * 
     * $this->db->delete('mytable', array('id' => $id));
     * // Produces:
     * // DELETE FROM mytable
     * // WHERE id = $id
     * 
     * Caso o ID não exista no segundo parâmetro o delete será feito na tabela completa
     * 
     */

    public function delete($table, $id_name, $array)
    {
        if ($id_name != "")
        {
            $this->db->where($id_name, $array[$id_name]);
        }
        $this->db->delete($table);
        if ($this->db->_error_number())
        {
           return $this->db->_error_number(); 
        }
        else
        {
            return true;
        }
    }
    
    /**
     * Metodos para fechar conexao
     */
    public function __destruct()
    {
        $this->db->close();
    }

}

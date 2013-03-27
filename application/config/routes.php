<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route = array(
    
    'principal' => 'principalController',
    
    // Rotas para usuários
    'usuarios' => 'usuariosController',
    'usuarios/cadastrar' => 'usuariosController/cadastrar',
    'usuarios/gerenciar/(:any)' => 'usuariosController/gerenciar',
    'usuarios/gerenciar/(:any)/(:num)' => 'usuariosController/gerenciar',
    'usuarios/excluir/(:num)' => 'usuariosController/excluir/$1',
    'usuarios/atualizar/(:num)' => 'usuariosController/atualizar/$1',
    'usuarios/status/(:num)/(:num)' => 'usuariosController/status/$1/$2',
    
    // Rotas para Alunos
    'alunos' => 'alunosController',
    'alunos/cadastrar' => 'alunosController/cadastrar',
    'alunos/gerenciar' => 'alunosController/gerenciar',
    'alunos/gerenciar/(:any)' => 'alunosController/gerenciar',
    'alunos/gerenciar/(:any)/(:num)' => 'alunosController/gerenciar',
    'alunos/excluir/(:num)' => 'alunosController/excluir/$1',
    'alunos/atualizar/(:num)' => 'alunosController/atualizar/$1',
    'alunos/status/(:num)/(:num)' => 'alunosController/status/$1/$2',
    
    // Ocorrencias
    'ocorrencias' => 'ocorrenciasController',
    'ocorrencias/cadastrar' => 'ocorrenciasController/cadastrar',
    'ocorrencias/gerenciar/(:any)' => 'ocorrenciasController/gerenciar',
    'ocorrencias/gerenciar/(:any)/(:num)' => 'ocorrenciasController/gerenciar',
    'ocorrencias/excluir/(:num)' => 'ocorrenciasController/excluir/$1',
    'ocorrencias/atualizar/(:num)' => 'ocorrenciasController/atualizar/$1',
    
    // Desempenho Escolhar
    'desempenho-escolar' => 'desempenhoEscolarController',
    'desempenho-escolar/cadastrar' => 'desempenhoEscolarController/cadastrar',
    'desempenho-escolar/gerenciar/(:any)' => 'desempenhoEscolarController/gerenciar',
    'desempenho-escolar/gerenciar/(:any)/(:num)' => 'desempenhoEscolarController/gerenciar',
    'desempenho-escolar/excluir/(:num)' => 'desempenhoEscolarController/excluir/$1',
    'desempenho-escolar/atualizar/(:num)' => 'desempenhoEscolarController/atualizar/$1',
    
    // Relatórios
    'relatorio' => 'relatorioController',
    'relatorio/gerarRelatorio' => 'relatorioController/gerarRelatorio',
    
    // Perfil
    'perfil' => 'perfilController',
    'perfil/atualizar' => 'perfilController/atualizar',
    
    //Textos
    'sobre-o-sistema' => 'textoController',
    'suporte' => 'textoController',
);

$route['default_controller'] = "logincontroller";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
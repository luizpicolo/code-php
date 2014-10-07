![Alt text](http://i.imgur.com/CSTSOdZ.png?2 "CODE" )
# C.O.D.E - Controle de Ocorrências e Desempenho Escolar

## Sobre o Sistema:

O  **Controle de Ocorrências de Desempenho Escolar** é um software desenvolvido com o objetivo
de controlar parte do processo de ocorrências e relatórios de desempenho escolar de forma prática e segura.
Possui menus auto-explicativos e, futuramente, um manual eletrônico para o auxilo no manuseio do
software, ou, para usuários mais avançados, à adaptação de novos sistemas baseados no mesmo.
Sendo assim, pode-se dizer que, o Sistema de Gestão de Ocorrências de Desempenho Escolar é de
fácil operação e automatiza as principais rotinas envolvidas no objetivo proposto.<br>
Operando em ambiente web, tem visual limpo que torna a navegação simples e rápida,
trabalhando em mono ou multi-usuário.</p>

## Demonstração:

[http://coode.herokuapp.com/](http://coode.herokuapp.com/) (off-line)

## Tecnologias:

PHP - [www.php.net](www.php.net)    
Mysql - [www.mysql.com](www.mysql.com)    
Framework Codeigniter - [www.codeigniter.com](www.codeigniter.com)    
Framework Css Twitter BootStrap - [http://twitter.github.com/bootstrap](http://twitter.github.com/bootstrap)    
Biblioteca Jquery - [www.jquery.com](www.jquery.com)    

## Reporte erros:
Reporte erros: [https://github.com/luizpicolo/code/issues](https://github.com/luizpicolo/code/issues)

## Cooperadores:

Michele Fernanda Picolo - [http://www.facebook.com/michele.picolo.7?fref=ts](http://www.facebook.com/michele.picolo.7?fref=ts)
Raquel Campos Klein - [http://www.facebook.com/queldevelopj?fref=ts](http://www.facebook.com/queldevelopj?fref=ts)
Wilma Costa - [http://www.facebook.com/profile.php?id=100002254005555](http://www.facebook.com/profile.php?id=100002254005555)
Vinícios Carvalho - [http://www.facebook.com/vinicioskf?ref=ts&fref=ts](http://www.facebook.com/vinicioskf?ref=ts&fref=ts)    

## Instalação:

A instalação do C.O.D.E é extremamente simples.    
Após o downloads do sistema, faça o upload no local desejado.    
Crie seu banco e importe o arquivo sql que está no diretório
sql/sql.sql
Logo após acesse o arquivo 
    config/config.php 
e mude as configurações do banco
com os dados do banco criado.    

    define('HOSTNAME', 'URL');
    define('USERNAME', 'USUÁRIO');
    define('PASSWORD', 'SENHA');
    define('DATABASE', 'BANCO DE DADOS');
    define('PORTA', '3306');
	
Se for servidor Linux, mude as permissões dos diretório:    

    temp/ = 0777
    assets/fotosAlunos/ = 0777
    application/logs/ = 0777

## Licença de Uso
Este software esta licenciado sobre a MIT License - [http://luizpicolo.mit-license.org/](http://luizpicolo.mit-license.org/)

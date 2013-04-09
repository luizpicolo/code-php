<h1>C.O.D.E - Controle de Ocorrências e Desempenho Escolar</h1>

<h2>Sobre o Sistema:</h2>

<p>O <b>Controle de Ocorrências de Desempenho Escolar</b> é um software desenvolvido com o objetivo 
de controlar parte do processo de ocorrências e relatórios de desempenho escolar de forma prática e segura. 
Possui menus auto-explicativos e, futuramente, um manual eletrônico para o auxilo no manuseio do 
software, ou, para usuários mais avançados, à adaptação de novos sistemas baseados no mesmo. 
Sendo assim, pode-se dizer que, o Sistema de Gestão de Ocorrências de Desempenho Escolar é de 
fácil operação e automatiza as principais rotinas envolvidas no objetivo proposto.<br>
Operando em ambiente web, tem visual limpo que torna a navegação simples e rápida, 
trabalhando em mono ou multi-usuário.</p>

<h2>Demonstração:</h2>

www.luizpicolo.com.br/code

<h2>Tecnologias:</h2>

PHP - www.php.net<br>
Mysql - www.mysql.com<br>
Framework Codeigniter - www.codeigniter.com<br>
Framework Css Twitter BootStrap - http://twitter.github.com/bootstrap<br>
Framework Jquery - www.jquery.com<br>

<h2>Reporte erros:</h2>
Reporte erros: https://github.com/luizpicolo/code/issues

<h2>Cooperadores:</h2>

Michele Fernanda Picolo - http://www.facebook.com/michele.picolo.7?fref=ts<br>
Raquel Campos Klein - http://www.facebook.com/queldevelopj?fref=ts<br>
Wilma Costa - http://www.facebook.com/profile.php?id=100002254005555<br>
Vinícios Carvalho - http://www.facebook.com/vinicioskf?ref=ts&fref=ts<br>

<h2>Instalação:</h2>

A instalação do C.O.D.E é extremamente simples.<br>
Após o downloads do sistema, faça o upload no local desejado.<br>
Crie seu banco e importe o arquivo sql que está no diretório 
<pre>sql/sql.sql</pre>
Logo após acesse o arquivo <pre>config/config.php</pre> e mude as configurações do banco 
com os dados do banco criado.
<pre>
define('HOSTNAME', 'URL');
define('USERNAME', 'USUÁRIO');
define('PASSWORD', 'SENHA');
define('DATABASE', 'BANCO DE DADOS');
define('PORTA', '3306');    
</pre>
Se for servidor Linux, mude as permissões dos diretório:<br>
<b>temp/ = 0777<br></b>
<b>assets/fotosAlunos/ = 0777<br></b>
<b>application/logs/ = 0777<br></b>
       


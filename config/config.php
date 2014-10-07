<?php
    /*
     * CONFIGURAÇÕE DE CONEXÃO COM BANCO DE DADOS
     * Atualize as configurações abaixo caso necessário, porém
     * as mesmas já foram geradas por meio do Install de iniciação
     */

     $url=parse_url(getenv("CLEARDB_DATABASE_URL"));

    define('HOSTNAME', $url["host"]);
    define('USERNAME', $url["user"]);
    define('PASSWORD', $url["pass"]);
    define('DATABASE', substr($url["path"],1));
    define('DOOR', '3306');

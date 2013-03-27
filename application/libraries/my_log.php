<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Log extends CI_Log {

    protected $_enabled = true;

    public function setLogPath($LogPath)
    {
        $this->_log_path = $LogPath;
        $this->criaDiretorio();
    }

    private function criaDiretorio()
    {
        if (!file_exists($this->_log_path))
        {
            @mkdir($this->_log_path);
        }
    }

}
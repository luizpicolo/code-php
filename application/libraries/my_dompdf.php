<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_Dompdf
{

    public function My_Dompdf()
    {
        require_once('dompdf/dompdf_config.inc.php');
    }

}
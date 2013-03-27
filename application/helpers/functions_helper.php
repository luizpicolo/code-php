<?php

// FOrmata data com dia da semana
function formata_data_extenso($strDate, $tipo = 1)
{
    // Array com os dia da semana em português;
    $arrDaysOfWeek = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
    // Array com os meses do ano em português;
    $arrMonthsOfYear = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    // Descobre o dia da semana
    $intDayOfWeek = date('w', strtotime($strDate));
    // Descobre o dia do mês
    $intDayOfMonth = date('d', strtotime($strDate));
    // Descobre o mês
    $intMonthOfYear = date('n', strtotime($strDate));
    // Descobre o ano
    $intYear = date('Y', strtotime($strDate));
    // Descobre o ano
    $intHora = date('H', strtotime($strDate));
    $intMIn = date('i', strtotime($strDate));
    // Formato a ser retornado
    if ($tipo == 1)
    {
        return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear . ' às ' . $intHora . ':' . $intMIn;
    }
    else
    {
        return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
    }
}

/**
 * 
 * Retorna data no formata especificado
 * 
 * @param String $data
 * @param Int $formato
 * @return String
 */
function formata_data($data, $formato)
{
    if ($formato == 1)
    {
        // Retorno 9999-99-99
        $retorno = str_replace("/", "-", $data);
        $retorno = str_replace(" ", "-", $retorno);
        $retorno = explode("-", $retorno);
        return $retorno[2] . "-" . $retorno[1] . "-" . $retorno[0];
    }
    if ($formato == 2)
    {
        // Retorno 9999-99-99
        $retorno = str_replace("/", "-", $data);
        $retorno = str_replace(" ", "-", $retorno);
        $retorno = explode("-", $retorno);
        return $retorno[2] . "/" . $retorno[1] . "/" . $retorno[0];
    }
}
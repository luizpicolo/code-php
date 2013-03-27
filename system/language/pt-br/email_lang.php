<?php

$lang['email_must_be_array'] = "O método de validação do e-mail deve ser passado em um array.";
$lang['email_invalid_address'] = "Endereço de e-mail inválido: %s";
$lang['email_attachment_missing'] = "Não foi possível localizar o seguinte anexo do e-mail: %s";
$lang['email_attachment_unreadable'] = "Não foi possível abrir este anexo: %s";
$lang['email_no_recipients'] = "Você deve incluir os destinatários: To, Cc, ou Bcc";
$lang['email_send_failure_phpmail'] = "Não foi possível enviar o e-mail usando a função mail() do PHP. Seu servidor não está configurado para enviar e-mails dessa maneira.";
$lang['email_send_failure_sendmail'] = "Não foi possível enviar o e-mail usando o sendmail via PHP. Seu servidor não está configurado para enviar e-mails dessa maneira.";
$lang['email_send_failure_smtp'] = "Não foi possível enviar o e-mail usando o SMTP via PHP. Seu servidor não está configurado para enviar e-mails dessa maneira.";
$lang['email_sent'] = "Sua mensagem foi enviada com sucesso utilizando o seguinte protocolo: %s";
$lang['email_no_socket'] = "Não foi possível abrir um socket para o Sendmail. Por favor confira suas configurações.";
$lang['email_no_hostname'] = "Você não especificou um servidor SMTP.";
$lang['email_smtp_error'] = "Os seguintes erros de SMTP foram encontrados: %s";
$lang['email_no_smtp_unpw'] = "Erro: Você deve informar um usuário e senha SMTP.";
$lang['email_failed_smtp_login'] = "Falha ao enviar o comando AUTH LOGIN. Erro: %s";
$lang['email_smtp_auth_un'] = "Falha ao autenticar o usuário. Erro: %s";
$lang['email_smtp_auth_pw'] = "Falha ao autenticar a senha. Erro: %s";
$lang['email_smtp_data_failure'] = "Não foi possível enviar os dados: %s";


/* End of file email_lang.php */
/* Location: ./system/language/english/email_lang.php */
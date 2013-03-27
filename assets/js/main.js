$(document).ready(function(){
    $("#form").submit(function(){
        /**
         *  retorna o valor do atributo Data remote do formulário enviado
         *  @return String
         */
        var dataRemote = $(this).attr("data-remote");
        
        // Verifa se o formulário será enviado remotamente
        if (dataRemote == "true")
        {
            /**
             * Retorna o caminho para a ação do formulário
             * @return String
             */
            var action = $(this).attr("action");
            
            /**
             * Retorna o ID da tag que será o foco
             * das mensagens de retorno
             * 
             * @return String
             */
            var focusResponse = $(this).attr("focus-response");
            
            /**
             * Retorna o Methodo utilizado para o envio do 
             * formulário
             * 
             * @return String
             */
            var method = $(this).attr("method");
            
            // Funções do jqueryForm
            $(this).ajaxStart(function() {
                $(focusResponse).html("Aguarde...").show();
            });
            
            // Variáveis
            var options = {
                target: focusResponse,
                url: action,
                type: method,
                success: function(resposta){
                    $(focusResponse).html(resposta).show();
                },
                error: function(xhr, textStatus, errorThrown) {
                    $(focusResponse).html(xhr).show();
                }
            }
            
            $(this).ajaxSubmit(options);
            
            // Retorna-se false para que o formulário não seja
            // enviado pelo methodo tradicional
            return false;
        }
    })
})

/*
 * DataPicker JqueryUI
 * @see http://jqueryui.com/datepicker/#localization
 * Brazilian initialisation for the jQuery UI date picker plugin. 
 * Written by Leonildo Costa Silva (leocsilva@gmail.com). 
 */
jQuery(function($){
    $(".datepicker").datepicker($.datepicker.regional["pt-BR"]);
    $.datepicker.regional['pt-BR'] = {
        closeText: 'Fechar',
        prevText: '&#x3c;Anterior',
        nextText: 'Pr&oacute;ximo&#x3e;',
        currentText: 'Hoje',
        monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
        'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
        'Jul','Ago','Set','Out','Nov','Dez'],
        dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});

$('.wysihtml5').wysihtml5();

// Menu
function menu(url){
    $(".menu li a").each(function(){
        var link = $(this).attr("href");
        if (link == url)
        {
            $(this).parents("li").attr("class", "active");
        }
    })
}

jQuery(function($){
   $(".maskDate").mask("99/99/9999");
   $(".maskTel").mask("(99)9999-9999");
});
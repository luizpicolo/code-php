<form data-remote="true" focus-response="#mensagem" id="form" method="post" action="index.php/desempenhoEscolarController/cadastrarDesempenhoEscolar">
    <fieldset>
        <legend>Desempenho Escolar</legend>
        <div class="row-fluid">
            <div class="span5">
                <label>Professor</label>
                <input class="input-xlarge span11" name="idProfessor" id="disabledInput" type="text" value="<?php echo $this->session->userdata('nome') ?>" placeholder="Input desabilitado aqui" disabled>
                <label>Aluno</label>
                <input class="input-xlarge span11" autocomplete="off" name="idAlunos" type="text" data-source='[<?php echo $alunos; ?>]' data-items="4" data-provide="typeahead" style="margin: 0 auto;" required>
                <span class="help-block"></span>
                <label>Período de Avaliação</label>
                <div class="row-fluid">
                    <div class="span5">
                        <label>Início</label>
                        <input type="text" class="datepicker span10 maskDate" name="dataInicio" required>
                    </div>
                    <div class="span5">
                        <label>Final</label>
                        <input type="text" class="datepicker span10 maskDate" name="dataFinal">
                    </div>
                </div>
            </div>
            <div class="span6">
                <label>Relatório de Desempenho Escolar</label>
                <textarea class="wysihtml5 span15" name="desempenhoEscolar" rows="15" required></textarea>     
                <span class="help-block"></span>
                <input type="submit" class="btn" value="Cadastrar">
                <span class="help-block"></span>
                <p id="mensagem"></p>              
            </div>
        </div>
    </fieldset>
</form>

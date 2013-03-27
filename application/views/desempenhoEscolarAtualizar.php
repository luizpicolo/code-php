<form data-remote="true" focus-response="#mensagem" id="form" method="post" action="index.php/desempenhoEscolarController/atualizarDesempenhoEscolar">
    <fieldset>
        <legend>Desempenho Escolar</legend>
        <div class="row-fluid">
            <div class="span5">
                <label>Professor</label>
                <input class="input-xlarge span11" name="idProfessor" id="disabledInput" type="text" value="<?php echo $this->session->userdata('nome') ?>" placeholder="Input desabilitado aqui" disabled>
                <label>Aluno</label>
                <input class="input-xlarge span11" autocomplete="off" name="idAlunos" value="<?php echo $dados[0]->idAluno . " - " .$dados[0]->aluno; ?>" type="text" data-source='[<?php echo $alunos; ?>]' data-items="4" data-provide="typeahead" style="margin: 0 auto;" required>
                <span class="help-block"></span>
                <label>Período de Avaliação</label>
                <div class="row-fluid">
                    <div class="span5">
                        <label>Início</label>
                        <input type="text" class="datepicker span10 maskDate" name="dataInicio" value="<?php echo $dados[0]->dataInicio; ?>" required>
                    </div>
                    <div class="span5">
                        <label>Final</label>
                        <input type="text" class="datepicker span10 maskDate" name="dataFinal" value="<?php echo $dados[0]->dataFinal; ?>" required>
                    </div>
                </div>
            </div>
            <div class="span6">
                <label>Relatório de Desempenho Escolar</label>
                <textarea class="wysihtml5 span15" name="desempenhoEscolar" rows="15" required><?php echo $dados[0]->desempenhoEscolar; ?></textarea>     
                <span class="help-block"></span>
                <input type="hidden" name="id" value="<?php echo $dados[0]->id; ?>">
                <input type="submit" class="btn" value="Atualizar">
                <span class="help-block"></span>
                <p id="mensagem"></p>              
            </div>
        </div>
    </fieldset>
</form>

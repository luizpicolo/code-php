<form data-remote="true" focus-response="#mensagem" id="form" method="post" action="index.php/ocorrenciasController/atualizarOcorrencia">
    <fieldset>
        <legend>Cadastro de Ocorrências</legend>
        <div class="row-fluid">
            <div class="span5">
                <label>Professor</label>
                <input class="input-xlarge span11" name="idProfessor" id="disabledInput" type="text" value="<?php echo $this->session->userdata('nome') ?>" placeholder="Input desabilitado aqui" disabled>
                <label>Aluno</label>
                <input class="input-xlarge span11" autocomplete="off" name="idAlunos" type="text" value="<?php echo $dados[0]->idAluno . " - " .$dados[0]->aluno; ?>" data-source='[<?php echo $alunos; ?>]' data-items="4" data-provide="typeahead" style="margin: 0 auto;" required>
                <span class="help-block"></span>
                <div class="row-fluid">
                    <div class="span5">
                        <label>Data Ocorrência</label>
                        <input type="text" class="datepicker span10 maskDate" value="<?php echo $dados[0]->dataOcorrencia; ?>" name="dataOcorrencia" required>
                    </div>
                    <div class="span5">
                        <label>Data Solução</label>
                        <input type="text" class="datepicker span10 maskDate" value="<?php if ($dados[0]->dataSolucao != "00/00/0000") { echo $dados[0]->dataSolucao; }; ?>" name="dataSolucao">
                    </div>
                </div>
            </div>
            <div class="span6">
                <label>Ocorrência</label>
                <textarea class="wysihtml5 span15" name="ocorrencia" rows="7"><?php echo $dados[0]->ocorrencia; ?></textarea>    
                <label>Solucões adotas para o problema</label>
                <textarea class="wysihtml5 span15" name="solucao" rows="7"><?php echo $dados[0]->solucao; ?></textarea>  
                <span class="help-block"></span>
                <input type="hidden" name="id" value="<?php echo $dados[0]->id; ?>">
                <input type="submit" class="btn" value="Atualizar">
                <span class="help-block"></span>
                <p id="mensagem"></p>              
            </div>
        </div>
    </fieldset>
</form>

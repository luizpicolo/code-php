<form data-remote="true" focus-response="#mensagem" id="form" method="post" action="index.php/ocorrenciasController/cadastrarOcorrencia">
    <fieldset>
        <legend>Cadastro de Ocorrências</legend>
        <div class="row-fluid">
            <div class="span5">
                <label>Professor</label>
                <input class="input-xlarge span11" name="idProfessor" id="disabledInput" type="text" value="<?php echo $this->session->userdata('nome') ?>" placeholder="Input desabilitado aqui" disabled>
                <label>Aluno</label>
                <input class="input-xlarge span11" autocomplete="off" name="idAlunos" type="text" data-source='[<?php echo $alunos; ?>]' data-items="4" data-provide="typeahead" style="margin: 0 auto;" required=>
                <span class="help-block"></span>
                <div class="row-fluid">
                    <div class="span5">
                        <label>Data Ocorrência</label>
                        <input type="text" class="datepicker span10 maskDate" name="dataOcorrencia" required>
                    </div>
                    <div class="span5">
                        <label>Data Solução</label> 
                        <input type="text" class="datepicker span10 maskDate" name="dataSolucao" required>
                    </div>
                </div>
            </div>
            <div class="span6">
                <label>Ocorrência</label>
                <textarea class="wysihtml5 span15" name="ocorrencia" rows="7" required></textarea>    
                <label>Solucões adotas para o problema</label>
                <textarea class="wysihtml5 span15" name="solucao" rows="7" required></textarea>  
                <span class="help-block"></span>
                <input type="submit" class="btn" value="Cadastrar">
                <span class="help-block"></span>
                <p id="mensagem"></p>              
            </div>
        </div>
    </fieldset>
</form>

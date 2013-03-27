<form data-remote="true" focus-response="#mensagem" id="form" method="post" action="index.php/alunosController/cadastrarDadosAluno">
    <fieldset>
        <legend>Cadastrar Alunos</legend>
        <label>Aluno</label>
        <input type="text" name="aluno" required>
        <label>Responsável</label>
        <input type="text" name="responsavel">
        <label>Telefone Responsável</label>
        <input type="text" class="maskTel" name="contatoResponsavel">
        <label>Data de Matrícula</label>
        <input type="text" class="datepicker maskDate" name="dataMatricula" required>
        <label>Data Término Estudos</label>
        <input type="text" class="datepicker maskDate" name="dataTerminoEstudos" required>
        <label>Foto</label>
        <input type="file" name="file">
        <small>Somente imagens no formato JPG</small>
        <span class="help-block"></span>
        <input type="submit" class="btn" value="Cadastrar">
        <span class="help-block"></span>
        <p id="mensagem"></p>
    </fieldset>
</form>
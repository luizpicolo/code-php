<form data-remote="true" focus-response="#mensagem" id="form" method="post" action="index.php/usuariosController/atualizarDadosUsuario">
    <fieldset>
        <legend>Atualizar dados Perfil</legend>
        <label>Nome</label>
        <input type="text" name="nome" value="<?php echo $dados[0]->nome; ?>" required>
        <label>Email</label>
        <input type="text" name="email1" disabled value="<?php echo $dados[0]->email; ?>" required>
        <input type="hidden" name="email" value="<?php echo $dados[0]->email; ?>">
        <label>Senha</label>
        <input type="password" name="senha">
        <label>Repetir Senha</label>
        <input type="password" name="repetirSenha">
        <span class="help-block"></span>
        <input type="submit" class="btn" value="Atualizar">
        <input type="hidden" name="id" value="<?php echo $dados[0]->id; ?>">
        <span class="help-block"></span>
        <p id="mensagem"></p>
    </fieldset>
</form>
<form data-remote="true" focus-response="#mensagem" id="form" method="post" action="index.php/usuariosController/atualizarDadosUsuario">
    <fieldset>
        <legend>Atualizar Dados Usuários</legend>
        <label>Nome</label>
        <input type="text" name="nome" value="<?php echo $dados[0]->nome; ?>" required>
        <label>Email</label>
        <input type="text" name="email1" value="<?php echo $dados[0]->email; ?>" disabled>
        <input type="hidden" name="email" value="<?php echo $dados[0]->email; ?>">
        <label>Senha</label>
        <input type="password" name="senha">
        <label>Repetir Senha</label>
        <input type="password" name="repetirSenha">
        <label>Nível</label>
        <select name="nivel">
            <option value="1" <?php if($dados[0]->nivel == 1){echo "selected";} ?>>Administrador</option>
            <option value="2" <?php if($dados[0]->nivel == 2){echo "selected";} ?>>Usuário</option>
        </select>
        <span class="help-block"></span>
        <input type="submit" class="btn" value="Atualizar">
        <input type="hidden" name="id" value="<?php echo $dados[0]->id; ?>">
        <span class="help-block"></span>
        <p id="mensagem"></p>
    </fieldset>
</form>
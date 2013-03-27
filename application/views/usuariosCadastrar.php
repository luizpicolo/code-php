<form data-remote="true" focus-response="#mensagem" id="form" method="post" action="index.php/usuariosController/cadastrarDadosUsuario">
    <fieldset>
        <legend>Cadastrar Usuários</legend>
        <label>Nome</label>
        <input type="text" name="nome" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Senha</label>
        <input type="password" name="senha" required>
        <label>Repetir Senha</label>
        <input type="password" name="repetirSenha" required>
        <label>Nível</label>
        <select name="nivel">
            <option value="1">Administrador</option>
            <option value="2">Usuário</option>
        </select>
        <span class="help-block"></span>
        <input type="submit" class="btn" value="Cadastrar">
        <span class="help-block"></span>
        <p id="mensagem"></p>
    </fieldset>
</form>
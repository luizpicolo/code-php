<legend>Gerenciar Usuários</legend>
<!-- Form Busca -->
<form class="form-search" method="post" action="index.php/usuarios/gerenciar/null">
    <div class="input-prepend">
        <button type="submit" class="btn">Buscar</button>
        <input type="text" name="busca" class="span12 search-query">
    </div>
</form>
<?php echo $this->session->userdata('mensagem'); $this->session->set_userdata(array("mensagem"=>"")); ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data de Acesso</th>
            <th>Nível</th>
            <th>Ação</th>
        </tr>
    </thead>
    <?php foreach ($dadosbusca as $dados): ?>
    <?php if ($dados->status == 2) { $status = 'class="muted"';}else{ $status = "";}?>
        <tr <?php echo $status; ?>>
            <th><?php echo $dados->id; ?></th>
            <td><?php echo $dados->nome; ?></td>
            <td><?php echo formata_data_extenso($dados->dataAcesso); ?></td>
            <td><?php if ($dados->nivel == 1){echo "Administrador";}else{echo "Usuário";} ?></td>
            <td>
                <?php if ($dados->status == 1){?>
                <a class="btn btn-mini" href="index.php/usuarios/status/<?php echo $dados->id; ?>/1"><i class="icon-plus"></i> Ativo</a>
                <?php } else { ?>
                <a class="btn btn-mini" href="index.php/usuarios/status/<?php echo $dados->id; ?>/2"><i class="icon-minus"></i> Inativo</a>
                <?php } ?>
                <a class="btn btn-mini" href="index.php/usuarios/atualizar/<?php echo $dados->id; ?>"><i class="icon-pencil"></i> Editar</a>
                <a class="btn btn-mini btn-danger" href="index.php/usuarios/excluir/<?php echo $dados->id; ?>" onclick="javascript:if(!confirm('Deseja realmente excluir os dados deste usuario? Ao excluir este usuário não terá acesso ao sistema')){return false;}"><i class="icon-remove-sign"></i> Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $paginacao; ?>
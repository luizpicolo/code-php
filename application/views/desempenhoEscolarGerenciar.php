<legend>Gerenciar Desempenho Escolar</legend>
<!-- Form Busca -->
<form class="form-search" method="post" action="index.php/desempenho-escolar/gerenciar/null">
    <div class="input-prepend">
        <button type="submit" class="btn">Buscar</button>
        <input type="text" name="busca" class="span12 search-query">
    </div>
</form>
<?php echo $this->session->userdata('mensagem'); $this->session->set_userdata(array("mensagem"=>"")); ?>
<!-- Janela Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Confirmação de Exclusão</h3>
    </div>
    <div class="modal-body">
        <p>One fine body…</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
        <button class="btn btn-danger">Excluir</button>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Alunos</th>
            <th>Período</th>
            <th>Ocorrência registrada por:</th>
            <th>Ação</th>
        </tr>
    </thead>
    <?php foreach ($dadosbusca as $dados): ?>
        <tr>
            <th><?php echo $dados->id; ?></th>
            <td><?php echo $dados->aluno; ?></td>
            <td><?php echo $dados->dataInicio; ?> à <?php echo $dados->dataFinal; ?></td>
            <td><?php echo $dados->usuario; ?></td>
            <td>
                <a class="btn btn-mini" href="index.php/desempenho-escolar/atualizar/<?php echo $dados->id; ?>"><i class="icon-pencil"></i> Editar</a>
                <a class="btn btn-mini btn-danger" href="index.php/desempenho-escolar/excluir/<?php echo $dados->id; ?>" onclick="javascript:if(!confirm('Deseja realmente excluir os dados deste desempenho escolar?')){return false;}"><i class="icon-remove-sign"></i> Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $paginacao; ?>
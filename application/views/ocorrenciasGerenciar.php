<legend>Gerenciar Dados Ocorrência</legend>
<!-- Form Busca -->
<form class="form-search" method="post" action="index.php/ocorrencias/gerenciar/null">
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
            <th class="text-center">ID</th>
            <th>Alunos</th>
            <th>Data Ocorrência</th>
            <th>Ocorrência registrada por:</th>
            <th>Situação:</th>
            <th>Açôes</th>
        </tr>
    </thead>
    <?php foreach ($dadosbusca as $dados): ?>
        <tr>
            <th class="text-center"><?php echo $dados->id; ?></th>
            <td><?php echo $dados->aluno; ?></td>
            <td><?php echo $dados->dataOcorrencia; ?></td>
            <td><?php echo $dados->usuario; ?></td>
            <?php if ($dados->dataSolucao != '00/00/0000'):?>
            <td class="text-center ocorrencia-fechada" title="Ocorrëncia Fechada">&#10004</td>
            <?php else : ?>
            <td class="text-center ocorrencia-aberta" title="Ocorrência em Aberto">&#10006</td>
            <?php endif; ?>
            <td class="text-center">
                <a class="btn btn-mini" href="index.php/ocorrencias/atualizar/<?php echo $dados->id; ?>"><i class="icon-pencil"></i> Editar</a>
                <a class="btn btn-mini btn-danger" href="index.php/ocorrencias/excluir/<?php echo $dados->id; ?>" onclick="javascript:if(!confirm('Deseja realmente excluir os dados desta ocorrência?')){return false;}"><i class="icon-remove-sign"></i> Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $paginacao; ?>
<legend>Gerenciar Alunos</legend>
<!-- Form Busca -->
<form class="form-search" method="post" action="index.php/alunos/gerenciar/null">
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
            <th>Alunos</th>
            <th>Matriculado em...</th>
            <th>Data prevista para termino dos estudos</th>
            <th>Ação</th>
        </tr>
    </thead>
    <?php foreach ($dadosbusca as $dados): ?>
    <?php if ($dados->status == 2) { $status = 'class="muted"';}else{ $status = "";}?>
        <tr <?php echo $status; ?>>
            <th><?php echo $dados->id; ?></th>
            <td><?php echo $dados->aluno; ?></td>
            <td><?php echo formata_data($dados->dataMatricula, 2); ?></td>
            <td><?php echo formata_data($dados->dataTerminoEstudos, 2); ?></td>
            <td>
                <?php if ($dados->status == 1){ ?>
                <a class="btn btn-mini" href="index.php/alunos/status/<?php echo $dados->id; ?>/1"><i class="icon-plus"></i> Ativo</a>
                <?php } else { ?>
                <a class="btn btn-mini" href="index.php/alunos/status/<?php echo $dados->id; ?>/2"><i class="icon-minus"></i> Inativo</a>
                <?php } ?>
                <a class="btn btn-mini" href="index.php/alunos/atualizar/<?php echo $dados->id; ?>"><i class="icon-pencil"></i> Editar</a>
                <a class="btn btn-mini btn-danger" href="index.php/alunos/excluir/<?php echo $dados->id; ?>" onclick="javascript:if(!confirm('Deseja realmente excluir os dados deste aluno? Ao excluir você não poderá acessar mais esses dados e nem outros relacionados a ele como: Ocorrências e Desempenho Escolar')){return false;}"><i class="icon-remove-sign"></i> Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $paginacao; ?>
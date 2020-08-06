<?php
    include("partials/header.php");
    include("partials/menu.php");    
?> 
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Container fluid  -->
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Produtos</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Imagem</th>
                                    <th>Alterar Visibilidade</th>
                                    <th>Alterar Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach ($produtos as $produto) {
                            ?>
                                <tr>
                                    <td><?= $produto->nome; ?></td>
                                    <td>
                                        <img src="<?= $produto->imagem; ?>" width="100">
                                    </td>
                                    <td>
                                        <?php
                                        if($produto->visivel == 1){
                                        ?>  
                                            <button class="btn btn-danger" onclick="alterar_visibilidade(<?= $produto->id; ?>, 0)">Ocultar</button>
                                        <?php
                                        }else{
                                        ?>
                                            <button class="btn btn-success" onclick="alterar_visibilidade(<?= $produto->id; ?>, 1)">Exibir</button>
                                        <?php   
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($produto->ativo == 1){
                                        ?>
                                            <button class="btn btn-danger" onclick="alterar_status(<?= $produto->id; ?>, 0)">Desativar</button>
                                        <?php
                                        }else{
                                        ?>
                                            <button class="btn btn-success" onclick="alterar_status(<?= $produto->id; ?>, 1)">Ativar</button>
                                        <?php   
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php   
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Container fluid  -->
</div>
<!-- End Page wrapper  -->
<?php
    include("partials/footer.php"); 
?>  
<script type="text/javascript">    
    function alterar_visibilidade(id, visibilidade){
        $.post("/produto/alterar/visibilidade",
            {produto: id, nova_visibilidade: visibilidade},
            function(data) {
                location.reload();
            });
    }

    function alterar_status(id, status){
        $.post("/produto/alterar/status",
            {produto: id, novo_status: status},
            function(data) {
                location.reload();
            });
    }
</script>                  

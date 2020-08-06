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
                    <h4 class="card-title">Cotações <?= $data; ?></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Titulo</th>
                                    <th>Preco</th>
                                    <th>Selecionar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach ($cotacoes as $cotacao) {
                                $url_img = montaURL($cotacao->url, $cotacao->imagem);
                            ?>
                                <tr id="<?= $cotacao->id; ?>">
                                    <td>
                                        <img src="<?= $url_img; ?>" width="100">
                                    </td>
                                    <td><a href="<?= $cotacao->url; ?>" target="_new"><?= $cotacao->titulo; ?></a></td>
                                    <td><?= $cotacao->preco_desconto; ?></td>
                                    <td>
                                        <button class="btn btn-success" onclick="selecionar_cotacao(<?= $cotacao->id; ?>)">Selecionar</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" onclick="excluir_cotacao(<?= $cotacao->id; ?>)">Excluir</button>
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
    function selecionar_cotacao(id){
        $.post("/cotacao/produto/selecionar",
            {cotacao: id},
            function(data) {
                //location.reload();
            });
    }

    function excluir_cotacao(id){
        $.post("/cotacao/produto/excluir",
            {cotacao: id},
            function(data) {
                //location.reload();
                $("#"+id).remove();
            });
    }
</script>            

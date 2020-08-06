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
                    <h4 class="card-title">Produtos Destacados</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Titulo</th>
                                    <th>Produto</th>
                                    <th>Preco</th>
                                    <th>Data</th>
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
                                    <td><?= $cotacao->nome; ?></td>
                                    <td><?= $cotacao->preco_desconto; ?></td>
                                    <td><?= $cotacao->data; ?></td>
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


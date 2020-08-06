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
                                    <th>Peso</th>
                                    <th>0.12</th>
                                    <th>0.20</th>
                                    <th>Cotações</th>
                                    <th>Visualizar</th>
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
                                    <td><?= $produto->peso; ?></td>
                                    <td><?= $produto->fps_20; ?></td>
                                    <td><?= $produto->fps_12; ?></td>
                                    <td><?= $produto->quantidade; ?></td>
                                    <td>
                                        <form method='post' action='/cotacao/produto'>
                                            <input type="hidden" name="produto" value="<?= $produto->id; ?>">
                                            <button class="btn btn-warning">Visualizar</button>
                                        </form>
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

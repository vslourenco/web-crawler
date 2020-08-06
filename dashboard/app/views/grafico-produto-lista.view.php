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
                                    <td><?= $produto->quantidade; ?></td>
                                    <td>
                                        <form method='post' action='/grafico/produto'>
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

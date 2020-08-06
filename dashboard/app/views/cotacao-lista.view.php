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
                    <h4 class="card-title">Datas das Cotações</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Cotações</th>
                                    <th>Visualizar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach ($cotacoes as $cotacao) {
                            ?>
                                <tr>
                                    <td><?= $cotacao->data; ?></td>
                                    <td><?= $cotacao->quantidade; ?></td>
                                    <td>
                                        <form method='post' action='/cotacao/data'>
                                            <input type="hidden" name="data" value="<?= $cotacao->data; ?>">
                                            <input type="hidden" name="site" value="<?= $site; ?>">
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

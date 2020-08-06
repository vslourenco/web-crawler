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
                    <h4 class="card-title">Sites</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Site</th>
                                    <th>Imagem</th>
                                    <th>Links</th>
                                    <th>Cotar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach ($sites as $site) {
                            ?>
                                <tr>
                                    <td><?= $site->descricao; ?></td>
                                    <td>
                                        <img src="<?= $site->imagem; ?>" width="100">
                                    </td>
                                    <td><?= $site->quantidade; ?></td>
                                    <td>
                                        <form method='post' action='/crawler'>
                                            <input type="hidden" name="site" value="<?= $site->id; ?>">
                                            <button class="btn btn-warning">Cotar</button>
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

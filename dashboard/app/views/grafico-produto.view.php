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
                    <h4 class="card-title">Histórico de Preços</h4>
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-chart"></div>
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
    //Flot Chart
    $(document).ready(function() {
        var label = "<?php echo $produto->nome;?>";
        var data = new Array();
        <?php 
        foreach ($cotacoes as $cotacao) {
        ?>
            data.push([<?=(strtotime($cotacao->data) * 1000);?>, <?=$cotacao->preco_desconto;?>]);
        <?php
        }
        ?>
        var options = {
            series: {
                lines: { show: true, fill: true, fillColor: "rgba(100, 100, 255, 0.2)" },
                points: { show: true, fill: false }
            },
            xaxis: {
                mode: "time",
                timeformat: "%d/%m"
            },
            colors: ["#55ce63"],
            grid: {
                color: "#AFAFAF",
                hoverable: true, //IMPORTANT! this is needed for tooltip to work
                borderWidth: 0,
                backgroundColor: '#FFF'
            },
            tooltip: {
                show: true,
                xDateFormat: "time",
                content: "%y",
                shifts: {
                    x: 10,
                    y: 10
                }
            }
        };

        var plot = $("#flot-chart").plot([ { label: label, data: data }], options).data("plot");
    });

</script>   
<style type="text/css">
    .flotTip{
        background:rgba(50, 50, 50, 0.5);  
    }
</style> 

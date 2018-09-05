
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SHControl</title>

    <!-- Bootstrap Core CSS -->
    <link href="startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="startbootstrap-sb-admin-2-gh-pages/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="startbootstrap-sb-admin-2-gh-pages/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="startbootstrap-sb-admin-2-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- Mi css -->
    <link href="startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/css/micss.css" rel="stylesheet">
</head>

<body>
    <script>
        //Funciones que permiten aceptar o cancelar los datos introducidos en los sitemas manual y automático
        function alertaManual(){
            if(confirm('Deseas continuar?')){ 
                document.manual.submit();
            }else{
                alert('Operacion Cancelada');
            }
        }
        function alertaAutomatico(){
            if(confirm('Deseas continuar?')){ 
                document.automatico.submit();
            }else{
                alert('Operacion Cancelada');
            }
        }
    </script>
<?php
    //Se abre el fichero "FDatos.csv" 
    $datos = fopen('startbootstrap-sb-admin-2-gh-pages/data/FDatos.csv', 'r');
    //Se introducen los datos del fichero en un array
    $arrayDatos = array();
    while (($line = fgetcsv($datos)) !== FALSE) {
    //$line es un array spbre los elementos del csv
    array_push($arrayDatos, $line);
    }
    //Se cierra el fichero "FDatos.csv" 
    fclose($datos);
    //Se abre el fichero "FDatosManualAutomático.csv"
    $datosmanauto = fopen('startbootstrap-sb-admin-2-gh-pages/data/FDatosManualAutomatico.csv', 'r');
    //Se introducen los datos del fichero en un array
    $arrayDatosManualAutomatico = array();
    if(($line = fgetcsv($datosmanauto)) !== FALSE) {
    //$line es un array spbre los elementos del csv
    array_push($arrayDatosManualAutomatico, $line);
    }
    //Se cierra el fichero "FDatosManualAutomático.csv"
    fclose($datosmanauto);
?>
	<div id="wrapper" style="background-color:black">
        <!--Se introduce el título: "SHCONTROL"-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color:white">SHControl</h1>
            </div>
        </div>
        <!--Se crea la cajas para el sitema manual-->
        <div class="row">
            <div class="col-lg-6">
                <div class="cajas">
                <div class="titulocaja"><b> Sistema Manual </b></div>                        
<?php 
                //Se comprueba si el sistema manual está activado o desactivado mirando el primer elemento del archivo "FDatosManualAutomatico.csv"
                    if(strcmp($arrayDatosManualAutomatico[0][0],"manual")==0){
                        echo "<b id=\"activado\"> Activado</b>";
                    }else{
                        echo "<b id=\"desactivado\"> Desactivado </b>";
                    }
?>
                    <!--Botón donde se muestra información sobre el sistema manual-->
                    <button class="info" onclick="alert('Los datos que se deberán introducir son los correspondientes a duración: tiempo de regado y intervalo: durante cuantto tiempo se riega')" value="i"><img src="Vista/inf.png"></button><br><br>
                    <!--Formulario con los datos correspondientes al sistema manual-->
                    <form class="texto" name="manual" method="post" display="inline-block" action="Controlador/controller.php?accion=manual">
                        <fieldset>                             
                            <b style="float:left"> Duracion:&nbsp</b>
                            <input id="duracion" type="text" size="5"  name="duracion" value="">  minutos
                            <b style="float:center; margin-left: 32px;"> Intervalo:&nbsp </b>
                            <input id="intervalo" type="text" size="5" name="intervalo" value="">  minutos<br><br><br>
                                
<?php 
                                    //Muestra en la caja manual los datos actuales del sistema, los recoge del segundo y tercer elemento del fichero "FDatosManualAutomatico.csv"
                                    if(strcmp($arrayDatosManualAutomatico[0][0],"manual")==0){
                                        echo "Valores duración: " . $arrayDatosManualAutomatico[0][1] . " minutos e intervalo " . $arrayDatosManualAutomatico[0][2] . " minutos.";
                                    }
?>
                            <!--Botón que permite reocger los valores del formulario-->
                            <input id="botonokma" type="button" onclick=alertaManual() value="OK">
                        </fieldset>
                    </form> 
                </div>
            </div>
            <!--Se crea la cajas para el sitema automático-->
            <div class="col-lg-6">
                <div class="cajas">
                <div class="titulocaja"><b> Sistema Automático </b></div>                          
<?php 
                    //Se comprueba si el sistema automático está activado o desactivado mirando el primer elemento del archivo "FDatosManualAutomatico.csv"
                    if(strcmp($arrayDatosManualAutomatico[0][0],"automatico")==0){
                        echo "<b id=\"activado\"> Activado</b>";
                    }else{
                        echo "<b id=\"desactivado\"> Desactivado </b>";
                    }
?>
                    <!--Botón donde se muestra información sobre el sistema automático-->
                    <button class="info" onclick="alert('El dato que se deberá introducir es el correpondiente a la humedad mínma que ha de tener el circuíto')" value="i"><img src="Vista/inf.png"></button><br><br>  
                    <!--Formulario con los datos correspondientes al sistema automático-->
                    <form class="texto" name="automatico" method="post" action="Controlador/controller.php?accion=automatico">
                        <fieldset>    
                            <b> Humedad mínima: </b>
                            <input type="text" size="5"  name="humedadminima" value=""> %<br><br><br>
                            <!--Botón que permite reocger los valores del formulario-->
                            <input id="botonokau" type="button" onclick=alertaAutomatico() value="OK">
<?php 
                            //Muestra en la caja automático el dato actual del sistema, lo recoge del segundo elemento del fichero "FDatosManualAutomatico.csv"
                            if(strcmp($arrayDatosManualAutomatico[0][0],"automatico")==0){
                                echo "Valor de humedad mínima: " . $arrayDatosManualAutomatico[0][1] . " %";
                            }
?>
                        </fieldset>
                    </form> 
                </div>
            </div>
            <!--Espacio para la gráfica-->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Gráfica
                        <div id="chartdiv"></div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
    <!-- Archivos necesarios para la gráfica -->
<script src="grafica/amcharts.js"></script>
<script src="grafica/serial.js"></script>
<script src="grafica/light.js"></script>
<script src="grafica/export.min.js"></script>
<link rel="stylesheet" href="grafica/export.css" type="text/css" media="all" />


    <!-- Codigo de Gráfica -->
    <script>

        var chartData = generateChartData();
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "synchronizeGrid":true,
            "valueAxes": [{
                "id":"v1",
                "axisColor": "red",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "left"
            }, {
                "id":"v2",
                "axisColor": "blue",
                "axisThickness": 2,
                "axisAlpha": 1,
                "offset": 50,
                "position": "left"
            }, {
                "id":"v3",
                "axisColor": "green",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "autoGridCount" : false,
                "gridCount" : 1,
                "labelFrequency" : 1,
                "axisFrequency": true
            }],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "red",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "temperatura",
                "valueField": "temperatura",
        		"fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "blue",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "humedad",
                "valueField": "humedad",
        		"fillAlphas": 0
            }, {
                "valueAxis": "v3",
                "lineColor": "green",
                "bullet": "triangleUp",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "riego",
                "valueField": "riego",
        		"fillAlphas": 0
            }],
            "chartScrollbar": {},
            "chartCursor": {
                "cursorPosition": "mouse"
            },
            "categoryField": "fecha",
            "categoryAxis": {
                "parseDates": false,
                "minorGridEnabled": true,
                "ignoreAxisWidth": true,
                "autoWrap": true,
                "color": "#f5f5f5"
                
            },
            "export": {
            	"enabled": true,
                "position": "bottom-right"
             }
        });

        chart.addListener("dataUpdated", zoomChart);
        zoomChart();


        // generate some random data, quite different range
        function generateChartData() {
            var arrayJS = <?php echo json_encode($arrayDatos);?>;


            var chartData = [];
            for(var i = 0; i < arrayJS.length; i++){
                chartData.push({"riego": arrayJS[i][3],"fecha": arrayJS[i][2],"humedad": arrayJS[i][1], "temperatura": arrayJS[i][0]});
            }
            console.log(chartData);    
            return chartData;
        }

        function zoomChart(){
            chart.zoomToIndexes(chart.dataProvider.length - 20, chart.dataProvider.length - 1);
        }
    </script>
</body>
</html>

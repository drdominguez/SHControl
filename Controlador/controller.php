<?php

    if (!isset($_REQUEST['accion'])){
        $_REQUEST['accion'] = '';
    }
        Switch ($_REQUEST['accion']) {
            case 'automatico':
                $humedadminima=$_REQUEST['humedadminima'];
                if(validarHumedad($humedadminima)){
                    $nombre_archivo = "FDatosManualAutomatico.csv";
                    if($archivo = fopen("../startbootstrap-sb-admin-2-gh-pages/data/".$nombre_archivo, "w"))
                    {
?>
                        <script>if(confirm('Deseas continuar?')){ 
                            alert('Insertados datos manuales correctamente');
                            document.location='../index.php';
                        }else{
                            alert('Operacion Cancelada');
                            document.location='../index.php';
                        }
                        </script>
<?php    
                        fwrite($archivo, "automatico,".$humedadminima.",0,".date("Y-m-d H:m:s"));
                        fclose($archivo);
                        exec('sh /Users/daniel/shcontrol.sh');
                    }
                }
                break;
            case 'manual':
                $duracion=$_REQUEST['duracion'];
                $intervalo=$_REQUEST['intervalo'];
                if(validarDuracion($duracion) && validarIntervalo($intervalo)){
                    $nombre_archivo = "FDatosManualAutomatico.csv";
                    if($archivo = fopen("../startbootstrap-sb-admin-2-gh-pages/data/".$nombre_archivo, "w"))
                    {
?>
                        <script>if(confirm('Deseas continuar?')){ 
                            alert('Insertados datos manuales correctamente');
                            document.location='../index.php';
                        }else{
                            alert('Operacion Cancelada');
                            document.location='../index.php';
                        }
                        </script>
<?php                        
                        fwrite($archivo, "manual,".$duracion.",".$intervalo.",".date("Y-m-d H:m:s"));
                        fclose($archivo);
                    }
                }
                break;
            default:
                break;
        }
        function validarDuracion($valor){
            if(($valor == '')||(!preg_match('/^[1-5]?[0-9]{1}$|^60$/', $valor))){
?>
                <script>alert('Datos duracion incorrectos');
                    document.location='../index.php';
                </script>
<?php 
                return false;
            }else{
                return true;
            }
        }
        function validarIntervalo($valor){
            if(($valor == '')||(!preg_match('/^[1-5]?[0-9]{1}$|^60$/', $valor))){
?>
                <script>alert('Datos intervalo incorrectos');
                    document.location='../index.php';
                </script>
<?php
                return false;
            }else{
                return true;
            }
        }
        function validarHumedad($valor){
            if(($valor == '')||(!preg_match('/^[1-9]?[0-9]([.][0-9][0-9]?)?$|^100$/', $valor))){
?>
                <script>alert('Datos humedad incorrectos');
                    document.location='../index.php';
                </script>
<?php
                return false;   
            }else{
                return true;
            }
        }
?>
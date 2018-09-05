<?php
    //Comprueba la acción del formulario
    if (!isset($_REQUEST['accion'])){
        $_REQUEST['accion'] = '';
    }   
        //Mira que valor tiene la accion
        Switch ($_REQUEST['accion']) {
            //En el caso de ser automatico
            case 'automatico':
                //Recoge el valor de la humedad
                $humedadminima=$_REQUEST['humedadminima'];
                //Comprueba que sea un valor válido
                if(validarHumedad($humedadminima)){
                    //Escribe en el archivo "FDatosManualAutomatico.csv", si no existe lo crea
                    $nombre_archivo = "FDatosManualAutomatico.csv";
                    if($archivo = fopen("../startbootstrap-sb-admin-2-gh-pages/data/".$nombre_archivo, "w"))
                    {
                        //Escribe el sistema que es con el valor correspondiente y la fecha
                        fwrite($archivo, "automatico,".$humedadminima.",0,".date("Y-m-d H:m:s"));
                        //Cierra el archivo
                        //Envía el fichero a la raspberry
                        $connection = ssh2_connect('192.168.40.115', 22);
                        ssh2_auth_password($connection, 'pi', 'shcontrol');
                        ssh2_scp_send($connection, '/var/www/html/SHControl/startbootstrap-sb-admin-2-gh-pages/data/FDatosManualAutomatico.csv', '/home/pi/Desktop/SHControl/FDatosManualAutomatico.csv', 0644);
?>
<script>                
                        //Muestra una alerta con que se introducieron los daqtos
                        alert('Insertado dato automático correctamente');
                        //Regresa a la vista inicial
                        document.location='../index.php';
</script>
<?php
                    }else{
                        //Muestra una alerta de error
                        alert('Error: Problema en el insertado del dato automático');
?>
<script>        
                        //Regresa a la vista inicial
                        document.location='../index.php';
</script>
<?php 
                    }
                }
                break;
            //En el caso de ser manual
            case 'manual':
                //Recoge los datos correspondientes a manual
                $duracion=$_REQUEST['duracion'];
                $intervalo=$_REQUEST['intervalo'];
                //Valida que esos datos sean correctos
                if(validarDuracion($duracion) && validarIntervalo($intervalo)){
                    $nombre_archivo = "FDatosManualAutomatico.csv";
                    //Crea, si no existe, el fichero "FDatosManualAutomatico.csv" y lo abre
                    if($archivo = fopen("../startbootstrap-sb-admin-2-gh-pages/data/".$nombre_archivo, "w"))
                    {   
                        //Escribe los datos correspondientes al sitema manual
                        fwrite($archivo, "manual,".$duracion.",".$intervalo.",".date("Y-m-d H:m:s"));
                        //Cierra el archivo
                        fclose($archivo);
                        //Envía el fichero a la raspberry
                        $connection = ssh2_connect('192.168.40.115', 22);
                        ssh2_auth_password($connection, 'pi', 'shcontrol');
                        ssh2_scp_send($connection, '/var/www/html/SHControl/startbootstrap-sb-admin-2-gh-pages/data/FDatosManualAutomatico.csv', '/home/pi/Desktop/SHControl/FDatosManualAutomatico.csv', 0644);
?>
<script>                
                        //Alerta de se escribieron los datos de manera correcta
                        alert('Insertados datos manuales correctamente');
                        //Vuelve a la vista principal
                        document.location='../index.php';
</script>
<?php                                            
                        
                    }else{
?>
<script>      
                        //Alerta de se escribieron los datos de manera incorrecta
                        alert('Insertados datos manuales correctamente');
                        //Vuelve a la vista principal
                        document.location='../index.php';
</script>
<?php 
                    }
                }
                break;
            //En caso de que tenga otro valor
            default:
                break;
        }
        //Comprueba que el dato de duración sean entre 1 y 60 enteros
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
        //Comprueba que el dato de intervalo sean entre 1 y 60 enteros
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
        //Comprueba que el dato de humedad este entre 1 y 100 siendo posible valores decimales
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
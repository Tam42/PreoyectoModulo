<?php
include("bd.php");

$conexion = connectDB2("prueba3");
if(!$conexion){
  echo mysqli_connnect_error()."<br>";
  echo mysqli_connnect_errno()."<br>";
  exit();
}
else{
  $PK= $_POST['NumTrabajador'];
  $Name= $_POST['NombreTrab'];
  $ApPt= $_POST['aptPaternoTrab'];
  $ApMt= $_POST['aptMaternoTrab'];
  $Pass= $_POST['passTrab1'];

  $sal = rand();
  echo "$sal";
  $password_con_sal_hasheados = $Pass+$sal;
  echo"$password_con_sal_hasheados";


  $sql = "INSERT INTO Trabajador VALUES ('$PK', \"$Name\", \"$ApPt\", \"$ApMt\", \"$Pass\" )";
  if(mysqli_query($conexion, $sql)){
    echo "Insercion exitosa";
  }
  else{
      echo "Hubo un problema";
  }
}

//Incluir la base de datos
include("bd.php");
  //Declarar la base de datos en la que seguardaran los datos ingresados
  $conexion = connectDB2("cafeteria");
  //Si no se encuentra la conexion
  if(!$conexion) {
    //Marcara los errores que hay en la conexion
    echo mysqli_connect_error()."<br>";
    echo mysqli_connect_errno()."<br>";
    //Para salir
    exit();
  }
  //Si encontro la conexio
  else {
    //definir el tipo de encriptamineto
    define("HASH", "sha256");
    //Definir el tipo de contraseña
    define("PASS","Secure password, plz make ec¿veryth!ng s3cUr3");
    //El metodo para encriptar
    define("METHOD","aes-128-cbc");
    //Hacer la funcion cifrar
    function Cifrar($text){
      //La llave que temdra el password
      $key= openssl_digest(PASS,HASH);
      //La longitud del texto
      $iv_len= openssl_cipher_iv_length(METHOD);
      //Un numero aleatorio de bytes
      $iv= openssl_random_pseudo_bytes($iv_len);
      //El texto que se va a a cifrar
      $textoCifrado= openssl_encrypt(
        $text,//Mensaje en texto plano
        METHOD,//método que escogimos para cifrar
        $key,//Contraseña hasheada
        OPENSSL_RAW_DATA,//Para que nos regrese sin base6
        $iv//Iv para cifrar
      );
      //Regresar en base 64
      $ciffWIv=base64_encode($iv.$textoCifrado);
      //Regresar la base
      return $ciffWIv;
    }
    //Con la funcion cifrar ciframos el usuarios
    $ciff= Cifrar($_POST['NumTrab'];);
    //Definir con variabkes los datos que se reciben del formulario
    $Name= $_POST['NombreTrab'];
    $ApPt= $_POST['apPaternoTrab'];
    $ApMt= $_POST['apMaternoTrab'];
    //Hashear la contraseña enviada del formulario
    $pass=password_hash($_POST['passTrab1'],PASSWORD_BCRYPT);
    //Definir la sal que sera un numero del 100 al 999
    $sal = rand(100,999);
    //Concatenar $sal y $pass
    $pass_con_sal_hasheados = $sal.$pass;
    //La consulta que se realizara para ver si el usuario existe
    $cons = "SELECT * FROM Trabajador WHERE Nombre='$Name' and ApellidoPat='$ApPt' and ApellidoMat='$ApMt'";
    //Ver si se pudo hacer la consulta con la conexion
    $result = $conexion -> query($cons);
      //Ver si existe un registro en la Base de Datos
      $count= mysqli_num_rows($result);
      //Si existe un registro hara el if
      if($count == 1){
          //Imprimira que el usuario ya existe
          echo "Registro existente<br>";
          //Imprimira un link que te direccionara de nuevo al formulario de registro
          echo"<a href='../Templates/RegistroCafe.html'>Volver al formulario</a>";
      }
      //Si el contador fue no fue uno sino 0 hara el elseif
      elseif($count == 0){
          //Hacer una insercion de los valores que se dijan
          $sql = "INSERT INTO Trabajador VALUES ('$PK', \"$Name\", \"$ApPt\", \"$ApMt\", \"$Pass\" )";
          //Si se logro la insercion con la conexion hara el if
          if(mysqli_query($conexion, $sql)){
            //Imprimira un mensaje de que se registro
            echo "Registro exitoso";
            //Lo mandara a la pagina de inicio
            echo "<a href=''></a>";
          }
          else{
            //Imprimira que hay un error
            echo "Hubo un problema inentelo mas tarde :(";
          }
      }
  }
?>

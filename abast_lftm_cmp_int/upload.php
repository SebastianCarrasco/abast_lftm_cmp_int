<?php
$target_dir = "archivos/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Comprueba si el archivo ya existe
if (file_exists($target_file)) {
  echo "Lo siento, el archivo ya existe.";
  $uploadOk = 0;
}

// Comprueba el tamaño del archivo
if ($_FILES["fileToUpload"]["size"] > 500000) { // 500 KB
  echo "Lo siento, su archivo es demasiado grande.";
  $uploadOk = 0;
}

// Permitir ciertos formatos de archivo
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG & GIF.";
  $uploadOk = 0;
}

// Comprueba si $uploadOk está establecido en 0 por un error
if ($uploadOk == 0) {
  echo "Lo siento, tu archivo no se subió.";
// Si todo está bien, intenta subir el archivo
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "El archivo ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " ha sido subido.";
  } else {
    echo "Lo siento, hubo un error al subir tu archivo.";
  }
}
?>
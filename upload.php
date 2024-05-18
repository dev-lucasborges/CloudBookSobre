<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.css?<?php echo $cssVersion?>">
    <link rel="stylesheet" href="./css/style.css?<?php echo $cssVersion?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;500;700&display=swap" rel="stylesheet">
    <title>Sucesso!</title>
</head>
<body>
    
</body>
</html>

<?php
$target_dir = "arquivos/";
$usuario = $_POST['id'];
$target_file = $target_dir . $usuario . ".jpg";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["arquivo"]["tmp_name"]);
    if ($check !== false) {
        echo "O arquivo é uma imagem - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "O arquivo não é uma imagem.";
        $uploadOk = 0;
    }
}

if ($_FILES["arquivo"]["size"] > 5000000) {
    echo "Desculpe, o arquivo é muito grande.";
    $uploadOk = 0;
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif") {
    echo "Desculpe, apenas JPG, JPEG, PNG e GIF são permitidos.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo '<div class="container">';
echo '<div class="mx-auto text-center box-v">';
echo '<h5 class="h5 mb-3">Desculpe, o arquivo não pôde ser carregado.</h5>';
echo "<a href='painel.php?r=".time()."'><button class='btn btn-primary'>Voltar para o painel</button>";
echo '</div>';
echo '</div>';

} else {
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    $image = imagecreatefromstring(file_get_contents($_FILES["arquivo"]["tmp_name"]));
    imagejpeg($image, $target_file, 100);
    imagedestroy($image);
    echo "<script>window.location.href='painel2.php?id=".$usuario."';</script>";
  echo "<script>location.reload(true);</script>";

}

?>

<?php

require_once __DIR__ . '/../data/conection.php';

function conectMYSQL(){
    return conection::conectar();
}

function desconectMYSQL($pdo){
    $pdo = null;
}

function checkData($data, array $value){ 
    for($i = 0; $i < count($value); $i++){
        if(empty($data[$value[$i]])){
            return false;
        }
    }
    return true; 
}

function salvarImagem(array $arquivo){
    if (($arquivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK
        || ($arquivo['size'] ?? 0) > 5 * 1024 * 1024
        || !is_uploaded_file($arquivo['tmp_name'])) {
        return false;
    }

    $tiposPermitidos = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($arquivo['tmp_name']);
    if (!isset($tiposPermitidos[$mime])) {
        return false;
    }

    $pastaDestino = __DIR__ . '/../../uploads/noticias/';
    if (!is_dir($pastaDestino) && !mkdir($pastaDestino, 0755, true)) {
        return false;
    }

    $nomeArquivo = bin2hex(random_bytes(16)) . '.' . $tiposPermitidos[$mime];
    if (!move_uploaded_file($arquivo['tmp_name'], $pastaDestino . $nomeArquivo)) {
        return false;
    }

    return '../uploads/noticias/' . $nomeArquivo;
}

function sendToMYSQL($pdo, $data){
    $sql = "INSERT INTO news (nws_title, nws_category, nws_content, nws_photo_url, nws_status)
            VALUES (:title, :category, :description, :photo, 0)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'title' => trim($data['title']),
        'category' => trim($data['category']),
        'description' => trim($data['description']),
        'photo' => $data['photo'],
    ]);
}

function redirectNews($status){
    header("Location: ../../frontend/news.php?status=$status");
    exit();
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

$requiredFields = ['category','title','description'];

if (!checkData($_POST, $requiredFields)){
    header('Location: ../../frontend/news.php?checkData=error');
    exit();
}

try {
    if (!isset($_FILES['photo'])) {
        redirectNews('erro');
    }

    $caminhoImagem = salvarImagem($_FILES['photo']);
    if ($caminhoImagem === false) {
        redirectNews('erro');
    }

    $pdo = conectMYSQL();
    $pdo->beginTransaction();
    sendToMYSQL($pdo, array_merge($_POST, ['photo' => $caminhoImagem]));
    $pdo->commit();
    desconectMYSQL($pdo);
    redirectNews('sucesso');
} catch (Throwable $exception) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    if (!empty($caminhoImagem)) {
        @unlink(__DIR__ . '/../../' . ltrim($caminhoImagem, '../'));
    }
    error_log('Falha ao salvar noticia: ' . $exception->getMessage());
    redirectNews('erro');
}
<?php

require_once __DIR__ . '/../data/conection.php';

function redirectNewsConfig($status){
	header('Location: ../../frontend/newsConfig.php?status=' . urlencode($status));
	exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirectNewsConfig('erro');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
	'options' => ['min_range' => 1],
]);
$status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

if ($id === false || $id === null || !in_array($status, [0, 1], true)) {
	redirectNewsConfig('erro');
}

try {
	$pdo = conection::conectar();
	$stmt = $pdo->prepare(
		'UPDATE news
		 SET nws_status = :status,
			 nws_data_publicacao = CASE WHEN :status = 1 THEN NOW() ELSE NULL END
		 WHERE nws_id = :id'
	);
	$stmt->execute([
		'status' => $status,
		'id' => $id,
	]);

	redirectNewsConfig('sucesso');
} catch (Throwable $exception) {
	error_log('Falha ao alterar status da noticia: ' . $exception->getMessage());
	redirectNewsConfig('erro');
}


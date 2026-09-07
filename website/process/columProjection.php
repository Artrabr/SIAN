<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../backsistem/backend/data/conection.php';
require_once __DIR__ . '/../../backsistem/backend/classes/payment.php';

//========================================================================//
//                                FUNÇÕES
//========================================================================//

function conectMYSQL(){
    return conection::conectar();
}

function desconectMYSQL(&$pdo){
    $pdo = null;
}

function redirectTo($url){
    header("Location: {$url}");
    exit();
}

function getLoggedAtletaId(){
    $idAtleta = $_SESSION['id_atl'] ?? null;
    return filter_var($idAtleta, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;
}

function isLogado($idAtl){
    return !empty($idAtl);
}

function encerrarSessao(){
    session_destroy();
}

function buscarAtletaPorId($pdo, $idAtl){
    $stmt = prepararBuscaAtleta($pdo);
    executarBuscaAtleta($stmt, $idAtl);
    return $stmt->fetch();
}

function prepararBuscaAtleta($pdo){
    // Nunca selecionar: cpf_atl, password_atl, contact_atl, payMethod_atl, birthDate_atl.
    return $pdo->prepare("
        SELECT name_atl, position_atl, team_atl, instagram_atl, created_at
        FROM athlete
        WHERE id_atl = :id
    ");
}

function executarBuscaAtleta($stmt, $idAtl){
    $stmt->execute(['id' => $idAtl]);
}

function atletaExiste($dadosAtleta){
    return !empty($dadosAtleta);
}

function buscarEquipePorTime($pdo, $teamAtl){
    $stmt = prepararBuscaEquipe($pdo);
    executarBuscaEquipe($stmt, $teamAtl);
    return mapearEquipe($stmt->fetchAll());
}

function prepararBuscaEquipe($pdo){
    return $pdo->prepare("
        SELECT name_atl, position_atl
        FROM athlete
        WHERE team_atl = :equipe
        ORDER BY name_atl
    ");
}

function executarBuscaEquipe($stmt, $teamAtl){
    $stmt->execute(['equipe' => $teamAtl]);
}

function mapearEquipe($linhas){
    return array_map('mapearMembroEquipe', $linhas);
}

function mapearMembroEquipe($row){
    return [
        'nome'    => $row['name_atl'],
        'posicao' => $row['position_atl'],
        'foto'    => fotoPadrao(),
    ];
}

function fotoPadrao(){
    return 'imagens/noialogo.png';
}

function buscarPagamentosPorAtleta($pdo, $idAtl){
    $stmt = prepararBuscaPagamentos($pdo);
    executarBuscaPagamentos($stmt, $idAtl);
    return $stmt->fetchAll();
}

function prepararBuscaPagamentos($pdo){
    return $pdo->prepare("
        SELECT payday, expired, type_pgm
        FROM payments
        WHERE atl_id = :id
        ORDER BY payday DESC
    ");
}

function executarBuscaPagamentos($stmt, $idAtl){
    $stmt->execute(['id' => $idAtl]);
}

function montarRelatorioFinanceiro($pagamentos){
    return array_map('montarLinhaRelatorio', $pagamentos);
}

function montarLinhaRelatorio($pagamento){
    return [
        'data'   => formatarData($pagamento['payday']),
        'tipo'   => formatarTipoPagamento($pagamento['type_pgm']),
        'status' => calcularStatusPagamento($pagamento['expired']),
    ];
}

function formatarTipoPagamento($tipoPagamento){
    return $tipoPagamento === 'diaria' ? 'Diária' : 'Mensalidade';
}

function formatarData($data){
    return (new DateTime($data))->format('d/m/Y');
}

function calcularStatusPagamento($dataVencimento){
    return estaVencido($dataVencimento) ? 'Vencido' : 'Vigente';
}

function estaVencido($dataVencimento){
    $vencimento = new DateTime($dataVencimento);
    $hoje = new DateTime();
    return $vencimento < $hoje;
}

function estaEmDia($relatorioFinanceiro){
    foreach ($relatorioFinanceiro as $linha) {
        if ($linha['status'] === 'Vencido') {
            return false;
        }
    }
    return true;
}

function statusFinanceiroTexto($relatorioFinanceiro){
    if (empty($relatorioFinanceiro)) {
        return 'Sem registro';
    }

    return estaEmDia($relatorioFinanceiro) ? 'Em dia' : 'Pendente';
}

function calcularLimitePrimeiroPagamento($dataCadastro){
    $data = new DateTime($dataCadastro);

    if ((int) $data->format('d') < 5) {
        $data->setDate((int) $data->format('Y'), (int) $data->format('m'), 5);
    } else {
        $data->modify('first day of next month');
        $data->setDate((int) $data->format('Y'), (int) $data->format('m'), 5);
    }

    return $data;
}

function statusFinanceiroComGratuidade($relatorioFinanceiro, $dataCadastro){
    if (!empty($relatorioFinanceiro)) {
        return statusFinanceiroTexto($relatorioFinanceiro);
    }

    $limite = calcularLimitePrimeiroPagamento($dataCadastro);
    $hoje = new DateTime('today');

    if ($hoje <= $limite) {
        return 'Gratuito até ' . $limite->format('d/m/Y');
    }

    return 'Sem registro';
}

function proximoTreinoTexto(){
    // Implementar quando existir a tabela de treinos.
    return 'Quarta-feira, 18:00';
}

function montarInstagram($instagram){
    return '@' . ltrim($instagram, '@');
}

function createAtletaView($dadosAtleta, $relatorioFinanceiro){
    return [
        'nome'           => $dadosAtleta['name_atl'],
        'posicao'        => $dadosAtleta['position_atl'],
        'equipe'         => $dadosAtleta['team_atl'],
        'instagram'      => montarInstagram($dadosAtleta['instagram_atl']),
        'foto'           => fotoPadrao(),
        'financeiro'     => statusFinanceiroComGratuidade($relatorioFinanceiro, $dadosAtleta['created_at']),
        'proximo_treino' => proximoTreinoTexto(),
    ];
}

function numeroWhatsAppPadrao(){
    return '5551999999999';
}

function montarMensagemWhatsApp($tipo, $atleta){
    $texto = "Olá! Gostaria de pagar a {$tipo} do atleta {$atleta['nome']}, da equipe {$atleta['equipe']}.";
    return rawurlencode($texto);
}

function podePagarMensalidadeHoje(){
    return diaDoMes() <= 5;
}

function diaDoMes(){
    return (int) date('j');
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

$idAtleta = getLoggedAtletaId();

if (!isLogado($idAtleta)) {
    redirectTo('index.php?login=required');
}

$pdo = conectMYSQL();

$dadosAtleta = buscarAtletaPorId($pdo, $idAtleta);

if (!atletaExiste($dadosAtleta)) {
    encerrarSessao();
    desconectMYSQL($pdo);
    redirectTo('index.php?login=required');
}

$equipe = buscarEquipePorTime($pdo, $dadosAtleta['team_atl']);

$pagamentos = buscarPagamentosPorAtleta($pdo, $idAtleta);
$relatorioFinanceiro = montarRelatorioFinanceiro($pagamentos);
$atleta = createAtletaView($dadosAtleta, $relatorioFinanceiro);

desconectMYSQL($pdo);

$numeroWhatsApp = numeroWhatsAppPadrao();
$mensagemWhatsApp = static fn(string $tipo): string => montarMensagemWhatsApp($tipo, $atleta);

$podePagarMensalidade = podePagarMensalidadeHoje();
?>
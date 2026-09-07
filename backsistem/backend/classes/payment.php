<?php

function calcularDataExpiracao($tipoPagamento, $dataPagamento){
    $data = new DateTime($dataPagamento);

    if ($tipoPagamento === 'mensalidade') {
        $data->modify('first day of next month');
        $data->setDate((int) $data->format('Y'), (int) $data->format('m'), 5);
        return $data->format('Y-m-d');
    }

    if ($tipoPagamento === 'diaria') {
        $data->modify('next Saturday');
        return $data->format('Y-m-d');
    }

    throw new InvalidArgumentException('Tipo de pagamento inválido.');
}

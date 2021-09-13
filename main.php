<?php

require_once __DIR__ . '/vendor/autoload.php';

use Moovin\Job\Backend\ContaCorrente as ContaCorrente;
use Moovin\Job\Backend\ContaPoupanca as ContaPoupanca;

$contaCorrente = new ContaCorrente();
$contaPoupanca = new ContaPoupanca();

$contaCorrente->depositar(5000);
$contaPoupanca->depositar(3000);

do {
    do {
        $linha = readline("Informe o tipo de conta: \n 1 - Conta corrente; \n 2 - Poupança " . PHP_EOL );
    } while ($linha > 2);

    if ($linha == 1) {
        $contaPrincipal = $contaCorrente;
        $contaSecundaria = $contaPoupanca;
    } else {
        $contaPrincipal = $contaPoupanca;
        $contaSecundaria = $contaCorrente;
    }

    echo " Transação que deseja realizar: \n
        1 - Consultar saldo; \n
        2 - Deposito; \n
        3 - Saque; \n
        4 - Transferência; \n
        5 - Sair. \n";
    $transacao = readline(" ");

    switch ($transacao) {
        case 1:
            $saldoConta = $contaPrincipal->getSaldoConta();
            echo "\n Saldo atual da conta é B$ " .number_format($saldoConta,2,",","."). " " . PHP_EOL;
            break;

        case 2:
            $valor = (float) readline("Valor a ser depositado: ");
            $resultado = $contaPrincipal->depositar($valor);
            echo "\n " . $resultado . PHP_EOL;
            break;

        case 3:
            $valor = (float) readline("Valor que deseja sacar: ");
            $resultado = $contaPrincipal->sacar($valor);
            echo "\n " . $resultado['message'] . " " . PHP_EOL;
            break;

        case 4:
            $valor = (float) readline("Valor que deseja transferir: ");
            $resultado = $contaPrincipal->transferir($contaSecundaria, $valor);
            echo "\n " . $resultado['message'] . " " . PHP_EOL;
            break;

        default:
            "Opção inválida." . PHP_EOL;
            break;
    }
} while ($transacao != 5);
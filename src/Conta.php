<?php

namespace Moovin\Job\Backend;

/**
 * Classe abstrata da Conta
 *
 * @author Adriane Bobsin <adrianebobsin@gmail.com.br>
 */
abstract class Conta
{
    protected $saldo;

    public function __construct()
    {
        $this->saldo = 0.00;
    }

    /**
    * Retorna o saldo da conta
    */
    public function getSaldoConta()
    {
        return $this->saldo; 
    }

    /**
     * Função que recebe um valor para deposito em conta
     * e soma ao valor que já consta nesta conta
     * 
     * @param $valor
     * @return String
     */
     public function depositar($valor)
     {
        $this->saldo += $valor;
        return "Depósito realizado com sucesso!";
     }

     /**
     * Função que recebe o valor a ser retirado de uma
     * conta validando se este valor excede o saldo total
     * 
     * @param $valor
     * @return array
     */
    public function sacar($valor)
    {
        $saldoAtual = $this->getSaldoConta();

        //Valida se o saque está dentro do limite de saque do tipo de conta
        if ($valor > $this->limiteSaque) {
            return array('status' => false, 'message' => "Valor maior que o limite de saque permitido para este tipo de conta. Seu limite de saque é: B$ " .number_format($this->limiteSaque,2,",","."). " ");
        }

        //Valida se o saldo é sufiente para realizar o saque
        if (($valor + $this->taxaOperacao) > $saldoAtual) {
           return array('status' => false, 'message' => "Saldo insuficiente. Saldo atual da conta: B$ ".number_format($this->saldo,2,",",".")." ");
        }

        $this->saldo -= ($valor + $this->taxaOperacao);
        return array('status' => true, 'message'=> "Saque efetuado com sucesso! Saldo atual da conta: B$ ".number_format($this->saldo,2,",",".")." ");
    }

    /**
    * Tranfere o valor informado para a conta indicada
    * 
    * @param $contaDestino, $valor
    * @return array
    */
    public function transferir($contaDestino, $valor)
    {
        $saldoAtual = $this->getSaldoConta();
        if ($valor > $saldoAtual) {
            return array('status' => false, 'message' => "Saldo insuficiente para realizar a transação. Saldo atual da conta: B$ ".number_format($saldoAtual,2,",",".")." ");
        }

        $this->saldo -= $valor;
        $contaDestino->depositar($valor);
        return array('status' => true, 'message' => "Transferência realizada com sucesso. Saldo atual da conta: B$ ".number_format($this->saldo,2,",",".")." ");
    }
    
}
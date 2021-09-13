<?php

namespace Moovin\Job\Backend\Tests;

use Moovin\Job\Backend;

/**
 * Teste unitário da classe Moovin\Job\Backend\ContaPoupança
 */
class ContaPoupancaTest extends \PHPUnit_Framework_TestCase
{
    /** @var Backend\ContaPoupança */
    protected $saldoConta;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->contaPoupanca = new Backend\ContaPoupanca();
        $this->contaPoupanca->depositar(900);
        $this->contaCorrente = new Backend\ContaCorrente();
    }

    /**
     * @covers Moovin\Job\Backend\ContaPoupanca::depositar
     */
    public function testDeposito()
    {
        $this->assertEquals('Depósito realizado com sucesso!', $this->contaPoupanca->depositar(900));
    }

    public function testSaqueLimiteParaSaqueExcedido() 
    {
        $this->assertEquals(array('status' => false, 'message' => "Valor maior que o limite de saque permitido para este tipo de conta. Seu limite de saque é: B$ 1.000,00 "), $this->contaPoupanca->sacar(2000));
    }

    public function testSaqueSaldoInsuficiente() 
    {
        $this->assertEquals(array('status' => false, 'message' => "Saldo insuficiente. Saldo atual da conta: B$ 900,00 "), $this->contaPoupanca->sacar(990));
    }

    public function testSaqueSaldoSuficiente() 
    {
        $this->assertEquals(array('status' => true, 'message' => "Saque efetuado com sucesso! Saldo atual da conta: B$ 649,20 "), $this->contaPoupanca->sacar(250));
    }

    public function testTransferirSaldoInsuficiente() 
    {
        $this->assertEquals(array('status' => false, 'message' => "Saldo insuficiente para realizar a transação. Saldo atual da conta: B$ 900,00 "), $this->contaPoupanca->transferir($this->contaPoupanca, 950));
    }

    public function testTransferirSaldoSuficiente() 
    {
        $this->assertEquals(array('status' => true, 'message' => "Transferência realizada com sucesso. Saldo atual da conta: B$ 900,00 "), $this->contaPoupanca->transferir($this->contaPoupanca, 200));
    }
}

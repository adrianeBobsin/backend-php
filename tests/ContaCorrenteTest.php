<?php

namespace Moovin\Job\Backend\Tests;

use Moovin\Job\Backend;

/**
 * Teste unitário da classe Moovin\Job\Backend\ContaCorrente
 */
class ContaCorrenteTest extends \PHPUnit_Framework_TestCase
{
    /** @var Backend\ContaCorrente */
    protected $saldoConta;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->contaCorrente = new Backend\ContaCorrente();
        $this->contaCorrente->depositar(500);
        $this->contaPoupanca = new Backend\ContaPoupanca();
    }

    /**
     * @covers Moovin\Job\Backend\ContaCorrente::depositar
     */
    public function testDeposito()
    {
        $this->assertEquals('Depósito realizado com sucesso!', $this->contaCorrente->depositar(500));
    }

    public function testSaqueLimiteParaSaqueExcedido() 
    {
        $this->assertEquals(array('status' => false, 'message' => "Valor maior que o limite de saque permitido para este tipo de conta. Seu limite de saque é: B$ 600,00 "), $this->contaCorrente->sacar(700));
    }

    public function testSaqueSaldoInsuficiente() 
    {
        $this->assertEquals(array('status' => false, 'message' => "Saldo insuficiente. Saldo atual da conta: B$ 500,00 "), $this->contaCorrente->sacar(550));
    }

    public function testSaqueSaldoSuficiente() 
    {
        $this->assertEquals(array('status' => true, 'message' => "Saque efetuado com sucesso! Saldo atual da conta: B$ 447,50 "), $this->contaCorrente->sacar(50));
    }

    public function testTransferirSaldoInsuficiente() 
    {
        $this->assertEquals(array('status' => false, 'message' => "Saldo insuficiente para realizar a transação. Saldo atual da conta: B$ 500,00 "), $this->contaCorrente->transferir($this->contaPoupanca, 900));
    }

    public function testTransferirSaldoSuficiente() 
    {
        $this->assertEquals(array('status' => true, 'message' => "Transferência realizada com sucesso. Saldo atual da conta: B$ 400,00 "), $this->contaCorrente->transferir($this->contaPoupanca, 100));
    }
}

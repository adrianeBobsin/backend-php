<?php

namespace Moovin\Job\Backend;

/**
 * Classe de conta poupança
 *
 * @author Adriane Bobsin <adrianebobsin@gmail.com.br>
 */
class ContaPoupanca extends Conta
{
    protected $limiteSaque  = 1000.00;
    protected $taxaOperacao = 0.80;

    public function __construct()
    {
        parent::__construct();
    }
}
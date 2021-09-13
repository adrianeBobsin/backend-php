<?php

namespace Moovin\Job\Backend;

/**
 * Classe de conta corrente
 *
 * @author Adriane Bobsin <adrianebobsin@gmail.com.br>
 */
class ContaCorrente extends Conta
{
    protected $limiteSaque  = 600.00;
    protected $taxaOperacao = 2.50;
    
    public function __construct()
    {
        parent::__construct();
    }
}
<?php

namespace ExchangeModel\Enum;

enum WithdrawalTypeEnum: string
{
    case BLOCKCHAIN = 'blockchain';
    case INTERNAL   = 'internal';
}
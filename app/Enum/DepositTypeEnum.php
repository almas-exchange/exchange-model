<?php

namespace ExchangeModel\Enum;

enum DepositTypeEnum: string
{
    case BLOCKCHAIN = 'blockchain';
    case INTERNAL   = 'internal';
}
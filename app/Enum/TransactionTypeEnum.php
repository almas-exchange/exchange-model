<?php

namespace ExchangeModel\Enum;

enum TransactionTypeEnum: string
{
    case DEPOSIT    = 'deposit';
    case WITHDRAWAL = 'withdrawal';
    case FEE        = 'fee';
    case GIFT       = 'gift';
    case REFERRAL   = 'referral';
    case TRADE      = 'trade';
}
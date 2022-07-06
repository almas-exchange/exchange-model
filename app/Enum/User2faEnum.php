<?php

namespace ExchangeModel\Enum;

enum User2faEnum: string
{
    case OFF = 'off';
    case SMS = 'sms';
    case TOTP  = 'totp';
}
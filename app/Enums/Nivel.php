<?php

namespace App\Enums;

enum Nivel:string
{
    CASE ADMIN = "admin";
    CASE MOD = "modelador";
    CASE FIRST = "FinaceiroFirst";
    CASE SECOND = "FinanceiroSecond";

    public function getValue():string
    {
        return $this->value;
    }
}

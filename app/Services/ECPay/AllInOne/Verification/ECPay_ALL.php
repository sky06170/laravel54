<?php

namespace App\Services\ECPay\AllInOne\Verification;

/**
 *  付款方式：全功能
 */
class ECPay_ALL extends ECPay_Verification
{
    public  $arPayMentExtend = array();

    function filter_string($arExtend = array(),$InvoiceMark = ''){
        return $arExtend ;
    }
}
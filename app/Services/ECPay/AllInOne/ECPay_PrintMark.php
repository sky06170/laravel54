<?php

namespace App\Services\ECPay\AllInOne;

/**
 * 電子發票列印註記
 */
abstract class ECPay_PrintMark {
    // 不列印
    const No = '0';

    // 列印
    const Yes = '1';
}
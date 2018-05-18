<?php

namespace App\Services\ECPay\AllInOne;

/**
 * 定期定額的週期種類。
 */
abstract class ECPay_PeriodType {

    /**
     * 無
     */
    const None = '';

    /**
     * 年
     */
    const Year = 'Y';

    /**
     * 月
     */
    const Month = 'M';

    /**
     * 日
     */
    const Day = 'D';

}
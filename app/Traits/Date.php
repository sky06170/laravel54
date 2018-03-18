<?php

namespace App\Traits;

use Carbon\Carbon;

Trait Date
{

    //取得兩個日期間的差異天數
    public static function diffDays($start_date,$end_date)
    {

        $diffDataA = Carbon::createFromFormat('Y-m-d',$start_date,'Asia/Taipei');

        $diffDataB = Carbon::createFromFormat('Y-m-d',$end_date,'Asia/Taipei');

        return $diffDataA->diff($diffDataB)->days + 1;

    }

    public static function now($tz = 'Asia/Taipei')
    {
        return Carbon::now($tz);
    }

    /**
     * 轉換Carbon日期時間物件
     *
     * @param $datetime
     * @return static
     */
    public static function object($datetime)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$datetime,'Asia/Taipei');
    }

    /**
     * 轉換unix時間戳
     *
     * @param $datetime
     * @return int
     */
    public static function timeStamp($datetime)
    {
        return Carbon::parse($datetime)->getTimestamp();
    }

}
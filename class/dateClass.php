<?php

/* 日時表示用クラス */
class dateClass {
    var $start_year;
    var $month;
    var $day;
    var $end_year;

    // コンストラクタ
    function __construct($start_year='', $end_year='') {
        if ($start_year)  $this->setStartYear($start_year);
        if ($end_year)    $this->setEndYear($end_year);
    }

    function setStartYear($year) {
        $this->start_year = $year;
    }

    function getStartYear() {
        return $this->start_year;
    }

    function setEndYear($endYear) {
        $this->end_year = $endYear;
    }

    function getEndYear() {
        return $this->end_year;
    }

    function setMonth($month) {
        $this->month = $month;
    }

    function setDay($day) {
        $this->day = $day;
    }

    /**
     * 年プルダウン用の配列を返す
     * FIXME $default_year に一致いる行が無かった場合、先頭か末尾に付加すべきと思われる。
     * @param string $year    XMLファイル名
     * @param bool|string $default_year
     *     false  「選択なし」は含めない。
     *     true   「選択なし」は含める。
     *     string 「選択なし」は指定された値の下に付加する。
     * @param string $default_key
     */
    function getYear($year = '', $default_year = false, $default_key = '') {
        if ($year) $this->setStartYear($year);

        $year = $this->start_year;
        if (! $year) $year = DATE('Y');

        $end_year = $this->end_year;
        if (! $end_year) $end_year = (DATE('Y') + 3);

        $year_array = array();

        if ($default_year === true) {
            $year_array[$default_key] = '';
        }

        for ($i = $year; $i <= $end_year; $i++) {
            $year_array[$i] = $i;
            if ($default_year !== true && strlen($default_year) >= 1 && $i == $default_year) {
                $year_array[$default_key] = '';
            }
        }
        return $year_array;
    }

    function getZeroYear($year = '') {
        if ($year) $this->setStartYear($year);

        $year = $this->start_year;
        if (! $year) $year = DATE('Y');

        $end_year = $this->end_year;
        if (! $end_year) $end_year = (DATE('Y') + 3);

        $year_array = array();

        for ($i = $year; $i <= $end_year; $i++) {
            $key = substr($i, -2);
            $year_array[$key] = $key;
        }
        return $year_array;
    }

    function getZeroMonth() {

        $month_array = array();
        for ($i=1; $i <= 12; $i++) {
            $val = sprintf('%02d', $i);
            $month_array[$val] = $val;
        }
        return $month_array;
    }   

    function getMonth($default = false) {
        $month_array = array();

        if ($default) $month_array[''] = '';

        for ($i=0; $i < 12; $i++) {
            $month_array[$i + 1 ] = $i + 1;
        }
        return $month_array;
    }   

    function getDay($default = false) {
        $day_array = array();

        if ($default) $day_array[''] = '';

        for ($i=0; $i < 31; $i++) {
            $day_array[ $i + 1 ] = $i + 1;
        }

        return $day_array;
    }

    function getHour() {

        $hour_array = array();
        for ($i=0; $i<=23; $i++) {
            $hour_array[$i] = $i;
        }

        return $hour_array;
    }

    function getMinutes() {

        $minutes_array = array();
        for ($i=0; $i<=59; $i++) {
            $minutes_array[$i] = $i;
        }

        return $minutes_array;
    }

    function getMinutesInterval() {

        $minutes_array = array('00'=>'00', '30'=>'30');
        return $minutes_array;
    }
}
?>

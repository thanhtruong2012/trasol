<?php
/**
 * class Entity file.
 * @copyright 2018 LP Group.
 * @since 1.0
 */

class Entity
{
    public function __construct(){
        $this->db = Database::instance("conn1");
        $this->arr_currency = array('AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM',
        'BBD', 'BDT', 'BGN', 'BHD', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BTC', 'BTN', 'BWP', 'BYR', 'BZD', 'CAD', 'CDF', 'CHF', 'CLF',
        'CLP', 'CNY', 'COP', 'CRC', 'CUP', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ERN', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL',
        'GHS', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'IQD', 'IRR', 'ISK', 'JMD', 'JOD',
        'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KPW', 'KRW', 'KWD', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'LTL', 'LVL', 'LYD', 'MAD',
        'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD',
        'OMR', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SDG', 'SEK', 'SGD',
        'SHP', 'SLL', 'SOS', 'SRD', 'STD', 'SVC', 'SYP', 'SZL', 'THB', 'TJS', 'TMT', 'TND', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX',
        'USD', 'UYU', 'UZS', 'VEF', 'VND', 'VUV', 'WST', 'XAF', 'XAG', 'XAU', 'XCD', 'XDR', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMK', 'ZMW', 'ZWL');
    }
    
    public function setConn($name = "conn1"){
        $this->db = Database::instance($name);
    }
    
    protected function get_car_seat($cus_num){
        $car_seat = 0;
        if ($cus_num >= 1 && $cus_num <= 2) {
            $car_seat = 4;
        } else if ($cus_num >= 3 && $cus_num <= 6) {
            $car_seat = 15;
        } else if ($cus_num >= 7 && $cus_num <= 9) {
            $car_seat = 29;
        } else if ($cus_num >= 10 && $cus_num <= 19) {
            $car_seat = 35;
        } else if ($cus_num >= 20 && $cus_num <= 29) {
            $car_seat = 45;
        }
        return $car_seat;
    }
    
    protected function is_url_exist($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }
    
    public function markup($price, $mark_value, $mark_type, $currency = '') {
        if (!empty($price)) {
            $mark_value = (!empty($mark_value)) ? $mark_value : 0;
            $mark_type = (!empty($mark_type)) ? $mark_type : 1;
            if ($mark_type == 1) {
                $price += $mark_value;
            } else if ($mark_type == 2) {
                if (((100 - $mark_value) / 100) != 0 && $price > 0) {
                    $price = ceil($price / ((100 - $mark_value) / 100));
                }
            }
            if (!empty($currency)) {
                $price = ceil(($price * $currency) / 100) * 100;
            }
        }
        return number_format($price);
    }
    
    protected function get_created_at(){
        return date("Y-m-d H:i:s");
    }
    
}
?>
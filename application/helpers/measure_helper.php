<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('cm2feetIn') || !function_exists('feetIn2Cm') || !function_exists('kg2pound')) {

    /**
     * @param $cm
     * @return array
     */
    function cm2feetIn($cm)
    {
        $inches = (int) $cm / 2.54;
        $feet = intval($inches / 12);
        $inches = round(fmod($inches, 12), 2);
        return ['ft' => $feet, 'in' => $inches];
    }

    /**
     * @param $ft
     * @param $in
     * @return integer|float
     */
    function feetIn2Cm($ft, $in)
    {
        $cm = round((int)$in * 0.39370079 + (int)$ft * 30.48, 2);
        return $cm;
    }

    /**
     * @param  $kg
     * @return float
     */
    function kg2pound($kg)
    {
        $pou = round((int) $kg * 2.2046226218, 2);
        return $pou;
    }
}
<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');


class rpd_date_helper {

    public static function iso2human($date)
    {
        if ((strpos($date,"0000-00-00")!==false) || ($date==""))
            return "";
        return preg_replace('#^(\d{4})-(\d{2})-(\d{2})( \d{2}:\d{2}:\d{2})?#', '$3/$2/$1$4', $date);
    }

    // --------------------------------------------------------------------

    public static function human2iso($date)
    {
        return preg_replace('#^(\d{2})/(\d{2})/(\d{4})( \d{2}:\d{2}:\d{2})?#', '$3-$2-$1$4', $date);
    }

    public static function ago($date,
                               $singular = array('year', 'month', 'day', 'hour', 'mitune', 'second'),
                               $plurals = array('years', 'months', 'days', 'hours', 'minutes', 'seconds'), $ago = 'ago')
    {
        $date = getdate(strtotime($date));
        $current = getdate();
        $p = array('year', 'mon', 'mday', 'hours', 'minutes', 'seconds');
        $factor = array(0, 12, 30, 24, 60, 60);

        for ($i = 0; $i < 6; $i++) {
            if ($i > 0) {
                $current[$p[$i]] += $current[$p[$i - 1]] * $factor[$i];
                $date[$p[$i]] += $date[$p[$i - 1]] * $factor[$i];
            }
            if ($current[$p[$i]] - $date[$p[$i]] > 1) {
                $value = $current[$p[$i]] - $date[$p[$i]];
                return $value . ' ' . (($value != 1) ? $plurals[$i] :  $singular[$i]) . ' ' . $ago;
            }
        }

        return '';
    }


}

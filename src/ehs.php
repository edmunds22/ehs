<?php

namespace edmunds22\ehs;

/**
 * Class ehs
 * @package edmunds22\ehs
 */
class ehs
{

    /**
     * hello world!
     *
     * @return string
     */
    public static function helloWorld()
    {
        return 'hello world!';
    }

    public static function forceDownload($path)
    {
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . basename($path) . "\"");
        readfile($path);
        exit();
    }

    /**
     * Convert input value into a float value of X precision
     *
     * Example: $1,123.3 = 1123.30 (with precision 2)
     *
     * @param $in String
     * @param $points Integer
     * @return string
     */
    public static function filteredFloat($in, $points = 2)
    {
        return number_format((float) preg_replace("/[^0-9.]/", "", $in), $points, '.', '');
    }

    /**
     * Convert a flat array of values into a commented-comma-separated list for use on MySql 'IN' statements
     *
     * Example: array(1,2,3) = '1', '2', '3'
     *
     * Warning: Input array should be correctly sanitized
     *
     * @param $inputs Array
     * @return string
     */
    public static function arrayToSqlInList($inputs = [])
    {
        return "'" . implode("'" . "," . "'", $inputs) . "'";
    }

    /**
     * Return a string with non alpha-num-space characters removed
     *
     * @param $input
     * @return string
     */
    public static function alphaNumSp($input = '')
    {
        return preg_replace("/[^A-Za-z0-9 ]/", "", $input);
    }

    /**
     * Return a string with uncommon search string characters removed
     *
     * @param $input
     * @return string
     */
    public static function searchValue($input = '')
    {
        return preg_replace("/[^A-Za-z&.0-9 ]/", "", $input);
    }

    /**
     * Validate a string is in Y-m-d format
     *
     * @param $date
     * @return bool
     */
    public static function validateYMD($date)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $date);
        if (!$date) {
            return false;
        }
        return true;
    }

    /**
     * Validate a string is in d/m/Y format
     *
     * @param $date
     * @return bool
     */
    public static function validateDMY($date)
    {
        $date = \DateTime::createFromFormat('d/m/Y', $date);
        if (!$date) {
            return false;
        }
        return true;
    }

    /**
     * Convert the format of a date string
     *
     * @param $in
     * @param $out
     * @param string $string
     * @return string
     */
    public static function convertDateString($in, $out, $string)
    {
        return \DateTime::createFromFormat($in, $string)->format($out);
    }

    /**
     * Add X amount of days to a date string, returning a string
     *
     * @param $date
     * @param $numberOfDays
     * @param string $format
     * @return string
     */
    public static function addDaysToDateString($date, $numberOfDays, $format = 'd/m/Y')
    {
        return \DateTime::createFromFormat($format, $date)->modify('+' . $numberOfDays . ' day')->format($format);
    }

    /**
     * Get the week day index of a day name
     *
     * @param string $day
     * @param int $start - set to 1 to start with Monday = 1, rather than 0
     * @return int
     */
    public static function weekDayIndex($day = 'Mon', $start = 0)
    {
        $index = 0;

        switch ($day) {
            case "Tue":
                $index = 1;
                break;
            case "Wed":
                $index = 2;
                break;
            case "Thu":
                $index = 3;
                break;
            case "Fri":
                $index = 4;
                break;
            case "Sat":
                $index = 5;
                break;
            case "Sun":
                $index = 6;
                break;
        }

        if ($start === 1) {
            $index = $index + 1;
        }

        return $index;
    }

    public static function generateSlug($input, $delimiter = '-')
    {

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $input))))), $delimiter));

        return $slug;

    }

    public static function spamFinder($input)
    {

        $checking = [
            'instant sales leads',
            'CNN World Today',
            'My name is eric',
            'Millions of instant sales leads',
            'Business database',
            'Marketing package',
            'showbiz',
            'Backlink',
            'tiktok',
            'phenyl',
            'betting',
            'casino',
            'leadgeneration',
            'lead generation',
            'authority boost',
            'реклама',
            'Уаndех'
        ];
        foreach ($checking as $chk) {
            if (stripos($chk, $input) !== false) {
                return true;
            }
        }

        return false;

    }

    //credit to https://stackoverflow.com/users/251760/jonathan
    public static function timezoneList() {
        static $timezones = null;
    
        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new \DateTime('now', new \DateTimeZone('UTC'));
    
            foreach (\DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new \DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[$timezone] = '(' . self::format_GMT_offset($offset) . ') ' . self::format_timezone_name($timezone);
            }
    
            array_multisort($offsets, $timezones);
        }
    
        return $timezones;
    }
    
    private static function format_GMT_offset($offset) {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }
    
    private static function format_timezone_name($name) {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }

}

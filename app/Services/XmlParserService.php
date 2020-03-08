<?php

namespace App\Services;

use Illuminate\Support\Arr;

class XmlParserService
{
    public function parse($file_path = null, string $str = '')
    {
        if($file_path === null) {
            return false;
        }

        $xml_str = file_get_contents($file_path);
        $xml = simplexml_load_string($xml_str);
        $to_string = json_encode($xml); // convert to string
        $to_array = json_decode($to_string, true); // convert to array

        if(strlen($str) > 1) {
            return $this->selectByPath($to_array, $str);
        }

        return $to_array;
    }

    public function pluck(array $data, string $keys)
    {
        $results = [];
        $keys = explode(".", $keys);

        foreach($data as $value) {
            $obj = [];

            foreach($keys as $key) {
                $obj[$key] = $value[$key];
            }

            array_push($results, $obj);
        }

        return $results;
    }

    protected function selectByPath(array $data, $str) {
        $result = Arr::get($data, $str);

        return $result;
    }
}

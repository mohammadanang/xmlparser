<?php

namespace App\Http\Controllers;

use App\Services\XmlParserService;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->food = public_path() . "\xml\simple.xml";
        $this->plant = public_path() . "\xml\plant_catalog.xml";
        $this->complex = public_path() . "\xml\complex.xml";
    }

    public function index(XmlParserService $parser)
    {
        $input = request()->file_name;
        
        if($input) {
            switch ($input) {
                case 'food':
                    $xml = $this->food;
                    break;
                case 'plant':
                    $xml = $this->plant;
                    break;
                case 'complex':
                    $xml = $this->complex;
                    break;
                default:
                    $xml = $this->food;
            }

            $keys = '';
            $param = '';
            if($name = request()->name) {
                $param = $name;
            }

            if($keys = request()->keys) {
                $keys = $keys;
            }

            $items = $parser->parse($xml, $param);
            if($param and strpos($param, ".0") == false and $keys) {
                $items = $parser->pluck($items, $keys);
            }

            return response()->json([
                'data'      => $items,
                'xml'       => file_get_contents($xml)
            ]);
        }

        return response()->json([
            'status'    => 'error',
            'message'   => '`file_name` input cannot be null'
        ]);
    }
}
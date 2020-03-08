<?php

namespace App\Http\Controllers;

use App\Services\XmlParserService;

class ApiController extends Controller
{
    public function food(XmlParserService $parser)
    {
        $xml = base_path() . "\public\xml\simple.xml";

        $keys = '';
        $param = '';
        if($name = request()->name) {
            $param = $name;
        }

        if($keys = request()->keys) {
            $keys = $keys;
        }

        $items = $parser->parse($simple_xml, $param);
        if($param and strpos($param, ".") == false and $keys) {
            $items = $parser->pluck($items, $keys);
        }

        return response()->json([
            'data'      => $items,
            'xml'       => file_get_contents($xml)
        ]);
    }

    public function plant(XmlParserService $parser)
    {
        $xml = base_path() . "\public\xml\plant_catalog.xml";

        $keys = '';
        $param = '';
        if($name = request()->name) {
            $param = $name;
        }

        if($keys = request()->keys) {
            $keys = $keys;
        }

        $items = $parser->parse($simple_xml, $param);
        if($param and strpos($param, ".") == false and $keys) {
            $items = $parser->pluck($items, $keys);
        }

        return response()->json([
            'data'      => $items,
            'xml'       => file_get_contents($xml)
        ]);
    }
}
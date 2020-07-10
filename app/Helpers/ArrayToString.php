<?php

namespace Shareexo\Helpers;

use \inArray;

class ArrayToString {

    public function transform(array $array, $excludes):string
    {
        $string = "";
        foreach($array as $index => $value){
            if(in_array($index, $excludes)){
                $string .= "";
            } else {
                $string .= strtoupper($index). ": $value".PHP_EOL;
            }            
        }
        return $string;
    }

    /*
    public function inArray($value, $array):bool
    {
        $valMode = 0;
        for($i = 0; $i <= count($array) - 1; $i++){
            if($array[$i] == $value){
                $valMode++;
            }
        }

        return $valMode > 0;
    }
    */

}
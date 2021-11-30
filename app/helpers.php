<?php

function getThumbs($url=""){
        $base = basename($url);
        if (strpos($url, 'https://') !== false or strpos($url, 'http://') !== false) {
            return str_replace($base, "thumbs/".$base, $url);
        }else{
            $preUrl = "storage/";
            $beforeBase = str_replace($base, "",$url);
            return $preUrl.$beforeBase.'thumbs/'.$base;
        }
    }
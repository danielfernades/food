<?php 

if (!defined('getDisplayName')) {
    function getDisplayName($fromName)
    {
        $name = implode(array_map('ucfirst',explode('-',$fromName)),' ');
        $name = implode(array_map('ucfirst',explode('_',$name)),' ');
        return $name;
    }
}


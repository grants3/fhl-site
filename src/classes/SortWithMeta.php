<?php
class SortWithMeta {
    private static $meta;
    
    static function sort(&$terms, $meta) {
        self::$meta = $meta;
        usort($terms, array("SortWithMeta", "cmp_method"));
    }
    
    static function cmp_method($a, $b) {
        $meta = self::$meta; //access meta data
        // do comparison here
    }
    
}

// usage
//SortWithMeta::sort($terms, array('hello'));
<?php
//namespace api;

abstract class AbstractApiResponse {
    
    function __construct() {
        
    }
    
    public abstract function setData($data);
    
}

?>
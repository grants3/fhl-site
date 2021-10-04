<?php
//namespace api;

require_once __DIR__.'/../baseConfig.php';

class ApiRequest {
    
    protected $_resource;
    protected $_extension;
    protected $_filter;
    protected $_sorting;
    protected $_completeURI;
    protected $_method;
    protected $_httpHeaders;
    
    function __construct($requestURI) {
        
        //$requestURI = strstr($requestURI, '/api/', false);
        $arr = explode('/api', $requestURI);
        $requestURI = $arr[1];
        
        //$requestURI = str_replace("/proj/api/v1", "", $requestURI);
        $dotPos = strpos($requestURI, ".", 0);
        if ($dotPos == false) {
            $extension = "json";
            $reqPos = strpos($requestURI, "?", 0);
            if ($reqPos == false) $reqPos = 9999999;
            $resource = substr($requestURI, 0, $reqPos);
            if ($resource == false) $resource = $requestURI;
        }
        else {
            $dotPos++;
            $reqPos = strpos($requestURI, "?", $dotPos);
            $extension = substr($requestURI, $dotPos, ($reqPos - $dotPos));
            if ($extension == false) $extension = substr($requestURI, $dotPos);
            $resource = substr($requestURI, 0, $dotPos);
        }

        if(isset($_REQUEST["resource"])) $resource = $_REQUEST["resource"];

        $sorting = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "";
        $filter = isset($_REQUEST["filter"]) ? $_REQUEST["filter"] : "";
        
        $this->_completeURI = $requestURI;
        $this->_resource = $resource;
        $this->_extension = $extension;
        $this->_filter = $filter;
        $this->_sorting = $sorting;
        $this->_filter = $filter;
        $this->_method = $_SERVER['REQUEST_METHOD'];
        $this->_httpHeaders = getallheaders();
        
    }
    
    public function getResource() {
        return $this->_resource;
    }
    
    public function getCompleteURI() {
        return $this->_completeURI;
    }
    
    public function getExtension() {
        return $this->_extension;
    }
    
    public function getFilter() {
        return $this->_filter;
    }
    
    public function getSorting() {
        return $this->_sorting;
    }
    
    public function getHTTPHeaders() {
        return $this->_httpHeaders;
    }
    
    public function getHTTPMethod() {
        return $this->_method;
    }
    
    public function toArray() {
        return array(
            "completeURI" => $this->_completeURI,
            "method" => $this->_method,
            "resource" => $this->_resource,
            "extension" => $this->_extension,
            "filter" => $this->_filter,
            "sorting" => $this->_sorting,
            "httpHeaders" => $this->_httpHeaders
        );
    }
    
}
?>

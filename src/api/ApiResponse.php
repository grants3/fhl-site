<?php
//namespace api\scoring;

class ApiResponse extends AbstractApiResponse {
    
    protected $_data;
    protected $_delay;
    
    function __construct() {
        
    }
    
    public function setData($data) {
        $this->_data = $data;
    }
    
    public function setDelay($delay) {
        $this->_delay = $delay;
    }
    
    public function asXML() {
        $xml = new SimpleXMLElement('<root/>');
        array_to_xml($this->_data,$xml);
        return $xml->asXML();
    }
    
    public function asJSON() {
        return json_encode($this->_data);
    }
    
}

?>
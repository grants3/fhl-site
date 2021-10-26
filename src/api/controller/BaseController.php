<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

class BaseController
{
    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
    
    /**
     * Get URI elements.
     *
     * @return array
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
        
        return $uri;
    }
    
    /**
     * Get querystring params.
     *
     * @return array
     */
    protected function getQueryStringParams()
    {        
        parse_str($_SERVER['QUERY_STRING'], $array);

        return $array;
    }
    
    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        
        echo $data;
        exit;
    }
    
    protected function dynamicFiltering(array $data, string $columnData, $searchValue, bool $searchRegex){
        return array_filter($data, function ($var) use($searchValue,$searchRegex,$columnData) {
            
            $_search = call_user_func(array($var, 'get'.ucfirst($columnData)));
            
            if($searchRegex)  return preg_match('/(?i)'.$searchValue.'/', $_search);

            return $_search == $searchValue;
            
        });
    }
    
}

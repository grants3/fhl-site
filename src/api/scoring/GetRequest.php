<?php
namespace api\scoring;

include_once 'GetSearch.php';

class GetRequest
{
//     private $draw;
//     private $columns = array();
//     private $start = 0;
//     private $length = 0;
    private $search;
    private $order;
    
    public function __construct() {
        //$this->search= new GetSearch();
       // $this->order = null;
    }

    /**
     * @return mixed
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * @return multitype:
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return number
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return number
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return multitype:
     */
    public function getSearch() : GetSearch
    {
        return $this->search;
    }

    /**
     * @return multitype:
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $draw
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;
    }

    /**
     * @param multitype: $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    /**
     * @param number $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @param number $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @param multitype: $search
     */
    public function setSearch(GetSearch $search)
    {
        //$getSearch = new GetSearch();
        $this->search = $search;
    }

    /**
     * @param multitype: $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }


    
//     public function loadFromArray($array) {
//         //error_log(print_r($array,1));
//         $class = new \ReflectionClass(get_class($this));
//         $instance = $this;
//         $props = $class->getProperties();
//         foreach($props as $p) {
//             error_log($p->getName());
//             if (isset($array[$p->getName()])){
//                 $p->setAccessible(true);
//                 $p->setValue($class, $array[$p->getName]);
//             }
            
//         }
//         return $class;
//     }
    public function loadFromArray($array) {
        $class = new \ReflectionClass(get_class($this));
        $props = $class->getProperties();
        foreach($props as $p) {
            $propertyName = $p->getName();
            if (isset($propertyName)){
                $p->setAccessible(true);
                
                if($propertyName == 'getSearch'){
                    
                }else{
                    $p->setValue($this, $array[$propertyName]);
                }
              
            }
                
        }
        
      
    }
    
//     /*
//      * override handling if method does not exist
//      */
//     public function __call($name, $arguments) {
//         if (!method_exists($this, $name)) {
//             //throw new \BadMethodCallException($name . ' method does not exist');
//         }
//     }
    
    
    
}


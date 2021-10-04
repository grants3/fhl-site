<?php
namespace api\scoring;

class GetSearch 
{
    private $value;
    private $regex = false;
    
    public function __construct(array $var1) {
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param boolean $regex
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;
    }


}


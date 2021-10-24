<?php
class ProspectObj implements \JsonSerializable{
    
    private $team;
    private $name;
    
    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
    
}
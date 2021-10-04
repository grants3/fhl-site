<?php

class RosterObj implements \JsonSerializable
{
    private $team;
    private $number;
    private $name;
    private $position;
    private $hand;
    private $condition;
    private $injStatus;
    private $it;
    private $sp;
    private $st;
    private $en;
    private $du;
    private $di;
    private $sk;
    private $pa;
    private $pc;
    private $df;
    private $sc;
    private $ex;
    private $ld;
    private $ov;
    

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return mixed
     */
    public function getInjStatus()
    {
        return $this->injStatus;
    }

    /**
     * @return mixed
     */
    public function getIt()
    {
        return $this->it;
    }

    /**
     * @return mixed
     */
    public function getSp()
    {
        return $this->sp;
    }

    /**
     * @return mixed
     */
    public function getSt()
    {
        return $this->st;
    }

    /**
     * @return mixed
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * @return mixed
     */
    public function getDu()
    {
        return $this->du;
    }

    /**
     * @return mixed
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * @return mixed
     */
    public function getSk()
    {
        return $this->sk;
    }

    /**
     * @return mixed
     */
    public function getPa()
    {
        return $this->pa;
    }

    /**
     * @return mixed
     */
    public function getPc()
    {
        return $this->pc;
    }

    /**
     * @return mixed
     */
    public function getDf()
    {
        return $this->df;
    }

    /**
     * @return mixed
     */
    public function getSc()
    {
        return $this->sc;
    }

    /**
     * @return mixed
     */
    public function getEx()
    {
        return $this->ex;
    }

    /**
     * @return mixed
     */
    public function getLd()
    {
        return $this->ld;
    }

    /**
     * @return mixed
     */
    public function getOv()
    {
        return $this->ov;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @param mixed $hand
     */
    public function setHand($hand)
    {
        $this->hand = $hand;
    }

    /**
     * @param mixed $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @param mixed $injStatus
     */
    public function setInjStatus($injStatus)
    {
        $this->injStatus = $injStatus;
    }

    /**
     * @param mixed $it
     */
    public function setIt($it)
    {
        $this->it = $it;
    }

    /**
     * @param mixed $sp
     */
    public function setSp($sp)
    {
        $this->sp = $sp;
    }

    /**
     * @param mixed $st
     */
    public function setSt($st)
    {
        $this->st = $st;
    }

    /**
     * @param mixed $en
     */
    public function setEn($en)
    {
        $this->en = $en;
    }

    /**
     * @param mixed $du
     */
    public function setDu($du)
    {
        $this->du = $du;
    }

    /**
     * @param mixed $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * @param mixed $sk
     */
    public function setSk($sk)
    {
        $this->sk = $sk;
    }

    /**
     * @param mixed $pa
     */
    public function setPa($pa)
    {
        $this->pa = $pa;
    }

    /**
     * @param mixed $pc
     */
    public function setPc($pc)
    {
        $this->pc = $pc;
    }

    /**
     * @param mixed $df
     */
    public function setDf($df)
    {
        $this->df = $df;
    }

    /**
     * @param mixed $sc
     */
    public function setSc($sc)
    {
        $this->sc = $sc;
    }

    /**
     * @param mixed $ex
     */
    public function setEx($ex)
    {
        $this->ex = $ex;
    }

    /**
     * @param mixed $ld
     */
    public function setLd($ld)
    {
        $this->ld = $ld;
    }

    /**
     * @param mixed $ov
     */
    public function setOv($ov)
    {
        $this->ov = $ov;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
    
    
}


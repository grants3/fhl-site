<?php

class RosterAvgObj
{
    private $avgIt = 0;
    private $avgSp  = 0;
    private $avgSt = 0;
    private $avgEn = 0;
    private $avgDu = 0;
    private $avgDi = 0;
    private $avgSk = 0;
    private $avgPa = 0;
    private $avgPc = 0;
    private $avgDf  = 0;
    private $avgSc  = 0;
    private $avgEx  = 0;
    private $avgLd  = 0;
    private $avgOv  = 0;
    
    public function __construct(array $rosters) {
        
        $goalieCount = 0;
        
        foreach ($rosters as $roster) {
            $this->avgIt += $roster->getIt();
            $this->avgSp += $roster->getSp();
            $this->avgSt += $roster->getSt();
            $this->avgEn += $roster->getEn();
            $this->avgDu += $roster->getDu();
            $this->avgDi += $roster->getDi();
            $this->avgSk += $roster->getSk();
            $this->avgPa += $roster->getPa();
            $this->avgPc += $roster->getPc();
            if($roster->getPosition() != 'G') {
                $this->avgDf += $roster->getDf();
                $this->avgSc += $roster->getSc();
            }
            else $goalieCount++;
            $this->avgEx += $roster->getEx();
            $this->avgLd += $roster->getLd();
            $this->avgOv += $roster->getOv();
            
        }
        
        $resultsSize = count($rosters);
        
        //may not have anyone on the roster.
        if($resultsSize == 0) return;

        $this->avgIt = round($this->avgIt / $resultsSize);
        $this->avgSp = round($this->avgSp / $resultsSize);
        $this->avgSt = round($this->avgSt / $resultsSize);
        $this->avgEn = round($this->avgEn / $resultsSize);
        $this->avgDu = round($this->avgDu / $resultsSize);
        $this->avgDi = round($this->avgDi / $resultsSize);
        $this->avgSk = round($this->avgSk / $resultsSize);
        $this->avgPa = round($this->avgPa / $resultsSize);
        $this->avgPc = round($this->avgPc / $resultsSize);
        if($resultsSize > $goalieCount){
            $this->avgDf = round($this->avgDf / ($resultsSize-$goalieCount));
            $this->avgSc = round($this->avgSc / ($resultsSize-$goalieCount));
        }else{
            $this->avgDf = 0;
            $this->avgSc = 0;
        }

        $this->avgEx = round($this->avgEx / $resultsSize);
        $this->avgLd = round($this->avgLd / $resultsSize);
        $this->avgOv = round($this->avgOv / $resultsSize);
    }
    /**
     * @return number
     */
    public function getAvgIt()
    {
        return $this->avgIt;
    }

    /**
     * @return number
     */
    public function getAvgSp()
    {
        return $this->avgSp;
    }

    /**
     * @return number
     */
    public function getAvgSt()
    {
        return $this->avgSt;
    }

    /**
     * @return number
     */
    public function getAvgEn()
    {
        return $this->avgEn;
    }

    /**
     * @return number
     */
    public function getAvgDu()
    {
        return $this->avgDu;
    }

    /**
     * @return number
     */
    public function getAvgDi()
    {
        return $this->avgDi;
    }

    /**
     * @return number
     */
    public function getAvgSk()
    {
        return $this->avgSk;
    }

    /**
     * @return number
     */
    public function getAvgPa()
    {
        return $this->avgPa;
    }

    /**
     * @return number
     */
    public function getAvgPc()
    {
        return $this->avgPc;
    }

    /**
     * @return number
     */
    public function getAvgDf()
    {
        return $this->avgDf;
    }

    /**
     * @return number
     */
    public function getAvgSc()
    {
        return $this->avgSc;
    }

    /**
     * @return number
     */
    public function getAvgEx()
    {
        return $this->avgEx;
    }

    /**
     * @return number
     */
    public function getAvgLd()
    {
        return $this->avgLd;
    }

    /**
     * @return number
     */
    public function getAvgOv()
    {
        return $this->avgOv;
    }

    
    
}


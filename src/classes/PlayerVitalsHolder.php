<?php

require_once __DIR__.'/../baseConfig.php';

include_once FS_ROOT.'lang.php';

class PlayerVitalsHolder {
    private $lastUpdated;
    private $vitals = array();
    private $avgAge = '';
    private $avgHeight = '';
    private $avgWeight = '';
    private $avgSalary = '';
    private $avgContract= 0;
    
    public function __construct(string $file, string $searchTeam) {
        if(!file_exists($file)) {
            throw new InvalidArgumentException('File does not exist');
        }
        
        if(!isset($searchTeam)){
            throw new InvalidArgumentException('Team must be set');
        }
        
        
        $number = 0;
        $rookie = '';
        $name = '';
        $position = '';
        $age = 0;
        $height = '';
        $weight = '';
        $salaryTemp = 0;
        $salary = '';
        $contractLength = '';
        
        $contents = file($file);
        
        $count = 0;
        $a = 0;
        $b = 0;
        $d = 1;
        //$i = 0;
        
        foreach ($contents as $cle => $val) {
            $val = encodeToUtf8($val);
            if(substr_count($val, '<P>(As of')){
                $pos = strpos($val, ')');
                $pos = $pos - 10;
                $val = substr($val, 10, $pos);
                
                $this->lastUpdated = $val;
            }
            if(substr_count($val, 'A NAME=') && $b) {
                $d = 0;
            }
            if(substr_count($val, 'A NAME='.$searchTeam)) {
                $pos = strpos($val, '</A>');
                $pos = $pos - 23;
                $equipe = substr($val, 23, $pos);
                $b++;
            }
            if($a == 3 && $b && $d) {
                //parse averages
                $reste = trim(substr($val, strpos($val, '  '), strpos($val, '</PRE>')-strpos($val, '  ')));
                $this->avgAge = substr($reste, 0, strpos($reste, '  '));

                $reste = trim(substr($reste, strpos($reste, '  ')));
                $this->avgHeight = substr($reste, 0, strpos($reste, '  '));
                $this->avgHeight = str_replace('ft', '\'', $this->avgHeight);
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $this->avgWeight = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $this->avgSalary = substr($reste, 0);
                $a++;
            }
            if(substr_count($val, '------------------') && $b && $d) {
                $a++;
            }
            if($a == 2 && $b && $d) {
                //parse values
                $number = substr($val, 0,  strpos($val, ' '));
                $reste = trim(substr($val, strpos($val, ' ')));
                if(substr_count($reste, '*', 0, 1)) {
                    $rookie = substr($reste, 0, 1);
                    $reste = trim(substr($reste, 1));
                }
                else $rookie = '';
                
                //$name = substr($reste, 0, strpos($reste, '  '));
                $name = trim(mb_substr($reste, 0, 22, 'UTF-8'));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $position = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                
                $age = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $height = substr($reste, 0, strpos($reste, '  '));
                $height = str_replace('ft', '\'', $height);
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $weight = substr($reste, 0, strpos($reste, 'lbs') + 3);
                $reste = trim(substr($reste, strpos($reste, 'lbs') + 3));
                $salaryTemp = substr($reste, 0, strpos($reste, '  '));
                $salary = preg_replace('/\D/', '', $salaryTemp);
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $contractLength = substr($reste, 0, 1);

                //create object
                $vitals = new PlayerVitalObj();
                $vitals->setNumber($number);
                $vitals->setRookie($rookie);
                $vitals->setName($name);
                $vitals->setPosition($position);
                $vitals->setAge($age);
                $vitals->setHeight($height);
                $vitals->setWeight($weight);
                $vitals->setSalary($salary);
                $vitals->setContractLength($contractLength);

                array_push($this->vitals, $vitals);
                
                $count++;
            }
            if($a == 1 && $b && $d) {
                $a++;
            }
            if(substr_count($val, '<PRE>') && $b && $d) {
                $a = 1;
            }
        }
        
    }
    
    
    /**
     * @return mixed
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @return multitype:
     */
    public function getVitals()
    {
        return $this->vitals;
    }

    /**
     * @param mixed $lastUpdated
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
    }

    /**
     * @param multitype: $vitals
     */
    public function setVitals($vitals)
    {
        $this->vitals = $vitals;
    }
    /**
     * @return string
     */
    public function getAvgAge()
    {
        return $this->avgAge;
    }

    /**
     * @return string
     */
    public function getAvgHeight()
    {
        return $this->avgHeight;
    }

    /**
     * @return string
     */
    public function getAvgWeight()
    {
        return $this->avgWeight;
    }

    /**
     * @return string
     */
    public function getAvgSalary()
    {
        return $this->avgSalary;
    }

    /**
     * @param string $avgAge
     */
    public function setAvgAge($avgAge)
    {
        $this->avgAge = $avgAge;
    }

    /**
     * @param string $avgHeight
     */
    public function setAvgHeight($avgHeight)
    {
        $this->avgHeight = $avgHeight;
    }

    /**
     * @param string $avgWeight
     */
    public function setAvgWeight($avgWeight)
    {
        $this->avgWeight = $avgWeight;
    }

    /**
     * @param string $avgSalary
     */
    public function setAvgSalary($avgSalary)
    {
        $this->avgSalary = $avgSalary;
    }

    public function findVital(int $number, string $name){
        foreach ($this->vitals as $vital) {
            if($vital->getNumber()  == $number && $vital->getName() == $name){
                return $vital;
            }
        }
        
        return;
    }
    
    
    
}

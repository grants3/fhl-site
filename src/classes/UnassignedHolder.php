<?php
include_once FS_ROOT.'classes/UnassignedObj.php';

class UnassignedHolder implements \JsonSerializable{

    private $unassigned = array();

    public function __construct(string $file) {
        
        if(!file_exists($file)) {
            //throw new InvalidArgumentException('File does not exist');
            return false;
        }

        $contents = file($file);
 
        $a = 0;
        $b = 0;
        $d = 1;
        $i = 0;
        $z = 0;
        

        $name = '';
        $position= '';
        $age = 0;
        $it = 0;
        $sp = 0;
        $st = 0;
        $en = 0;
        $du = 0;
        $di = 0;
        $sk = 0;
        $pa = 0;
        $pc = 0;
        $df = 0;
        $sc = 0;
        $ex = 0;
        $ld = 0;
        $ov = 0;

        foreach ($contents as $cle => $val) {
            $val = utf8_encode($val);
            
            if(substr_count($val, '</PRE>')) {
                $a = 0;
            }
            if($a == 1) {
                $reste = trim($val);
                $ov = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $ld = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $ex = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $sc = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $df = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $pc = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $pa = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $sk = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $di = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $du = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $en = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $st = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $sp = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $it= substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $position = trim(substr($reste, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                //$unassignedAG[$i] = substr($reste, strrpos($reste, ' '));
                $age = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $name = $reste;
                
                
                $roster = new UnassignedObj();
                $roster->setName($name);
                $roster->setAge($age);
                $roster->setPosition($position);
                $roster->setIt($it);
                $roster->setSp($sp);
                $roster->setSt($st);
                $roster->setEn($en);
                $roster->setDu($du);
                $roster->setDi($di);
                $roster->setSk($sk);
                $roster->setPa($pa);
                $roster->setPc($pc);
                $roster->setDf($df);
                $roster->setSc($sc);
                $roster->setEx($ex);
                $roster->setLd($ld);
                $roster->setOv($ov);
                
                array_push($this->unassigned, $roster);
                
                $i++;
            }
            if(substr_count($val, '<PRE>Player')) {
                $a = 1;
            }
   
        }

    }
    /**
     * @return multitype:
     */
    public function getUnassigned()
    {
        return $this->unassigned;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

}

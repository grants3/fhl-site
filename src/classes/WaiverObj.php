<?php
class WaiverObj {
    var $player;
    var $waiveDate;
    var $waivedBy;
    var $claimedBy;
    
    function __get($name)
    {
        return$this->$name;
    }  
    
    function set_player($new_player) {
        $this->player = $new_player;
    }
    function get_player() {
        return $this->player;
    }
    
    function set_waiveDate($new_waiveDate) {
        $this->waiveDate = $new_waiveDate;
    }
    function get_waiveDate() {
        return $this->waiveDate;
    }
    
    function set_waivedBy($new_waivedBy) {
        $this->waivedBy = $new_waivedBy;
    }
    function get_waivedBy() {
        return $this->waivedBy;
    }
    
    function set_claimedBy($new_claimedBy) {
        $this->claimedBy = $new_claimedBy;
    }
    function get_claimedBy() {
        return $this->claimedBy;
    }
}
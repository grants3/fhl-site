<?php
if(count(get_included_files()) ==1) die(header('HTTP/1.1 404 Not Found')); //must be included 

interface Model{
    public function findBySeason($seasonId, $seasonType);
}


<?php

interface Model{
    public function get($identifier);
    public function getAll() : array;
}


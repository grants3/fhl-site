<?php
namespace api\scoring;

class GetRequestColumn
{
    private $data;
    private $name;
    private $searchable=false;
    private $orderable=false;
    private $search = array(); //GetSearch

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * @return boolean
     */
    public function getOrderable()
    {
        return $this->orderable;
    }

    /**
     * @return multitype:
     */
    public function getSearch() : GetSearch
    {
        return $this->search;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param boolean $searchable
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;
    }

    /**
     * @param boolean $orderable
     */
    public function setOrderable($orderable)
    {
        $this->orderable = $orderable;
    }

    /**
     * @param multitype: $search
     */
    public function setSearch(GetSearch $search)
    {
        $this->search = $search;
    }
    
    
}


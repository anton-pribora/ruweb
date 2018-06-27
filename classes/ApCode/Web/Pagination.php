<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Web;

class Pagination implements \JsonSerializable
{
    private $page  = 0;
    private $limit = 25;
    private $total = 0;
    
    private $pageParamName = 'page';
    private $limitParamName = 'limit';
    
    /**
     * @var Url
     */
    private $url;
    
    public function __construct($params = []) {
        foreach ($params as $name => $value) {
            $function = [$this, 'set' . ucfirst($name)];
            
            if (is_callable($function)) {
                $function($value);
            }
        }
    }
    
    public function totalItems()
    {
        return $this->total;
    }
    
    public function totalPages()
    {
        return ceil($this->total / $this->limit);
    }
    
    public function setTotalItems($totalItems)
    {
        $this->total = intval($totalItems);
        return $this;
    }
    
    public function page()
    {
        return $this->page;
    }
    
    public function setPage($page)
    {
        $this->page = intval($page);
        return $this;
    }
    
    public function limit()
    {
        return $this->limit;
    }
    
    public function setLimit($limit)
    {
        $this->limit = intval($limit);
        return $this;
    }
    
    /**
     * @return \ApCode\Web\Url
     */
    public function url()
    {
        return $this->url;
    }
    
    public function startFrom()
    {
        return $this->page * $this->limit;
    }
    
    public function setUrl(Url $url, $setParamsFromUrl = TRUE)
    {
        $this->url = $url;
        
        if ($setParamsFromUrl && $url->hasQueryParam($this->pageParamName)) {
            $this->setPage($url->getQueryParam($this->pageParamName));
        }
        
        if ($setParamsFromUrl && $url->hasQueryParam($this->limitParamName)) {
            $this->setLimit($url->getQueryParam($this->limitParamName));
        }
        
        return $this;
    }
    
    public function pageUrl($page)
    {
        $this->url->setQueryParam($this->pageParamName, $page);
        return (string) $this->url;
    }
    
    public function jsonSerialize()
    {
        return [
            'page'       => (int) $this->page(),
            'limit'      => (int) $this->limit(),
            'totalPages' => (int) $this->totalPages(),
            'totalItems' => (int) $this->totalItems(),
        ];
    }
}
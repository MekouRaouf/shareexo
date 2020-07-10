<?php

namespace Shareexo\Pagination;

use AshleyDawson\SimplePagination\Paginator as SimplePaginationPaginator;
use Psr\Http\Message\ServerRequestInterface;
use Shareexo\Pagination\Contracts\PaginatorInterface;

class Paginator implements PaginatorInterface{

    protected $items = [];
    protected $totalPages;
    protected $pagination;
    protected $paginator;

    public function __construct(ServerRequestInterface $request, $items, $itemsPerPage, $pagesInRange)
    {
        $this->items_to_array($items);
        
        $this->paginator = new SimplePaginationPaginator();
        $this->paginator
                        ->setPagesInRange($pagesInRange)
                        ->setItemsPerPage($itemsPerPage)
                        ->setItemTotalCallback(function(){
                            return count($this->items);
                        });

        /*$offset = 1;
        $length = $itemsPerPage;
        if($this->pageNum($request) > 1){
            for($i = 2; $i <= (int)$this->pageNum($request); $i++){
                $offset = $length + 1;
                $length = $offset + $itemsPerPage;
            }
        }*/
        

        $this->paginator->setSliceCallback(function($offset, $length){
                            return array_slice($this->items, $offset, $length);
                        });
        $this->pagination = $this->paginator->paginate($this->pageNum($request));
    }

    public function pageNum(\Psr\Http\Message\ServerRequestInterface $request)
    {        
        if($request->getParam('page') == null){
            $actualPage = 1;
        } else {
            $actualPage = (int)$request->getParam('page');
        }
        
        return $actualPage;
    }

    public function items_to_array($items)
    {
        foreach($items as $item){
            $this->items[] = $item;
        }
    }

    public function getItems()
    {
        return $this->pagination->getItems();
    }

    public function totalPages()
    {
        return (int)$this->pagination->getTotalNumberOfPages();
    }

    public function pages()
    {
        return $this->pagination->getPages();
    }

    public function lastButton()
    {
        return $this->pagination->getLastPageNumber();
    }

    public function prev()
    {
        return $this->pagination->getPreviousPageNumber();
    }

    public function next()
    {
        return (int)$this->pagination->getNextPageNumber();
    }

    public function currentPage()
    {
        return $this->pagination->getCurrentPageNumber();
    }

    public function lastPage()
    {
        return $this->pagination->getLastPageNumber();
    }


}
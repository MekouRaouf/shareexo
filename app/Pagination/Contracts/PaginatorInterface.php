<?php

namespace shareexo\Pagination\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface PaginatorInterface{

    public function items_to_array($items);
    public function pageNum(ServerRequestInterface $request);
    public function getItems();
    public function pages();
    public function totalPages();
    public function currentPage();
    public function lastPage();
    public function prev();
    public function next();

}
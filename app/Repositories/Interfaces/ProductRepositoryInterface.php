<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getFilterProductByCatgoryId($category_id = null, $limit = null, $start = null, $search = null, array $filter = []);

    public function getProductById($product_id, $with = []);
}

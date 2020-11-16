<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\AddProducts;

interface AddProductsToHivePresenter
{
    /**
     * @param AddProductsToHiveGrowerResponse $response
     * @return mixed
     */
    public function present(AddProductsToHiveGrowerResponse $response);
}

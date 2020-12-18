<?php

declare(strict_types=1);

namespace App\Application\UseCases\Order\Register;

interface RegisterOrderPresenter
{
    public function present(RegisterOrderResponse $response): void;

}

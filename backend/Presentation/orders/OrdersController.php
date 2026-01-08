<?php

namespace Presentation\orders;

require_once __DIR__ . '/../../Database/dbconnect.php';
require_once __DIR__ . '/../../Infrastructure/DbalOrders.php';

use Infrastructure\DbalOrders;

class OrdersController extends \Database
{
    public function getOrders()
    {
        $pdo = $this->connect();
        $repo = new DbalOrders($pdo);
        return $repo->getAllOrders();
    }
}


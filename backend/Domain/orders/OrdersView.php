<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/OrdersController.php';
require_once __DIR__ . '/../../CustomExceptions/OrdersFetchCustomException.php';

use CustomExceptions\OrdersFetchCustomException;
use Presentation\orders\OrdersController;

try {
    $controller = new OrdersController();
    $orders = $controller->getOrders();
    echo json_encode(['ok' => true, 'orders' => $orders]);
} catch (Throwable $e) {
    throw new OrdersFetchCustomException('Failed fetching orders: ' . $e->getMessage(), 0, $e);
}

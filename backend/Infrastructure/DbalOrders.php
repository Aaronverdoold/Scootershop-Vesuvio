<?php

namespace Infrastructure;

class DbalOrders
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Return an array of orders, each with a 'parts' array.
     */
    public function getAllOrders()
    {
        $sql = "SELECT o.id as order_id, o.date, o.company_name, o.recipient, o.addressline1, o.addressline2, o.country, o.status,
                       p.id as part_id, p.part, p.sell_price, orr.packed
                FROM orders o
                LEFT JOIN orderrules orr ON orr.order_id = o.id
                LEFT JOIN parts p ON p.id = orr.part_id
                ORDER BY o.id, orr.id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $orders = [];
        foreach ($rows as $row) {
            $oid = $row['order_id'];
            if (!isset($orders[$oid])) {
                $orders[$oid] = [
                    'id' => $oid,
                    'date' => $row['date'],
                    'company_name' => $row['company_name'],
                    'recipient' => $row['recipient'],
                    'addressline1' => $row['addressline1'],
                    'addressline2' => $row['addressline2'],
                    'country' => $row['country'],
                    'status' => $row['status'],
                    'parts' => []
                ];
            }

            if (!empty($row['part_id'])) {
                $orders[$oid]['parts'][] = [
                    'id' => $row['part_id'],
                    'part' => $row['part'],
                    'sell_price' => $row['sell_price'],
                    'packed' => $row['packed']
                ];
            }
        }

        return array_values($orders);
    }
}

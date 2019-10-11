<?php

declare(strict_types=1);

namespace Order\Infra\Repository\Mongo;

use App\Facades\Mongo;
use DateTime;
use MongoDB\Collection;
use Order\Domain\Order\Model\IOrderRepository;
use Order\Domain\Order\Model\Order;
use Order\Domain\Order\Model\OrderId;
use Order\Domain\Order\Model\OrderItem;

class OrderRepository implements IOrderRepository
{

    public function generateOrderId(): OrderId
    {
        /** @var Collection $collection */
        $collection = Mongo::get()->coffee_shop->orders;
        $seq = $collection->countDocuments();
        return new OrderId($seq, new DateTime());
    }

    public function getBy(OrderId $orderId): Order
    {
        // TODO: Implement getBy() method.
    }

    public function save(Order $order)
    {
        $items = [];
        foreach ($order->getItems() as $item) {

            /** @var OrderItem $item */

            $items[] = [
                'product_id' => $item->getProductId(),
                'qty' => $item->getQty(),
                'price' => $item->getPrice(),
            ];
        }

        $collection = Mongo::get()->coffee_shop->orders;
        $collection->insertOne([
            'order_id' => $order->getOrderId()->toString(),
            'table_no' => $order->getTableNo(),
            'order_status' => $order->getOrderStatus()->getValue(),
            'items' => $items,
            'create_date' => $order->getCreatedDate(),
            'modify_date' => $order->getModifiedDate()
        ]);
    }
}
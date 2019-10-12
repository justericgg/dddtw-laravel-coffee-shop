<?php

declare(strict_types=1);

namespace Order\Infra\Repository\Mongo;

use App\Facades\Mongo;
use DateTime;
use Exception;
use MongoDB\Collection;
use Order\Domain\Order\Model\IOrderRepository;
use Order\Domain\Order\Model\Order;
use Order\Domain\Order\Model\OrderId;
use Order\Domain\Order\Model\OrderItem;
use Order\Domain\Order\Model\OrderStatus;

class OrderRepository implements IOrderRepository
{
    public function generateOrderId(): OrderId
    {
        /** @var Collection $collection */
        $collection = Mongo::get()->coffee_shop->orders;
        $seq = $collection->countDocuments();
        return new OrderId($seq, new DateTime());
    }

    /**
     * @param OrderId $orderId
     * @return Order
     * @throws Exception
     */
    public function getBy(OrderId $orderId): Order
    {
        $data = Mongo::get()->coffee_shop->orders->findOne(['order_id' => $orderId->toString()]);
        $orderStatus = new OrderStatus($data['order_status']);
        $createDate = new DateTime($data['create_date']['date']);

        if (!empty($data['modify_date'])) {
            $modifyDate = new DateTime($data['modify_date']['date']);
        } else {
            $modifyDate = null;
        }

        $items = [];
        foreach ($data['items'] as $item) {
            $items[] = new OrderItem($item['product_id'], $item['qty'], $item['price']);
        }

        return new Order($orderId, $data['table_no'], $orderStatus, $items, $createDate, $modifyDate);
    }

    public function save(Order $order): void
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

        /** @var Collection $collection */
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
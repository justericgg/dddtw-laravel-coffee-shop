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

        $items = $this->buildItemsDomainCollection($data);

        return new Order($orderId, $data['table_no'], $orderStatus, $items, $createDate, $modifyDate);
    }

    /**
     * @param Order $order
     * @throws Exception
     */
    public function save(Order $order): void
    {
        /** @var Collection $collection */
        $collection = Mongo::get()->coffee_shop->orders;

        $fetchedData = $collection->findOne(['order_id' => $order->getOrderId()->toString()]);

        if ($fetchedData === null) {
            $collection->insertOne([
                'order_id' => $order->getOrderId()->toString(),
                'table_no' => $order->getTableNo(),
                'order_status' => $order->getOrderStatus()->getValue(),
                'items' => $this->buildItemsArray($order),
                'create_date' => $order->getCreatedDate(),
                'modify_date' => $order->getModifiedDate()
            ]);
        } else {
            $collection->updateOne(
                ['order_id' => $order->getOrderId()->toString()],
                [
                    '$set' => [
                        'order_status' => $order->getOrderStatus()->getValue(),
                        'items' => $this->buildItemsArray($order),
                        'create_date' => $order->getCreatedDate(),
                        'modify_date' => $order->getModifiedDate()
                    ]
                ]
            );
        }
    }

    /**
     * @param Order $order
     * @return array
     */
    private function buildItemsArray(Order $order): array
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

        return $items;
    }

    private function buildItemsDomainCollection($data): array
    {
        $items = [];
        foreach ($data['items'] as $item) {
            $items[] = new OrderItem($item['product_id'], $item['qty'], $item['price']);
        }

        return $items;
    }
}
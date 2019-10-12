<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Order\Application\Order\CreateOrderSvc;
use Order\Application\Order\DataContract\Message\CreateOrderMsg;
use Order\Application\Order\DataContract\Message\GetOrderMsg;
use Order\Application\Order\DataContract\Result\OrderItemRst;
use Order\Application\Order\DomainService\OrderIdTranslator;
use Order\Application\Order\DomainService\OrderItemsTranslator;
use Order\Application\Order\Service\GetOrderSvc;
use Order\Domain\Order\Exception\OrderIdIsNullException;
use Order\Domain\Order\Exception\OrderItemEmptyException;
use Order\Domain\Order\Exception\TableNoEmptyException;
use Order\Infra\Repository\Mongo\OrderRepository;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return false|string
     * @throws OrderIdIsNullException
     * @throws OrderItemEmptyException
     * @throws TableNoEmptyException
     */
    public function createOrder(Request $request)
    {
        $orderRepository = new OrderRepository();
        $orderItemsTranslator = new OrderItemsTranslator();
        $createOrderSvc = new CreateOrderSvc($orderRepository, $orderItemsTranslator);

        $inputs = $request->all();
        $items = [];
        foreach ($inputs['items'] as $item) {
            $items[] = new OrderItemRst($item['productId'], $item['qty'], $item['price']);
        }

        $createOrderMsg = new CreateOrderMsg(
            $inputs['tableNo'],
            $items
        );

        $result = $createOrderSvc->handle($createOrderMsg);

        return json_encode($result);
    }

    public function getOrder(string $id)
    {
        $orderRepository = new OrderRepository();
        $orderIdTranslator = new OrderIdTranslator();
        $getOrderSvc = new GetOrderSvc($orderRepository, $orderIdTranslator);

        $getOrderMsg = new GetOrderMsg($id);

        $orderRst = $getOrderSvc->handle($getOrderMsg);

        return json_encode($orderRst);
    }

    public function changeOrderItems(string $id)
    {

    }

    public function changeOrderStatus(string $id)
    {

    }

    public function cancelOrder(string $id)
    {

    }
}

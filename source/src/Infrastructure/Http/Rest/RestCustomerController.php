<?php
namespace App\Infrastructure\Http\Rest;

use App\Application\Service\CustomerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RestCustomerController
{
    /** @var CustomerService */
    private $customerService;

    /** RestCustomerController constructor. */
    public function __construct()
    {
        $this->customerService = app(CustomerService::class);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function get(int $id)
    {
        $customer = $this->customerService->getCustomer($id);

        $data = '';
        if ($customer) {
            $data = json_encode($customer->extract(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        return new Response($data);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {
        $customer = $this->customerService->addCustomer(
            $request->get('name'),
            $request->get('isActive'),
            $request->get('email')
        );

        $data = '';
        if ($customer) {
            $data = json_encode($customer->extract(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        return new Response($data, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $customer = $this->customerService->updateCustomer(
            $id,
            $request->get('name'),
            $request->get('isActive'),
            $request->get('email')
        );

        $data = json_encode($customer->extract(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return new Response($data, Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $this->customerService->deleteCustomer($id);

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @return Response
     */
    public function list()
    {
        $customers = $this->customerService->getAllCustomers();
        $data = json_encode($customers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return new Response($data);
    }
}
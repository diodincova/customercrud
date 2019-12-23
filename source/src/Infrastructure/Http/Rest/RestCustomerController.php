<?php
namespace App\Infrastructure\Http\Rest;

use App\Application\Service\CustomerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

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
     * @return JsonResponse
     */
    public function get(int $id)
    {
        $customer = $this->customerService->getCustomer($id);

        $status = $customer ? Response::HTTP_OK : Response::HTTP_NO_CONTENT;

        $errors = [];
        if (!$customer) {
            $errors[] = 'Customer not found';
        }

        return new JsonResponse($this->createData($status, $customer, $errors));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $errors = $this->validate($request);

        if(count($errors) > 0) {
            return new JsonResponse($this->createData(Response::HTTP_BAD_REQUEST, [], $errors));
        }

        $customer = $this->customerService->addCustomer(
            $request->get('name'),
            $request->get('isActive') === 'true',
            $request->get('email')
        );

        return new JsonResponse($this->createData(Response::HTTP_CREATED, $customer, $errors));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $errors = $this->validate($request);

        if(count($errors) > 0) {
            return new JsonResponse($this->createData(Response::HTTP_BAD_REQUEST, [], $errors));
        }

        $customer = $this->customerService->updateCustomer(
            $id,
            $request->get('name'),
            $request->get('isActive') === 'true',
            $request->get('email')
        );

        $status = $customer ? Response::HTTP_OK : Response::HTTP_NO_CONTENT;

        $errors = [];
        if (!$customer) {
            $errors[] = 'Customer not found';
        }

        return new JsonResponse($this->createData($status, $customer, $errors));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        $this->customerService->deleteCustomer($id);

        return new JsonResponse($this->createData(Response::HTTP_OK, [], []));
    }

    /**
     * @return JsonResponse
     */
    public function list()
    {
        $customers = $this->customerService->getAllCustomers();

        return new JsonResponse($this->createData(Response::HTTP_OK, $customers, []));
    }

    /**
     * @param int $status
     * @param array|null $data
     * @param array $errors
     * @return array
     */
    private function createData(int $status, ?array $data, array $errors): array
    {
        return [
            'status' => $status,
            'data' => $data,
            'errors' => $errors,
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    private function validate(Request $request): array
    {
        $errors = [];
        $validator = Validation::createValidator();

        $violations = $validator->validate($request->get('name'), [
            new NotBlank(),
        ]);

        foreach ($violations as $violation) {
            $errors['name'][] =  $violation->getMessage();
        }

        $violations = $validator->validate($request->get('email'), [
            new NotBlank(),
            new Email(),
        ]);

        foreach ($violations as $violation) {
            $errors['email'][] =  $violation->getMessage();
        }

        $violations = $validator->validate($request->get('isActive'), [
            new Choice(['choices'=> ['true', 'false']])
        ]);

        foreach ($violations as $violation) {
            $errors['isActive'][] =  $violation->getMessage() . ' (true|false)';
        }

        return $errors;
    }
}
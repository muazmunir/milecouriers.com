<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequest; // Make sure to create this request
use App\Interfaces\PaymentMethodInterface; // Make sure to create this interface
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    private $paymentMethodRepository;

    public function __construct(PaymentMethodInterface $paymentMethodInterface)
    {
        $this->paymentMethodRepository = $paymentMethodInterface;
    }

    public function index(): View
    {
        $pageTitle = 'Payment Methods';

        return view('admin.payment_methods.index', compact('pageTitle'));
    }

    public function dataTable(): JsonResponse
    {
        return $this->paymentMethodRepository->getDataTable();
    }

    public function store(PaymentMethodRequest $request): JsonResponse
    {
        $result = $this->paymentMethodRepository->createPaymentMethod($request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Payment method added successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add payment method. Please try again.'
            ], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        $paymentMethod = $this->paymentMethodRepository->findPaymentMethodById($id);

        if ($paymentMethod) {
            return response()->json([
                'success' => true,
                'data' => $paymentMethod
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Payment method not found.'
        ], 404);
    }

    public function update(PaymentMethodRequest $request, $id): JsonResponse
    {
        $result = $this->paymentMethodRepository->updatePaymentMethod($id, $request->validated());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Payment method updated successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment method. Please try again.'
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->paymentMethodRepository->deletePaymentMethod($id);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Payment method deleted successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payment method. Please try again.'
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentsDataTable;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PaymentsDataTable $dataTable
     *
     * @return Response
     */
    public function index(PaymentsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Payments')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.payments.index', compact(
            'breadcrumbs', 'pageConfigs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => 'javascript:void(0)', 'name' => __('Payment')],
            ['name' => __('Create')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.payments.create', compact(
            'breadcrumbs', 'pageConfigs'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     * @throws MassAssignmentException
     */
    public function store(Request $request)
    {
        $payment = new Payment();
        $payment->fill($request->all());
        $payment->save();

        $message = __('Create payment has been successful');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'payment' => new PaymentResource($payment),
            ], 200);
        }

        alert()->success($payment->fee, $message);

        return redirect()->route('payments.show', $payment);
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $payment
     *
     * @return Application|Factory|View
     */
    public function show(Payment $payment)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => 'javascript:void(0)', 'name' => __('Payment')],
            ['name' => __('Edit')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.payments.view', compact(
            'breadcrumbs', 'pageConfigs', 'payment'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Payment $payment
     *
     * @return Application|Factory|View
     */
    public function edit(Payment $payment)
    {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $payment->load('contract');

        return view('pages.payments.update', compact(
            'pageConfigs', 'payment'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Payment $payment
     *
     * @return RedirectResponse
     * @throws MassAssignmentException
     */
    public function update(Request $request, Payment $payment)
    {
        $payment->fill($request->all());
        $payment->save();

        alert()->success($payment->fee, __('Payment data has been update successful'));

        return redirect()->route('contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Payment $payment
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Payment $payment)
    {
        if ($payment->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Payment has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }
}

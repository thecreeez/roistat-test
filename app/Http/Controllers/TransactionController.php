<?php

namespace App\Http\Controllers;

use App\Http\Requests\PutTransactionRequest;
use App\Services\AmoCRMService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    protected AmoCRMService $amoCRMService;

    public function __construct(AmoCRMService $amoCRMService) {
        $this->amoCRMService = $amoCRMService;
    }

    public function put(PutTransactionRequest $request) {
        $validated = $request->validated();
        $validated['isVisitLong'] = $validated['isVisitLong'] == '1';
        
        if ($this->amoCRMService->put($validated['price'], $validated['isVisitLong'], $validated['name'], $validated['email'], $validated['phone'])) {
            Log::channel('amocrm_lead')->info('Added new lead: ' . $validated['name'] . '. Price: ' . $validated['price']);
            return redirect(route('index'))->with('status', 'Спасибо за обратную связь!');
        }

        return redirect(route('index'))->with('status-error', 'Что-то пошло не так, попробуйте позже.');
    }
}

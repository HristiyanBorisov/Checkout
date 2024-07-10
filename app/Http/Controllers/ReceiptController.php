<?php

namespace App\Http\Controllers;

use App\Models\SpecialPrice;
use App\Services\ReceiptCalculationService;
use App\Services\ReceiptService;
use App\Services\ReceiptServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ReceiptController extends Controller
{

    private ReceiptServiceInterface $receiptService;

    public function __construct() {
        $this->receiptService = app(ReceiptService::class);
    }
    public function getReceipt(): array
    {
        return $this->receiptService->getReceipt();
    }

    public function clearReceipt(): bool
    {
        return $this->receiptService->clearReceipt();
    }
}

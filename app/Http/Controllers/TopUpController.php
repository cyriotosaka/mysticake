<?php

namespace App\Http\Controllers;

// Created by Okky Priscila_168

use App\Models\PaymentMethod;
use App\Models\TopUp;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    /**
     * Payment Method IDs (sesuai dengan data di tabel payment_method)
     * 1 = Debit Card
     * 2 = Bank Transfer
     * 3 = E-Wallet
     * 4 = Indomaret
     * 5 = Alfamart
     * 6 = Cash
     */
    private const PAYMENT_METHOD_DEBIT_CARD = 1;

    private const PAYMENT_METHOD_BANK_TRANSFER = 2;

    private const PAYMENT_METHOD_EWALLET = 3;

    private const PAYMENT_METHOD_INDOMARET = 4;

    private const PAYMENT_METHOD_ALFAMART = 5;

    /**
     * Display the Top Up page (redirect from plus icon on home)
     */
    public function showTopUpCoinPage()
    {
        $user = Auth::user();
        $paymentMethods = PaymentMethod::all();

        return view('topup.topUp', [
            'user' => $user,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Display the Top Up page
     */
    public function index()
    {
        $user = Auth::user();
        $paymentMethods = PaymentMethod::all();

        return view('topup.topUp', [
            'user' => $user,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Redirect to Add Debit Card page
     */
    public function redirectToAddDebitCard()
    {
        $user = Auth::user();

        return view('topup.topUpDebitCard', [
            'user' => $user,
        ]);
    }

    /**
     * Show Bank Transfer Page (Step 1 - Input Amount)
     */
    public function showBankTransferPage(Request $request)
    {
        $user = Auth::user();
        $bank = $request->query('bank', 'bca');
        $adminFee = $this->calculateAdminFee('bank_transfer', 0);

        return view('topup.topUpBankTransfer', [
            'user' => $user,
            'bank' => $bank,
            'adminFee' => $adminFee,
        ]);
    }

    /**
     * Process Bank Transfer Payment dan redirect ke VA page (Step 2)
     */
    public function processBankTransferPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank' => 'required|string',
        ]);

        $user = Auth::user();
        $amount = (float) $request->input('amount');
        $bank = $request->input('bank');
        $adminFee = (float) $this->calculateAdminFee('bank_transfer', $amount);
        $virtualAccount = $this->generateVirtualAccount($bank);

        session([
            'pending_payment' => [
                'type' => 'bank_transfer',
                'bank' => $bank,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'payment_method_id' => self::PAYMENT_METHOD_BANK_TRANSFER,
                'virtual_account' => $virtualAccount,
            ],
        ]);

        return view('topup.topUpDebitCardVA', [
            'user' => $user,
            'adminFee' => $adminFee,
            'virtualAccount' => $virtualAccount,
            'amount' => $amount,
            'paymentType' => 'bank_transfer',
            'paymentLabel' => 'Bank Transfer - '.strtoupper($bank),
            'bank' => $bank,
        ]);
    }

    /**
     * Show E-wallet Page (Step 1 - Input Amount)
     */
    public function showEwalletPage()
    {
        $user = Auth::user();
        $adminFee = $this->calculateAdminFee('ewallet', 0);

        return view('topup.topUpEwallet', [
            'user' => $user,
            'adminFee' => $adminFee,
        ]);
    }

    /**
     * Process E-wallet Payment dan redirect ke VA page (Step 2)
     */
    public function processEwalletPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        $amount = (float) $request->input('amount');
        $adminFee = (float) $this->calculateAdminFee('ewallet', $amount);
        $virtualAccount = $this->generateVirtualAccount('ewallet');

        session([
            'pending_payment' => [
                'type' => 'ewallet',
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'payment_method_id' => self::PAYMENT_METHOD_EWALLET,
                'virtual_account' => $virtualAccount,
            ],
        ]);

        return view('topup.topUpDebitCardVA', [
            'user' => $user,
            'adminFee' => $adminFee,
            'virtualAccount' => $virtualAccount,
            'amount' => $amount,
            'paymentType' => 'ewallet',
            'paymentLabel' => 'E-Wallet',
        ]);
    }

    /**
     * Redirect to Payment VA page untuk Bank Transfer dan E-Wallet
     * Method ini dipanggil ketika user klik bank atau e-wallet di topUp.blade.php
     */
    public function redirectToPayment(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|string',
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        $paymentType = $request->input('payment_type');
        $bank = $request->input('bank', null);
        $amount = (float) $request->input('amount');

        // Determine admin fee and payment method based on type
        if ($paymentType === 'bank_transfer') {
            $adminFee = $this->calculateAdminFee('bank_transfer', $amount);
            $paymentMethodId = self::PAYMENT_METHOD_BANK_TRANSFER;
            $paymentLabel = 'Bank Transfer'.($bank ? ' - '.strtoupper($bank) : '');
        } else {
            // E-wallet
            $adminFee = $this->calculateAdminFee('ewallet', $amount);
            $paymentMethodId = self::PAYMENT_METHOD_EWALLET;
            $paymentLabel = 'E-Wallet';
        }

        $virtualAccount = $this->generateVirtualAccount($bank ?? 'default');

        // Store pending payment in session
        session([
            'pending_payment' => [
                'type' => $paymentType,
                'bank' => $bank,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'payment_method_id' => $paymentMethodId,
                'payment_label' => $paymentLabel,
                'virtual_account' => $virtualAccount,
            ],
        ]);

        return view('topup.topUpDebitCardVA', [
            'user' => $user,
            'adminFee' => $adminFee,
            'virtualAccount' => $virtualAccount,
            'amount' => $amount,
            'paymentType' => $paymentType,
            'paymentLabel' => $paymentLabel,
            'bank' => $bank,
        ]);
    }

    /**
     * Store new debit card and redirect to VA page
     */
    public function storeDebitCard(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|min:19',
            'expiry_date' => 'required|string|min:5|max:5',
            'cvv' => 'required|string|min:3|max:3',
            'name_on_card' => 'required|string|max:100',
            'address' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        $user = Auth::user();
        $cardNumber = preg_replace('/\D/', '', $request->input('card_number'));

        session([
            'debit_card' => [
                'card_number' => $cardNumber,
                'card_number_masked' => $this->maskCardNumber($cardNumber),
                'expiry_date' => $request->input('expiry_date'),
                'name_on_card' => $request->input('name_on_card'),
                'address' => $request->input('address'),
                'postal_code' => $request->input('postal_code'),
            ],
        ]);

        $adminFee = $this->calculateAdminFee('debit_card', 0);
        $virtualAccount = $this->generateVirtualAccount('debit');

        return view('topup.topUpDebitCardVA', [
            'user' => $user,
            'adminFee' => $adminFee,
            'virtualAccount' => $virtualAccount,
            'cardNumberMasked' => $this->maskCardNumber($cardNumber),
            'paymentType' => 'debit_card',
            'paymentLabel' => 'Debit Card',
        ]);
    }

    private function maskCardNumber($cardNumber)
    {
        $lastFour = substr($cardNumber, -4);

        return '•••• •••• •••• '.$lastFour;
    }

    /**
     * Show Top Up Coin Indomaret Page (Step 1 & 2)
     */
    public function showTopUpCoinIndomaret12()
    {
        $user = Auth::user();
        $adminFee = $this->calculateAdminFee('indomaret', 0);

        return view('topup.topUpCoinIndomaret12', [
            'user' => $user,
            'adminFee' => $adminFee,
        ]);
    }

    /**
     * Process Indomaret Payment and redirect to barcode page
     */
    public function processIndomaretPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        $amount = (float) $request->input('amount');
        $adminFee = (float) $this->calculateAdminFee('indomaret', $amount);
        $totalPayment = $amount + $adminFee;

        $paymentCode = $this->generatePaymentCode('indomaret');
        $expiresAt = now()->addHours(24);
        $dueDate = $expiresAt->format('d M Y');
        $dueTime = $expiresAt->format('H:i');

        session([
            'pending_topup' => [
                'type' => 'indomaret',
                'store' => 'indomaret',
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'total_payment' => $totalPayment,
                'payment_code' => $paymentCode,
                'expires_at' => $expiresAt->toIso8601String(),
                'due_date' => $dueDate,
                'due_time' => $dueTime,
            ],
        ]);

        // Create TopUp record
        TopUp::create([
            'id_payment_method' => self::PAYMENT_METHOD_INDOMARET,
            'id_user' => $user->id_user,
            'total_top_up' => $amount,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'admin_fee' => $adminFee,
        ]);

        // Update wallet dengan amount (tanpa admin fee)
        $this->updateWallet($user, $amount);

        return view('topup.topUpCoinIndomaret3', [
            'amount' => $amount,
            'adminFee' => $adminFee,
            'totalPayment' => $totalPayment,
            'paymentCode' => $paymentCode,
            'expiresAt' => $expiresAt->toIso8601String(),
            'dueDate' => $dueDate,
            'dueTime' => $dueTime,
        ]);
    }

    public function showTopUpCoinIndomaret3()
    {
        $pendingTopup = session('pending_topup');

        if (! $pendingTopup || $pendingTopup['type'] !== 'indomaret') {
            return redirect()->route('topup.indomaret.page')->with('error', 'No pending payment found.');
        }

        return view('topup.topUpCoinIndomaret3', [
            'amount' => $pendingTopup['amount'],
            'adminFee' => $pendingTopup['admin_fee'],
            'totalPayment' => $pendingTopup['total_payment'],
            'paymentCode' => $pendingTopup['payment_code'],
            'expiresAt' => $pendingTopup['expires_at'],
            'dueDate' => $pendingTopup['due_date'],
            'dueTime' => $pendingTopup['due_time'],
        ]);
    }

    public function showTopUpCoinAlfamart12()
    {
        $user = Auth::user();
        $adminFee = $this->calculateAdminFee('alfamart', 0);

        return view('topup.topUpCoinAlfamart12', [
            'user' => $user,
            'adminFee' => $adminFee,
        ]);
    }

    public function processAlfamartPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        $amount = (float) $request->input('amount');
        $adminFee = (float) $this->calculateAdminFee('alfamart', $amount);
        $totalPayment = $amount + $adminFee;

        $paymentCode = $this->generatePaymentCode('alfamart');
        $expiresAt = now()->addHours(24);
        $dueDate = $expiresAt->format('d M Y');
        $dueTime = $expiresAt->format('H:i');

        session([
            'pending_topup' => [
                'type' => 'alfamart',
                'store' => 'alfamart',
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'total_payment' => $totalPayment,
                'payment_code' => $paymentCode,
                'expires_at' => $expiresAt->toIso8601String(),
                'due_date' => $dueDate,
                'due_time' => $dueTime,
            ],
        ]);

        TopUp::create([
            'id_payment_method' => self::PAYMENT_METHOD_ALFAMART,
            'id_user' => $user->id_user,
            'total_top_up' => $amount,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'admin_fee' => $adminFee,
        ]);

        $this->updateWallet($user, $amount);

        return view('topup.topUpCoinAlfamart3', [
            'amount' => $amount,
            'adminFee' => $adminFee,
            'totalPayment' => $totalPayment,
            'paymentCode' => $paymentCode,
            'expiresAt' => $expiresAt->toIso8601String(),
            'dueDate' => $dueDate,
            'dueTime' => $dueTime,
        ]);
    }

    public function showCreditCardDropDown(Request $request)
    {
        return response()->json([
            'success' => true,
            'debitCards' => [],
            'showAddNew' => true,
        ]);
    }

    public function showBankTransferDropDown(Request $request)
    {
        $banks = [
            ['id' => 'bca', 'name' => 'Bank BCA', 'logo' => 'bca.png'],
            ['id' => 'bni', 'name' => 'Bank BNI', 'logo' => 'bni.png'],
            ['id' => 'bri', 'name' => 'Bank BRI', 'logo' => 'bri.png'],
            ['id' => 'mandiri', 'name' => 'Bank Mandiri', 'logo' => 'mandiri.png'],
            ['id' => 'other', 'name' => 'Other Banks', 'logo' => null],
        ];

        return response()->json([
            'success' => true,
            'banks' => $banks,
        ]);
    }

    public function processDebitCard(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        $amount = (float) $request->input('amount');
        $adminFee = (float) $this->calculateAdminFee('debit_card', $amount);

        TopUp::create([
            'id_payment_method' => self::PAYMENT_METHOD_DEBIT_CARD,
            'id_user' => $user->id_user,
            'total_top_up' => $amount,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'admin_fee' => $adminFee,
        ]);

        $this->updateWallet($user, $amount);

        return redirect()->route('topup.success')->with('message', 'Top up successful! Amount: Rp '.number_format($amount, 0, ',', '.'));
    }

    public function processBankTransfer(Request $request)
    {
        $request->validate([
            'bank' => 'required|string|in:bca,bni,bri,mandiri,other',
            'amount' => 'required|numeric|min:10000',
        ]);

        $bank = $request->input('bank');
        $amount = (float) $request->input('amount');
        $adminFee = (float) $this->calculateAdminFee('bank_transfer', $amount);
        $virtualAccount = $this->generateVirtualAccount($bank);

        session([
            'pending_payment' => [
                'type' => 'bank_transfer',
                'bank' => $bank,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'payment_method_id' => self::PAYMENT_METHOD_BANK_TRANSFER,
                'virtual_account' => $virtualAccount,
                'expires_at' => now()->addHours(24),
            ],
        ]);

        return view('topup.topUpDebitCardVA', [
            'bank' => $bank,
            'amount' => $amount,
            'adminFee' => $adminFee,
            'virtualAccount' => $virtualAccount,
            'paymentType' => 'bank_transfer',
            'paymentLabel' => 'Bank Transfer - '.strtoupper($bank),
        ]);
    }

    public function processEwallet(Request $request)
    {
        $request->validate([
            'ewallet_type' => 'required|string',
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        $amount = (float) $request->input('amount');
        $adminFee = (float) $this->calculateAdminFee('ewallet', $amount);
        $virtualAccount = $this->generateVirtualAccount('ewallet');

        session([
            'pending_payment' => [
                'type' => 'ewallet',
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'payment_method_id' => self::PAYMENT_METHOD_EWALLET,
                'virtual_account' => $virtualAccount,
            ],
        ]);

        return view('topup.topUpDebitCardVA', [
            'amount' => $amount,
            'adminFee' => $adminFee,
            'virtualAccount' => $virtualAccount,
            'paymentType' => 'ewallet',
            'paymentLabel' => 'E-Wallet',
        ]);
    }

    public function processIndomaret(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $amount = (float) $request->input('amount');
        $adminFee = (float) $this->calculateAdminFee('indomaret', $amount);
        $paymentCode = $this->generatePaymentCode('indomaret');

        session([
            'pending_topup' => [
                'type' => 'indomaret',
                'store' => 'indomaret',
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'payment_code' => $paymentCode,
                'expires_at' => now()->addHours(24),
            ],
        ]);

        return view('topup.topUpIndomaret', [
            'amount' => $amount,
            'adminFee' => $adminFee,
            'paymentCode' => $paymentCode,
        ]);
    }

    public function processAlfamart(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $amount = (float) $request->input('amount');
        $adminFee = (float) $this->calculateAdminFee('alfamart', $amount);
        $paymentCode = $this->generatePaymentCode('alfamart');

        session([
            'pending_topup' => [
                'type' => 'alfamart',
                'store' => 'alfamart',
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'payment_code' => $paymentCode,
                'expires_at' => now()->addHours(24),
            ],
        ]);

        return view('topup.topUpAlfamart', [
            'amount' => $amount,
            'adminFee' => $adminFee,
            'paymentCode' => $paymentCode,
        ]);
    }

    public function confirmPayment(Request $request)
    {
        $pendingTopup = session('pending_topup');

        if (! $pendingTopup) {
            return redirect()->route('topup.index')->with('error', 'No pending top up found.');
        }

        $user = Auth::user();

        $paymentMethodId = match ($pendingTopup['type'] ?? 'unknown') {
            'bank_transfer' => self::PAYMENT_METHOD_BANK_TRANSFER,
            'indomaret' => self::PAYMENT_METHOD_INDOMARET,
            'alfamart' => self::PAYMENT_METHOD_ALFAMART,
            default => 1
        };

        TopUp::create([
            'id_payment_method' => $paymentMethodId,
            'id_user' => $user->id_user,
            'total_top_up' => (float) $pendingTopup['amount'],
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'admin_fee' => (float) $pendingTopup['admin_fee'],
        ]);

        $this->updateWallet($user, $pendingTopup['amount']);
        session()->forget('pending_topup');

        return redirect()->route('topup.success')->with('message', 'Top up successful!');
    }

    private function generateVirtualAccount($bank)
    {
        $prefix = match ($bank) {
            'bca' => '8801',
            'bni' => '8802',
            'bri' => '8803',
            'mandiri' => '8804',
            'debit' => '8805',
            'ewallet' => '8806',
            default => '8800'
        };

        return $prefix.' '.rand(1000, 9999).' '.rand(1000, 9999).' '.rand(1000, 9999);
    }

    private function generatePaymentCode($store)
    {
        $prefix = $store === 'indomaret' ? 'IDM' : 'ALF';

        return $prefix.date('YmdHis').rand(1000, 9999);
    }

    private function calculateAdminFee($method, $amount)
    {
        return (float) match ($method) {
            'debit_card' => 2000,
            'bank_transfer' => 2000,
            'ewallet' => 1500,
            'indomaret' => 2000,
            'alfamart' => 2000,
            default => 0
        };
    }

    /**
     * Update user's wallet balance
     * Menambahkan top up amount ke saldo_coin di tabel wallet
     */
    private function updateWallet($user, $amount)
    {
        $wallet = Wallet::where('id_user', $user->id_user)->first();

        if ($wallet) {
            $wallet->saldo_coin += $amount;
            $wallet->save();
        } else {
            Wallet::create([
                'id_user' => $user->id_user,
                'saldo_coin' => $amount,
            ]);
        }
    }

    public function showSuccess()
    {
        return view('topup.topUpSuccess');
    }

    public function addDebitCard(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|min:16|max:19',
            'card_holder' => 'required|string|max:100',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string|min:3|max:4',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Debit card added successfully',
        ]);
    }

    public function history()
    {
        $user = Auth::user();

        $topUps = TopUp::where('id_user', $user->id_user)
            ->with('paymentMethod')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10);

        return view('topup.topUpHistory', [
            'user' => $user,
            'topUps' => $topUps,
        ]);
    }

    public function cancelPayment()
    {
        session()->forget('pending_topup');
        session()->forget('pending_payment');

        return redirect()->route('topup.index')->with('message', 'Payment cancelled.');
    }

    /**
     * Confirm Debit Card / Bank Transfer / E-Wallet Payment dari VA page
     */
    public function confirmDebitCardPayment(Request $request)
    {
        $user = Auth::user();
        $debitCard = session('debit_card');
        $pendingPayment = session('pending_payment');

        // Jika ada pending payment (dari bank transfer atau e-wallet)
        if ($pendingPayment) {
            $amount = (float) $pendingPayment['amount'];
            $adminFee = (float) $pendingPayment['admin_fee'];
            $paymentMethodId = $pendingPayment['payment_method_id'];

            TopUp::create([
                'id_payment_method' => $paymentMethodId,
                'id_user' => $user->id_user,
                'total_top_up' => $amount,
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'admin_fee' => $adminFee,
            ]);

            // Update wallet dengan amount (tanpa admin fee)
            $this->updateWallet($user, $amount);

            session()->forget('pending_payment');
            session()->forget('debit_card');

            return redirect()->route('topup.success')->with('message', 'Top up successful! Rp '.number_format($amount, 0, ',', '.').' has been added to your wallet.');
        }

        // Jika dari add debit card flow (tanpa amount)
        if ($debitCard) {
            session()->forget('debit_card');

            return redirect()->route('topup.success')->with('message', 'Debit card added successfully!');
        }

        return redirect()->route('topup.index')->with('error', 'No pending payment found.');
    }

    public function backToPreviousPage()
    {
        return redirect()->back();
    }
}

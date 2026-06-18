<?php

use App\Models\TopUp;
use App\Models\User;
use App\Models\Wallet;

// ============================================================
// AUTH GUARDS
// ============================================================

it('redirects guests from the topup index page', function () {
    $this->get(route('topup.index'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the topup coin page', function () {
    $this->get(route('topup.coin'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the topup history page', function () {
    $this->get(route('topup.history'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the bank transfer page', function () {
    $this->get(route('topup.banktransfer.page'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the ewallet page', function () {
    $this->get(route('topup.ewallet.page'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the indomaret page', function () {
    $this->get(route('topup.indomaret.page'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the alfamart page', function () {
    $this->get(route('topup.alfamart.page'))
        ->assertRedirect(route('login'));
});

// ============================================================
// PAGE RENDERING
// ============================================================

it('renders topup main page with payment methods and user data', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.index'))
        ->assertOk()
        ->assertViewIs('topup.topUp')
        ->assertViewHas('user', $user);
});

it('renders topup coin page (redirect from home plus icon)', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.coin'))
        ->assertOk()
        ->assertViewIs('topup.topUp');
});

it('renders bank transfer amount input page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.banktransfer.page'))
        ->assertOk()
        ->assertViewIs('topup.topUpBankTransfer')
        ->assertViewHas('user', $user);
});

it('renders ewallet amount input page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.ewallet.page'))
        ->assertOk()
        ->assertViewIs('topup.topUpEwallet');
});

it('renders indomaret amount input page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.indomaret.page'))
        ->assertOk()
        ->assertViewIs('topup.topUpCoinIndomaret12');
});

it('renders alfamart amount input page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.alfamart.page'))
        ->assertOk()
        ->assertViewIs('topup.topUpCoinAlfamart12');
});

it('renders debit card add form page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/topup/debitcard/add')
        ->assertOk()
        ->assertViewIs('topup.topUpDebitCard');
});

it('renders topup success page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.success'))
        ->assertOk()
        ->assertViewIs('topup.topUpSuccess');
});

// ============================================================
// BANK TRANSFER – New Flow (processBankTransferPayment)
// ============================================================

it('processes bank transfer and stores pending payment in session', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.banktransfer.process.payment'), [
            'amount' => 50000,
            'bank'   => 'bca',
        ])
        ->assertOk()
        ->assertViewIs('topup.topUpDebitCardVA');

    expect(session('pending_payment.type'))->toBe('bank_transfer')
        ->and(session('pending_payment.bank'))->toBe('bca')
        ->and((float) session('pending_payment.amount'))->toBe(50000.0);
});

it('generates a virtual account number when processing bank transfer', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.banktransfer.process.payment'), [
            'amount' => 100000,
            'bank'   => 'bni',
        ]);

    expect(session('pending_payment.virtual_account'))->not->toBeNull();
});

it('rejects bank transfer when amount is below 10 000', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.banktransfer.process.payment'), [
            'amount' => 9999,
            'bank'   => 'bca',
        ])
        ->assertSessionHasErrors('amount');
});

it('rejects bank transfer when bank field is missing', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.banktransfer.process.payment'), [
            'amount' => 50000,
        ])
        ->assertSessionHasErrors('bank');
});

// ============================================================
// BANK TRANSFER – Legacy Flow (processBankTransfer)
// ============================================================

it('legacy bank transfer accepts a valid bank and stores session data', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.banktransfer.process'), [
            'bank'   => 'mandiri',
            'amount' => 75000,
        ])
        ->assertOk()
        ->assertViewIs('topup.topUpDebitCardVA');

    expect(session('pending_payment.bank'))->toBe('mandiri');
});

it('legacy bank transfer rejects an unknown bank name', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.banktransfer.process'), [
            'bank'   => 'unknownbank',
            'amount' => 50000,
        ])
        ->assertSessionHasErrors('bank');
});

it('legacy bank transfer accepts all allowed bank values', function (string $bank) {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.banktransfer.process'), [
            'bank'   => $bank,
            'amount' => 50000,
        ])
        ->assertOk();
})->with(['bca', 'bni', 'bri', 'mandiri', 'other']);

// ============================================================
// E-WALLET – New Flow (processEwalletPayment)
// ============================================================

it('processes ewallet payment and stores pending payment in session', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.ewallet.process.payment'), [
            'amount' => 25000,
        ])
        ->assertOk()
        ->assertViewIs('topup.topUpDebitCardVA');

    expect(session('pending_payment.type'))->toBe('ewallet')
        ->and((float) session('pending_payment.amount'))->toBe(25000.0);
});

it('rejects ewallet payment when amount is below 10 000', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.ewallet.process.payment'), [
            'amount' => 5000,
        ])
        ->assertSessionHasErrors('amount');
});

it('rejects ewallet payment when amount is missing', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.ewallet.process.payment'), [])
        ->assertSessionHasErrors('amount');
});

// ============================================================
// DEBIT CARD – processDebitCard
// ============================================================

it('processes debit card topup, writes TopUp record, and credits wallet', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->post(route('topup.debitcard.process'), ['amount' => 100000])
        ->assertRedirect(route('topup.success'))
        ->assertSessionHas('message');

    $this->assertDatabaseHas('top_up', [
        'id_user'           => $user->id_user,
        'id_payment_method' => 1,
        'total_top_up'      => 100000,
    ]);

    expect((float) Wallet::where('id_user', $user->id_user)->value('saldo_coin'))
        ->toBe(100000.0);
});

it('accumulates wallet balance on successive debit card topups', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 50000]);

    $this->actingAs($user)
        ->post(route('topup.debitcard.process'), ['amount' => 100000]);

    expect((float) Wallet::where('id_user', $user->id_user)->value('saldo_coin'))
        ->toBe(150000.0);
});

it('creates a new wallet when none exists on debit card topup', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.process'), ['amount' => 50000]);

    $this->assertDatabaseHas('wallet', [
        'id_user'    => $user->id_user,
        'saldo_coin' => 50000,
    ]);
});

it('rejects debit card topup when amount is below minimum', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.process'), ['amount' => 5000])
        ->assertSessionHasErrors('amount');
});

// ============================================================
// DEBIT CARD – storeDebitCard
// ============================================================

it('stores debit card in session and renders VA page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.store'), [
            'card_number'  => '4111 1111 1111 1111',
            'expiry_date'  => '12/26',
            'cvv'          => '123',
            'name_on_card' => 'Budi Santoso',
            'address'      => 'Jl. Pemuda No. 10 Surabaya',
            'postal_code'  => '60271',
        ])
        ->assertOk()
        ->assertViewIs('topup.topUpDebitCardVA');

    expect(session('debit_card'))->not->toBeNull()
        ->and(session('debit_card.name_on_card'))->toBe('Budi Santoso');
});

it('masks the card number stored in session', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.store'), [
            'card_number'  => '4111 1111 1111 1234',
            'expiry_date'  => '12/26',
            'cvv'          => '123',
            'name_on_card' => 'Test User',
            'address'      => 'Jl. Test',
            'postal_code'  => '60111',
        ]);

    expect(session('debit_card.card_number_masked'))->toContain('1234');
});

it('rejects store debit card when card number is shorter than 19 characters', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.store'), [
            'card_number'  => '4111 1111',
            'expiry_date'  => '12/26',
            'cvv'          => '123',
            'name_on_card' => 'Budi Santoso',
            'address'      => 'Jl. Test',
            'postal_code'  => '60271',
        ])
        ->assertSessionHasErrors('card_number');
});

it('rejects store debit card when required fields are absent', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.store'), [])
        ->assertSessionHasErrors(['card_number', 'expiry_date', 'cvv', 'name_on_card', 'address', 'postal_code']);
});

// ============================================================
// DEBIT CARD – addDebitCard (JSON endpoint)
// ============================================================

it('add debit card JSON endpoint returns success true', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.add'), [
            'card_number'  => '4111111111111111',
            'card_holder'  => 'Budi Santoso',
            'expiry_date'  => '12/26',
            'cvv'          => '123',
        ])
        ->assertOk()
        ->assertJson(['success' => true]);
});

it('rejects add debit card when card number is too short', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.add'), [
            'card_number'  => '4111',
            'card_holder'  => 'Budi',
            'expiry_date'  => '12/26',
            'cvv'          => '123',
        ])
        ->assertSessionHasErrors('card_number');
});

// ============================================================
// INDOMARET
// ============================================================

it('processes indomaret payment, writes TopUp record, and credits wallet', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->post(route('topup.indomaret.process.payment'), ['amount' => 50000])
        ->assertOk()
        ->assertViewIs('topup.topUpCoinIndomaret3');

    $this->assertDatabaseHas('top_up', [
        'id_user'           => $user->id_user,
        'id_payment_method' => 4,
        'total_top_up'      => 50000,
    ]);

    expect((float) Wallet::where('id_user', $user->id_user)->value('saldo_coin'))
        ->toBe(50000.0);
});

it('stores indomaret payment code with IDM prefix in session', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->post(route('topup.indomaret.process.payment'), ['amount' => 30000]);

    expect(session('pending_topup.type'))->toBe('indomaret')
        ->and(session('pending_topup.payment_code'))->toStartWith('IDM');
});

it('rejects indomaret payment when amount is below minimum', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.indomaret.process.payment'), ['amount' => 1000])
        ->assertSessionHasErrors('amount');
});

it('shows indomaret barcode page when valid session is present', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->withSession([
            'pending_topup' => [
                'type'          => 'indomaret',
                'amount'        => 50000,
                'admin_fee'     => 2000,
                'total_payment' => 52000,
                'payment_code'  => 'IDM20260101120000001',
                'expires_at'    => now()->addHours(24)->toIso8601String(),
                'due_date'      => '01 Jan 2026',
                'due_time'      => '12:00',
            ],
        ])
        ->get(route('topup.indomaret.barcode'))
        ->assertOk()
        ->assertViewIs('topup.topUpCoinIndomaret3');
});

it('redirects from indomaret barcode page when session is absent', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.indomaret.barcode'))
        ->assertRedirect(route('topup.indomaret.page'));
});

it('redirects from indomaret barcode page when session type is not indomaret', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->withSession(['pending_topup' => ['type' => 'alfamart', 'amount' => 50000]])
        ->get(route('topup.indomaret.barcode'))
        ->assertRedirect(route('topup.indomaret.page'));
});

// ============================================================
// ALFAMART
// ============================================================

it('processes alfamart payment, writes TopUp record, and credits wallet', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->post(route('topup.alfamart.process.payment'), ['amount' => 75000])
        ->assertOk()
        ->assertViewIs('topup.topUpCoinAlfamart3');

    $this->assertDatabaseHas('top_up', [
        'id_user'           => $user->id_user,
        'id_payment_method' => 5,
        'total_top_up'      => 75000,
    ]);

    expect((float) Wallet::where('id_user', $user->id_user)->value('saldo_coin'))
        ->toBe(75000.0);
});

it('stores alfamart payment code with ALF prefix in session', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->post(route('topup.alfamart.process.payment'), ['amount' => 30000]);

    expect(session('pending_topup.payment_code'))->toStartWith('ALF');
});

it('rejects alfamart payment when amount is below minimum', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.alfamart.process.payment'), ['amount' => 0])
        ->assertSessionHasErrors('amount');
});

// ============================================================
// CONFIRM PAYMENT (confirmPayment)
// ============================================================

it('confirms pending topup from session and credits wallet', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->withSession([
            'pending_topup' => [
                'type'      => 'bank_transfer',
                'amount'    => 50000,
                'admin_fee' => 2000,
            ],
        ])
        ->post(route('topup.confirm'))
        ->assertRedirect(route('topup.success'));

    expect((float) Wallet::where('id_user', $user->id_user)->value('saldo_coin'))
        ->toBe(50000.0);
});

it('creates wallet when none exists on confirm payment', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->withSession([
            'pending_topup' => [
                'type'      => 'indomaret',
                'amount'    => 30000,
                'admin_fee' => 2000,
            ],
        ])
        ->post(route('topup.confirm'));

    $this->assertDatabaseHas('wallet', [
        'id_user'    => $user->id_user,
        'saldo_coin' => 30000,
    ]);
});

it('clears pending_topup session key after successful confirmation', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->withSession([
            'pending_topup' => [
                'type'      => 'alfamart',
                'amount'    => 50000,
                'admin_fee' => 2000,
            ],
        ])
        ->post(route('topup.confirm'));

    expect(session('pending_topup'))->toBeNull();
});

it('redirects to topup index when confirming with no session', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.confirm'))
        ->assertRedirect(route('topup.index'));
});

it('writes a TopUp record with the correct payment method id on confirm', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->withSession([
            'pending_topup' => [
                'type'      => 'alfamart',
                'amount'    => 40000,
                'admin_fee' => 2000,
            ],
        ])
        ->post(route('topup.confirm'));

    $this->assertDatabaseHas('top_up', [
        'id_user'           => $user->id_user,
        'id_payment_method' => 5,
        'total_top_up'      => 40000,
    ]);
});

// ============================================================
// CONFIRM DEBIT CARD PAYMENT (confirmDebitCardPayment)
// ============================================================

it('confirms bank-transfer pending_payment and credits wallet', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->withSession([
            'pending_payment' => [
                'type'              => 'bank_transfer',
                'amount'            => 100000,
                'admin_fee'         => 2000,
                'payment_method_id' => 2,
            ],
        ])
        ->post(route('topup.debitcard.confirm'))
        ->assertRedirect(route('topup.success'));

    expect((float) Wallet::where('id_user', $user->id_user)->value('saldo_coin'))
        ->toBe(100000.0);
});

it('clears both session keys after confirming debit card payment', function () {
    $user = User::factory()->create();
    Wallet::create(['id_user' => $user->id_user, 'saldo_coin' => 0]);

    $this->actingAs($user)
        ->withSession([
            'pending_payment' => [
                'type'              => 'ewallet',
                'amount'            => 50000,
                'admin_fee'         => 1500,
                'payment_method_id' => 3,
            ],
            'debit_card' => ['card_number' => '4111111111111111'],
        ])
        ->post(route('topup.debitcard.confirm'));

    expect(session('pending_payment'))->toBeNull()
        ->and(session('debit_card'))->toBeNull();
});

it('redirects to topup index when confirming debit card with no session', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('topup.debitcard.confirm'))
        ->assertRedirect(route('topup.index'));
});

// ============================================================
// CANCEL PAYMENT
// ============================================================

it('cancel clears pending_topup and pending_payment sessions', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->withSession([
            'pending_topup'   => ['type' => 'indomaret', 'amount' => 50000],
            'pending_payment' => ['type' => 'bank_transfer', 'amount' => 50000],
        ])
        ->get(route('topup.cancel'))
        ->assertRedirect(route('topup.index'));

    expect(session('pending_topup'))->toBeNull()
        ->and(session('pending_payment'))->toBeNull();
});

it('cancel redirects to topup index even with no active sessions', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.cancel'))
        ->assertRedirect(route('topup.index'));
});

// ============================================================
// TOP UP HISTORY
// ============================================================

it('renders topup history page with the users paginated records', function () {
    $user = User::factory()->create();

    TopUp::create([
        'id_payment_method' => 1,
        'id_user'           => $user->id_user,
        'total_top_up'      => 50000,
        'date'              => now()->toDateString(),
        'time'              => now()->toTimeString(),
        'admin_fee'         => 2000,
    ]);

    $this->actingAs($user)
        ->get(route('topup.history'))
        ->assertOk()
        ->assertViewIs('topup.topUpHistory')
        ->assertViewHas('topUps');
});

it('shows only the authenticated users records in topup history', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    TopUp::create([
        'id_payment_method' => 1,
        'id_user'           => $userA->id_user,
        'total_top_up'      => 50000,
        'date'              => now()->toDateString(),
        'time'              => now()->toTimeString(),
        'admin_fee'         => 2000,
    ]);

    $response = $this->actingAs($userB)->get(route('topup.history'));

    expect($response->viewData('topUps')->total())->toBe(0);
});

it('shows an empty history page for a user with no topup records', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('topup.history'));

    $response->assertOk();
    expect($response->viewData('topUps')->total())->toBe(0);
});

// ============================================================
// DROPDOWN JSON ENDPOINTS
// ============================================================

it('debit card dropdown endpoint returns success JSON', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.debitcard.dropdown'))
        ->assertOk()
        ->assertJson(['success' => true, 'showAddNew' => true]);
});

it('bank transfer dropdown returns all 5 supported banks', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('topup.banktransfer.dropdown'))
        ->assertOk()
        ->assertJson(['success' => true])
        ->assertJsonCount(5, 'banks');
});

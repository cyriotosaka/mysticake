<!DOCTYPE html>
<html lang="id">
<!-- Created by Okky Priscila_168 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top-up Coin - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/topup/topUp.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="header-container">
        <a href="{{ route('home') }}" class="back-button">
        <i class="bi bi-arrow-left"></i>
        </a>
        <span class="header-title">Top-up Coin MystiCake</span>
    </div>

    <!-- Fixed Floating Bar -->
    <div class="floating-bar">
        <span class="floating-bar-text">Choose Top Up Method</span>
        <i class="bi bi-coin coin-icon"></i>
    </div>

    <!-- Main Content -->
    <div class="content-container">

        <!-- 1. Debit Card Section -->
        <div class="payment-card" id="debitCardSection">
            <div class="payment-card-header" onclick="toggleDropdown('debitCard')">
                <div class="payment-card-left">
                    <img src="{{ asset('images/topup/debitCardDark.png') }}" alt="Debit Card" class="payment-icon">
                    <span class="payment-title">Debit Card</span>
                </div>
                <i class="bi bi-chevron-down dropdown-icon" id="debitCardIcon"></i>
            </div>
            <div class="payment-card-dropdown" id="debitCardDropdown">
                <div class="dropdown-item add-new-card" onclick="goToAddDebitCard()">
                    <i class="bi bi-plus-square add-icon"></i>
                    <span class="add-text">Add new debit card</span>
                </div>
            </div>
        </div>

        <!-- 2. Bank Transfer Section -->
        <div class="payment-card" id="bankTransferSection">
            <div class="payment-card-header" onclick="toggleDropdown('bankTransfer')">
                <div class="payment-card-left">
                    <img src="{{ asset('images/topup/creditCardTransfer.png') }}" alt="Bank Transfer" class="payment-icon">
                    <span class="payment-title">Bank Transfer</span>
                </div>
                <i class="bi bi-chevron-down dropdown-icon" id="bankTransferIcon"></i>
            </div>
            <div class="payment-card-dropdown" id="bankTransferDropdown">
                <div class="dropdown-item bank-item" onclick="selectBank('bca')">
                    <img src="{{ asset('images/topup/bca.png') }}" alt="BCA" class="bank-logo">
                    <span class="bank-name">Bank BCA</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item bank-item" onclick="selectBank('bni')">
                    <img src="{{ asset('images/topup/bni.png') }}" alt="BNI" class="bank-logo">
                    <span class="bank-name">Bank BNI</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item bank-item" onclick="selectBank('bri')">
                    <img src="{{ asset('images/topup/bri.png') }}" alt="BRI" class="bank-logo">
                    <span class="bank-name">Bank BRI</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item bank-item" onclick="selectBank('mandiri')">
                    <img src="{{ asset('images/topup/mandiri.png') }}" alt="Mandiri" class="bank-logo">
                    <span class="bank-name">Bank Mandiri</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item bank-item" onclick="selectBank('other')">
                    <i class="bi bi-bank bank-icon"></i>
                    <span class="bank-name">Other Banks</span>
                </div>
            </div>
        </div>

        <!-- 3. E-wallet Section -->
        <div class="payment-card" id="ewalletSection" onclick="selectEwallet()">
            <div class="payment-card-header">
                <div class="payment-card-left">
                    <i class="bi bi-wallet2 wallet-icon"></i>
                    <span class="payment-title">E-wallet</span>
                </div>
            </div>
        </div>

        <!-- 4. Indomaret Section - Redirect to new page -->
        <div class="payment-card" id="indomaretSection" onclick="goToIndomaretPage()">
            <div class="payment-card-header">
                <div class="payment-card-left">
                    <img src="{{ asset('images/topup/indomaret.png') }}" alt="Indomaret" class="payment-icon indomaret-logo">
                    <span class="payment-title">Indomaret</span>
                </div>
            </div>
        </div>

        <!-- 5. Alfamart Section - Redirect to new page -->
        <div class="payment-card" id="alfamartSection" onclick="goToAlfamartPage()">
            <div class="payment-card-header">
                <div class="payment-card-left">
                    <img src="{{ asset('images/topup/alfamart.png') }}" alt="Alfamart" class="payment-icon alfamart-logo">
                    <span class="payment-title">Alfamart</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Amount Input Modal (for other payment methods) -->
    <div class="modal fade" id="amountModal" tabindex="-1" aria-labelledby="amountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="amountModalLabel">Enter Top Up Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="topupForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="payment_type" id="paymentType">
                        <input type="hidden" name="bank" id="selectedBank">
                        <input type="hidden" name="store" id="selectedStore">
                        <input type="hidden" name="ewallet_type" id="ewalletType" value="E-wallet">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount (Rp)</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="10000" step="1000" placeholder="Min. Rp 10.000" required>
                        </div>
                        <div class="admin-fee-info">
                            <small class="text-muted">Admin fee: <span id="adminFeeDisplay">Rp 0</span></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle dropdown function
        function toggleDropdown(section) {
            const dropdown = document.getElementById(section + 'Dropdown');
            const icon = document.getElementById(section + 'Icon');
            const card = document.getElementById(section + 'Section');
            
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
                icon.classList.remove('bi-chevron-up');
                icon.classList.add('bi-chevron-down');
                card.classList.remove('expanded');
            } else {
                dropdown.classList.add('show');
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-up');
                card.classList.add('expanded');
            }
        }

        // ✅ FUNGSI BARU - Select bank (redirect ke halaman input amount)
        function selectBank(bank) {
            window.location.href = '{{ route("topup.banktransfer.page") }}?bank=' + bank;
        }

        // Go to Indomaret page (new flow)
        function goToIndomaretPage() {
            window.location.href = '{{ route("topup.indomaret.page") }}';
        }

        // Go to Alfamart page (new flow)
        function goToAlfamartPage() {
            window.location.href = '{{ route("topup.alfamart.page") }}';
        }

        // Go to Add Debit Card page (new flow)
        function goToAddDebitCard() {
            window.location.href = '{{ route("topup.debitcard.add") }}';
        }

        // ✅ FUNGSI BARU - Select E-wallet (redirect ke halaman input amount)
        function selectEwallet() {
            window.location.href = '{{ route("topup.ewallet.page") }}';
        }

        // Show add card modal
        function showAddCardModal() {
            document.getElementById('paymentType').value = 'debit_card';
            document.getElementById('topupForm').action = '{{ route("topup.debitcard.process") }}';
            updateAdminFee('debit_card');
            
            var amountModal = new bootstrap.Modal(document.getElementById('amountModal'));
            amountModal.show();
        }

        // Update admin fee display
        function updateAdminFee(method) {
            let fee = 0;
            switch(method) {
                case 'debit_card': fee = 2500; break;
                case 'bank_transfer': fee = 4000; break;
                case 'ewallet': fee = 1500; break;
                case 'indomaret': fee = 2000; break;
                case 'alfamart': fee = 2000; break;
            }
            document.getElementById('adminFeeDisplay').textContent = 'Rp ' + fee.toLocaleString('id-ID');
        }
    </script>
</body>
</html>

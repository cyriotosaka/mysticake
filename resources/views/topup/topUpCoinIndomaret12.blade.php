<!DOCTYPE html>
<html lang="id">
<!-- Created by Okky Priscila_168 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Top Up - Indomaret - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/topup/topUpCoinIndomaret12.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="header-container">
        <a href="{{ route('topup.index') }}" class="back-button">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="header-title">Coin Top Up</span>
    </div>

    <!-- Fixed Floating Bar -->
    <div class="floating-bar">
        <img src="{{ asset('images/topup/indomaret.png') }}" alt="Indomaret" class="floating-bar-logo">
        <span class="floating-bar-text">Indomaret Payment Method</span>
    </div>

    <!-- Main Content -->
    <div class="content-container">

        <!-- Input Amount Card -->
        <div class="amount-input-card">
            <div class="input-label">Input Amount (Rp)</div>
            
            <!-- Static Input Bar -->
            <div class="input-static-bar">
                <span class="currency-prefix">Rp</span>
                <span class="amount-display" id="amountDisplay">0</span>
            </div>

            <!-- Amount Options Grid -->
            <div class="amount-options-grid">
                <div class="amount-option" data-amount="20000" onclick="selectAmount(this, 20000)">20.000</div>
                <div class="amount-option" data-amount="50000" onclick="selectAmount(this, 50000)">50.000</div>
                <div class="amount-option" data-amount="100000" onclick="selectAmount(this, 100000)">100.000</div>
                <div class="amount-option" data-amount="200000" onclick="selectAmount(this, 200000)">200.000</div>
                <div class="amount-option" data-amount="300000" onclick="selectAmount(this, 300000)">300.000</div>
                <div class="amount-option" data-amount="500000" onclick="selectAmount(this, 500000)">500.000</div>
                <div class="amount-option" data-amount="1000000" onclick="selectAmount(this, 1000000)">1.000.000</div>
                <div class="amount-option" data-amount="2000000" onclick="selectAmount(this, 2000000)">2.000.000</div>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="summary-card">
            <div class="summary-row">
                <span class="summary-label">Top Up Amount</span>
                <span class="summary-value" id="topUpAmountDisplay">Rp0</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Admin Fee</span>
                <span class="summary-value" id="adminFeeDisplay">Rp{{ number_format($adminFee ?? 2000, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total-row">
                <span class="summary-label">Total Payment</span>
                <span class="summary-value" id="totalPaymentDisplay">Rp0</span>
            </div>
        </div>

    </div>

    <!-- Pay Now Button -->
    <form id="paymentForm" action="{{ route('topup.indomaret.process.payment') }}" method="POST">
        @csrf
        <input type="hidden" name="amount" id="hiddenAmount" value="0">
        <input type="hidden" name="admin_fee" id="hiddenAdminFee" value="{{ $adminFee ?? 2000 }}">
        <input type="hidden" name="total_payment" id="hiddenTotalPayment" value="0">
        <button type="submit" class="pay-now-btn" id="payNowBtn" disabled>
            <span>Pay Now</span>
        </button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedAmount = 0;
        let selectedElement = null;
        const adminFee = {{ $adminFee ?? 2000 }};

        function selectAmount(element, amount) {
            // If clicking the same element, deselect it
            if (selectedElement === element) {
                element.classList.remove('selected');
                selectedElement = null;
                selectedAmount = 0;
                updateDisplay();
                return;
            }

            // Remove selection from previous element
            if (selectedElement) {
                selectedElement.classList.remove('selected');
            }

            // Select new element
            element.classList.add('selected');
            selectedElement = element;
            selectedAmount = amount;
            updateDisplay();
        }

        function updateDisplay() {
            const totalPayment = selectedAmount + (selectedAmount > 0 ? adminFee : 0);
            
            // Update displays
            document.getElementById('amountDisplay').textContent = formatNumber(selectedAmount);
            document.getElementById('topUpAmountDisplay').textContent = 'Rp' + formatNumber(selectedAmount);
            document.getElementById('totalPaymentDisplay').textContent = 'Rp' + formatNumber(totalPayment);
            
            // Update hidden inputs
            document.getElementById('hiddenAmount').value = selectedAmount;
            document.getElementById('hiddenTotalPayment').value = totalPayment;
            
            // Enable/disable button
            const payNowBtn = document.getElementById('payNowBtn');
            if (selectedAmount > 0) {
                payNowBtn.disabled = false;
                payNowBtn.classList.add('active');
            } else {
                payNowBtn.disabled = true;
                payNowBtn.classList.remove('active');
            }
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
</body>
</html>

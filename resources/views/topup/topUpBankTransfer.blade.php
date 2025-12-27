<!DOCTYPE html>
<html lang="id">
<!-- Created by Okky Priscila_168 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transfer - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/topup/topUpDebitCard.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="header-container">
        <a href="{{ route('topup.index') }}" class="back-button">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="header-title">Bank Transfer</span>
    </div>

    <!-- Fixed Floating Bar -->
    <div class="floating-bar">
        <i class="bi bi-shield-check shield-icon"></i>
        <span class="floating-bar-text">Your transaction is protected.</span>
    </div>

    <!-- Main Content -->
    <div class="content-container">

        <!-- Bank Details Section -->
        <div class="section-title">Bank Details</div>

        <form id="bankTransferForm" action="{{ route('topup.banktransfer.process.payment') }}" method="POST">
            @csrf
            <input type="hidden" name="bank" value="{{ $bank }}">
            
            <!-- Selected Bank Display -->
            <div class="input-group-custom">
                <input type="text" 
                       class="input-box input-box-full" 
                       id="selectedBank" 
                       value="Bank {{ strtoupper($bank) }}"
                       readonly
                       disabled>
            </div>

            <!-- Top Up Amount Section -->
            <div class="section-title section-title-billing">Top Up Amount</div>

            <!-- Amount Input -->
            <div class="input-group-custom">
                <span class="error-message" id="amountError">Minimum top up Rp 10.000</span>
                <input type="number" 
                       class="input-box input-box-full" 
                       id="amount" 
                       name="amount" 
                       placeholder="Amount (Min. Rp 10.000)"
                       min="10000"
                       step="1000"
                       required>
            </div>

            <!-- Admin Fee Display -->
            <div class="input-group-custom">
                <input type="text" 
                       class="input-box input-box-full" 
                       id="adminFeeDisplay" 
                       value="Admin Fee: Rp {{ number_format($adminFee, 0, ',', '.') }}"
                       readonly
                       disabled>
            </div>

            <!-- Total Payment Display -->
            <div class="input-group-custom">
                <input type="text" 
                       class="input-box input-box-full" 
                       id="totalDisplay" 
                       value="Total: Rp {{ number_format($adminFee, 0, ',', '.') }}"
                       readonly
                       disabled>
            </div>

            <!-- Terms Text -->
            <div class="terms-text-weirdcombo">
                By clicking "Continue", you agree to our data sharing policies according to our <span class="terms-bold">Privacy Policy</span> & <span class="terms-bold">Terms of Services</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn" id="submitBtn" disabled>
                <span>Continue</span>
            </button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get all input elements
        const amountInput = document.getElementById('amount');
        const submitBtn = document.getElementById('submitBtn');
        const adminFee = {{ $adminFee }};

        // Amount input validation
        amountInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
            validateForm();
            updateTotal();
        });

        // Update total display
        function updateTotal() {
            const amount = parseInt(amountInput.value) || 0;
            const total = amount + adminFee;
            document.getElementById('totalDisplay').value = 'Total: Rp ' + total.toLocaleString('id-ID');
        }

        // Validate form and enable/disable submit button
        function validateForm() {
            const amount = parseInt(amountInput.value) || 0;

            // Show/hide error messages
            document.getElementById('amountError').style.display = 
                amount > 0 && amount < 10000 ? 'block' : 'none';

            // Check if amount is valid
            const isValid = amount >= 10000;

            // Enable/disable submit button
            if (isValid) {
                submitBtn.disabled = false;
                submitBtn.classList.add('active');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('active');
            }
        }

        // Form submission validation
        document.getElementById('bankTransferForm').addEventListener('submit', function(e) {
            const amount = parseInt(amountInput.value) || 0;

            if (amount < 10000) {
                document.getElementById('amountError').style.display = 'block';
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
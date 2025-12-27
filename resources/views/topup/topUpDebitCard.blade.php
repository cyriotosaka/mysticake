<!DOCTYPE html>
<html lang="id">
<!-- Created by Okky Priscila_168 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Debit Card - MystiCake</title>

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
        <span class="header-title">Add Debit Card</span>
    </div>

    <!-- Fixed Floating Bar -->
    <div class="floating-bar">
        <i class="bi bi-shield-check shield-icon"></i>
        <span class="floating-bar-text">Your card details are protected.</span>
    </div>

    <!-- Main Content -->
    <div class="content-container">

        <!-- Card Details Section -->
        <div class="section-title">Card Details</div>

        <form id="debitCardForm" action="{{ route('topup.debitcard.store') }}" method="POST">
            @csrf
            
            <!-- Card Number Input -->
            <div class="input-group-custom">
                <span class="error-message" id="cardNumberError">Card number wajib diisi.</span>
                <input type="text" 
                       class="input-box input-box-full" 
                       id="cardNumber" 
                       name="card_number" 
                       placeholder="Card Number"
                       maxlength="25"
                       required>
            </div>

            <!-- Expiry Date and CVV Row -->
            <div class="input-row">
                <div class="input-group-custom input-left">
                    <span class="error-message" id="expiryDateError">Expiry date wajib diisi.</span>
                    <input type="text" 
                           class="input-box input-box-expiry" 
                           id="expiryDate" 
                           name="expiry_date" 
                           placeholder="Expiry Date (MM/YY)"
                           maxlength="5"
                           required>
                </div>
                <div class="input-group-custom input-right">
                    <span class="error-message" id="cvvError">CVV wajib diisi.</span>
                    <input type="text" 
                           class="input-box input-box-cvv" 
                           id="cvv" 
                           name="cvv" 
                           placeholder="CVV"
                           maxlength="3"
                           required>
                </div>
            </div>

            <!-- Name on Card Input -->
            <div class="input-group-custom">
                <span class="error-message" id="nameOnCardError">Name on number wajib diisi.</span>
                <input type="text" 
                       class="input-box input-box-full" 
                       id="nameOnCard" 
                       name="name_on_card" 
                       placeholder="Name on Number"
                       required>
            </div>

            <!-- Billing Address Section -->
            <div class="section-title section-title-billing">Billing Address</div>

            <!-- Address Input -->
            <div class="input-group-custom">
                <span class="error-message" id="addressError">Address wajib diisi.</span>
                <input type="text" 
                       class="input-box input-box-full" 
                       id="address" 
                       name="address" 
                       placeholder="Address"
                       required>
            </div>

            <!-- Postal Code Input -->
            <div class="input-group-custom">
                <span class="error-message" id="postalCodeError">Postal code wajib diisi.</span>
                <input type="text" 
                       class="input-box input-box-full" 
                       id="postalCode" 
                       name="postal_code" 
                       placeholder="Postal Code"
                       required>
            </div>

            <!-- Terms Text -->
            <div class="terms-text">
                By clicking "Submit", you agree to our data sharing policies according to our <span class="terms-bold">Privacy Policy</span> & <span class="terms-bold">Terms of Services</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn" id="submitBtn" disabled>
                <span>Submit</span>
            </button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get all input elements
        const cardNumberInput = document.getElementById('cardNumber');
        const expiryDateInput = document.getElementById('expiryDate');
        const cvvInput = document.getElementById('cvv');
        const nameOnCardInput = document.getElementById('nameOnCard');
        const addressInput = document.getElementById('address');
        const postalCodeInput = document.getElementById('postalCode');
        const submitBtn = document.getElementById('submitBtn');

        // Format card number with dots every 4 digits
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            value = value.substring(0, 16); // Max 16 digits
            // Add dot separator every 4 digits
            let formatted = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formatted += ' ';
                }
                formatted += value[i];
            }
            e.target.value = formatted;
            validateForm();
        });

        // Format expiry date with slash
        expiryDateInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            value = value.substring(0, 4); // Max 4 digits (MMYY)
            
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }
            e.target.value = value;
            validateForm();
        });

        // CVV input - only digits, max 3
        cvvInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            e.target.value = value.substring(0, 3);
            validateForm();
        });

        // Other inputs validation
        nameOnCardInput.addEventListener('input', validateForm);
        addressInput.addEventListener('input', validateForm);
        postalCodeInput.addEventListener('input', validateForm);

        // Validate form and enable/disable submit button
        function validateForm() {
            const cardNumber = cardNumberInput.value.replace(/\D/g, '');
            const expiryDate = expiryDateInput.value;
            const cvv = cvvInput.value;
            const nameOnCard = nameOnCardInput.value.trim();
            const address = addressInput.value.trim();
            const postalCode = postalCodeInput.value.trim();

            // Show/hide error messages
            document.getElementById('cardNumberError').style.display = 
                cardNumber.length < 16 && cardNumber.length > 0 ? 'block' : 'none';
            document.getElementById('expiryDateError').style.display = 
                expiryDate.length < 5 && expiryDate.length > 0 ? 'block' : 'none';
            document.getElementById('cvvError').style.display = 
                cvv.length < 3 && cvv.length > 0 ? 'block' : 'none';
            document.getElementById('nameOnCardError').style.display = 'none';
            document.getElementById('addressError').style.display = 'none';
            document.getElementById('postalCodeError').style.display = 'none';

            // Check if all fields are valid
            const isValid = cardNumber.length === 16 &&
                           expiryDate.length === 5 &&
                           cvv.length === 3 &&
                           nameOnCard.length > 0 &&
                           address.length > 0 &&
                           postalCode.length > 0;

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
        document.getElementById('debitCardForm').addEventListener('submit', function(e) {
            const cardNumber = cardNumberInput.value.replace(/\D/g, '');
            const expiryDate = expiryDateInput.value;
            const cvv = cvvInput.value;
            const nameOnCard = nameOnCardInput.value.trim();
            const address = addressInput.value.trim();
            const postalCode = postalCodeInput.value.trim();

            let hasError = false;

            if (cardNumber.length < 16) {
                document.getElementById('cardNumberError').style.display = 'block';
                hasError = true;
            }
            if (expiryDate.length < 5) {
                document.getElementById('expiryDateError').style.display = 'block';
                hasError = true;
            }
            if (cvv.length < 3) {
                document.getElementById('cvvError').style.display = 'block';
                hasError = true;
            }
            if (nameOnCard.length === 0) {
                document.getElementById('nameOnCardError').style.display = 'block';
                hasError = true;
            }
            if (address.length === 0) {
                document.getElementById('addressError').style.display = 'block';
                hasError = true;
            }
            if (postalCode.length === 0) {
                document.getElementById('postalCodeError').style.display = 'block';
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>

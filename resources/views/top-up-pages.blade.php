<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="style.css">
  @include('partials.theme-script')

  <title>MystiCake Top-up</title>
</head>
<body>

  <div class="mobile-view shadow">

    <header class="d-flex align-items-center p-3 bg-white border-bottom sticky-top">
      <a href="#" class="text-dark me-3">
        <i class="bi bi-arrow-left fs-5"></i>
      </a>
      <h5 class="mb-0 fw-bold mx-auto">Top-up Coin MystiCake</h5>
      <span style="width: 28px;"></span> 
    </header>

    <div class="sub-header d-flex align-items-center justify-content-between p-3">
      <h6 class="mb-0 fw-bold">Choose Top Up Method</h6>
      <span class="fs-4">🪙</span>
    </div>

    <main class="content-area p-3">

      <div class="accordion" id="paymentAccordion">

        <div class="accordion-item payment-card">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
              <div class="icon-wrapper">
                <i class="bi bi-credit-card-2-front"></i>
              </div>
              Debit Card
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
              Opsi kartu debit akan muncul di sini (misal: Visa, Mastercard).
            </div>
          </div>
        </div>

        <div class="accordion-item payment-card">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
              <span class="me-3"></span> Bank Transfer
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
              Opsi bank transfer akan muncul di sini (misal: VA BCA, VA Mandiri).
            </div>
          </div>
        </div>

        <div class="accordion-item payment-card">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
              <div class="icon-wrapper">
                <i class="bi bi-wallet2"></i>
              </div>
              E-wallet
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
              Opsi E-wallet akan muncul di sini (misal: GoPay, OVO, ShopeePay).
            </div>
          </div>
        </div>
      </div>

      <a href="#" class="payment-card payment-link d-flex align-items-center">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Logo_Indomaret.png/640px-Logo_Indomaret.png" alt="Indomaret" class="payment-logo">
        Indomaret
      </a>

      <a href="#" class="payment-card payment-link d-flex align-items-center">
        <img src="https://upload.wikimedia.org/wikipedia/id/thumb/a/a7/Logo_Alfamart.svg/1200px-Logo_Alfamart.svg.png" alt="Alfamart" class="payment-logo">
        Alfamart
      </a>

    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
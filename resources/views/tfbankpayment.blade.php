<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="style.css">
  @include('partials.theme-script')

  <title>MystiCake Payment</title>
</head>
<body>

  <div class="mobile-view shadow">

    <header class="d-flex align-items-center p-3 bg-white border-bottom sticky-top">
      <a href="#" class="text-dark me-3">
        <i class="bi bi-arrow-left fs-5"></i>
      </a>
      <h5 class="mb-0 fw-bold mx-auto">Payment</h5>
      <span style="width: 28px;"></span> 
    </header>

    <div class="sub-header d-flex align-items-center justify-content-between p-3">
      <h6 class="mb-0 fw-bold">Admin Fee</h6>
      <h6 class="mb-0 fw-bold text-end">Rp2.000</h6>
    </div>

    <main class="content-area p-3">

      <div class="payment-card virtual-account-card">
        <div class="d-flex align-items-center mb-3">
          <div class="icon-wrapper me-3">
            <i class="bi bi-credit-card"></i>
          </div>
          <div>
            <h6 class="mb-0 fw-bold">Virtual Account</h6>
          </div>
        </div>

        <div class="va-details p-3">
          <small class="text-muted d-block">Account Number</small>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 fw-bold">9801 2345 6789 9001</h4>
            <i class="bi bi-clipboard fs-5"></i>
          </div>
          
          <div class="alert alert-warning-light small mb-3">
            It will take less than 10 minutes to verify after making payment
          </div>

          <p class="small mb-1">
            To ensure Virtual Account number remains the same, please complete payment before creating another order with Virtual Account.
          </p>
          <p class="small mb-0">
            Accepts transfers from <span class="fw-bold">[Bank Name]</span> only.
          </p>
        </div>
      </div>

      <p class="info-min-topup mt-3">
        <i class="bi bi-info-circle me-1"></i> Min. Top up amount is Rp10.000
      </p>

    </main>

    <footer class="sticky-bottom p-3 footer-shadow">
      <button class="btn btn-dark-brown w-100 py-3 fw-bold">OK</button>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
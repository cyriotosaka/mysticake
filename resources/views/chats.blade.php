<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="style.css">
  @include('partials.theme-script')

  <title>MystiCake Chats</title>
</head>
<body>

  <div class="mobile-view shadow">

    <header class="d-flex align-items-center p-3">
      <a href="#" class="text-dark me-3">
        <i class="bi bi-arrow-left fs-5"></i>
      </a>
      <h5 class="mb-0 fw-bold mx-auto">Chats</h5>
      <span style="width: 28px;"></span> 
    </header>

    <div class="p-3">
      <div class="position-relative">
        <i class="bi bi-search search-icon"></i>
        <input type="text" class="form-control search-bar" placeholder="Search">
      </div>
    </div>

    <main class="chat-list">
      <ul class="list-group list-group-flush">
        
        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <img src="https://via.placeholder.com/50/E99D9C/FFFFFF?text=S" alt="Sweetology" class="rounded-circle chat-list-img me-3">
          
          <div class="flex-grow-1 me-2 overflow-hidden">
            <h6 class="fw-bold mb-0">Sweetology</h6>
            <p class="mb-0 text-muted text-truncate small">
              Thank you for purchasing our product. Your order is being..........
            </p>
          </div>
          
          <div class="text-end small chat-meta">
            <span class="chat-time d-block mb-1">Sunday</span>
            <span class="badge unread-badge rounded-pill">1</span>
          </div>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <img src="https://via.placeholder.com/50/C6A98D/FFFFFF?text=M" alt="Melt & Munch" class="rounded-circle chat-list-img me-3">
          
          <div class="flex-grow-1 me-2 overflow-hidden">
            <h6 class="fw-bold mb-0">Melt & Munch</h6>
            <p class="mb-0 text-muted text-truncate small">
              Thank you for purchasing our product. Your order is being..........
            </p>
          </div>
          
          <div class="text-end small chat-meta">
            <span class="chat-time d-block mb-1">16/06</span>
            <span class="badge unread-badge rounded-pill">1</span>
          </div>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <img src="https://via.placeholder.com/50/E9C3A0/FFFFFF?text=P" alt="Puff & Sugar" class="rounded-circle chat-list-img me-3">
          
          <div class="flex-grow-1 me-2 overflow-hidden">
            <h6 class="fw-bold mb-0">Puff & Sugar</h6>
            <p class="mb-0 text-dark text-truncate small">
              Makasi kak, enak banget pas nyampe😋
            </p>
          </div>
          
          <div class="text-end small chat-meta">
            <span class="chat-time d-block mb-1">10/06</span>
          </div>
        </li>
        
        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <img src="https://via.placeholder.com/50/6A8D8C/FFFFFF?text=C" alt="Creamistry Co." class="rounded-circle chat-list-img me-3">
          
          <div class="flex-grow-1 me-2 overflow-hidden">
            <h6 class="fw-bold mb-0">Creamistry Co.</h6>
            <p class="mb-0 text-muted text-truncate small">
              Thank you for purchasing our product. Your order is being..........
            </p>
          </div>
          
          <div class="text-end small chat-meta">
            <span class="chat-time d-block mb-1">11/05</span>
            <span class="badge unread-badge rounded-pill">1</span>
          </div>
        </li>

      </ul>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
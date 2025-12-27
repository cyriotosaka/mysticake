<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="style.css">
  @include('partials.theme-script')

  <title>MystiCake Chat</title>
</head>
<body>

  <div class="mobile-view shadow">

    <header class="chat-header d-flex align-items-center p-3 sticky-top">
      <a href="#" class="text-dark me-3">
        <i class="bi bi-arrow-left fs-5"></i>
      </a>
      <img src="https://via.placeholder.com/40" alt="Profile Picture" class="rounded-circle me-2">
      <div>
        <h6 class="mb-0 fw-bold">Puff & Sugar</h6>
        <small class="text-muted">Active 26 seconds ago</small>
      </div>
    </header>

    <main class="chat-area p-3">
      
      <div class="chat-date text-center my-3">
        <span class="badge text-bg-light px-3 py-2 rounded-pill">Today</span>
      </div>

      <div class="chat-bubble left-bubble chat-inquiry p-3 rounded-3 mb-2">
        <small class="text-pink fw-bold d-block mb-2">You're inquiring about this item</small>
        <div class="d-flex align-items-center">
          <img src="https://images.unsplash.com/photo-1570197943414-760daddb080b?w=60" alt="Product Image" class="rounded me-2 product-img-chat">
          <div>
            <p class="mb-0 fw-bold">Caramel Choco Icecream Cake</p>
            <p class="mb-0">RP 25000</p>
          </div>
        </div>
      </div>

      <div class="chat-bubble right-bubble p-3 rounded-3 mb-2">
        Hai seller, kalo aku mau order sekarang terus 3 hari lagi mau repeat order kira-kira bakal ready ga ya?
        <div class="chat-time text-end mt-1">10:00</div>
      </div>

      <div class="chat-bubble left-bubble p-3 rounded-3 mb-2">
        Hai kak, ready ya kak👋
        <div class="chat-time mt-1">10:05</div>
      </div>

      <div class="chat-bubble right-bubble p-3 rounded-3 mb-2">
        Okei, aku CO sekarang. Yuhuuuu🍰
        <div class="chat-time text-end mt-1">10:06</div>
      </div>

      <div class="chat-bubble left-bubble chat-order p-3 rounded-3 mb-2">
        <small class="text-pink fw-bold d-block mb-2">You're chatting with seller about this order</small>
        <div class="d-flex align-items-center mb-2">
          <img src="https://images.unsplash.com/photo-1570197943414-760daddb080b?w=60" alt="Product Image" class="rounded me-2 product-img-chat">
          <div>
            <p class="mb-0 fw-bold">Caramel Choco Icecream Cake</p>
            <p class="mb-0 text-muted small">1 item, Total: RP 28000</p>
            <span class="badge text-bg-warning">Shipping</span>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center small">
          <span class="text-muted">Order ID</span>
          <span class="fw-bold">250613CCIC1</span>
          <i class="bi bi-clipboard"></i>
        </div>
      </div>

      <div class="chat-bubble left-bubble chat-order p-3 rounded-3 mb-2">
        <small class="text-pink fw-bold d-block mb-2">You're chatting with seller about this order</small>
        <div class="d-flex align-items-center mb-2">
          <img src="https://images.unsplash.com/photo-1570197943414-760daddb080b?w=60" alt="Product Image" class="rounded me-2 product-img-chat">
          <div>
            <p class="mb-0 fw-bold">Caramel Choco Icecream Cake</p>
            <p class="mb-0 text-muted small">1 item, Total: RP 28000</p>
            <span class="badge text-bg-success">Completed</span>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center small">
          <span class="text-muted">Order ID</span>
          <span class="fw-bold">250613CCIC1</span>
          <i class="bi bi-clipboard"></i>
        </div>
      </div>

      <div class="chat-bubble right-bubble p-3 rounded-3 mb-2">
        Makasi kak, enak banget pas nyampe😋
        <div class="chat-time text-end mt-1">11:15</div>
      </div>

    </main>

    <footer class="chat-footer d-flex align-items-center p-3 sticky-bottom">
      <button class="btn btn-plus me-2 p-0">
        <i class="bi bi-plus-circle fs-4"></i>
      </button>
      <div class="input-group">
        <input type="text" class="form-control rounded-pill py-2 ps-3 pe-5 chat-input" placeholder="Type a message......">
        <span class="input-group-text bg-transparent border-0 position-absolute end-0 top-50 translate-middle-y">
          <i class="bi bi-send-fill text-muted"></i>
        </span>
      </div>
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
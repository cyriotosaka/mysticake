<!---Created by Lailatul Fitaliqoh_229--->
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <title>Chat with {{ $store->name_store }}</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  @include('partials.theme-script')
  
  <style>
      body {
          background-color: #FFFDF5; 
          margin: 0;
          font-family: 'Poppins', sans-serif;
      }
      .mobile-view {
          max-width: 480px;
          margin: 0 auto;
          background: #FFFDF5;
          height: 100vh; 
          display: flex;
          flex-direction: column;
          position: relative;
          box-shadow: 0 0 20px rgba(0,0,0,0.05);
      }

      /* --- HEADER --- */
      .chat-header {
          background: #FFFDF5;
          border-bottom: 1px solid #E0E0E0;
          z-index: 1000;
          height: 70px;
          flex-shrink: 0; 
      }
      .back-btn {
          width: 40px; height: 40px;
          display: flex; align-items: center; justify-content: center;
          border-radius: 50%; transition: 0.2s;
      }
      .back-btn:hover { background: rgba(0,0,0,0.05); }

      /* --- CHAT AREA --- */
      .chat-area {
          flex: 1; 
          overflow-y: auto;
          background-color: #FFFDF5;
          padding-bottom: 20px;
      }

      /* --- BUBBLES --- */
      .chat-bubble {
          max-width: 80%;
          padding: 12px 16px;
          border-radius: 18px;
          position: relative;
          margin-bottom: 12px;
          font-size: 14px;
          line-height: 1.4;
          word-wrap: break-word;
      }
      .right-bubble {
          background-color: #FFE5EC; 
          color: #333;
          margin-left: auto;
          border-bottom-right-radius: 4px;
      }
      .left-bubble {
          background-color: #FFFFFF;
          color: #333;
          margin-right: auto;
          border-bottom-left-radius: 4px;
          box-shadow: 0 1px 2px rgba(0,0,0,0.05);
          border: 1px solid #F0EFE9;
      }

      /* --- CARDS --- */
      .chat-card {
          background: #fff;
          border-radius: 12px;
          padding: 10px;
          margin-bottom: 5px;
          border: 1px solid #eee;
          display: flex;
          align-items: center;
          gap: 10px;
      }
      .product-img-chat {
          width: 50px; height: 50px;
          object-fit: cover; border-radius: 8px; background: #eee;
      }

      /* --- FOOTER & ATTACHMENT MENU --- */
      .chat-footer {
          background: #FFFDF5;
          border-top: 1px solid #E0E0E0;
          padding: 10px 15px;
          flex-shrink: 0; 
      }
      
      .attachment-menu {
          background: #FFFDF5;
          padding-top: 20px;
          border-top: 1px dashed #E0E0E0;
          margin-top: 15px;
          animation: slideUp 0.2s ease-out;
      }
      
      @keyframes slideUp {
          from { transform: translateY(20px); opacity: 0; }
          to { transform: translateY(0); opacity: 1; }
      }

      .menu-grid {
          display: grid;
          grid-template-columns: repeat(5, 1fr);
          gap: 10px;
          text-align: center;
      }
      
      .menu-item {
          cursor: pointer;
          transition: transform 0.1s;
      }
      .menu-item:active { transform: scale(0.95); }

      .icon-box {
          width: 50px; height: 50px;
          background-color: #FFC4D0; 
          border-radius: 15px;
          display: flex; align-items: center; justify-content: center;
          margin: 0 auto 8px;
          color: #5D4037; 
          font-size: 22px;
          box-shadow: 0 2px 5px rgba(255, 196, 208, 0.5);
      }
      
      .menu-text {
          font-size: 11px;
          color: #5D4037;
          font-weight: 500;
      }

      /* --- DARK MODE --- */
      [data-bs-theme="dark"] body, [data-bs-theme="dark"] .mobile-view, 
      [data-bs-theme="dark"] .chat-header, [data-bs-theme="dark"] .chat-footer,
      [data-bs-theme="dark"] .chat-area, [data-bs-theme="dark"] .attachment-menu {
          background-color: #121212 !important; border-color: #333 !important;
      }
      [data-bs-theme="dark"] .chat-header h6 { color: #fff !important; }
      [data-bs-theme="dark"] .right-bubble { background-color: #E66A7F !important; color: #fff !important; }
      [data-bs-theme="dark"] .left-bubble { background-color: #2C2C2C !important; color: #e0e0e0 !important; border-color: #444 !important; }
      [data-bs-theme="dark"] .chat-input { background-color: #333 !important; color: #fff !important; border-color: #444 !important; }
      [data-bs-theme="dark"] .icon-box { background-color: #333 !important; color: #E66A7F !important; border: 1px solid #444; }
      [data-bs-theme="dark"] .menu-text { color: #ccc !important; }
  </style>
</head>
<body>

  <div class="mobile-view">

    <header class="chat-header d-flex align-items-center px-3 sticky-top">
      <a href="{{ route('chat.index') }}" class="back-btn text-dark text-decoration-none me-2">
        <i class="bi bi-arrow-left fs-5"></i>
      </a>
      
      <img src="{{ $store->photo ? asset('images/stores/'.$store->photo) : '' }}" 
           class="rounded-circle me-3" 
           style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #E0E0E0;"
           onerror="this.src='https://placehold.co/40x40/E66A7F/white?text={{ substr($store->name_store, 0, 1) }}'">
      
      <div class="flex-grow-1">
        <h6 class="mb-0 fw-bold">{{ $store->name_store }}</h6>
        <small class="text-muted" style="font-size: 11px;">
            <i class="bi bi-circle-fill text-success" style="font-size: 8px;"></i> Online
        </small>
      </div>
      
      <button class="btn btn-link text-dark p-0"><i class="bi bi-three-dots-vertical"></i></button>
    </header>

    <main class="chat-area p-3" id="chatContainer">
      <div class="text-center mb-4">
        <span class="badge bg-white text-secondary rounded-pill px-3 py-1 fw-normal border shadow-sm">Today</span>
      </div>

      @forelse($messages as $msg)
        @php
            $isMe = ($msg->sender_role == 'user');
            $bubbleClass = $isMe ? 'right-bubble' : 'left-bubble';
            $alignClass = $isMe ? 'justify-content-end' : 'justify-content-start';
        @endphp

        <div class="d-flex {{ $alignClass }} mb-1">
            {{-- Inquiry --}}
            @if($msg->id_product && $msg->product)
            <div class="chat-bubble {{ $bubbleClass }}">
                <div class="small fw-bold mb-2 text-danger opacity-75">
                    {{ $isMe ? "You inquired about:" : "Seller sent product:" }}
                </div>
                <div class="chat-card">
                    <img src="{{ asset('images/products/'.$msg->product->product_picture) }}" 
                         class="product-img-chat" onerror="this.src='https://placehold.co/50x50?text=Cake'">
                    <div style="flex: 1;">
                        <div class="fw-bold text-truncate" style="max-width: 150px;">{{ $msg->product->name_product }}</div>
                        <div class="text-danger small">Rp {{ number_format($msg->product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Text --}}
            @if($msg->message)
            <div class="chat-bubble {{ $bubbleClass }}">
                {{ $msg->message }}
                <div class="text-end mt-1" style="font-size: 10px; opacity: 0.6;">
                    {{ \Carbon\Carbon::parse($msg->time)->format('H:i') }}
                    @if($isMe) <i class="bi bi-check2-all ms-1 text-primary"></i> @endif
                </div>
            </div>
            @endif
        </div>
      @empty
        <div class="text-center py-5">
            <div class="bg-white rounded-circle d-inline-flex p-3 mb-3 shadow-sm">
                <i class="bi bi-chat-dots text-muted fs-1"></i>
            </div>
            <p class="text-muted small">Mulai percakapan dengan toko ini!</p>
        </div>
      @endforelse
    </main>

    <footer class="chat-footer">
      <form action="{{ route('chat.send', $store->id_store) }}" method="POST" class="d-flex align-items-center gap-2">
          @csrf
          
          {{-- Tombol Toggle Menu (+) --}}
          <button type="button" class="btn p-0 border-0" onclick="toggleAttachmentMenu()">
            {{-- Icon ini akan berubah lewat JS --}}
            <i class="bi bi-plus-circle-fill fs-3" id="plusIcon" style="color: #4E342E;"></i>
          </button>
          
          <div class="position-relative flex-grow-1">
            <input type="text" name="message" class="form-control rounded-pill py-2 ps-3 pe-5 chat-input" placeholder="Type a message..." required autocomplete="off">
            <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y text-danger border-0 pe-3">
              <i class="bi bi-send-fill" style="color: #E66A7F;"></i>
            </button>
          </div>
      </form>

      <div id="attachmentMenu" class="attachment-menu d-none">
          <div class="menu-grid">
              
              <div class="menu-item">
                  <div class="icon-box"><i class="bi bi-image"></i></div>
                  <div class="menu-text">Gallery</div>
              </div>

              <div class="menu-item">
                  <div class="icon-box"><i class="bi bi-camera"></i></div>
                  <div class="menu-text">Camera</div>
              </div>

              <div class="menu-item">
                  <div class="icon-box"><i class="bi bi-cake2"></i></div>
                  <div class="menu-text">Products</div>
              </div>

              <div class="menu-item">
                  <div class="icon-box"><i class="bi bi-clipboard-check"></i></div>
                  <div class="menu-text">Orders</div>
              </div>

              <div class="menu-item">
                  <div class="icon-box"><i class="bi bi-cart-plus"></i></div>
                  <div class="menu-text">Buy Now</div>
              </div>

          </div>
      </div>
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
      // Auto Scroll ke Bawah
      window.onload = function() {
          scrollToBottom();
      };

      function scrollToBottom() {
          var chatArea = document.getElementById("chatContainer");
          chatArea.scrollTop = chatArea.scrollHeight;
      }

      // Toggle Menu Attachment
      function toggleAttachmentMenu() {
          var menu = document.getElementById("attachmentMenu");
          var icon = document.getElementById("plusIcon");
          
          if (menu.classList.contains("d-none")) {
              // Buka Menu
              menu.classList.remove("d-none");
              // Ubah icon jadi X
              icon.classList.remove("bi-plus-circle-fill");
              icon.classList.add("bi-x-circle-fill");
              icon.style.color = "#E66A7F"; 
              
              setTimeout(scrollToBottom, 100);
          } else {
              // Tutup Menu
              menu.classList.add("d-none");
              
              icon.classList.remove("bi-x-circle-fill");
              icon.classList.add("bi-plus-circle-fill");
              icon.style.color = "#4E342E"; 
          }
      }
  </script>
</body>
</html>
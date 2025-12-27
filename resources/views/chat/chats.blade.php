<!---Created by Lailatul Fitaliqoh_229--->
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <title>MystiCake Chats</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  @include('partials.theme-script')

  <style>
      body {
          background-color: #FFFDF5; 
          font-family: 'Poppins', sans-serif;
          color: #4E342E; 
      }

      .mobile-view {
          max-width: 480px;
          margin: 0 auto;
          background: #FFFDF5;
          min-height: 100vh;
          box-shadow: 0 0 20px rgba(0,0,0,0.05);
          display: flex;
          flex-direction: column;
      }

      /* --- HEADER --- */
      .header-title {
          font-size: 18px;
          font-weight: 700;
          color: #4E342E;
      }
      .back-btn {
          color: #4E342E !important;
          transition: 0.2s;
      }
      .back-btn:hover {
          transform: translateX(-3px);
      }

      /* --- SEARCH BAR --- */
      .search-container {
          margin-bottom: 10px;
      }
      .search-bar {
          background-color: #FFFFFF;
          border: 1px solid #E6D5C3; 
          color: #4E342E;
          font-size: 14px;
          padding-top: 10px;
          padding-bottom: 10px;
      }
      .search-bar::placeholder {
          color: #BCAAA4;
      }
      .search-bar:focus {
          box-shadow: 0 0 0 3px rgba(240, 106, 125, 0.1);
          border-color: #F06A7D;
      }
      .search-icon {
          color: #8D6E63;
      }

      /* --- CHAT LIST --- */
      .chat-list {
          flex: 1;
          background: #FFFDF5;
      }
      .chat-link {
          text-decoration: none;
          color: inherit;
          display: block;
      }
      
      .chat-item {
          background-color: transparent;
          border-bottom: 1px solid #F3E5DC !important; 
          padding: 16px 20px !important;
          transition: background-color 0.2s;
      }
      .chat-item:hover {
          background-color: #FFF0F3; 
      }

      .chat-list-img {
          width: 55px;
          height: 55px;
          object-fit: cover;
          border: 2px solid #FFF;
          box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      }

      .chat-name {
          font-size: 16px;
          color: #4E342E; 
          margin-bottom: 3px;
      }
      
      .chat-preview {
          font-size: 13px;
          color: #8D6E63; 
      }

      .chat-time {
          font-size: 11px;
          color: #A1887F;
          font-weight: 500;
      }

      .unread-badge {
          background-color: #F06A7D !important; 
          font-size: 10px;
          width: 22px;
          height: 22px;
          display: flex;
          align-items: center;
          justify-content: center;
          margin-top: 5px;
          border: 1px solid #fff;
      }

      .empty-chat {
          color: #A1887F;
      }

      /* --- DARK MODE --- */
      [data-bs-theme="dark"] body, 
      [data-bs-theme="dark"] .mobile-view,
      [data-bs-theme="dark"] .chat-list {
          background-color: #121212 !important;
          color: #E0E0E0 !important;
      }
      [data-bs-theme="dark"] .header-title,
      [data-bs-theme="dark"] .back-btn,
      [data-bs-theme="dark"] .chat-name {
          color: #FFFFFF !important;
      }
      [data-bs-theme="dark"] .search-bar {
          background-color: #2C2C2C !important;
          border-color: #444 !important;
          color: #FFF !important;
      }
      [data-bs-theme="dark"] .chat-item {
          border-bottom-color: #333 !important;
      }
      [data-bs-theme="dark"] .chat-item:hover {
          background-color: #1E1E1E !important;
      }
      [data-bs-theme="dark"] .chat-preview,
      [data-bs-theme="dark"] .chat-time {
          color: #9E9E9E !important;
      }
  </style>
</head>
<body>

  <div class="mobile-view">

    <header class="d-flex align-items-center p-3 pt-4">
      <a href="{{ route('home') }}" class="back-btn text-decoration-none me-3">
        <i class="bi bi-arrow-left fs-4"></i>
      </a>
      <h5 class="mb-0 mx-auto header-title">Chats</h5>
      <span style="width: 24px;"></span> 
    </header>

    <div class="px-3 pb-2">
      <div class="position-relative search-container">
        <i class="bi bi-search search-icon position-absolute top-50 start-0 translate-middle-y ms-3"></i>
        <input type="text" class="form-control search-bar ps-5 rounded-pill" placeholder="Search">
      </div>
    </div>

    <main class="chat-list">
      <ul class="list-group list-group-flush">
        
        @forelse($chats as $chat)
        <a href="{{ route('chat.show', $chat['store_id']) }}" class="chat-link">
            <li class="list-group-item d-flex justify-content-between align-items-center border-0 chat-item">
                
                {{-- Avatar --}}
                <img src="{{ $chat['avatar'] }}" 
                     alt="{{ $chat['name'] }}" 
                     class="rounded-circle chat-list-img me-3">
                
                {{-- Content --}}
                <div class="flex-grow-1 me-2 overflow-hidden">
                    <h6 class="fw-bold mb-0 chat-name">{{ $chat['name'] }}</h6>
                    <p class="mb-0 text-truncate chat-preview">
                        {{-- Logika: Jika pesan gambar/produk, ganti teksnya --}}
                        @if(Str::contains($chat['message'], 'attached a product'))
                            <i class="bi bi-image"></i> Sent a product
                        @else
                            {{ $chat['message'] ?? 'Start chatting...' }}
                        @endif
                    </p>
                </div>
                
                {{-- Meta (Time & Badge) --}}
                <div class="text-end d-flex flex-column align-items-end" style="min-width: 50px;">
                    <span class="chat-time d-block">{{ $chat['time'] }}</span>
                    
                    @if($chat['unread'] > 0)
                        <span class="badge rounded-circle unread-badge">
                            {{ $chat['unread'] }}
                        </span>
                    @endif
                </div>
            </li>
        </a>
        @empty
        <div class="text-center p-5 empty-chat mt-5">
            <div class="mb-3">
                <i class="bi bi-chat-heart display-1" style="color: #F06A7D; opacity: 0.5;"></i>
            </div>
            <h6 class="fw-bold" style="color: #4E342E;">No conversations yet</h6>
            <p class="small">Start exploring products to chat with sellers!</p>
        </div>
        @endforelse

      </ul>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
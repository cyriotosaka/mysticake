<style>
    /* Created by Lailatul Fitaliqoh (5026231229) 

    1. GLOBAL STYLES */
    [data-bs-theme="dark"] body {
        background-color: #121212 !important;
        background-image: none !important;
        color: #E0E0E0 !important;
    }

    /* Heading & Text Colors Global */
    [data-bs-theme="dark"] h1, [data-bs-theme="dark"] h2, [data-bs-theme="dark"] h3, 
    [data-bs-theme="dark"] h4, [data-bs-theme="dark"] h5, [data-bs-theme="dark"] h6,
    [data-bs-theme="dark"] .header-title,
    [data-bs-theme="dark"] .page-title,
    [data-bs-theme="dark"] .page-header,
    [data-bs-theme="dark"] .brand-title,
    [data-bs-theme="dark"] .brand-text,
    [data-bs-theme="dark"] .back-btn {
        color: #FFFFFF !important;
    }

    /* Cards & Containers Global */
    [data-bs-theme="dark"] .card,
    [data-bs-theme="dark"] .menu-card,
    [data-bs-theme="dark"] .modal-content-custom,
    [data-bs-theme="dark"] .account-item,
    [data-bs-theme="dark"] .session-card,
    [data-bs-theme="dark"] .info-box,
    [data-bs-theme="dark"] .section-card {
        background-color: #1E1E1E !important;
        border-color: #333 !important;
        color: #E0E0E0 !important;
    }

    /* Form Inputs */
    [data-bs-theme="dark"] .form-control,
    [data-bs-theme="dark"] .input-group-custom,
    [data-bs-theme="dark"] .custom-field {
        background-color: #2C2C2C !important;
        border-color: #444 !important;
        color: #FFF !important;
    }
    
    [data-bs-theme="dark"] .custom-label,
    [data-bs-theme="dark"] .form-label,
    [data-bs-theme="dark"] label {
        color: #E0E0E0 !important;
    }

    /* Icons Global */
    [data-bs-theme="dark"] .menu-icon,
    [data-bs-theme="dark"] .text-danger {
        color: #FF8FA3 !important;
    }

    /* Modals Global */
    [data-bs-theme="dark"] .modal-content {
        background-color: #1E1E1E !important;
        border: 1px solid #444 !important;
        color: #E0E0E0 !important;
    }
    [data-bs-theme="dark"] .modal-header,
    [data-bs-theme="dark"] .modal-footer {
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .modal-title {
        color: #FFFFFF !important;
    }
    [data-bs-theme="dark"] .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%); /* Biar icon silang jadi putih */
    }

    /* 2. PRODUCT DETAIL STYLES */
    [data-bs-theme="dark"] .mobile-container {
        background-color: #1E1E1E !important;
        color: #FFFFFF !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .product-title,
    [data-bs-theme="dark"] .price-tag,
    [data-bs-theme="dark"] .rating-score,
    [data-bs-theme="dark"] .review-count,
    [data-bs-theme="dark"] .section-title,
    [data-bs-theme="dark"] .item-name,
    [data-bs-theme="dark"] .info-value,
    [data-bs-theme="dark"] .total-label,
    [data-bs-theme="dark"] .timeline-date {
        color: #FFFFFF !important;
    }
    [data-bs-theme="dark"] .product-desc,
    [data-bs-theme="dark"] .item-details,
    [data-bs-theme="dark"] .info-label,
    [data-bs-theme="dark"] .timeline-time {
        color: #B0B0B0 !important;
    }
    [data-bs-theme="dark"] .back-btn i,
    [data-bs-theme="dark"] .cart-btn,
    [data-bs-theme="dark"] .fa-arrow-left,
    [data-bs-theme="dark"] .fa-shopping-cart {
        color: #FFFFFF !important;
    }
    [data-bs-theme="dark"] .reviews-link {
        color: #F06A7D !important;
        text-decoration: underline;
    }
    [data-bs-theme="dark"] .btn-chat {
        background-color: #2C2C2C !important;
        color: #F06A7D !important;
        border: 1px solid #444 !important;
    }
    [data-bs-theme="dark"] .section-title,
    [data-bs-theme="dark"] .item-row,
    [data-bs-theme="dark"] .total-row {
        border-color: #333 !important;
    }

    /* 3. HOME PAGE STYLES */
    [data-bs-theme="dark"] .username { color: #FFFFFF !important; }
    [data-bs-theme="dark"] .username a i { color: #B0B0B0 !important; }
    [data-bs-theme="dark"] .cart-icon { color: #FFFFFF !important; }
    [data-bs-theme="dark"] .search-container {
        background-color: #2C2C2C !important;
        border: 1px solid #444 !important;
    }
    [data-bs-theme="dark"] .search-input,
    [data-bs-theme="dark"] .search-icon-left { color: #FFFFFF !important; }
    [data-bs-theme="dark"] .card-custom {
        background-color: #1E1E1E !important;
        border: 1px solid #333 !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .card-custom h3 { color: #FFFFFF !important; }
    [data-bs-theme="dark"] .rating span { color: #B0B0B0 !important; }
    [data-bs-theme="dark"] .feature-card {
        background-color: #1E1E1E !important;
        border: 1px solid #333 !important;
    }
    [data-bs-theme="dark"] .feature-title { color: #FFFFFF !important; }
    [data-bs-theme="dark"] .feature-subtitle { color: #B0B0B0 !important; }
    [data-bs-theme="dark"] .bottom-nav-container {
        background-color: #1E1E1E !important;
        border-top: 1px solid #333 !important;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.3) !important;
    }

    /* 4. CART PAGE STYLES */
    [data-bs-theme="dark"] .cart-header,
    [data-bs-theme="dark"] .product-name,
    [data-bs-theme="dark"] .subtotal-amount,
    [data-bs-theme="dark"] .qty-display {
        color: #FFFFFF !important;
    }
    [data-bs-theme="dark"] .subtotal-label,
    [data-bs-theme="dark"] .quantity-text,
    [data-bs-theme="dark"] .nav-tab:not(.active),
    [data-bs-theme="dark"] .empty-cart {
        color: #B0B0B0 !important;
    }
    [data-bs-theme="dark"] .cart-card,
    [data-bs-theme="dark"] .nav-tabs-container {
        background-color: #1E1E1E !important;
        border: 1px solid #333 !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .qty-btn {
        background-color: #2C2C2C !important;
        border-color: #F06A7D !important;
        color: #F06A7D !important;
    }
    [data-bs-theme="dark"] .checkout-section {
        background-color: #1E1E1E !important;
        border-top: 1px solid #333 !important;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.5) !important;
    }
    [data-bs-theme="dark"] .nav-tab:hover:not(.active) {
        background-color: #333 !important;
        color: #FFF !important;
    }
    [data-bs-theme="dark"] .purchase-btn:disabled {
        background-color: #333 !important;
        color: #666 !important;
    }

    /* 5. ORDER HISTORY STYLES */
    [data-bs-theme="dark"] .order-card {
        background-color: #1E1E1E !important;
        border: 1px solid #333 !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .order-id,
    [data-bs-theme="dark"] .order-items {
        color: #FFFFFF !important;
    }
    [data-bs-theme="dark"] .order-date,
    [data-bs-theme="dark"] .empty-state {
        color: #B0B0B0 !important;
    }
    [data-bs-theme="dark"] .status-pending {
        background-color: #4a3e20 !important;
        color: #ffd700 !important;
    }
    [data-bs-theme="dark"] .status-completed {
        background-color: #1b4d2e !important;
        color: #75b798 !important;
    }
    [data-bs-theme="dark"] .status-cancelled {
        background-color: #4c1f24 !important;
        color: #e57373 !important;
    }

    /* 6. RATINGS & REVIEWS STYLES */
    /* Container Utama & Area Konten */
    [data-bs-theme="dark"] .mobile-view,
    [data-bs-theme="dark"] .content-area {
        background-color: #121212 !important; 
        color: #E0E0E0 !important;
    }

    /* Header Rating & Tabs */
    [data-bs-theme="dark"] .rating-header,
    [data-bs-theme="dark"] .nav-tabs-container {
        background-color: #1E1E1E !important;
        border-bottom: 1px solid #333 !important;
    }
    [data-bs-theme="dark"] .nav-tab-item {
        color: #888 !important;
    }
    [data-bs-theme="dark"] .nav-tab-item.active {
        color: #E66A7F !important;
        border-bottom-color: #E66A7F !important;
    }

    /* Product Info Section (Tempat Foto & Harga) */
    [data-bs-theme="dark"] .product-info-section,
    [data-bs-theme="dark"] .filter-section {
        background-color: #1E1E1E !important; /* Abu gelap */
        color: #E0E0E0 !important;
        border-bottom: 1px solid #333 !important; /* border pemisah */
    }

    /* Product Summary Teks */
    [data-bs-theme="dark"] .product-name,
    [data-bs-theme="dark"] .product-price-box h4 {
        color: #FFFFFF !important;
    }
    [data-bs-theme="dark"] .rating-summary {
        color: #B0B0B0 !important;
    }

    /* Filter Pills (All, 5 Star, dll) */
    [data-bs-theme="dark"] .nav-pills .nav-link {
        background-color: #2C2C2C !important;
        color: #E0E0E0 !important;
        border: 1px solid #444 !important;
    }
    [data-bs-theme="dark"] .nav-pills .nav-link.active {
        background-color: #E66A7F !important;
        color: #FFFFFF !important;
        border-color: #E66A7F !important;
    }

    /* Form & Review Cards */
    [data-bs-theme="dark"] .add-review-section, 
    [data-bs-theme="dark"] .review-card {
        background-color: #1E1E1E !important;
        border: 1px solid #333 !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .add-review-title,
    [data-bs-theme="dark"] .rating-label {
        color: #FFFFFF !important;
    }
    [data-bs-theme="dark"] .user-name {
        color: #FFFFFF !important;
    }
    [data-bs-theme="dark"] .review-text {
        color: #E0E0E0 !important;
    }
    [data-bs-theme="dark"] .like-count-num {
        color: #B0B0B0 !important;
    }
    [data-bs-theme="dark"] .text-muted {
        color: #888 !important; /* Timestamps */
    }
    
    /* Tombol Like/Edit/Delete Review */
    [data-bs-theme="dark"] .btn-like-review,
    [data-bs-theme="dark"] .btn-edit-review,
    [data-bs-theme="dark"] .btn-delete-review {
        background-color: #2C2C2C !important;
        border-color: #444 !important;
        color: #B0B0B0 !important;
    }

</style>

<script>
    (function() {
        const savedTheme = localStorage.getItem('mysticake_theme') || 'light';
        const html = document.documentElement;

        if (savedTheme === 'auto') {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                html.setAttribute('data-bs-theme', 'dark');
            } else {
                html.setAttribute('data-bs-theme', 'light');
            }
        } else {
            html.setAttribute('data-bs-theme', savedTheme);
        }
    })();
</script>
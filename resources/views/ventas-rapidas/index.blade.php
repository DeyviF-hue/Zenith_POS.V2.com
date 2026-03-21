@extends('adminlte::page')

@section('title', 'Ventas Rápidas')

@section('content')
<style>
    /* ─── Variables de Diseño ─── */
    :root {
        --z-primary: {{ config('zenith.primary_color', '#6C5CE7') }};
        --z-dark: {{ config('zenith.sidebar_color', '#2D2A3A') }};
        --z-accent: {{ config('zenith.accent_color', '#A29BFE') }};
        --bg-color: #f8f9fe;
        --card-bg: #ffffff;
        --text-main: #2d3436;
        --text-muted: #636e72;
        --border-color: #dfe6e9;
    }

    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* Ocultar header de AdminLTE para dar más espacio */
    .content-header {
        display: none;
    }
    .content-wrapper {
        background: var(--bg-color) !important;
        padding: 0 !important;
    }
    .content {
        padding: 0 !important;
    }

    /* ─── Layout Principal ─── */
    .pos-wrapper {
        display: flex;
        height: calc(100vh - 57px); /* Ajustar según navbar */
        overflow: hidden;
    }
    
    /* Panel Izquierdo (Buscador y Resultados) */
    .pos-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 24px;
        position: relative;
    }

    /* Barra Búsqueda */
    .search-box {
        position: relative;
        margin-bottom: 24px;
        z-index: 20;
    }
    .search-box input {
        width: 100%;
        height: 64px;
        border: 2px solid var(--border-color);
        border-radius: 16px;
        padding: 0 24px 0 64px;
        font-size: 1.2rem;
        font-weight: 500;
        background: #fff;
        color: var(--text-main);
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0,0,0,0.03);
    }
    .search-box input:focus {
        outline: none;
        border-color: var(--z-primary);
        box-shadow: 0 8px 25px rgba(108, 92, 231, 0.15);
    }
    .search-box i.search-icon {
        position: absolute;
        left: 24px;
        top: 22px;
        font-size: 1.4rem;
        color: var(--z-accent);
    }

    /* Contenedor de Resultados (Autocompletado visual) */
    .search-results {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
        overflow-y: auto;
        padding-bottom: 20px;
        align-content: start;
    }
    
    .product-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 120px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .product-card:hover {
        transform: translateY(-3px);
        border-color: var(--z-primary);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.1);
    }
    .p-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--text-main);
        line-height: 1.3;
        margin-bottom: 8px;
    }
    .p-code {
        font-size: 0.85rem;
        color: var(--text-muted);
        background: #f1f2f6;
        padding: 4px 8px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 12px;
    }
    .p-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .p-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--z-primary);
    }
    .p-stock {
        font-size: 0.85rem;
        font-weight: 600;
        color: #00b894;
    }

    /* ─── Panel Derecho (Carrito) ─── */
    .pos-sidebar {
        width: 420px;
        background: var(--z-dark);
        display: flex;
        flex-direction: column;
        color: #fff;
        box-shadow: -5px 0 30px rgba(0,0,0,0.1);
        z-index: 30;
    }

    .cart-header {
        padding: 24px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .cart-header h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: #fff;
    }
    .cart-header .badge {
        background: var(--z-primary);
        color: #fff;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 20px 10px 20px 20px;
    }

    /* Scrollbar minimalista */
    .cart-items::-webkit-scrollbar { width: 6px; }
    .cart-items::-webkit-scrollbar-track { background: transparent; }
    .cart-items::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

    .cart-item {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        flex-direction: column;
        transition: all 0.2s;
    }
    .cart-item:hover {
        background: rgba(255,255,255,0.07);
    }
    .ci-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .ci-title {
        font-weight: 500;
        font-size: 1rem;
        line-height: 1.3;
        flex: 1;
        padding-right: 10px;
    }
    .ci-remove {
        color: #ff7675;
        cursor: pointer;
        opacity: 0.7;
        transition: 0.2s;
    }
    .ci-remove:hover { opacity: 1; }

    .ci-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .qty-control {
        display: flex;
        align-items: center;
        background: rgba(0,0,0,0.2);
        border-radius: 8px;
        padding: 4px;
    }
    .qty-btn {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        cursor: pointer;
        border-radius: 6px;
        user-select: none;
    }
    .qty-btn:hover { background: var(--z-primary); }
    .qty-val {
        width: 40px;
        text-align: center;
        font-weight: 600;
    }
    .ci-price {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--z-accent);
    }

    /* Caja de Resumen */
    .cart-summary {
        background: rgba(0,0,0,0.2);
        padding: 24px;
        border-top: 1px solid rgba(255,255,255,0.05);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        color: rgba(255,255,255,0.7);
        font-size: 1rem;
    }
    .summary-row.total {
        color: #fff;
        font-size: 1.6rem;
        font-weight: 700;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px dashed rgba(255,255,255,0.15);
        margin-bottom: 20px;
    }

    .btn-pay {
        background: var(--z-primary);
        color: #fff;
        width: 100%;
        border: none;
        padding: 18px;
        border-radius: 14px;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 8px 25px rgba(108, 92, 231, 0.3);
    }
    .btn-pay:hover {
        background: var(--z-accent);
        transform: translateY(-2px);
    }
    .btn-pay:disabled {
        background: #576574;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    /* ─── Modal Minimalista ─── */
    .modal-content {
        background: var(--z-dark);
        color: #fff;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }
    .modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.08);
        padding: 24px;
    }
    .modal-title {
        font-weight: 600;
        font-size: 1.4rem;
    }
    .modal-body {
        padding: 30px 24px;
    }
    .close { color: #fff; opacity: 0.8; }
    .close:hover { color: #fff; opacity: 1; }

    .z-input {
        background: rgba(0,0,0,0.2) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: #fff !important;
        border-radius: 12px !important;
        padding: 14px 20px !important;
        height: auto !important;
        font-size: 1.05rem !important;
    }
    .z-input:focus {
        border-color: var(--z-primary) !important;
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2) !important;
    }
    .z-label {
        color: rgba(255,255,255,0.7);
        font-weight: 500;
        margin-bottom: 8px;
    }

    /* Grid Métodos Pago */
    .pm-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-top: 24px;
    }
    .pm-card {
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.05);
        border-radius: 14px;
        padding: 16px 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .pm-card i {
        font-size: 2rem;
        margin-bottom: 8px;
        color: rgba(255,255,255,0.5);
        display: block;
        transition: 0.2s;
    }
    .pm-card span {
        font-size: 0.85rem;
        font-weight: 600;
        color: rgba(255,255,255,0.7);
    }
    .pm-card:hover {
        background: rgba(255,255,255,0.1);
    }
    .pm-card.active {
        border-color: var(--z-primary);
        background: rgba(108, 92, 231, 0.15);
    }
    .pm-card.active i {
        color: var(--z-accent);
    }
    .pm-card.active span {
        color: #fff;
    }

    /* Empty state */
    .empty-cart {
        text-align: center;
        padding: 40px 20px;
        color: rgba(255,255,255,0.4);
    }
    .empty-cart i {
        font-size: 4rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    /* Esconder inputs radio originales */
    .pm-radio { display: none; }
    
    /* Document type switcher */
    .doc-switcher {
        display: flex;
        background: rgba(0,0,0,0.2);
        padding: 4px;
        border-radius: 12px;
        margin-bottom: 24px;
    }
    .doc-tab {
        flex: 1;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        color: rgba(255,255,255,0.6);
        transition: 0.3s;
    }
    .doc-tab.active {
        background: var(--z-primary);
        color: #fff;
    }
</style>

<div class="pos-wrapper">
    <!-- Panel Izquierdo: Buscador -->
    <div class="pos-main">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" placeholder="Buscar por código o descripción... (min 3 letras)" autocomplete="off">
        </div>

        <div class="search-results" id="searchResults">
            <!-- Loading o Empty State -->
            <div style="grid-column: 1 / -1; text-align: center; padding-top: 60px; color: var(--text-muted);">
                <i class="fas fa-barcode" style="font-size: 4rem; color: #dfe6e9; margin-bottom: 20px;"></i>
                <h4>Escanea o busca productos</h4>
            </div>
        </div>
    </div>

    <!-- Panel Derecho: Ticket / Carrito -->
    <div class="pos-sidebar">
        <div class="cart-header">
            <i class="fas fa-receipt fa-lg"></i>
            <h3>Ticket Actual</h3>
            <span class="badge" id="cartCount">0</span>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="empty-cart" id="emptyCartMessage">
                <i class="fas fa-shopping-basket"></i>
                <p>No hay productos en el ticket</p>
            </div>
            <!-- Items irán aquí -->
        </div>

        <div class="cart-summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>S/ <span id="lblSubtotal">0.00</span></span>
            </div>
            <div class="summary-row">
                <span>IGV (18%)</span>
                <span>S/ <span id="lblIgv">0.00</span></span>
            </div>
            <div class="summary-row total">
                <span>TOTAL</span>
                <span>S/ <span id="lblTotal">0.00</span></span>
            </div>
            <button class="btn-pay" id="btnOpenModal" disabled>
                <i class="fas fa-money-bill-wave"></i> Cobrar S/ <span id="btnTotalText">0.00</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal de Checkout -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="posForm" action="{{ route('ventas-rapidas.store') }}" method="POST">
        @csrf
        <div class="modal-header border-0">
          <h5 class="modal-title">Completar Venta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <!-- Tipo Comprobante -->
            <div class="doc-switcher">
                <div class="doc-tab active" data-type="boleta">Boleta</div>
                <div class="doc-tab" data-type="factura">Factura</div>
            </div>
            <input type="hidden" name="comprobante" id="inpComprobante" value="boleta">

            <!-- Cliente Info -->
            <div class="form-group mb-3">
                <label class="z-label">DNI / RUC (Opcional)</label>
                <input type="text" name="cliente_cuit" class="form-control z-input" placeholder="Ej: 72481923" autocomplete="off">
            </div>
            <div class="form-group mb-4">
                <label class="z-label">Nombre del Cliente (Opcional)</label>
                <input type="text" name="cliente_nombre" class="form-control z-input" placeholder="Consumidor Final" autocomplete="off">
            </div>

            <!-- Método de Pago -->
            <label class="z-label">Método de Pago</label>
            <div class="pm-grid">
                <label class="pm-card active">
                    <input type="radio" name="metodo_pago" value="efectivo" class="pm-radio" checked>
                    <i class="fas fa-money-bill-alt"></i>
                    <span>Efectivo</span>
                </label>
                <label class="pm-card">
                    <input type="radio" name="metodo_pago" value="yape" class="pm-radio">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Yape</span>
                </label>
                <label class="pm-card">
                    <input type="radio" name="metodo_pago" value="plin" class="pm-radio">
                    <i class="fas fa-mobile"></i>
                    <span>Plin</span>
                </label>
                <label class="pm-card">
                    <input type="radio" name="metodo_pago" value="qr" class="pm-radio">
                    <i class="fas fa-qrcode"></i>
                    <span>QR</span>
                </label>
            </div>

            <!-- Contenedor dinámico de items -->
            <div id="hiddenItemsContainer"></div>
        </div>

        <div class="modal-footer border-0 pb-4 px-4 pt-0">
            <button type="submit" class="btn-pay m-0" id="btnConfirmSale">
                <i class="fas fa-check-circle"></i> Confirmar Venta
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

@if($errors->any())
    <div style="display:none;" id="serverErrors">
        @foreach($errors->all() as $error)
            {{ $error }}\n
        @endforeach
    </div>
@endif

@stop

@section('js')
<script>
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const cartItemsDiv = document.getElementById('cartItems');
    const emptyCartMsg = document.getElementById('emptyCartMessage');
    const lblSubtotal = document.getElementById('lblSubtotal');
    const lblIgv = document.getElementById('lblIgv');
    const lblTotal = document.getElementById('lblTotal');
    const cartCountTag = document.getElementById('cartCount');
    const btnOpenModal = document.getElementById('btnOpenModal');
    const btnTotalText = document.getElementById('btnTotalText');
    const posForm = document.getElementById('posForm');
    const hiddenItemsContainer = document.getElementById('hiddenItemsContainer');

    let cart = [];

    // --- Buscador ---
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length === 0) {
            searchResults.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding-top:60px;color:var(--text-muted);"><i class="fas fa-barcode" style="font-size:4rem;color:#dfe6e9;margin-bottom:20px;"></i><h4>Escanea o busca productos</h4></div>`;
            return;
        }

        if (query.length < 2) return;

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('vr-inventario.buscar.pos') }}?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                searchResults.innerHTML = '';
                if(data.length === 0) {
                    searchResults.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding-top:40px;color:var(--text-muted);"><h4>No se encontraron productos</h4></div>`;
                    return;
                }
                
                data.forEach(prod => {
                    const div = document.createElement('div');
                    div.className = 'product-card';
                    div.innerHTML = `
                        <div>
                            <span class="p-code">${prod.sku}</span>
                            <div class="p-title">${prod.nombre}</div>
                        </div>
                        <div class="p-bottom">
                            <span class="p-price">S/ ${parseFloat(prod.precio).toFixed(2)}</span>
                            <span class="p-stock">${prod.stock} disp.</span>
                        </div>
                    `;
                    div.onclick = () => addToCart(prod);
                    searchResults.appendChild(div);
                });
            });
        }, 300); // debounce
    });

    // --- Carrito ---
    function addToCart(prod) {
        // Formatear precio de manera segura
        const precio = parseFloat(prod.precio);
        
        const existingInfo = cart.find(item => item.id === prod.id);
        if (existingInfo) {
            if (existingInfo.cantidad < prod.stock) {
                existingInfo.cantidad++;
            } else {
                Swal.fire('Stock Limitado', 'No hay más unidades disponibles.', 'warning');
            }
        } else {
            cart.push({
                id: prod.id,
                descripcion: prod.nombre,
                precio_unitario: precio,
                cantidad: 1,
                stock_max: prod.stock
            });
        }
        
        // Limpiar buscador para rapidez
        searchInput.value = '';
        searchInput.focus();
        searchResults.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding-top:60px;color:var(--text-muted);"><i class="fas fa-check-circle" style="font-size:4rem;color:#00b894;margin-bottom:20px;"></i><h4>Producto Agregado</h4></div>`;

        renderCart();
    }

    function changeQty(id, delta) {
        const item = cart.find(i => i.id === id);
        if(!item) return;

        if (delta === 1 && item.cantidad >= item.stock_max) {
             Swal.fire('Atención', 'Alcanzaste el máximo stock ' + item.stock_max, 'info');
             return;
        }

        item.cantidad += delta;
        
        if (item.cantidad <= 0) {
            cart = cart.filter(i => i.id !== id);
        }
        renderCart();
    }

    function removeItem(id) {
        cart = cart.filter(i => i.id !== id);
        renderCart();
    }

    function renderCart() {
        cartItemsDiv.innerHTML = '';
        if (cart.length === 0) {
            cartItemsDiv.appendChild(emptyCartMsg);
            btnOpenModal.disabled = true;
            cartCountTag.textContent = '0';
            updateTotals();
            return;
        }

        btnOpenModal.disabled = false;
        
        let totalQty = 0;
        cart.forEach(item => {
            totalQty += item.cantidad;
            const rowTotal = item.cantidad * item.precio_unitario;

            const div = document.createElement('div');
            div.className = 'cart-item';
            div.innerHTML = `
                <div class="ci-top">
                    <div class="ci-title">${item.descripcion}</div>
                    <div class="ci-remove" onclick="removeItem('${item.id}')"><i class="fas fa-times"></i></div>
                </div>
                <div class="ci-controls">
                    <div class="qty-control">
                        <div class="qty-btn" onclick="changeQty('${item.id}', -1)"><i class="fas fa-minus"></i></div>
                        <div class="qty-val">${item.cantidad}</div>
                        <div class="qty-btn" onclick="changeQty('${item.id}', 1)"><i class="fas fa-plus"></i></div>
                    </div>
                    <div class="ci-price">S/ ${rowTotal.toFixed(2)}</div>
                </div>
            `;
            cartItemsDiv.appendChild(div);
        });

        cartCountTag.textContent = totalQty;
        updateTotals();
    }

    function updateTotals() {
        let rawSubtotal = 0;
        cart.forEach(item => { rawSubtotal += (item.cantidad * item.precio_unitario); });
        
        // El subtotal de la vista es el neto antes de IGV
        // Total = rawSubtotal
        // Subtotal + IGV = rawSubtotal
        // Subtotal = rawSubtotal / 1.18
        const realSubtotal = rawSubtotal / 1.18;
        const igv = rawSubtotal - realSubtotal;

        lblSubtotal.textContent = realSubtotal.toFixed(2);
        lblIgv.textContent =igv.toFixed(2);
        lblTotal.textContent = rawSubtotal.toFixed(2);
        btnTotalText.textContent = rawSubtotal.toFixed(2);
    }

    // --- Modal Logic ---
    btnOpenModal.addEventListener('click', () => {
        if(cart.length === 0) return;
        $('#checkoutModal').modal('show');
    });

    // Doc switcher
    const docTabs = document.querySelectorAll('.doc-tab');
    const inpComprobante = document.getElementById('inpComprobante');
    docTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            docTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            inpComprobante.value = tab.dataset.type;
        });
    });

    // Payment methods visual selection
    const pmCards = document.querySelectorAll('.pm-card');
    const pmRadios = document.querySelectorAll('.pm-radio');
    pmCards.forEach((card, index) => {
        card.addEventListener('click', () => {
            pmCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            pmRadios[index].checked = true;
        });
    });

    // Form Submission: Inject dynamically the hidden array items
    posForm.addEventListener('submit', function(e) {
        hiddenItemsContainer.innerHTML = '';
        cart.forEach((item, idx) => {
            hiddenItemsContainer.innerHTML += `
                <input type="hidden" name="items[${idx}][id]" value="${item.id}">
                <input type="hidden" name="items[${idx}][cantidad]" value="${item.cantidad}">
                <input type="hidden" name="items[${idx}][precio_unitario]" value="${item.precio_unitario}">
                <input type="hidden" name="items[${idx}][descuento]" value="0">
            `;
        });
    });

    // Initial check for server errors
    const srvErrs = document.getElementById('serverErrors');
    if (srvErrs) {
        Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            text: srvErrs.innerText
        });
    }

    // Auto focus on load
    window.onload = () => {
        searchInput.focus();
    };
</script>
@stop
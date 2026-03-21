@extends('adminlte::page')

@section('title', 'Nueva Venta')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-cash-register mr-2"></i>Nueva Venta</h1>
        <a href="{{ route('venta.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Volver al Historial
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0"><i class="fas fa-receipt mr-1"></i>Registro de Venta</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('venta.store') }}" method="POST" id="form-venta">
                            @csrf
                            
                            <!-- Información general de la venta -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha" class="font-weight-bold">Fecha <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               class="form-control @error('fecha') is-invalid @enderror" 
                                               id="fecha" 
                                               name="fecha" 
                                               value="{{ old('fecha', date('Y-m-d')) }}" 
                                               required>
                                        @error('fecha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="CUIT" class="font-weight-bold">Cliente <span class="text-danger">*</span></label>
                                        <select class="form-control @error('CUIT') is-invalid @enderror" 
                                                id="CUIT" 
                                                name="CUIT" 
                                                required>
                                            <option value="">Seleccione un cliente</option>
                                            @foreach($clientes as $cliente)
                                                <option value="{{ $cliente->CUIT }}" {{ old('CUIT') == $cliente->CUIT ? 'selected' : '' }}>
                                                    {{ $cliente->Nombre }} {{ $cliente->Apellidos }} - {{ $cliente->CUIT }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('CUIT')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="idasesor" class="font-weight-bold">Asesor <span class="text-danger">*</span></label>
                                        <select class="form-control @error('idasesor') is-invalid @enderror" 
                                                id="idasesor" 
                                                name="idasesor" 
                                                required>
                                            <option value="">Seleccione un asesor</option>
                                            @foreach($asesores as $asesor)
                                                <option value="{{ $asesor->idasesor }}" {{ old('idasesor') == $asesor->idasesor ? 'selected' : '' }}>
                                                    {{ $asesor->empleado->nombre }} {{ $asesor->empleado->apellidos }} - {{ $asesor->idasesor }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('idasesor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Detalle de productos -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5><i class="fas fa-boxes mr-1"></i>Detalle de Productos</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tabla-productos">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="45%">Producto</th>
                                                    <th width="15%">Precio Unit.</th>
                                                    <th width="15%">Cantidad</th>
                                                    <th width="15%">Subtotal</th>
                                                    <th width="10%">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cuerpo-tabla">
                                                <!-- Las filas de productos se agregarán aquí dinámicamente -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-right font-weight-bold">TOTAL:</td>
                                                    <td colspan="2" class="font-weight-bold text-success" id="total-venta">S/ 0.00</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="agregar-producto">
                                        <i class="fas fa-plus mr-1"></i>Agregar Producto
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <button type="reset" class="btn btn-secondary mr-2">
                                        <i class="fas fa-undo mr-1"></i>Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>Registrar Venta
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            border-radius: 0.35rem;
        }
        .form-group label {
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 0.3rem;
        }
        .btn {
            border-radius: 0.3rem;
        }
        #tabla-productos th {
            font-size: 0.85rem;
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Array para llevar el control de los productos agregados
            let productosAgregados = [];
            let contadorFila = 0;

            // Referencias a elementos
            const cuerpoTabla = document.getElementById('cuerpo-tabla');
            const totalVenta = document.getElementById('total-venta');
            const botonAgregar = document.getElementById('agregar-producto');
            const formVenta = document.getElementById('form-venta');

            // Función para formatear número a dos decimales
            const formatearDecimal = (numero) => {
                return parseFloat(numero).toFixed(2);
            };

            // Función para calcular el total de la venta
            const calcularTotal = () => {
                let total = 0;
                document.querySelectorAll('.subtotal').forEach(subtotalElement => {
                    total += parseFloat(subtotalElement.value || 0);
                });
                totalVenta.textContent = `S/ ${formatearDecimal(total)}`;
            };

            // Función para agregar una nueva fila de producto
            const agregarFilaProducto = (producto = null) => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>
                        <select name="productos[${contadorFila}][idproducto]" class="form-control select-producto" required>
                            <option value="">Seleccione un producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->idproducto }}" data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock }}">
                                    {{ $producto->descripcion }} - S/ {{ number_format($producto->precio, 2) }} (Stock: {{ $producto->stock }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control precio" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control cantidad" name="productos[${contadorFila}][cantidad]" min="1" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control subtotal" readonly>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                cuerpoTabla.appendChild(fila);

                // Si se pasó un producto, seleccionarlo
                if (producto) {
                    fila.querySelector('.select-producto').value = producto.idproducto;
                    fila.querySelector('.precio').value = producto.precio;
                }

                // Eventos para la nueva fila
                const selectProducto = fila.querySelector('.select-producto');
                const inputPrecio = fila.querySelector('.precio');
                const inputCantidad = fila.querySelector('.cantidad');
                const inputSubtotal = fila.querySelector('.subtotal');
                const botonEliminar = fila.querySelector('.btn-eliminar');

                // Cuando se selecciona un producto
                selectProducto.addEventListener('change', function() {
                    const opcion = this.options[this.selectedIndex];
                    const precio = opcion.getAttribute('data-precio');
                    inputPrecio.value = precio ? formatearDecimal(precio) : '';
                    inputCantidad.value = '';
                    inputSubtotal.value = '';
                    calcularTotal();
                });

                // Cuando cambia la cantidad
                inputCantidad.addEventListener('input', function() {
                    const precio = parseFloat(inputPrecio.value || 0);
                    const cantidad = parseInt(this.value || 0);
                    const subtotal = precio * cantidad;
                    inputSubtotal.value = formatearDecimal(subtotal);
                    calcularTotal();
                });

                // Eliminar la fila
                botonEliminar.addEventListener('click', function() {
                    fila.remove();
                    calcularTotal();
                });

                contadorFila++;
            };

            // Agregar primera fila al cargar
            agregarFilaProducto();

            // Agregar más filas al hacer clic en el botón
            botonAgregar.addEventListener('click', function() {
                agregarFilaProducto();
            });

            // Validar el formulario antes de enviar
            formVenta.addEventListener('submit', function(e) {
                const total = parseFloat(totalVenta.textContent.replace('S/ ', ''));
                if (total <= 0) {
                    e.preventDefault();
                    alert('Debe agregar al menos un producto con cantidad válida.');
                }
            });
        });
    </script>
@stop
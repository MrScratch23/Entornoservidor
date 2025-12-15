/**
 * Archivo: personajes.js
 * Manejo de filtros con JavaScript para la página de personajes
 * VERSIÓN CORREGIDA - Usa datos reales de la BD
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const buscarInput = document.getElementById('buscarInput');
    const buscarBtn = document.getElementById('buscarBtn');
    const rarezaSelect = document.getElementById('rarezaSelect');
    const rarezaBtn = document.getElementById('rarezaBtn');
    const rutaSelect = document.getElementById('rutaSelect');
    const rutaBtn = document.getElementById('rutaBtn');
    const elementoSelect = document.getElementById('elementoSelect');
    const elementoBtn = document.getElementById('elementoBtn');
    const charactersGrid = document.getElementById('charactersGrid');
    const contadorResultados = document.getElementById('contadorResultados');
    const resultadosCount = document.getElementById('resultadosCount');
    const resetContainer = document.getElementById('resetContainer');
    const resetBtn = document.getElementById('resetBtn');
    
    // Estado de los filtros
    let filtrosActivos = {
        busqueda: '',
        rareza: '',
        ruta: '',
        elemento: ''
    };
    
    // Inicializar
    inicializarFiltros();
    
    // Event Listeners
    if (buscarBtn) buscarBtn.addEventListener('click', aplicarBusqueda);
    if (buscarInput) {
        buscarInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                aplicarBusqueda();
            }
        });
    }
    
    if (rarezaBtn) rarezaBtn.addEventListener('click', function() {
        aplicarFiltro('rareza', rarezaSelect.value);
    });
    
    if (rutaBtn) rutaBtn.addEventListener('click', function() {
        aplicarFiltro('ruta', rutaSelect.value);
    });
    
    if (elementoBtn) elementoBtn.addEventListener('click', function() {
        aplicarFiltro('elemento', elementoSelect.value);
    });
    
    if (resetBtn) resetBtn.addEventListener('click', resetearFiltros);
    
    // Función para inicializar los filtros
    function inicializarFiltros() {
        // Los personajes ya están cargados en el HTML desde PHP
        // Solo actualizamos el contador
        if (window.personajesData) {
            actualizarContador(window.personajesData.length);
        }
        
        // Configurar eventos automáticos para selects
        if (rarezaSelect) {
            rarezaSelect.addEventListener('change', function() {
                aplicarFiltro('rareza', this.value);
            });
        }
        
        if (rutaSelect) {
            rutaSelect.addEventListener('change', function() {
                aplicarFiltro('ruta', this.value);
            });
        }
        
        if (elementoSelect) {
            elementoSelect.addEventListener('change', function() {
                aplicarFiltro('elemento', this.value);
            });
        }
        
        // Filtro automático mientras se escribe
        if (buscarInput) {
            let timeoutBusqueda;
            buscarInput.addEventListener('input', function() {
                clearTimeout(timeoutBusqueda);
                timeoutBusqueda = setTimeout(() => {
                    aplicarBusqueda();
                }, 300);
            });
        }
    }
    
    // Función para aplicar búsqueda por texto
    function aplicarBusqueda() {
        if (!buscarInput) return;
        const textoBusqueda = buscarInput.value.trim().toLowerCase();
        filtrosActivos.busqueda = textoBusqueda;
        aplicarFiltrosCombinados();
    }
    
    // Función para aplicar un filtro específico
    function aplicarFiltro(tipo, valor) {
        filtrosActivos[tipo] = valor;
        aplicarFiltrosCombinados();
    }
    
    // Función para aplicar todos los filtros combinados
    function aplicarFiltrosCombinados() {
        // Obtener todas las cards de personaje del HTML
        const todasLasCards = document.querySelectorAll('.character-card');
        
        if (todasLasCards.length === 0) return;
        
        let resultadosVisibles = 0;
        
        // Filtrar las cards basándonos en los datos y los filtros
        todasLasCards.forEach(card => {
            const cardRareza = card.dataset.rareza;
            const cardRuta = card.dataset.ruta;
            const cardElemento = card.dataset.elemento;
            const cardNombre = card.dataset.nombre;
            
            let mostrar = true;
            
            // Aplicar filtro de búsqueda
            if (filtrosActivos.busqueda) {
                if (!cardNombre.includes(filtrosActivos.busqueda.toLowerCase())) {
                    mostrar = false;
                }
            }
            
            // Aplicar filtro de rareza
            if (filtrosActivos.rareza && cardRareza !== filtrosActivos.rareza) {
                mostrar = false;
            }
            
            // Aplicar filtro de ruta
            if (filtrosActivos.ruta && cardRuta !== filtrosActivos.ruta) {
                mostrar = false;
            }
            
            // Aplicar filtro de elemento
            if (filtrosActivos.elemento && cardElemento !== filtrosActivos.elemento) {
                mostrar = false;
            }
            
            // Mostrar u ocultar la card
            if (mostrar) {
                card.style.display = 'block';
                resultadosVisibles++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Mostrar mensaje si no hay resultados
        const noResultsEl = document.querySelector('.no-results');
        if (resultadosVisibles === 0) {
            if (!noResultsEl) {
                const noResults = document.createElement('div');
                noResults.className = 'no-results';
                noResults.innerHTML = `
                    <h3>🚫 No se encontraron personajes</h3>
                    <p>Intenta con otros filtros o términos de búsqueda.</p>
                `;
                charactersGrid.appendChild(noResults);
            }
        } else if (noResultsEl) {
            noResultsEl.remove();
        }
        
        actualizarContador(resultadosVisibles);
        actualizarUIEstadoFiltros();
    }
    
    // Función para actualizar el contador de resultados
    function actualizarContador(cantidad) {
        if (!resultadosCount || !contadorResultados) return;
        
        resultadosCount.textContent = cantidad;
        
        const totalPersonajes = document.querySelectorAll('.character-card').length;
        if (cantidad !== totalPersonajes) {
            contadorResultados.style.display = 'flex';
        } else {
            contadorResultados.style.display = 'none';
        }
    }
    
    // Función para actualizar la UI según el estado de los filtros
    function actualizarUIEstadoFiltros() {
        const hayFiltrosActivos = 
            filtrosActivos.busqueda || 
            filtrosActivos.rareza || 
            filtrosActivos.ruta || 
            filtrosActivos.elemento;
        
        if (resetContainer) {
            resetContainer.style.display = hayFiltrosActivos ? 'block' : 'none';
        }
    }
    
    // Función para resetear todos los filtros
    function resetearFiltros(e) {
        e.preventDefault();
        
        // Limpiar estado de filtros
        filtrosActivos = {
            busqueda: '',
            rareza: '',
            ruta: '',
            elemento: ''
        };
        
        // Limpiar inputs
        if (buscarInput) buscarInput.value = '';
        if (rarezaSelect) rarezaSelect.value = '';
        if (rutaSelect) rutaSelect.value = '';
        if (elementoSelect) elementoSelect.value = '';
        
        // Mostrar todos los personajes
        const todasLasCards = document.querySelectorAll('.character-card');
        todasLasCards.forEach(card => {
            card.style.display = 'block';
        });
        
        // Remover mensaje de no resultados si existe
        const noResultsEl = document.querySelector('.no-results');
        if (noResultsEl) {
            noResultsEl.remove();
        }
        
        const totalPersonajes = document.querySelectorAll('.character-card').length;
        actualizarContador(totalPersonajes);
        actualizarUIEstadoFiltros();
    }
});
/**
 * Archivo: personajes.js
 * Manejo de filtros con JavaScript para la página de personajes
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
    const totalPersonajes = document.getElementById('totalPersonajes');
    
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
    buscarBtn.addEventListener('click', aplicarBusqueda);
    buscarInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            aplicarBusqueda();
        }
    });
    
    rarezaBtn.addEventListener('click', function() {
        aplicarFiltro('rareza', rarezaSelect.value);
    });
    
    rutaBtn.addEventListener('click', function() {
        aplicarFiltro('ruta', rutaSelect.value);
    });
    
    elementoBtn.addEventListener('click', function() {
        aplicarFiltro('elemento', elementoSelect.value);
    });
    
    resetBtn.addEventListener('click', resetearFiltros);
    
    // Función para inicializar los filtros
    function inicializarFiltros() {
        // Cargar personajes iniciales
        mostrarPersonajes(window.personajesData);
        
        // Actualizar contador inicial
        actualizarContador(window.personajesData.length);
    }
    
    // Función para aplicar búsqueda por texto
    function aplicarBusqueda() {
        const textoBusqueda = buscarInput.value.trim().toLowerCase();
        filtrosActivos.busqueda = textoBusqueda;
        aplicarFiltrosCombinados();
    }
    
    // Función para aplicar un filtro específico
    function aplicarFiltro(tipo, valor) {
        if (tipo === 'rareza') {
            filtrosActivos.rareza = valor;
        } else if (tipo === 'ruta') {
            filtrosActivos.ruta = valor;
        } else if (tipo === 'elemento') {
            filtrosActivos.elemento = valor;
        }
        aplicarFiltrosCombinados();
    }
    
    // Función para aplicar todos los filtros combinados
    function aplicarFiltrosCombinados() {
        const personajesFiltrados = window.personajesData.filter(personaje => {
            // Filtro por búsqueda de texto
            if (filtrosActivos.busqueda && 
                !personaje.nombre.toLowerCase().includes(filtrosActivos.busqueda)) {
                return false;
            }
            
            // Filtro por rareza
            if (filtrosActivos.rareza && personaje.rareza !== filtrosActivos.rareza) {
                return false;
            }
            
            // Filtro por ruta
            if (filtrosActivos.ruta && personaje.ruta !== filtrosActivos.ruta) {
                return false;
            }
            
            // Filtro por elemento
            if (filtrosActivos.elemento && personaje.elemento !== filtrosActivos.elemento) {
                return false;
            }
            
            return true;
        });
        
        mostrarPersonajes(personajesFiltrados);
        actualizarContador(personajesFiltrados.length);
        actualizarUIEstadoFiltros();
    }
    
    // Función para mostrar personajes en el grid
    function mostrarPersonajes(personajes) {
        charactersGrid.innerHTML = '';
        
        if (personajes.length === 0) {
            charactersGrid.innerHTML = `
                <div class="no-results">
                    <h3>🚫 No se encontraron personajes</h3>
                    <p>Intenta con otros filtros o términos de búsqueda.</p>
                </div>
            `;
            return;
        }
        
        personajes.forEach(personaje => {
            const card = document.createElement('div');
            card.className = 'character-card';
            card.setAttribute('data-rareza', personaje.rareza);
            card.setAttribute('data-ruta', personaje.ruta);
            card.setAttribute('data-elemento', personaje.elemento);
            card.setAttribute('data-nombre', personaje.nombre.toLowerCase());
            
            const rarezaClass = personaje.rareza === '5 estrellas' ? 'gold' : 'purple';
            
            card.innerHTML = `
                <img src="${personaje.imagen_url}" 
                     alt="${personaje.nombre}"
                     class="character-image">
                <div class="character-info">
                    <h3 class="character-name">${personaje.nombre}</h3>
                    <div class="character-meta">
                        <span class="rareza ${rarezaClass}" data-rarity="${personaje.rareza}">
                            ${personaje.rareza}
                        </span>
                        <span class="ruta">${personaje.ruta}</span>
                    </div>
                    <div style="margin: 8px 0;">
                        <span class="elemento">${personaje.elemento}</span>
                    </div>
                    <p class="character-desc">
                        ${personaje.descripcion}
                    </p>
                </div>
            `;
            
            charactersGrid.appendChild(card);
        });
    }
    
    // Función para actualizar el contador de resultados
    function actualizarContador(cantidad) {
        resultadosCount.textContent = cantidad;
        
        if (cantidad !== window.personajesData.length) {
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
        
        if (hayFiltrosActivos) {
            resetContainer.style.display = 'block';
            
            // Actualizar selects para reflejar filtros activos
            if (filtrosActivos.rareza) {
                rarezaSelect.value = filtrosActivos.rareza;
            }
            if (filtrosActivos.ruta) {
                rutaSelect.value = filtrosActivos.ruta;
            }
            if (filtrosActivos.elemento) {
                elementoSelect.value = filtrosActivos.elemento;
            }
        } else {
            resetContainer.style.display = 'none';
            
            // Limpiar selects
            rarezaSelect.value = '';
            rutaSelect.value = '';
            elementoSelect.value = '';
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
        buscarInput.value = '';
        rarezaSelect.value = '';
        rutaSelect.value = '';
        elementoSelect.value = '';
        
        // Mostrar todos los personajes
        mostrarPersonajes(window.personajesData);
        actualizarContador(window.personajesData.length);
        actualizarUIEstadoFiltros();
    }
    
    // Opcional: Filtro automático mientras se escribe (con debounce)
    let timeoutBusqueda;
    buscarInput.addEventListener('input', function() {
        clearTimeout(timeoutBusqueda);
        timeoutBusqueda = setTimeout(() => {
            aplicarBusqueda();
        }, 300);
    });
    
    // Opcional: Cambios en selects sin necesidad de botón
    rarezaSelect.addEventListener('change', function() {
        if (this.value) {
            aplicarFiltro('rareza', this.value);
        }
    });
    
    rutaSelect.addEventListener('change', function() {
        if (this.value) {
            aplicarFiltro('ruta', this.value);
        }
    });
    
    elementoSelect.addEventListener('change', function() {
        if (this.value) {
            aplicarFiltro('elemento', this.value);
        }
    });
});
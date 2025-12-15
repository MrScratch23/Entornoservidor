/**
 * Archivo: detalles-personaje.js (SIMPLIFICADO - SIN API)
 * Manejo del modal de detalles de personajes con comentarios
 */

class DetallesPersonaje {
    constructor() {
        this.modal = null;
        this.currentPersonajeId = null;
        this.currentPersonajeNombre = null;
        this.isLoading = false;
        this.comentarios = [];
        this.init();
    }
    
    init() {
        this.createModal();
        this.bindEvents();
    }
    
    createModal() {
        // Crear estructura del modal
        const modalHTML = `
            <div id="detallesModal" class="detalles-modal">
                <div class="detalles-modal-overlay"></div>
                <div class="detalles-modal-content">
                    <div class="detalles-modal-header">
                        <h2 id="modalPersonajeNombre"></h2>
                        <button class="detalles-modal-close">&times;</button>
                    </div>
                    <div class="detalles-modal-body">
                        <div class="detalles-loading">
                            <div class="spinner"></div>
                            <p>Cargando detalles...</p>
                        </div>
                        <div class="detalles-content" style="display: none;">
                            <!-- Contenido se llenará dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.modal = document.getElementById('detallesModal');
    }
    
    bindEvents() {
        // Cerrar modal al hacer click en overlay o botón cerrar
        this.modal.querySelector('.detalles-modal-overlay').addEventListener('click', () => this.close());
        this.modal.querySelector('.detalles-modal-close').addEventListener('click', () => this.close());
        
        // Cerrar con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.style.display === 'flex') {
                this.close();
            }
        });
        
        // Agregar event listener a todas las cards de personaje
        document.addEventListener('click', (e) => {
            const characterCard = e.target.closest('.character-card');
            if (characterCard) {
                e.preventDefault();
                const personajeId = characterCard.dataset.id;
                this.open(personajeId, characterCard);
            }
        });
    }
    
    async open(personajeId, characterCard) {
        this.currentPersonajeId = personajeId;
        
        // Obtener datos básicos de la card
        this.currentPersonajeNombre = characterCard.querySelector('.character-name').textContent;
        const rareza = characterCard.dataset.rareza;
        const ruta = characterCard.dataset.ruta;
        const elemento = characterCard.dataset.elemento;
        const imagen = characterCard.querySelector('.character-image').src;
        const descripcion = characterCard.querySelector('.character-desc').textContent;
        
        // Mostrar modal con datos básicos
        this.showBasicInfo(this.currentPersonajeNombre, rareza, ruta, elemento, imagen, descripcion);
        this.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Cargar datos detallados
        await this.loadDetalles(personajeId);
    }
    
    showBasicInfo(nombre, rareza, ruta, elemento, imagen, descripcion) {
        this.modal.querySelector('#modalPersonajeNombre').textContent = nombre;
        
        const basicInfoHTML = `
            <div class="detalles-basic-info">
                <div class="detalles-character-image">
                    <img src="${imagen}" alt="${nombre}" onerror="this.src='https://via.placeholder.com/300x400/1a1a2e/667eea?text=Imagen+no+disponible'">
                    <div class="detalles-character-badges">
                        <span class="badge rareza ${rareza.includes('5') ? 'gold' : 'purple'}">${rareza}</span>
                        <span class="badge ruta">${ruta}</span>
                        <span class="badge elemento">${elemento}</span>
                    </div>
                </div>
                <div class="detalles-character-desc">
                    <h3>Descripción</h3>
                    <p>${descripcion}</p>
                </div>
            </div>
        `;
        
        const contentDiv = this.modal.querySelector('.detalles-content');
        contentDiv.innerHTML = basicInfoHTML;
        contentDiv.style.display = 'none';
        this.modal.querySelector('.detalles-loading').style.display = 'flex';
    }
    
    async loadDetalles(personajeId) {
        if (this.isLoading) return;
        
        this.isLoading = true;
        
        try {
            // Cargar comentarios del personaje
            await this.loadComentarios(personajeId);
            
            // Aquí podrías cargar otros datos del personaje (habilidades, estadísticas, etc.)
            const detalles = this.getMockDetalles(); // Por ahora datos mock
            
            // Añadir los comentarios reales a los detalles
            detalles.comentarios = this.comentarios;
            
            this.renderDetalles(detalles);
            
        } catch (error) {
            console.error('Error cargando detalles:', error);
            this.showError();
        } finally {
            this.isLoading = false;
        }
    }
    
    async loadComentarios(personajeId) {
        // Por ahora, usamos comentarios mock
        // En una versión real, harías una petición AJAX a un archivo PHP
        await this.simulateLoad();
        
        // Datos mock de comentarios
        this.comentarios = this.getMockComentarios();
    }
    
    simulateLoad() {
        return new Promise(resolve => setTimeout(resolve, 500));
    }
    
    getMockDetalles() {
        // Datos mock para el personaje
        return {
            habilidades: [
                { nombre: 'Ataque Básico', tipo: 'Básica', descripcion: 'Ataque básico que inflige daño.', nivel_max: '10' },
                { nombre: 'Habilidad', tipo: 'Habilidad', descripcion: 'Habilidad especial del personaje.', nivel_max: '15' },
                { nombre: 'Definitiva', tipo: 'Definitiva', descripcion: 'Habilidad definitiva poderosa.', nivel_max: '15' }
            ],
            estadisticas: {
                nivel: 80,
                ataque_base: 600,
                defensa_base: 400,
                vida_base: 1200,
                velocidad_base: 100,
                probabilidad_critica: '5.00',
                danio_critico: '100.00'
            },
            artefactos: [
                { nombre: 'Set Recomendado', tipo: 'Cuerpo', conjunto: 'Set Básico', estadistica_principal: 'ATQ%', prioridad: 'Alta' }
            ],
            sinergias: [
                { personaje_sinergia: 'Personaje Soporte', rol_sinergia: 'Soporte', razon: 'Excelente sinergia.', nivel_recomendacion: 'S' }
            ],
            reviews: [
                { titulo: 'Análisis Básico', contenido: 'Personaje versátil y poderoso.', rating_overall: 4 }
            ]
        };
    }
    
    getMockComentarios() {
        return [
            {
                id_comentario: 1,
                id_usuario: window.currentUserId,
                id_personaje: this.currentPersonajeId,
                contenido: '¡Me encanta este personaje! Es mi main favorito.',
                fecha_creacion: '2024-01-15 14:30:00',
                username: window.currentUserUsername,
                usuario_nombre: window.currentUserName
            },
            {
                id_comentario: 2,
                id_usuario: 999,
                id_personaje: this.currentPersonajeId,
                contenido: 'Buen personaje para equipos de DPS. Recomiendo build de velocidad.',
                fecha_creacion: '2024-01-14 10:15:00',
                username: 'usuario2',
                usuario_nombre: 'Usuario Ejemplo'
            }
        ];
    }
    
    renderDetalles(detalles) {
        const contentHTML = this.generateDetallesHTML(detalles);
        const contentDiv = this.modal.querySelector('.detalles-content');
        
        // Mantener la info básica y añadir el resto
        const basicInfo = contentDiv.innerHTML;
        contentDiv.innerHTML = basicInfo + contentHTML;
        
        // Mostrar contenido y ocultar loading
        this.modal.querySelector('.detalles-loading').style.display = 'none';
        contentDiv.style.display = 'block';
        
        // Inicializar tabs
        this.initTabs();
        
        // Inicializar sistema de comentarios
        this.initComentarios();
    }
    
    generateDetallesHTML(detalles) {
        const totalComentarios = detalles.comentarios?.length || 0;
        
        return `
            <div class="detalles-tabs">
                <div class="detalles-tabs-nav">
                    <button class="tab-btn active" data-tab="habilidades">Habilidades</button>
                    <button class="tab-btn" data-tab="estadisticas">Estadísticas</button>
                    <button class="tab-btn" data-tab="artefactos">Artefactos</button>
                    <button class="tab-btn" data-tab="sinergias">Sinergias</button>
                    <button class="tab-btn" data-tab="reviews">Reviews</button>
                    <button class="tab-btn" data-tab="comentarios">
                        Comentarios <span class="comments-count">${totalComentarios}</span>
                    </button>
                </div>
                
                <div class="detalles-tabs-content">
                    <!-- Habilidades -->
                    <div class="tab-pane active" id="habilidades">
                        <h3><i class="fas fa-fire"></i> Habilidades</h3>
                        ${this.renderHabilidades(detalles.habilidades)}
                    </div>
                    
                    <!-- Estadísticas -->
                    <div class="tab-pane" id="estadisticas">
                        <h3><i class="fas fa-chart-bar"></i> Estadísticas (Nivel ${detalles.estadisticas.nivel})</h3>
                        ${this.renderEstadisticas(detalles.estadisticas)}
                    </div>
                    
                    <!-- Artefactos -->
                    <div class="tab-pane" id="artefactos">
                        <h3><i class="fas fa-gem"></i> Artefactos Recomendados</h3>
                        ${this.renderArtefactos(detalles.artefactos)}
                    </div>
                    
                    <!-- Sinergias -->
                    <div class="tab-pane" id="sinergias">
                        <h3><i class="fas fa-users"></i> Sinergias de Equipo</h3>
                        ${this.renderSinergias(detalles.sinergias)}
                    </div>
                    
                    <!-- Reviews -->
                    <div class="tab-pane" id="reviews">
                        <h3><i class="fas fa-star"></i> Análisis y Reviews</h3>
                        ${this.renderReviews(detalles.reviews)}
                    </div>
                    
                    <!-- Comentarios -->
                    <div class="tab-pane" id="comentarios">
                        <h3><i class="fas fa-comments"></i> Comentarios de la Comunidad</h3>
                        ${this.renderComentarios(detalles.comentarios)}
                    </div>
                </div>
            </div>
        `;
    }
    
    renderHabilidades(habilidades) {
        return `
            <div class="habilidades-grid">
                ${habilidades.map(habilidad => `
                    <div class="habilidad-card" data-tipo="${habilidad.tipo}">
                        <div class="habilidad-header">
                            <span class="habilidad-nombre">${habilidad.nombre}</span>
                            <span class="habilidad-tipo ${habilidad.tipo.toLowerCase()}">${habilidad.tipo}</span>
                        </div>
                        <div class="habilidad-desc">${habilidad.descripcion}</div>
                        ${habilidad.nivel_max ? `<div class="habilidad-nivel">Nivel Máx: ${habilidad.nivel_max}</div>` : ''}
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderEstadisticas(estadisticas) {
        return `
            <div class="estadisticas-grid">
                <div class="estadistica-item">
                    <span class="estadistica-label">Ataque Base</span>
                    <span class="estadistica-value">${estadisticas.ataque_base}</span>
                </div>
                <div class="estadistica-item">
                    <span class="estadistica-label">Defensa Base</span>
                    <span class="estadistica-value">${estadisticas.defensa_base}</span>
                </div>
                <div class="estadistica-item">
                    <span class="estadistica-label">Vida Base</span>
                    <span class="estadistica-value">${estadisticas.vida_base}</span>
                </div>
                <div class="estadistica-item">
                    <span class="estadistica-label">Velocidad</span>
                    <span class="estadistica-value">${estadisticas.velocidad_base}</span>
                </div>
                <div class="estadistica-item">
                    <span class="estadistica-label">Prob. Crítica</span>
                    <span class="estadistica-value">${estadisticas.probabilidad_critica}%</span>
                </div>
                <div class="estadistica-item">
                    <span class="estadistica-label">Daño Crítico</span>
                    <span class="estadistica-value">${estadisticas.danio_critico}%</span>
                </div>
            </div>
        `;
    }
    
    renderArtefactos(artefactos) {
        return `
            <div class="artefactos-list">
                ${artefactos.map(artefacto => `
                    <div class="artefacto-card ${artefacto.prioridad.toLowerCase()}">
                        <div class="artefacto-header">
                            <span class="artefacto-nombre">${artefacto.nombre}</span>
                            <span class="artefacto-prioridad ${artefacto.prioridad.toLowerCase()}">${artefacto.prioridad}</span>
                        </div>
                        <div class="artefacto-info">
                            <span class="artefacto-tipo">${artefacto.tipo}</span>
                            ${artefacto.conjunto ? `<span class="artefacto-conjunto">${artefacto.conjunto}</span>` : ''}
                        </div>
                        ${artefacto.estadistica_principal ? `
                            <div class="artefacto-stats">
                                <strong>Principal:</strong> ${artefacto.estadistica_principal}
                            </div>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderSinergias(sinergias) {
        return `
            <div class="sinergias-grid">
                ${sinergias.map(sinergia => `
                    <div class="sinergia-card nivel-${sinergia.nivel_recomendacion.toLowerCase()}">
                        <div class="sinergia-header">
                            <span class="sinergia-personaje">${sinergia.personaje_sinergia}</span>
                            <span class="sinergia-rol ${sinergia.rol_sinergia.toLowerCase()}">${sinergia.rol_sinergia}</span>
                        </div>
                        <div class="sinergia-razon">${sinergia.razon}</div>
                        <div class="sinergia-recomendacion">
                            <span class="nivel-${sinergia.nivel_recomendacion.toLowerCase()}">Tier ${sinergia.nivel_recomendacion}</span>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderReviews(reviews) {
        return `
            <div class="reviews-list">
                ${reviews.map(review => `
                    <div class="review-card">
                        <div class="review-header">
                            <h4 class="review-titulo">${review.titulo}</h4>
                            <div class="review-rating">
                                ${this.renderStars(review.rating_overall)}
                            </div>
                        </div>
                        <div class="review-contenido">${review.contenido}</div>
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderComentarios(comentarios) {
        if (!comentarios || comentarios.length === 0) {
            return `
                <div class="no-comments">
                    <p><i class="fas fa-comment-slash"></i> No hay comentarios aún. ¡Sé el primero en comentar!</p>
                    ${this.renderFormularioComentario()}
                </div>
            `;
        }
        
        return `
            <div class="comentarios-section">
                ${this.renderFormularioComentario()}
                
                <div class="comentarios-list">
                    ${comentarios.map(comentario => this.renderComentarioItem(comentario)).join('')}
                </div>
            </div>
        `;
    }
    
    renderFormularioComentario() {
        return `
            <div class="add-comment-form">
                <textarea id="nuevoComentario" placeholder="Escribe tu comentario sobre ${this.currentPersonajeNombre}..." maxlength="500"></textarea>
                <div class="comment-form-actions">
                    <small id="charCount">0/500</small>
                    <button id="enviarComentario" class="btn-enviar-comentario">
                        <i class="fas fa-paper-plane"></i> Publicar
                    </button>
                </div>
            </div>
        `;
    }
    
    renderComentarioItem(comentario) {
        const esPropietario = comentario.id_usuario == window.currentUserId;
        const fechaFormateada = this.formatFecha(comentario.fecha_creacion);
        
        return `
            <div class="comentario-item" data-id="${comentario.id_comentario}">
                <div class="comentario-header">
                    <div class="comentario-user">
                        <i class="fas fa-user-circle"></i>
                        <span class="user-name">${comentario.usuario_nombre || comentario.username}</span>
                        ${esPropietario ? '<span class="badge-propietario">(Tú)</span>' : ''}
                    </div>
                    <div class="comentario-date">${fechaFormateada}</div>
                </div>
                <div class="comentario-content">${this.escapeHtml(comentario.contenido)}</div>
                ${esPropietario ? `
                    <div class="comentario-actions">
                        <button class="btn-eliminar-comentario" data-id="${comentario.id_comentario}">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                ` : ''}
            </div>
        `;
    }
    
    renderStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += `<i class="fas fa-star ${i <= rating ? 'active' : ''}"></i>`;
        }
        return `<div class="stars">${stars}</div>`;
    }
    
    formatFecha(fechaString) {
        const fecha = new Date(fechaString);
        return fecha.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    initTabs() {
        const tabBtns = this.modal.querySelectorAll('.tab-btn');
        const tabPanes = this.modal.querySelectorAll('.tab-pane');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tabId = btn.dataset.tab;
                
                // Remover active de todos
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));
                
                // Añadir active al seleccionado
                btn.classList.add('active');
                this.modal.querySelector(`#${tabId}`).classList.add('active');
            });
        });
    }
    
    initComentarios() {
        // Contador de caracteres
        const textarea = this.modal.querySelector('#nuevoComentario');
        const charCount = this.modal.querySelector('#charCount');
        
        if (textarea && charCount) {
            textarea.addEventListener('input', () => {
                const length = textarea.value.length;
                charCount.textContent = `${length}/500`;
                
                if (length > 500) {
                    textarea.value = textarea.value.substring(0, 500);
                    charCount.textContent = '500/500';
                    charCount.style.color = '#ff6b6b';
                } else if (length > 450) {
                    charCount.style.color = '#ff9800';
                } else {
                    charCount.style.color = '#aaa';
                }
            });
            
            // Botón enviar comentario
            const enviarBtn = this.modal.querySelector('#enviarComentario');
            enviarBtn.addEventListener('click', () => this.agregarComentario());
            
            // También enviar con Ctrl+Enter
            textarea.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.key === 'Enter') {
                    this.agregarComentario();
                }
            });
        }
        
        // Botones eliminar comentario
        this.modal.querySelectorAll('.btn-eliminar-comentario').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = e.target.closest('.btn-eliminar-comentario').dataset.id;
                if (confirm('¿Eliminar este comentario?')) {
                    this.eliminarComentario(id);
                }
            });
        });
    }
    
    agregarComentario() {
        const textarea = this.modal.querySelector('#nuevoComentario');
        const contenido = textarea.value.trim();
        
        if (!contenido) {
            alert('El comentario no puede estar vacío');
            return;
        }
        
        if (contenido.length > 500) {
            alert('El comentario no puede tener más de 500 caracteres');
            return;
        }
        
        // Crear nuevo comentario (en una versión real, aquí harías una petición AJAX)
        const nuevoComentario = {
            id_comentario: Date.now(), // ID temporal
            id_usuario: window.currentUserId,
            id_personaje: this.currentPersonajeId,
            contenido: contenido,
            fecha_creacion: new Date().toISOString(),
            username: window.currentUserUsername,
            usuario_nombre: window.currentUserName
        };
        
        // Añadir a la lista
        this.comentarios.unshift(nuevoComentario);
        
        // Actualizar la vista
        this.actualizarVistaComentarios();
        
        // Limpiar textarea
        textarea.value = '';
        this.modal.querySelector('#charCount').textContent = '0/500';
        
        // Mostrar mensaje de éxito
        this.mostrarMensaje('Comentario publicado correctamente', 'success');
    }
    
    eliminarComentario(id) {
        // Eliminar de la lista (en una versión real, aquí harías una petición AJAX DELETE)
        this.comentarios = this.comentarios.filter(c => c.id_comentario != id);
        
        // Actualizar la vista
        this.actualizarVistaComentarios();
        
        // Mostrar mensaje
        this.mostrarMensaje('Comentario eliminado', 'success');
    }
    
    actualizarVistaComentarios() {
        // Encontrar el contenedor de comentarios
        const comentariosPane = this.modal.querySelector('#comentarios');
        if (!comentariosPane) return;
        
        // Re-renderizar la sección de comentarios
        comentariosPane.innerHTML = `
            <h3><i class="fas fa-comments"></i> Comentarios de la Comunidad</h3>
            ${this.renderComentarios(this.comentarios)}
        `;
        
        // Actualizar contador en el tab
        const commentsTab = this.modal.querySelector('[data-tab="comentarios"] .comments-count');
        if (commentsTab) {
            commentsTab.textContent = this.comentarios.length;
        }
        
        // Re-inicializar eventos
        this.initComentarios();
    }
    
    mostrarMensaje(texto, tipo = 'info') {
        // Crear mensaje temporal
        const mensaje = document.createElement('div');
        mensaje.className = `mensaje-flotante ${tipo}`;
        mensaje.innerHTML = `
            <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'info-circle'}"></i>
            <span>${texto}</span>
        `;
        
        document.body.appendChild(mensaje);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.remove(), 300);
        }, 3000);
    }
    
    showError() {
        const contentDiv = this.modal.querySelector('.detalles-content');
        contentDiv.innerHTML = `
            <div class="detalles-error">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Error al cargar detalles</h3>
                <p>No se pudieron cargar los detalles del personaje. Intenta nuevamente.</p>
                <button class="btn-retry">Reintentar</button>
            </div>
        `;
        
        this.modal.querySelector('.detalles-loading').style.display = 'none';
        contentDiv.style.display = 'block';
        
        // Botón para reintentar
        contentDiv.querySelector('.btn-retry').addEventListener('click', () => {
            this.loadDetalles(this.currentPersonajeId);
        });
    }
    
    close() {
        this.modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        const contentDiv = this.modal.querySelector('.detalles-content');
        contentDiv.innerHTML = '';
        this.modal.querySelector('.detalles-loading').style.display = 'flex';
        this.comentarios = [];
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.detallesPersonaje = new DetallesPersonaje();
});
// detalles-personaje.js - VERSIÓN CON DEBUGGING

console.log('✅ detalles-personaje.js cargado');

class DetallesPersonaje {
    constructor() {
        console.log('🔄 Clase DetallesPersonaje instanciada');
        this.modal = null;
        this.currentPersonajeId = null;
        this.currentPersonajeNombre = null;
        this.isLoading = false;
        this.comentarios = [];
        this.detallesCompletos = null;
        this.init();
    }
    
    init() {
        console.log('🔧 Inicializando DetallesPersonaje...');
        this.createModal();
        this.bindEvents();
    }
    
    createModal() {
        console.log('🛠️ Creando modal...');
        // Crear estructura del modal si no existe
        if (document.getElementById('detallesModal')) {
            console.log('ℹ️ Modal ya existe');
            return;
        }
        
        const modalHTML = `
            <div id="detallesModal" class="detalles-modal" style="display: none;">
                <div class="detalles-modal-overlay"></div>
                <div class="detalles-modal-content">
                    <div class="detalles-modal-header">
                        <h2 id="modalPersonajeNombre">Cargando...</h2>
                        <button class="detalles-modal-close">&times;</button>
                    </div>
                    <div class="detalles-modal-body">
                        <div class="detalles-loading">
                            <div class="spinner"></div>
                            <p>Cargando detalles...</p>
                        </div>
                        <div class="detalles-content" style="display: none;"></div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.modal = document.getElementById('detallesModal');
        console.log('✅ Modal creado:', this.modal);
    }
    
    bindEvents() {
        console.log('🔗 Vinculando eventos...');
        
        // Delegación de eventos para las cards de personaje
        document.addEventListener('click', (e) => {
            console.log('🖱️ Click detectado en:', e.target);
            
            const characterCard = e.target.closest('.character-card');
            console.log('🔍 Card encontrada:', characterCard);
            
            if (characterCard && !this.isLoading) {
                e.preventDefault();
                e.stopPropagation();
                
                const personajeId = characterCard.dataset.id;
                console.log('🎯 ID del personaje:', personajeId);
                
                if (personajeId) {
                    console.log('🚀 Abriendo modal para personaje ID:', personajeId);
                    this.open(personajeId, characterCard);
                } else {
                    console.error('❌ Card no tiene data-id');
                }
            }
        });
        
        // Eventos del modal
        this.modal.querySelector('.detalles-modal-overlay').addEventListener('click', () => {
            console.log('👆 Click en overlay - cerrando modal');
            this.close();
        });
        
        this.modal.querySelector('.detalles-modal-close').addEventListener('click', () => {
            console.log('❌ Click en botón cerrar - cerrando modal');
            this.close();
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.style.display === 'flex') {
                console.log('ESC presionado - cerrando modal');
                this.close();
            }
        });
    }
    
    async open(personajeId, characterCard) {
        console.log('📂 Abriendo modal para personaje:', personajeId);
        
        this.currentPersonajeId = personajeId;
        this.currentPersonajeNombre = characterCard.querySelector('.character-name').textContent;
        console.log('📝 Nombre del personaje:', this.currentPersonajeNombre);
        
        // Mostrar modal inmediatamente con información básica
        this.showBasicInfo(characterCard);
        this.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('🪟 Modal mostrado');
        
        // Cargar datos detallados
        console.log('📡 Solicitando datos a la API...');
        await this.loadDetallesReal(personajeId);
    }
    
    async loadDetallesReal(personajeId) {
        if (this.isLoading) {
            console.log('⏳ Ya está cargando, ignorando...');
            return;
        }
        
        this.isLoading = true;
        console.log('🔄 Iniciando carga de detalles...');
        
        try {
            console.log(`🌐 Fetching: detalles-personaje-data.php?id=${personajeId}`);
            const response = await fetch(`detalles-personaje-data.php?id=${personajeId}`);
            
            console.log('📊 Respuesta HTTP:', response.status, response.statusText);
            
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`);
            }
            
            const data = await response.json();
            console.log('📦 Datos recibidos:', data);
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            if (data.success) {
                console.log('✅ Datos cargados correctamente');
                this.detallesCompletos = data;
                this.comentarios = data.comentarios || [];
                
                this.renderDetallesCompletos(data);
            } else {
                throw new Error('La respuesta no indica éxito');
            }
            
        } catch (error) {
            console.error('❌ Error cargando detalles:', error);
            console.error('Stack:', error.stack);
            this.showError(error.message);
        } finally {
            this.isLoading = false;
            console.log('🏁 Carga finalizada');
        }
    }
    
    // ... resto del código igual ...
    
    showBasicInfo(characterCard) {
        const nombre = characterCard.querySelector('.character-name').textContent;
        const imagen = characterCard.querySelector('.character-image').src;
        const descripcion = characterCard.querySelector('.character-desc').textContent;
        const rareza = characterCard.dataset.rareza;
        const ruta = characterCard.dataset.ruta;
        const elemento = characterCard.dataset.elemento;
        
        this.modal.querySelector('#modalPersonajeNombre').textContent = nombre;
        
        const basicInfoHTML = `
            <div class="detalles-basic-info">
                <div class="detalles-character-image">
                    <img src="${imagen}" alt="${nombre}" 
                         onerror="this.src='https://via.placeholder.com/300x400/1a1a2e/667eea?text=Imagen+no+disponible'">
                    <div class="detalles-character-badges">
                        <span class="badge rareza ${rareza.includes('5') ? 'gold' : 'purple'}">
                            ${rareza}
                        </span>
                        <span class="badge ruta">${ruta}</span>
                        <span class="badge elemento">${elemento}</span>
                    </div>
                </div>
                <div class="detalles-character-desc">
                    <h3>Descripción</h3>
                    <p>${this.escapeHtml(descripcion)}</p>
                </div>
            </div>
        `;
        
        const contentDiv = this.modal.querySelector('.detalles-content');
        contentDiv.innerHTML = basicInfoHTML;
        contentDiv.style.display = 'none';
        this.modal.querySelector('.detalles-loading').style.display = 'flex';
    }
    
    async loadDetallesReal(personajeId) {
        if (this.isLoading) return;
        
        this.isLoading = true;
        
        try {
            const response = await fetch(`detalles-personaje-data.php?id=${personajeId}`);
            
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            this.detallesCompletos = data;
            this.comentarios = data.comentarios || [];
            
            this.renderDetallesCompletos(data);
            
        } catch (error) {
            console.error('Error cargando detalles:', error);
            this.showError(error.message);
        } finally {
            this.isLoading = false;
        }
    }
    
    renderDetallesCompletos(data) {
        const personaje = data.personaje;
        const detalles = data.detalles;
        const totalComentarios = this.comentarios.length;
        
        const tabsHTML = `
            <div class="detalles-tabs">
                <div class="detalles-tabs-nav">
                    <button class="tab-btn active" data-tab="habilidades">
                        <i class="fas fa-fire"></i> Habilidades
                    </button>
                    <button class="tab-btn" data-tab="estadisticas">
                        <i class="fas fa-chart-bar"></i> Estadísticas
                    </button>
                    <button class="tab-btn" data-tab="artefactos">
                        <i class="fas fa-gem"></i> Artefactos
                    </button>
                    <button class="tab-btn" data-tab="conos">
                        <i class="fas fa-cube"></i> Conos de Luz
                    </button>
                    <button class="tab-btn" data-tab="trazas">
                        <i class="fas fa-star"></i> Trazas
                    </button>
                    <button class="tab-btn" data-tab="sinergias">
                        <i class="fas fa-users"></i> Sinergias
                    </button>
                    <button class="tab-btn" data-tab="reviews">
                        <i class="fas fa-star"></i> Reviews
                    </button>
                    <button class="tab-btn" data-tab="comentarios">
                        <i class="fas fa-comments"></i> Comentarios 
                        <span class="comments-count">${totalComentarios}</span>
                    </button>
                </div>
                
                <div class="detalles-tabs-content">
                    <div class="tab-pane active" id="habilidades">
                        ${this.renderHabilidades(detalles.habilidades)}
                    </div>
                    
                    <div class="tab-pane" id="estadisticas">
                        ${this.renderEstadisticas(detalles.estadisticas)}
                    </div>
                    
                    <div class="tab-pane" id="artefactos">
                        ${this.renderArtefactos(detalles.artefactos)}
                    </div>
                    
                    <div class="tab-pane" id="conos">
                        ${this.renderConosLuz(detalles.conos_luz)}
                    </div>
                    
                    <div class="tab-pane" id="trazas">
                        ${this.renderTrazas(detalles.trazas)}
                    </div>
                    
                    <div class="tab-pane" id="sinergias">
                        ${this.renderSinergias(detalles.sinergias)}
                    </div>
                    
                    <div class="tab-pane" id="reviews">
                        ${this.renderReviews(detalles.reviews)}
                    </div>
                    
                    <div class="tab-pane" id="comentarios">
                        ${this.renderComentarios()}
                    </div>
                </div>
            </div>
        `;
        
        const contentDiv = this.modal.querySelector('.detalles-content');
        contentDiv.insertAdjacentHTML('beforeend', tabsHTML);
        
        this.modal.querySelector('.detalles-loading').style.display = 'none';
        contentDiv.style.display = 'block';
        
        this.initTabs();
        this.initComentarios();
    }
    
    renderHabilidades(habilidades) {
        if (!habilidades || habilidades.length === 0) {
            return '<div class="no-data"><p>No hay información de habilidades disponible.</p></div>';
        }
        
        return `
            <h3>Habilidades</h3>
            <div class="habilidades-grid">
                ${habilidades.map(habilidad => `
                    <div class="habilidad-card" data-tipo="${habilidad.tipo}">
                        <div class="habilidad-header">
                            <span class="habilidad-nombre">${this.escapeHtml(habilidad.nombre)}</span>
                            <span class="habilidad-tipo">${habilidad.tipo}</span>
                        </div>
                        <div class="habilidad-desc">${this.escapeHtml(habilidad.descripcion)}</div>
                        ${habilidad.nivel_max ? `
                            <div class="habilidad-nivel">Nivel Máx: ${habilidad.nivel_max}</div>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderEstadisticas(estadisticas) {
        if (!estadisticas) {
            return '<div class="no-data"><p>No hay estadísticas disponibles.</p></div>';
        }
        
        return `
            <h3>Estadísticas</h3>
            <div class="estadisticas-info">
                <div class="estadisticas-nivel">Nivel ${estadisticas.nivel || 80}</div>
                <div class="estadisticas-grid">
                    ${estadisticas.ataque_base ? `
                        <div class="estadistica-item">
                            <span class="estadistica-label">Ataque Base</span>
                            <span class="estadistica-value">${estadisticas.ataque_base}</span>
                        </div>
                    ` : ''}
                    ${estadisticas.defensa_base ? `
                        <div class="estadistica-item">
                            <span class="estadistica-label">Defensa Base</span>
                            <span class="estadistica-value">${estadisticas.defensa_base}</span>
                        </div>
                    ` : ''}
                    ${estadisticas.vida_base ? `
                        <div class="estadistica-item">
                            <span class="estadistica-label">Vida Base</span>
                            <span class="estadistica-value">${estadisticas.vida_base}</span>
                        </div>
                    ` : ''}
                    ${estadisticas.velocidad_base ? `
                        <div class="estadistica-item">
                            <span class="estadistica-label">Velocidad</span>
                            <span class="estadistica-value">${estadisticas.velocidad_base}</span>
                        </div>
                    ` : ''}
                    ${estadisticas.probabilidad_critica ? `
                        <div class="estadistica-item">
                            <span class="estadistica-label">Prob. Crítica</span>
                            <span class="estadistica-value">${estadisticas.probabilidad_critica}%</span>
                        </div>
                    ` : ''}
                    ${estadisticas.danio_critico ? `
                        <div class="estadistica-item">
                            <span class="estadistica-label">Daño Crítico</span>
                            <span class="estadistica-value">${estadisticas.danio_critico}%</span>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    }
    
    renderArtefactos(artefactos) {
        if (!artefactos || artefactos.length === 0) {
            return '<div class="no-data"><p>No hay artefactos recomendados disponibles.</p></div>';
        }
        
        return `
            <h3>Artefactos Recomendados</h3>
            <div class="artefactos-list">
                ${artefactos.map(artefacto => `
                    <div class="artefacto-card ${artefacto.prioridad ? artefacto.prioridad.toLowerCase() : ''}">
                        <div class="artefacto-header">
                            <span class="artefacto-nombre">${this.escapeHtml(artefacto.nombre)}</span>
                            ${artefacto.prioridad ? `
                                <span class="artefacto-prioridad ${artefacto.prioridad.toLowerCase()}">
                                    ${artefacto.prioridad}
                                </span>
                            ` : ''}
                        </div>
                        <div class="artefacto-info">
                            <span class="artefacto-tipo">${artefacto.tipo}</span>
                            ${artefacto.conjunto ? `
                                <span class="artefacto-conjunto">${artefacto.conjunto}</span>
                            ` : ''}
                        </div>
                        ${artefacto.estadistica_principal ? `
                            <div class="artefacto-stats">
                                <strong>Principal:</strong> ${artefacto.estadistica_principal}
                            </div>
                        ` : ''}
                        ${artefacto.estadisticas_secundarias ? `
                            <div class="artefacto-stats">
                                <strong>Secundarias:</strong> ${artefacto.estadisticas_secundarias}
                            </div>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderConosLuz(conos) {
        if (!conos || conos.length === 0) {
            return '<div class="no-data"><p>No hay conos de luz recomendados disponibles.</p></div>';
        }
        
        return `
            <h3>Conos de Luz Recomendados</h3>
            <div class="conos-grid">
                ${conos.map(cono => `
                    <div class="cono-card ${cono.prioridad ? cono.prioridad.toLowerCase() : ''}">
                        <div class="cono-header">
                            <span class="cono-nombre">${this.escapeHtml(cono.nombre)}</span>
                            <span class="cono-rareza ${this.getRarezaClass(cono.rareza)}">
                                ${cono.rareza}
                            </span>
                        </div>
                        <div class="cono-desc">${this.escapeHtml(cono.descripcion)}</div>
                        ${cono.razon ? `
                            <div class="cono-razon">
                                <strong>Razón:</strong> ${this.escapeHtml(cono.razon)}
                            </div>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderTrazas(trazas) {
        if (!trazas || trazas.length === 0) {
            return '<div class="no-data"><p>No hay trazas disponibles.</p></div>';
        }
        
        return `
            <h3>Trazas del Personaje</h3>
            <div class="trazas-grid">
                ${trazas.map(traza => `
                    <div class="traza-card traza-${traza.tipo.toLowerCase().replace(' ', '-')}">
                        <div class="traza-header">
                            <span class="traza-nombre">${this.escapeHtml(traza.nombre)}</span>
                            <span class="traza-tipo">${traza.tipo}</span>
                        </div>
                        <div class="traza-desc">${this.escapeHtml(traza.descripcion)}</div>
                        ${traza.efecto ? `
                            <div class="traza-efecto"><strong>Efecto:</strong> ${this.escapeHtml(traza.efecto)}</div>
                        ` : ''}
                        ${traza.nivel_desbloqueo ? `
                            <div class="traza-nivel">Nivel ${traza.nivel_desbloqueo}+</div>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderSinergias(sinergias) {
        if (!sinergias || sinergias.length === 0) {
            return '<div class="no-data"><p>No hay sinergias disponibles.</p></div>';
        }
        
        return `
            <h3>Sinergias de Equipo</h3>
            <div class="sinergias-grid">
                ${sinergias.map(sinergia => `
                    <div class="sinergia-card nivel-${sinergia.nivel_recomendacion.toLowerCase()}">
                        <div class="sinergia-header">
                            <span class="sinergia-personaje">${this.escapeHtml(sinergia.personaje_sinergia)}</span>
                            <span class="sinergia-rol ${sinergia.rol_sinergia.toLowerCase()}">
                                ${sinergia.rol_sinergia}
                            </span>
                        </div>
                        <div class="sinergia-razon">${this.escapeHtml(sinergia.razon)}</div>
                        <div class="sinergia-recomendacion">
                            <span class="nivel-${sinergia.nivel_recomendacion.toLowerCase()}">
                                Tier ${sinergia.nivel_recomendacion}
                            </span>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderReviews(reviews) {
        if (!reviews || reviews.length === 0) {
            return '<div class="no-data"><p>No hay reviews disponibles.</p></div>';
        }
        
        return `
            <h3>Análisis y Reviews</h3>
            <div class="reviews-list">
                ${reviews.map(review => `
                    <div class="review-card">
                        <div class="review-header">
                            <h4 class="review-titulo">${this.escapeHtml(review.titulo)}</h4>
                            <div class="review-metadata">
                                <span class="review-autor">${this.escapeHtml(review.autor || 'Admin')}</span>
                                <span class="review-fecha">${this.formatFecha(review.fecha_publicacion)}</span>
                            </div>
                        </div>
                        <div class="review-contenido">${this.escapeHtml(review.contenido)}</div>
                        ${review.rating_overall ? `
                            <div class="review-rating">
                                <strong>Rating general:</strong> ${this.renderStars(review.rating_overall)}
                            </div>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderComentarios() {
        if (this.comentarios.length === 0) {
            return `
                <h3>Comentarios de la Comunidad</h3>
                <div class="no-comments">
                    <p><i class="fas fa-comment-slash"></i> No hay comentarios aún. ¡Sé el primero en comentar!</p>
                    ${this.renderFormularioComentario()}
                </div>
            `;
        }
        
        return `
            <h3>Comentarios de la Comunidad</h3>
            <div class="comentarios-section">
                ${this.renderFormularioComentario()}
                <div class="comentarios-list">
                    ${this.comentarios.map(comentario => this.renderComentarioItem(comentario)).join('')}
                </div>
            </div>
        `;
    }
    
    renderFormularioComentario() {
        // Solo mostrar formulario si el usuario está logueado
        if (!window.currentUserId) {
            return `
                <div class="login-required">
                    <p><i class="fas fa-lock"></i> Debes iniciar sesión para comentar.</p>
                </div>
            `;
        }
        
        return `
            <div class="add-comment-form">
                <textarea id="nuevoComentario" 
                          placeholder="Escribe tu comentario sobre ${this.currentPersonajeNombre}..." 
                          maxlength="500"></textarea>
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
        const fechaFormateada = this.formatFecha(comentario.fecha_creacion);
        const esPropietario = comentario.id_usuario == window.currentUserId;
        
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
    
    // Métodos auxiliares
    getRarezaClass(rareza) {
        if (rareza.includes('5')) return 'cinco-estrellas';
        if (rareza.includes('4')) return 'cuatro-estrellas';
        return 'tres-estrellas';
    }
    
    renderStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += `<i class="fas fa-star ${i <= rating ? 'active' : ''}"></i>`;
        }
        return `<div class="stars">${stars}</div>`;
    }
    
    formatFecha(fechaString) {
        try {
            const fecha = new Date(fechaString);
            return fecha.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (e) {
            return fechaString;
        }
    }
    
    escapeHtml(text) {
        if (!text) return '';
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
                
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));
                
                btn.classList.add('active');
                this.modal.querySelector(`#${tabId}`).classList.add('active');
            });
        });
    }
    
    initComentarios() {
        const textarea = this.modal.querySelector('#nuevoComentario');
        const charCount = this.modal.querySelector('#charCount');
        
        if (textarea && charCount) {
            textarea.addEventListener('input', () => {
                const length = textarea.value.length;
                charCount.textContent = `${length}/500`;
                charCount.style.color = length > 450 ? '#ff9800' : '#aaa';
            });
            
            const enviarBtn = this.modal.querySelector('#enviarComentario');
            if (enviarBtn) {
                enviarBtn.addEventListener('click', () => this.agregarComentario());
            }
            
            // También enviar con Ctrl+Enter
            textarea.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.key === 'Enter') {
                    this.agregarComentario();
                }
            });
        }
        
        this.modal.querySelectorAll('.btn-eliminar-comentario').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = e.target.closest('.btn-eliminar-comentario').dataset.id;
                if (confirm('¿Eliminar este comentario?')) {
                    this.eliminarComentario(id);
                }
            });
        });
    }
    
    async agregarComentario() {
        const textarea = this.modal.querySelector('#nuevoComentario');
        const contenido = textarea.value.trim();
        
        if (!contenido) {
            alert('El comentario no puede estar vacío');
            return;
        }
        
        if (!window.currentUserId) {
            alert('Debes iniciar sesión para comentar');
            return;
        }
        
        try {
            const formData = new FormData();
            formData.append('personaje_id', this.currentPersonajeId);
            formData.append('contenido', contenido);
            
            const response = await fetch('guardar-comentario.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Recargar comentarios
                await this.loadDetallesReal(this.currentPersonajeId);
                
                // Limpiar textarea
                textarea.value = '';
                if (this.modal.querySelector('#charCount')) {
                    this.modal.querySelector('#charCount').textContent = '0/500';
                }
                
                this.mostrarMensaje('Comentario publicado correctamente', 'success');
            } else {
                alert(result.error || 'Error al publicar comentario');
            }
            
        } catch (error) {
            console.error('Error:', error);
            alert('Error al publicar el comentario');
        }
    }
    
    async eliminarComentario(id) {
        if (!confirm('¿Eliminar este comentario?')) return;
        
        try {
            const formData = new FormData();
            formData.append('comentario_id', id);
            
            const response = await fetch('eliminar-comentario.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Recargar comentarios
                await this.loadDetallesReal(this.currentPersonajeId);
                this.mostrarMensaje('Comentario eliminado', 'success');
            } else {
                alert(result.error || 'Error al eliminar comentario');
            }
            
        } catch (error) {
            console.error('Error:', error);
            alert('Error al eliminar el comentario');
        }
    }
    
    showError(mensaje) {
        const contentDiv = this.modal.querySelector('.detalles-content');
        contentDiv.innerHTML = `
            <div class="detalles-error">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Error al cargar detalles</h3>
                <p>${mensaje || 'No se pudieron cargar los detalles del personaje.'}</p>
                <button class="btn-retry">Reintentar</button>
            </div>
        `;
        
        this.modal.querySelector('.detalles-loading').style.display = 'none';
        contentDiv.style.display = 'block';
        
        contentDiv.querySelector('.btn-retry').addEventListener('click', () => {
            this.loadDetallesReal(this.currentPersonajeId);
        });
    }
    
    mostrarMensaje(texto, tipo = 'info') {
        const mensaje = document.createElement('div');
        mensaje.className = `mensaje-flotante ${tipo}`;
        mensaje.innerHTML = `
            <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'info-circle'}"></i>
            <span>${texto}</span>
        `;
        
        document.body.appendChild(mensaje);
        
        setTimeout(() => {
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.remove(), 300);
        }, 3000);
    }
    
    close() {
        this.modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        const contentDiv = this.modal.querySelector('.detalles-content');
        contentDiv.innerHTML = '';
        contentDiv.style.display = 'none';
        this.modal.querySelector('.detalles-loading').style.display = 'flex';
        this.comentarios = [];
        this.detallesCompletos = null;
        this.currentPersonajeId = null;
        this.currentPersonajeNombre = null;
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    // Verificar si estamos en la página de personajes
    if (document.querySelector('.character-card')) {
        window.detallesPersonaje = new DetallesPersonaje();
    }
});
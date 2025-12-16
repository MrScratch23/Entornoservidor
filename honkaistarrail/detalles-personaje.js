/**
 * Archivo: detalles-personaje.js
 * Manejo del modal de detalles de personajes con sistema de notificaciones flash
 * VERSIÓN COMPLETA CON IMÁGENES
 */

// ============================================
// SISTEMA DE NOTIFICACIONES FLASH
// ============================================
const FlashNotifications = {
    container: null,
    
    init() {
        if (!document.querySelector('.mensaje-flotante-container')) {
            this.container = document.createElement('div');
            this.container.className = 'mensaje-flotante-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.querySelector('.mensaje-flotante-container');
        }
    },
    
    show(type, title, message, duration = 5000) {
        if (!this.container) this.init();
        
        const notification = document.createElement('div');
        notification.className = `mensaje-flotante ${type}`;
        
        const iconMap = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-exclamation-circle"></i>',
            info: '<i class="fas fa-info-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>'
        };
        
        notification.innerHTML = `
            ${iconMap[type] || '<i class="fas fa-info-circle"></i>'}
            <div class="notification-content">
                <strong>${title}</strong>
                <p>${message}</p>
            </div>
            <button class="notification-close">&times;</button>
        `;
        
        this.container.appendChild(notification);
        
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => this.hide(notification));
        
        if (duration > 0) {
            setTimeout(() => this.hide(notification), duration);
        }
        
        return notification;
    },
    
    confirm(title, message) {
        return new Promise((resolve) => {
            if (!this.container) this.init();
            
            const notification = document.createElement('div');
            notification.className = 'mensaje-flotante confirm';
            
            notification.innerHTML = `
                <i class="fas fa-question-circle"></i>
                <div class="notification-content">
                    <strong>${title}</strong>
                    <p>${message}</p>
                    <div class="confirm-buttons">
                        <button class="btn-confirm btn-success">
                            <i class="fas fa-check"></i> Sí, eliminar
                        </button>
                        <button class="btn-cancel btn-danger">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </div>
            `;
            
            this.container.appendChild(notification);
            
            const confirmBtn = notification.querySelector('.btn-confirm');
            const cancelBtn = notification.querySelector('.btn-cancel');
            
            const cleanup = () => {
                confirmBtn.removeEventListener('click', onConfirm);
                cancelBtn.removeEventListener('click', onCancel);
                this.hide(notification);
            };
            
            const onConfirm = () => {
                cleanup();
                resolve(true);
            };
            
            const onCancel = () => {
                cleanup();
                resolve(false);
            };
            
            confirmBtn.addEventListener('click', onConfirm);
            cancelBtn.addEventListener('click', onCancel);
        });
    },
    
    hide(notification) {
        notification.style.animation = 'slideOut 0.3s ease-out forwards';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    },
    
    success(title, message, duration = 5000) {
        return this.show('success', title, message, duration);
    },
    
    error(title, message, duration = 7000) {
        return this.show('error', title, message, duration);
    },
    
    info(title, message, duration = 5000) {
        return this.show('info', title, message, duration);
    },
    
    warning(title, message, duration = 6000) {
        return this.show('warning', title, message, duration);
    }
};

// ============================================
// CLASE DETALLES PERSONAJE
// ============================================
class DetallesPersonaje {
    constructor() {
        this.modal = null;
        this.currentPersonajeId = null;
        this.currentPersonajeNombre = null;
        this.isLoading = false;
        this.comentarios = [];
        this.detallesCompletos = null;
        this.init();
    }
    
    init() {
        this.createModal();
        this.bindEvents();
    }
    
    createModal() {
        if (document.getElementById('detallesModal')) {
            this.modal = document.getElementById('detallesModal');
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
    }
    
    bindEvents() {
        document.addEventListener('click', (e) => {
            const characterCard = e.target.closest('.character-card');
            
            if (characterCard && !this.isLoading) {
                e.preventDefault();
                e.stopPropagation();
                
                const personajeId = characterCard.dataset.id;
                
                if (personajeId) {
                    this.open(personajeId, characterCard);
                }
            }
        });
        
        this.modal.querySelector('.detalles-modal-overlay').addEventListener('click', () => {
            this.close();
        });
        
        this.modal.querySelector('.detalles-modal-close').addEventListener('click', () => {
            this.close();
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.style.display === 'flex') {
                this.close();
            }
        });
    }
    
    async open(personajeId, characterCard) {
        this.currentPersonajeId = personajeId;
        this.currentPersonajeNombre = characterCard.querySelector('.character-name').textContent;
        
        this.showBasicInfo(characterCard);
        this.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        await this.loadDetallesReal(personajeId);
    }
    
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
                throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`);
            }
            
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            if (data.success) {
                this.detallesCompletos = data;
                this.comentarios = data.comentarios || [];
                this.renderDetallesCompletos(data);
            } else {
                throw new Error('La respuesta no indica éxito');
            }
            
        } catch (error) {
            this.showError(error.message);
        } finally {
            this.isLoading = false;
        }
    }
    
    renderDetallesCompletos(data) {
        const detalles = data.detalles;
        const totalComentarios = this.comentarios.length;
        
        // Primero, verificar qué datos tenemos
        console.log("📊 DETALLES DISPONIBLES:", {
            artefactos: detalles.artefactos,
            conos_luz: detalles.conos_luz
        });
        
        // Verificar estructura de artefactos
        if (detalles.artefactos && detalles.artefactos.length > 0) {
            console.log("🔍 Primer artefacto:", detalles.artefactos[0]);
            console.log("📷 ¿Tiene imagen?", 'imagen_artefacto' in detalles.artefactos[0]);
            console.log("📷 URL de imagen:", detalles.artefactos[0]?.imagen_artefacto);
        }
        
        // Verificar estructura de conos
        if (detalles.conos_luz && detalles.conos_luz.length > 0) {
            console.log("🔍 Primer cono:", detalles.conos_luz[0]);
            console.log("📷 ¿Tiene imagen?", 'imagen_url' in detalles.conos_luz[0]);
            console.log("📷 URL de imagen:", detalles.conos_luz[0]?.imagen_url);
        }
        
        const existingTabs = this.modal.querySelector('.detalles-tabs');
        
        if (existingTabs) {
            this.actualizarPestanaComentarios();
            return;
        }
        
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
        
        const basicInfo = contentDiv.querySelector('.detalles-basic-info');
        if (basicInfo) {
            basicInfo.insertAdjacentHTML('afterend', tabsHTML);
        } else {
            contentDiv.innerHTML = tabsHTML;
        }
        
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
        console.log("🖼️ MÉTODO renderArtefactos EJECUTADO");
        console.log("🖼️ Datos de artefactos:", artefactos);
        
        if (!artefactos || artefactos.length === 0) {
            console.log("🖼️ No hay artefactos");
            return '<div class="no-data"><p>No hay artefactos recomendados disponibles.</p></div>';
        }
        
        // Verificar cada artefacto
        artefactos.forEach((art, i) => {
            console.log(`🖼️ Artefacto ${i}:`, {
                nombre: art.nombre,
                tieneImagenArt: 'imagen_artefacto' in art,
                imagen_artefacto: art.imagen_artefacto,
                propiedades: Object.keys(art)
            });
        });
        
        return `
            <h3>Artefactos Recomendados</h3>
            <div class="artefactos-list">
                ${artefactos.map(artefacto => {
                    console.log("🖼️ Procesando artefacto en template:", artefacto.nombre);
                    console.log("🖼️ URL de imagen:", artefacto.imagen_artefacto);
                    
                    return `
                    <div class="artefacto-card ${artefacto.prioridad ? artefacto.prioridad.toLowerCase() : ''}">
                        <div class="artefacto-header">
                            <div class="artefacto-title-section">
                                ${artefacto.imagen_artefacto ? `
                                    <div class="artefacto-image">
                                        <img src="${artefacto.imagen_artefacto}" 
                                             alt="${this.escapeHtml(artefacto.nombre)}"
                                             onerror="console.log('❌ Error cargando imagen:', this.src); this.src='https://via.placeholder.com/80x80/1a1a2e/667eea?text=Art'"
                                             class="artefacto-img">
                                    </div>
                                ` : `
                                    <div class="artefacto-image">
                                        <img src="https://via.placeholder.com/80x80/1a1a2e/667eea?text=Art" 
                                             alt="${this.escapeHtml(artefacto.nombre)}"
                                             class="artefacto-img">
                                    </div>
                                `}
                                <div class="artefacto-titles">
                                    <span class="artefacto-nombre">${this.escapeHtml(artefacto.nombre)}</span>
                                    <div class="artefacto-info">
                                        <span class="artefacto-tipo">${artefacto.tipo}</span>
                                        ${artefacto.conjunto ? `
                                            <span class="artefacto-conjunto">${artefacto.conjunto}</span>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                            ${artefacto.prioridad ? `
                                <span class="artefacto-prioridad ${artefacto.prioridad.toLowerCase()}">
                                    ${artefacto.prioridad}
                                </span>
                            ` : ''}
                        </div>
                        
                        ${artefacto.estadistica_principal ? `
                            <div class="artefacto-stats">
                                <strong><i class="fas fa-chart-line"></i> Principal:</strong> ${artefacto.estadistica_principal}
                            </div>
                        ` : ''}
                        
                        ${artefacto.estadisticas_secundarias ? `
                            <div class="artefacto-stats">
                                <strong><i class="fas fa-chart-bar"></i> Secundarias:</strong> ${artefacto.estadisticas_secundarias}
                            </div>
                        ` : ''}
                        
                        ${artefacto.descripcion ? `
                            <div class="artefacto-personal-desc">${this.escapeHtml(artefacto.descripcion)}</div>
                        ` : ''}
                    </div>
                    `;
                }).join('')}
            </div>
        `;
    }
    
    renderConosLuz(conos) {
        console.log("🔦 MÉTODO renderConosLuz EJECUTADO");
        console.log("🔦 Datos de conos:", conos);
        
        if (!conos || conos.length === 0) {
            console.log("🔦 No hay conos");
            return '<div class="no-data"><p>No hay conos de luz recomendados disponibles.</p></div>';
        }
        
        // Verificar cada cono
        conos.forEach((cono, i) => {
            console.log(`🔦 Cono ${i}:`, {
                nombre: cono.nombre,
                tieneImagenUrl: 'imagen_url' in cono,
                imagen_url: cono.imagen_url,
                tieneImagenCono: 'imagen_cono' in cono,
                imagen_cono: cono.imagen_cono,
                propiedades: Object.keys(cono)
            });
        });
        
        return `
            <h3>Conos de Luz Recomendados</h3>
            <div class="conos-grid">
                ${conos.map(cono => {
                    console.log("🔦 Procesando cono en template:", cono.nombre);
                    
                    // Intentar obtener la imagen de varias propiedades posibles
                    const imagenUrl = cono.imagen_url || cono.imagen_cono || null;
                    console.log("🔦 URL de imagen final:", imagenUrl);
                    
                    return `
                    <div class="cono-card ${cono.prioridad ? cono.prioridad.toLowerCase() : ''}">
                        <div class="cono-header">
                            ${imagenUrl ? `
                                <div class="cono-image">
                                    <img src="${imagenUrl}" 
                                         alt="${this.escapeHtml(cono.nombre)}"
                                         onerror="console.log('❌ Error cargando imagen de cono:', this.src); this.src='https://via.placeholder.com/80x80/1a1a2e/667eea?text=Cono'"
                                         class="cono-img">
                                </div>
                            ` : `
                                <div class="cono-image">
                                    <img src="https://via.placeholder.com/80x80/1a1a2e/667eea?text=Cono" 
                                         alt="${this.escapeHtml(cono.nombre)}"
                                         class="cono-img">
                                </div>
                            `}
                            <div class="cono-info">
                                <div class="cono-title-section">
                                    <span class="cono-nombre">${this.escapeHtml(cono.nombre)}</span>
                                   
                                </div>
                            </div>
                        </div>
                        
                        <div class="cono-desc">${this.escapeHtml(cono.descripcion)}</div>
                        
                        ${cono.razon ? `
                            <div class="cono-razon">
                                <strong><i class="fas fa-lightbulb"></i> Razón:</strong> ${this.escapeHtml(cono.razon)}
                            </div>
                        ` : ''}
                        
                        ${cono.prioridad ? `
                            <div class="cono-prioridad ${cono.prioridad.toLowerCase()}">
                                <i class="fas fa-${cono.prioridad === 'Óptimo' ? 'crown' : cono.prioridad === 'Alternativa' ? 'check' : 'clock'}"></i>
                                ${cono.prioridad}
                            </div>
                        ` : ''}
                    </div>
                    `;
                }).join('')}
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
    
    // ============================================
    // MÉTODOS AUXILIARES
    // ============================================
    
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
            
            textarea.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.key === 'Enter') {
                    this.agregarComentario();
                }
            });
        }
        
        this.modal.querySelectorAll('.btn-eliminar-comentario').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const id = e.target.closest('.btn-eliminar-comentario').dataset.id;
                
                const confirmacion = await FlashNotifications.confirm(
                    'Eliminar comentario',
                    '¿Estás seguro de que quieres eliminar este comentario? Esta acción no se puede deshacer.'
                );
                
                if (confirmacion) {
                    this.eliminarComentario(id);
                }
            });
        });
    }
    
    async agregarComentario() {
        const textarea = this.modal.querySelector('#nuevoComentario');
        const contenido = textarea.value.trim();
        
        if (!contenido) {
            FlashNotifications.warning(
                'Comentario vacío',
                'El comentario no puede estar vacío'
            );
            return;
        }
        
        if (!window.currentUserId) {
            FlashNotifications.error(
                'Sesión requerida',
                'Debes iniciar sesión para comentar'
            );
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
                await this.actualizarPestanaComentarios();
                
                textarea.value = '';
                if (this.modal.querySelector('#charCount')) {
                    this.modal.querySelector('#charCount').textContent = '0/500';
                }
                
                FlashNotifications.success(
                    'Comentario publicado',
                    'Tu comentario se ha publicado correctamente'
                );
                
            } else {
                FlashNotifications.error(
                    'Error al publicar',
                    result.error || 'Error al publicar comentario'
                );
            }
            
        } catch (error) {
            FlashNotifications.error(
                'Error de conexión',
                'No se pudo publicar el comentario. Intenta nuevamente.'
            );
        }
    }
    
    async actualizarPestanaComentarios() {
        try {
            const response = await fetch(`detalles-personaje-data.php?id=${this.currentPersonajeId}`);
            const data = await response.json();
            
            if (data.success) {
                this.comentarios = data.comentarios || [];
                
                const comentariosTab = this.modal.querySelector('#comentarios');
                if (comentariosTab) {
                    comentariosTab.innerHTML = this.renderComentarios();
                    this.initComentarios();
                    
                    const commentsCount = this.modal.querySelector('.comments-count');
                    if (commentsCount) {
                        commentsCount.textContent = this.comentarios.length;
                    }
                }
            }
        } catch (error) {
            console.error('Error actualizando comentarios:', error);
        }
    }
    
    async eliminarComentario(id) {
        try {
            const formData = new FormData();
            formData.append('comentario_id', id);
            
            const response = await fetch('eliminar-comentario.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                await this.actualizarPestanaComentarios();
                
                FlashNotifications.success(
                    'Comentario eliminado',
                    'El comentario se ha eliminado correctamente'
                );
            } else {
                FlashNotifications.error(
                    'Error al eliminar',
                    result.error || 'Error al eliminar comentario'
                );
            }
            
        } catch (error) {
            FlashNotifications.error(
                'Error de conexión',
                'No se pudo eliminar el comentario. Intenta nuevamente.'
            );
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
        
        FlashNotifications.error(
            'Error de carga',
            'No se pudieron cargar los detalles del personaje'
        );
        
        contentDiv.querySelector('.btn-retry').addEventListener('click', () => {
            this.loadDetallesReal(this.currentPersonajeId);
        });
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

// ============================================
// INICIALIZACIÓN
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    FlashNotifications.init();
    
    if (document.querySelector('.character-card')) {
        console.log('✅ Inicializando DetallesPersonaje...');
        window.detallesPersonaje = new DetallesPersonaje();
        console.log('✅ DetallesPersonaje listo');
    }
});
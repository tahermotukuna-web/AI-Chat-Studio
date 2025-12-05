/**
 * AI Chat Studio - Advanced Theme Management System
 * Comprehensive theming with custom themes, presets, and visual customization
 */

class ThemeManager {
    constructor() {
        this.currentTheme = 'dark';
        this.customThemes = {};
        this.themePresets = this.getThemePresets();
        this.animationsEnabled = true;
        this.highContrast = false;
        this.reducedMotion = false;
        this.colorBlindFriendly = false;
        this.isInitialLoad = true;
        
        this.init();
    }

    init() {
        this.loadThemeSettings();
        this.setupEventListeners();
        this.createThemeCustomizer();
        this.applyTheme(this.currentTheme);
        this.isInitialLoad = false;
    }

    getThemePresets() {
        return {
            dark: {
                name: 'Dark Theme',
                description: 'Visual Studio Code modern dark interface',
                colors: {
                    primary: '#007acc',
                    secondary: '#569cd6',
                    background: '#1e1e1e',
                    surface: '#252526',
                    text: '#cccccc',
                    textSecondary: '#9d9d9d',
                    textMuted: '#6c6c6c'
                }
            },
            light: {
                name: 'Light Theme',
                description: 'Visual Studio Code authentic light interface',
                colors: {
                    primary: '#0078d4',
                    secondary: '#106ebe',
                    background: '#ffffff',
                    surface: '#ffffff',
                    text: '#1e1e1e',
                    textSecondary: '#333333',
                    textMuted: '#666666',
                    borderColor: '#f8f8f8'
                }
            },
            midnight: {
                name: 'Midnight Blue',
                description: 'Deep blue night theme',
                colors: {
                    primary: '#4c51bf',
                    secondary: '#553c9a',
                    background: '#1a202c',
                    surface: '#2d3748',
                    text: '#f7fafc',
                    textSecondary: '#e2e8f0',
                    textMuted: '#a0aec0'
                }
            },
            forest: {
                name: 'Forest Green',
                description: 'Nature-inspired green theme',
                colors: {
                    primary: '#38a169',
                    secondary: '#2f855a',
                    background: '#0f2017',
                    surface: '#1a2e1f',
                    text: '#f0fff4',
                    textSecondary: '#c6f6d5',
                    textMuted: '#9ae6b4'
                }
            },
            sunset: {
                name: 'Sunset Orange',
                description: 'Warm orange sunset theme',
                colors: {
                    primary: '#ed8936',
                    secondary: '#dd6b20',
                    background: '#1c1917',
                    surface: '#292524',
                    text: '#fef7ed',
                    textSecondary: '#fed7aa',
                    textMuted: '#fdba74'
                }
            },
            purple: {
                name: 'Purple Dream',
                description: 'Rich purple theme',
                colors: {
                    primary: '#805ad5',
                    secondary: '#6b46c1',
                    background: '#1a1120',
                    surface: '#2d1b3d',
                    text: '#faf5ff',
                    textSecondary: '#e9d8fd',
                    textMuted: '#d6bcfa'
                }
            },
            ocean: {
                name: 'Ocean Blue',
                description: 'Deep blue ocean theme',
                colors: {
                    primary: '#3182ce',
                    secondary: '#2c5282',
                    background: '#0a0e1a',
                    surface: '#1e293b',
                    text: '#e6fffa',
                    textSecondary: '#b2f5ea',
                    textMuted: '#81e6d9'
                }
            },
            rose: {
                name: 'Rose Pink',
                description: 'Soft pink rose theme',
                colors: {
                    primary: '#e53e3e',
                    secondary: '#c53030',
                    background: '#1a0a0a',
                    surface: '#2d1b1b',
                    text: '#fff5f5',
                    textSecondary: '#fed7d7',
                    textMuted: '#feb2b2'
                }
            },
            matrix: {
                name: 'Matrix Green',
                description: 'Neo-inspired green theme',
                colors: {
                    primary: '#00ff41',
                    secondary: '#00cc33',
                    background: '#000000',
                    surface: '#001100',
                    text: '#00ff41',
                    textSecondary: '#00cc33',
                    textMuted: '#009900'
                }
            }
        };
    }

    loadThemeSettings() {
        // Load current theme
        this.currentTheme = localStorage.getItem('selectedTheme') || 'dark';
        
        // Load custom themes
        const savedThemes = localStorage.getItem('customThemes');
        if (savedThemes) {
            try {
                this.customThemes = JSON.parse(savedThemes);
            } catch (e) {
                console.error('Error loading custom themes:', e);
                this.customThemes = {};
            }
        }

        // Load accessibility settings
        this.animationsEnabled = localStorage.getItem('animationsEnabled') !== 'false';
        this.highContrast = localStorage.getItem('highContrast') === 'true';
        this.reducedMotion = localStorage.getItem('reducedMotion') === 'true';
        this.colorBlindFriendly = localStorage.getItem('colorBlindFriendly') === 'true';
    }

    setupEventListeners() {
        // Theme toggle button
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => this.toggleTheme());
        }

        // Theme selector dropdown
        const themeSelect = document.getElementById('themeSelect');
        if (themeSelect) {
            themeSelect.addEventListener('change', (e) => {
                this.applyTheme(e.target.value);
            });
        }

        // Settings modal theme options
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('theme-option')) {
                const theme = e.target.dataset.theme;
                this.applyTheme(theme);
            }
        });

        // Accessibility controls
        const accessibilityToggle = document.getElementById('accessibilityToggle');
        if (accessibilityToggle) {
            accessibilityToggle.addEventListener('click', () => this.openAccessibilitySettings());
        }
    }

    applyTheme(themeName) {
        const theme = this.getTheme(themeName);
        if (!theme) return;

        this.currentTheme = themeName;
        localStorage.setItem('selectedTheme', themeName);

        // Apply CSS custom properties
        const root = document.documentElement;
        
        // Apply theme colors - map to expected CSS variable names
        const colorMapping = {
            'primary': '--primary-color',
            'secondary': '--secondary-color',
            'background': '--background',
            'surface': '--surface',
            'text': '--text',
            'textSecondary': '--text-secondary',
            'textMuted': '--text-muted',
            'borderColor': '--border-color'
        };
        
        Object.entries(theme.colors).forEach(([key, value]) => {
            const cssVar = colorMapping[key] || `--theme-${key}`;
            root.style.setProperty(cssVar, value);
        });

        // Apply special theme classes and data attribute
        document.body.className = document.body.className.replace(/theme-\w+/g, '');
        document.body.classList.add(`theme-${themeName}`);
        
        // Set data-theme attribute for CSS selectors
        document.documentElement.setAttribute('data-theme', themeName);

        // Apply accessibility modifications
        if (this.highContrast) {
            this.applyHighContrast();
        }
        
        if (this.colorBlindFriendly) {
            this.applyColorBlindFriendly();
        }

        // Update theme selector
        const themeSelect = document.getElementById('themeSelect');
        if (themeSelect) {
            themeSelect.value = themeName;
        }

        // Update theme toggle icon
        this.updateThemeToggleIcon();

        // Dispatch theme change event
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: themeName, themeData: theme }
        }));

        // Show toast notification only when user manually changes theme
        if (!this.isInitialLoad && window.app) {
            window.app.showToast(`Applied ${theme.name} theme`, 'info');
        }
    }

    getTheme(themeName) {
        // Check custom themes first
        if (this.customThemes[themeName]) {
            return this.customThemes[themeName];
        }
        
        // Check preset themes
        return this.themePresets[themeName];
    }

    toggleTheme() {
        const themes = Object.keys(this.themePresets).concat(Object.keys(this.customThemes));
        const currentIndex = themes.indexOf(this.currentTheme);
        const nextIndex = (currentIndex + 1) % themes.length;
        const nextTheme = themes[nextIndex];
        
        this.applyTheme(nextTheme);
    }

    updateThemeToggleIcon() {
        const toggle = document.getElementById('themeToggle');
        if (toggle) {
            const isDark = ['dark', 'midnight', 'matrix'].includes(this.currentTheme);
            toggle.textContent = isDark ? '☀️' : '🌙';
            toggle.title = isDark ? 'Switch to light theme' : 'Switch to dark theme';
        }
    }

    // High contrast mode
    applyHighContrast() {
        const root = document.documentElement;
        root.style.setProperty('--text', '#000000');
        root.style.setProperty('--background', '#ffffff');
        root.style.setProperty('--surface', '#ffffff');
        root.style.setProperty('--primary-color', '#0000ff');
        root.style.setProperty('--secondary-color', '#000080');
        
        // Increase border widths
        root.style.setProperty('--border-width', '2px');
    }

    // Color blind friendly mode
    applyColorBlindFriendly() {
        const root = document.documentElement;
        // Use colorblind-safe color palette
        root.style.setProperty('--primary-color', '#0173b2');
        root.style.setProperty('--secondary-color', '#de8f05');
        root.style.setProperty('--success-color', '#029e73');
        root.style.setProperty('--error-color', '#cc78bc');
        root.style.setProperty('--warning-color', '#ca9161');
    }

    // Theme Customizer
    createThemeCustomizer() {
        // Create theme customizer modal if it doesn't exist
        if (!document.getElementById('themeCustomizer')) {
            this.createThemeCustomizerModal();
        }
    }

    createThemeCustomizerModal() {
        const modal = document.createElement('div');
        modal.id = 'themeCustomizer';
        modal.className = 'modal';
        modal.style.display = 'none';
        
        modal.innerHTML = `
            <div class="modal-content theme-customizer">
                <div class="modal-header">
                    <h3>Theme Customizer</h3>
                    <button class="modal-close" onclick="themeManager.closeThemeCustomizer()">×</button>
                </div>
                <div class="modal-body">
                    <div class="theme-customizer-content">
                        <div class="theme-tabs">
                            <button class="tab-btn active" data-tab="presets">Presets</button>
                            <button class="tab-btn" data-tab="custom">Custom</button>
                            <button class="tab-btn" data-tab="accessibility">Accessibility</button>
                        </div>

                        <div class="tab-content">
                            <div class="tab-panel active" id="presets-tab">
                                <div class="theme-grid">
                                    ${this.generatePresetThemesHTML()}
                                </div>
                            </div>

                            <div class="tab-panel" id="custom-tab">
                                <div class="custom-theme-controls">
                                    <div class="color-section">
                                        <h4>Primary Colors</h4>
                                        <div class="color-controls">
                                            <div class="color-control">
                                                <label>Primary Color</label>
                                                <input type="color" id="primaryColor" value="#3b82f6">
                                                <input type="text" id="primaryColorText" value="#3b82f6">
                                            </div>
                                            <div class="color-control">
                                                <label>Secondary Color</label>
                                                <input type="color" id="secondaryColor" value="#6366f1">
                                                <input type="text" id="secondaryColorText" value="#6366f1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="color-section">
                                        <h4>Background Colors</h4>
                                        <div class="color-controls">
                                            <div class="color-control">
                                                <label>Background</label>
                                                <input type="color" id="backgroundColor" value="#ffffff">
                                                <input type="text" id="backgroundColorText" value="#ffffff">
                                            </div>
                                            <div class="color-control">
                                                <label>Surface</label>
                                                <input type="color" id="surfaceColor" value="#f8fafc">
                                                <input type="text" id="surfaceColorText" value="#f8fafc">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="color-section">
                                        <h4>Text Colors</h4>
                                        <div class="color-controls">
                                            <div class="color-control">
                                                <label>Primary Text</label>
                                                <input type="color" id="textColor" value="#1f2937">
                                                <input type="text" id="textColorText" value="#1f2937">
                                            </div>
                                            <div class="color-control">
                                                <label>Secondary Text</label>
                                                <input type="color" id="textSecondaryColor" value="#4b5563">
                                                <input type="text" id="textSecondaryColorText" value="#4b5563">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="custom-theme-actions">
                                        <button class="btn-secondary" onclick="themeManager.resetCustomTheme()">Reset</button>
                                        <button class="btn-primary" onclick="themeManager.saveCustomTheme()">Save Custom Theme</button>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-panel" id="accessibility-tab">
                                <div class="accessibility-controls">
                                    <div class="accessibility-option">
                                        <label class="toggle-option">
                                            <input type="checkbox" id="highContrast" ${this.highContrast ? 'checked' : ''}>
                                            <span class="toggle-slider"></span>
                                            <div class="toggle-content">
                                                <strong>High Contrast</strong>
                                                <small>Enhances color contrast for better readability</small>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="accessibility-option">
                                        <label class="toggle-option">
                                            <input type="checkbox" id="colorBlindFriendly" ${this.colorBlindFriendly ? 'checked' : ''}>
                                            <span class="toggle-slider"></span>
                                            <div class="toggle-content">
                                                <strong>Color Blind Friendly</strong>
                                                <small>Uses colors that work for all types of color blindness</small>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="accessibility-option">
                                        <label class="toggle-option">
                                            <input type="checkbox" id="reduceMotion" ${this.reducedMotion ? 'checked' : ''}>
                                            <span class="toggle-slider"></span>
                                            <div class="toggle-content">
                                                <strong>Reduce Motion</strong>
                                                <small>Minimizes animations and transitions</small>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="accessibility-option">
                                        <label class="toggle-option">
                                            <input type="checkbox" id="animationsEnabled" ${this.animationsEnabled ? 'checked' : ''}>
                                            <span class="toggle-slider"></span>
                                            <div class="toggle-content">
                                                <strong>Enable Animations</strong>
                                                <small>Turn on smooth transitions and micro-interactions</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" onclick="themeManager.closeThemeCustomizer()">Close</button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        this.setupThemeCustomizerEvents();
    }

    generatePresetThemesHTML() {
        let html = '';
        
        // Built-in themes
        Object.entries(this.themePresets).forEach(([key, theme]) => {
            html += `
                <div class="theme-preset ${this.currentTheme === key ? 'active' : ''}" data-theme="${key}">
                    <div class="theme-preview">
                        <div class="color-preview" style="background: ${theme.colors.primary};"></div>
                        <div class="color-preview" style="background: ${theme.colors.secondary};"></div>
                        <div class="color-preview" style="background: ${theme.colors.background};"></div>
                        <div class="color-preview" style="background: ${theme.colors.surface};"></div>
                    </div>
                    <div class="theme-info">
                        <h4>${theme.name}</h4>
                        <p>${theme.description}</p>
                    </div>
                </div>
            `;
        });

        // Custom themes
        Object.entries(this.customThemes).forEach(([key, theme]) => {
            html += `
                <div class="theme-preset custom ${this.currentTheme === key ? 'active' : ''}" data-theme="${key}">
                    <div class="theme-preview">
                        <div class="color-preview" style="background: ${theme.colors.primary};"></div>
                        <div class="color-preview" style="background: ${theme.colors.secondary};"></div>
                        <div class="color-preview" style="background: ${theme.colors.background};"></div>
                        <div class="color-preview" style="background: ${theme.colors.surface};"></div>
                    </div>
                    <div class="theme-info">
                        <h4>${theme.name}</h4>
                        <p>${theme.description}</p>
                        <button class="btn-delete-theme" onclick="themeManager.deleteCustomTheme('${key}')">🗑️</button>
                    </div>
                </div>
            `;
        });

        return html;
    }

    setupThemeCustomizerEvents() {
        // Tab switching
        document.querySelectorAll('.theme-customizer .tab-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const tab = e.target.dataset.tab;
                this.switchThemeCustomizerTab(tab);
            });
        });

        // Color controls sync
        const colorInputs = ['primaryColor', 'secondaryColor', 'backgroundColor', 'surfaceColor', 'textColor', 'textSecondaryColor'];
        colorInputs.forEach(id => {
            const colorInput = document.getElementById(id);
            const textInput = document.getElementById(id + 'Text');
            
            if (colorInput && textInput) {
                colorInput.addEventListener('input', (e) => {
                    textInput.value = e.target.value;
                    this.previewCustomColors();
                });
                
                textInput.addEventListener('change', (e) => {
                    if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
                        colorInput.value = e.target.value;
                        this.previewCustomColors();
                    }
                });
            }
        });

        // Accessibility controls
        document.getElementById('highContrast')?.addEventListener('change', (e) => {
            this.highContrast = e.target.checked;
            localStorage.setItem('highContrast', this.highContrast);
            this.applyTheme(this.currentTheme);
        });

        document.getElementById('colorBlindFriendly')?.addEventListener('change', (e) => {
            this.colorBlindFriendly = e.target.checked;
            localStorage.setItem('colorBlindFriendly', this.colorBlindFriendly);
            this.applyTheme(this.currentTheme);
        });

        document.getElementById('reduceMotion')?.addEventListener('change', (e) => {
            this.reducedMotion = e.target.checked;
            localStorage.setItem('reducedMotion', this.reducedMotion);
            this.applyTheme(this.currentTheme);
        });

        document.getElementById('animationsEnabled')?.addEventListener('change', (e) => {
            this.animationsEnabled = e.target.checked;
            localStorage.setItem('animationsEnabled', this.animationsEnabled);
            document.body.classList.toggle('no-animations', !this.animationsEnabled);
        });
    }

    switchThemeCustomizerTab(tabName) {
        // Update tab buttons
        document.querySelectorAll('.theme-customizer .tab-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.tab === tabName) {
                btn.classList.add('active');
            }
        });

        // Update tab panels
        document.querySelectorAll('.theme-customizer .tab-panel').forEach(panel => {
            panel.classList.remove('active');
        });
        document.getElementById(tabName + '-tab').classList.add('active');
    }

    previewCustomColors() {
        const colors = {
            primary: document.getElementById('primaryColor').value,
            secondary: document.getElementById('secondaryColor').value,
            background: document.getElementById('backgroundColor').value,
            surface: document.getElementById('surfaceColor').value,
            text: document.getElementById('textColor').value,
            textSecondary: document.getElementById('textSecondaryColor').value,
            borderColor: document.getElementById('borderColor').value
        };

        // Apply preview colors temporarily
        Object.entries(colors).forEach(([key, value]) => {
            document.documentElement.style.setProperty(`--preview-${key}`, value);
        });

        document.body.classList.add('preview-mode');
    }

    resetCustomTheme() {
        // Use current theme colors as defaults
        const currentTheme = this.getTheme(this.currentTheme);
        const defaults = currentTheme ? currentTheme.colors : {
            primary: '#3b82f6',
            secondary: '#6366f1',
            background: '#ffffff',
            surface: '#f8fafc',
            text: '#1f2937',
            textSecondary: '#4b5563'
        };

        Object.entries(defaults).forEach(([key, value]) => {
            const colorInput = document.getElementById(key + 'Color');
            const textInput = document.getElementById(key + 'ColorText');
            if (colorInput) colorInput.value = value;
            if (textInput) textInput.value = value;
        });

        this.previewCustomColors();
    }

    saveCustomTheme() {
        const name = prompt('Enter a name for your custom theme:');
        if (!name) return;

        const theme = {
            name: name,
            description: 'Custom theme created by user',
            colors: {
                primary: document.getElementById('primaryColor').value,
                secondary: document.getElementById('secondaryColor').value,
                background: document.getElementById('backgroundColor').value,
                surface: document.getElementById('surfaceColor').value,
                text: document.getElementById('textColor').value,
                textSecondary: document.getElementById('textSecondaryColor').value,
                borderColor: document.getElementById('borderColor').value
            }
        };

        const themeKey = name.toLowerCase().replace(/\s+/g, '_');
        this.customThemes[themeKey] = theme;
        
        // Save to localStorage
        localStorage.setItem('customThemes', JSON.stringify(this.customThemes));
        
        // Apply the new theme
        this.applyTheme(themeKey);
        
        // Close customizer and refresh preset grid
        this.closeThemeCustomizer();
        
        if (window.app) {
            window.app.showToast(`Custom theme "${name}" saved`, 'success');
        }
    }

    deleteCustomTheme(themeKey) {
        if (confirm('Are you sure you want to delete this custom theme?')) {
            delete this.customThemes[themeKey];
            localStorage.setItem('customThemes', JSON.stringify(this.customThemes));
            
            // If this was the current theme, switch to default dark theme
            if (this.currentTheme === themeKey) {
                this.applyTheme('dark');
            }
            
            this.closeThemeCustomizer();
            
            if (window.app) {
                window.app.showToast('Custom theme deleted', 'success');
            }
        }
    }

    openThemeCustomizer() {
        let modal = document.getElementById('themeCustomizer');
        
        // Create modal if it doesn't exist
        if (!modal) {
            this.createThemeCustomizerModal();
            modal = document.getElementById('themeCustomizer');
        }
        
        if (modal) {
            // Add show class to make modal visible
            modal.classList.add('show');
            this.loadCustomThemeValues();
            
            // Refresh the presets grid to show current selection
            const presetsGrid = modal.querySelector('.theme-grid');
            if (presetsGrid) {
                presetsGrid.innerHTML = this.generatePresetThemesHTML();
                // Re-attach click handlers for theme presets
                presetsGrid.querySelectorAll('.theme-preset').forEach(preset => {
                    preset.addEventListener('click', () => {
                        const theme = preset.dataset.theme;
                        this.applyTheme(theme);
                        // Update active state
                        presetsGrid.querySelectorAll('.theme-preset').forEach(p => p.classList.remove('active'));
                        preset.classList.add('active');
                    });
                });
            }
        }
    }

    closeThemeCustomizer() {
        const modal = document.getElementById('themeCustomizer');
        if (modal) {
            modal.classList.remove('show');
        }
        document.body.classList.remove('preview-mode');
    }

    loadCustomThemeValues() {
        const theme = this.getTheme(this.currentTheme);
        if (!theme) return;

        const colorMap = {
            primary: 'primaryColor',
            secondary: 'secondaryColor',
            background: 'backgroundColor',
            surface: 'surfaceColor',
            text: 'textColor',
            textSecondary: 'textSecondaryColor',
            borderColor: 'borderColor'
        };

        Object.entries(colorMap).forEach(([themeKey, inputId]) => {
            const input = document.getElementById(inputId);
            const textInput = document.getElementById(inputId + 'Text');
            if (input) input.value = theme.colors[themeKey];
            if (textInput) textInput.value = theme.colors[themeKey];
        });
    }

    openAccessibilitySettings() {
        // Open theme customizer on accessibility tab
        this.openThemeCustomizer();
        setTimeout(() => {
            this.switchThemeCustomizerTab('accessibility');
        }, 100);
    }

    // Export/Import themes
    exportThemes() {
        const exportData = {
            version: '2.0.0',
            exported: new Date().toISOString(),
            customThemes: this.customThemes,
            settings: {
                highContrast: this.highContrast,
                colorBlindFriendly: this.colorBlindFriendly,
                reducedMotion: this.reducedMotion,
                animationsEnabled: this.animationsEnabled
            }
        };

        const blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        
        const a = document.createElement('a');
        a.href = url;
        a.download = `ai-chat-studio-themes-${new Date().toISOString().split('T')[0]}.json`;
        a.click();
        
        URL.revokeObjectURL(url);
    }

    importThemes(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const importData = JSON.parse(e.target.result);
                
                if (importData.customThemes) {
                    this.customThemes = { ...this.customThemes, ...importData.customThemes };
                    localStorage.setItem('customThemes', JSON.stringify(this.customThemes));
                }
                
                if (importData.settings) {
                    Object.entries(importData.settings).forEach(([key, value]) => {
                        this[key] = value;
                        localStorage.setItem(key, value);
                    });
                }
                
                if (window.app) {
                    window.app.showToast('Themes imported successfully', 'success');
                }
                
            } catch (error) {
                if (window.app) {
                    window.app.showToast('Error importing themes: ' + error.message, 'error');
                }
            }
        };
        reader.readAsText(file);
    }
}

// Initialize theme manager
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
    
    // Add theme-specific CSS
    const themeStyles = `
    <style>
    .theme-customizer {
        max-width: 800px;
        width: 90vw;
        max-height: 90vh;
        overflow-y: auto;
    }

    .theme-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1rem;
    }

    .tab-btn {
        padding: 0.75rem 1.5rem;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-secondary);
        cursor: pointer;
        transition: all var(--transition-fast);
        font-size: 0.9rem;
    }

    .tab-btn:hover,
    .tab-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .tab-panel {
        display: none;
    }

    .tab-panel.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    .theme-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .theme-preset {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        cursor: pointer;
        transition: all var(--transition-normal);
        position: relative;
    }

    .theme-preset:hover {
        border-color: var(--primary-color);
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .theme-preset.active {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-glow);
    }

    .theme-preview {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        height: 60px;
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .color-preview {
        flex: 1;
        border-radius: var(--radius-sm);
    }

    .theme-info h4 {
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .theme-info p {
        color: var(--text-secondary);
        font-size: 0.85rem;
        line-height: 1.4;
    }

    .btn-delete-theme {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--error-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        cursor: pointer;
        font-size: 0.8rem;
        opacity: 0;
        transition: opacity var(--transition-fast);
    }

    .theme-preset:hover .btn-delete-theme {
        opacity: 1;
    }

    .color-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--dark-bg);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
    }

    .color-section h4 {
        color: var(--text-primary);
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .color-controls {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .color-control {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .color-control label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .color-control input[type="color"] {
        width: 100%;
        height: 40px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        cursor: pointer;
        background: transparent;
    }

    .color-control input[type="text"] {
        padding: 0.5rem;
        background: var(--card-bg);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-family: monospace;
        font-size: 0.9rem;
    }

    .custom-theme-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .accessibility-controls {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .accessibility-option {
        padding: 1.5rem;
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
    }

    .toggle-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        width: 100%;
    }

    .toggle-option input[type="checkbox"] {
        display: none;
    }

    .toggle-slider {
        width: 48px;
        height: 24px;
        background: var(--border-color);
        border-radius: 12px;
        position: relative;
        transition: background-color var(--transition-fast);
        flex-shrink: 0;
    }

    .toggle-slider::before {
        content: '';
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 50%;
        position: absolute;
        top: 2px;
        left: 2px;
        transition: transform var(--transition-fast);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toggle-option input:checked + .toggle-slider {
        background: var(--primary-color);
    }

    .toggle-option input:checked + .toggle-slider::before {
        transform: translateX(24px);
    }

    .toggle-content {
        flex: 1;
    }

    .toggle-content strong {
        color: var(--text-primary);
        display: block;
        margin-bottom: 0.25rem;
    }

    .toggle-content small {
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    /* Preview mode for custom theme */
    body.preview-mode {
        transition: none !important;
    }

    /* Theme-specific customizations */
    .theme-matrix {
        --primary-color: #00ff41;
        --secondary-color: #00cc33;
        --background: #000000;
        --surface: #001100;
        --text: #00ff41;
        --text-secondary: #00cc33;
        --text-muted: #009900;
    }

    .no-animations *,
    .no-animations *::before,
    .no-animations *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }

    @media (max-width: 768px) {
        .theme-grid {
            grid-template-columns: 1fr;
        }
        
        .color-controls {
            grid-template-columns: 1fr;
        }
        
        .custom-theme-actions {
            flex-direction: column;
        }
        
        .theme-tabs {
            flex-direction: column;
        }
    }
    </style>
    `;

    document.head.insertAdjacentHTML('beforeend', themeStyles);
});
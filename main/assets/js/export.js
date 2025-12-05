/**
 * AI Chat Studio - Export/Import System
 * Comprehensive data export and import functionality
 */

class ExportImportSystem {
    constructor() {
        this.exportFormats = ['json', 'csv', 'pdf', 'markdown'];
        this.currentExportData = null;
        this.selectedImportFile = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.checkBrowserSupport();
    }

    setupEventListeners() {
        // Export buttons
        const exportAllBtn = document.getElementById('exportAllBtn');
        if (exportAllBtn) {
            exportAllBtn.addEventListener('click', () => this.showExportModal('all'));
        }

        const exportCurrentBtn = document.getElementById('exportCurrentBtn');
        if (exportCurrentBtn) {
            exportCurrentBtn.addEventListener('click', () => this.showExportModal('current'));
        }

        const exportSelectedBtn = document.getElementById('exportSelectedBtn');
        if (exportSelectedBtn) {
            exportSelectedBtn.addEventListener('click', () => this.showExportModal('selected'));
        }

        // Import button
        const importBtn = document.getElementById('importBtn');
        if (importBtn) {
            importBtn.addEventListener('click', () => this.showImportModal());
        }



        // File input for import - using event delegation
        document.addEventListener('change', (e) => {
            if (e.target.id === 'importFileInput') {
                this.handleFileSelect(e);
            }
        });

        // Tab switching for import and export modals - VS Code style
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('vs-tab')) {
                const modal = document.getElementById('importExportModal');
                if (modal && modal.classList.contains('active')) {
                    // Determine if we're in import or export mode based on title
                    const title = document.getElementById('importExportTitle');
                    if (title && title.textContent.includes('Export')) {
                        this.switchExportTab(e.target.dataset.tab);
                    } else {
                        this.switchImportTab(e.target.dataset.tab);
                    }
                }
            }
        });

        // Browse files button
        document.addEventListener('click', (e) => {
            if (e.target.id === 'browseFileBtn' || e.target.closest('#browseFileBtn')) {
                const fileInput = document.getElementById('importFileInput');
                if (fileInput) {
                    fileInput.click();
                }
            }
        });
    }

    checkBrowserSupport() {
        this.features = {
            download: 'download' in document.createElement('a'),
            clipboard: 'clipboard' in navigator,
            fileAPI: 'FileReader' in window && 'File' in window && 'Blob' in window
        };
    }

    // Export Modal Functions
    showExportModal(type = 'all') {
        const modal = document.getElementById('importExportModal');
        const title = document.getElementById('importExportTitle');
        const body = document.getElementById('importExportBody');

        if (!modal) {
            return;
        }
        if (!title || !body) {
            return;
        }

        title.textContent = 'Export Conversations';
        body.innerHTML = this.getExportModalContent(type);
        
        // Add VS Code styling class to modal
        modal.classList.add('import-export-modal');
        
        modal.style.display = 'flex';
        modal.classList.add('active');

        // Set up export button and modal event listeners
        this.setupExportModalEventListeners();

        // Initialize the preview tab
        setTimeout(() => {
            this.switchExportTab('scope'); // Start with scope tab
        }, 100);
    }

    getExportModalContent(type) {
        const conversationCount = window.app ? window.app.conversations.length : 0;
        
        return `
            <div class="vs-panel">
                <!-- VS Code style tabs -->
                <div class="vs-tab-bar">
                    <button class="vs-tab active" data-tab="scope">
                        <i class="fas fa-list"></i> Scope
                    </button>
                    <button class="vs-tab" data-tab="format">
                        <i class="fas fa-file-export"></i> Format
                    </button>
                    <button class="vs-tab" data-tab="options">
                        <i class="fas fa-cog"></i> Options
                    </button>
                    <button class="vs-tab" data-tab="preview">
                        <i class="fas fa-eye"></i> Preview
                    </button>
                </div>

                <div class="vs-panel-content">
                    <!-- Export Scope Tab -->
                    <div class="vs-panel-item active" id="scope-tab">
                        <div class="vs-form-group">
                            <label class="vs-label">What would you like to export?</label>
                            <p class="vs-label-description">Choose the scope of your export operation</p>
                            <div class="vs-radio-group">
                                <label class="vs-radio-option">
                                    <input type="radio" name="exportType" value="all" ${type === 'all' ? 'checked' : ''}>
                                    <span class="vs-radio-mark"></span>
                                    <div class="vs-radio-content">
                                        <strong>All Conversations</strong>
                                        <small>Export all ${conversationCount} conversations with full history and metadata</small>
                                    </div>
                                </label>
                                <label class="vs-radio-option">
                                    <input type="radio" name="exportType" value="current" ${type === 'current' ? 'checked' : ''}>
                                    <span class="vs-radio-mark"></span>
                                    <div class="vs-radio-content">
                                        <strong>Current Conversation</strong>
                                        <small>Export only the currently active conversation</small>
                                    </div>
                                </label>
                                <label class="vs-radio-option">
                                    <input type="radio" name="exportType" value="selected" ${type === 'selected' ? 'checked' : ''}>
                                    <span class="vs-radio-mark"></span>
                                    <div class="vs-radio-content">
                                        <strong>Selected Conversations</strong>
                                        <small>Choose specific conversations to export from your library</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Format Selection Tab -->
                    <div class="vs-panel-item" id="format-tab">
                        <div class="vs-form-group">
                            <label class="vs-label">Choose export format</label>
                            <p class="vs-label-description">Select the file format that best suits your needs</p>
                            <div class="vs-format-grid">
                                <label class="vs-format-option">
                                    <input type="radio" name="exportFormat" value="json" class="export-format" checked>
                                    <div class="vs-format-card">
                                        <i class="fas fa-code"></i>
                                        <strong>JSON</strong>
                                        <p>Complete data with metadata</p>
                                        <small>Best for backup & import</small>
                                    </div>
                                </label>
                                <label class="vs-format-option">
                                    <input type="radio" name="exportFormat" value="csv" class="export-format">
                                    <div class="vs-format-card">
                                        <i class="fas fa-table"></i>
                                        <strong>CSV</strong>
                                        <p>Spreadsheet format</p>
                                        <small>For data analysis</small>
                                    </div>
                                </label>
                                <label class="vs-format-option">
                                    <input type="radio" name="exportFormat" value="markdown" class="export-format">
                                    <div class="vs-format-card">
                                        <i class="fas fa-file-alt"></i>
                                        <strong>Markdown</strong>
                                        <p>Readable text format</p>
                                        <small>For documentation</small>
                                    </div>
                                </label>
                                <label class="vs-format-option">
                                    <input type="radio" name="exportFormat" value="pdf" class="export-format">
                                    <div class="vs-format-card">
                                        <i class="fas fa-file-pdf"></i>
                                        <strong>PDF</strong>
                                        <p>Printable document</p>
                                        <small>For sharing & printing</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Export Options Tab -->
                    <div class="vs-panel-item" id="options-tab">
                        <div class="vs-form-group">
                            <label class="vs-label">Export options</label>
                            <p class="vs-label-description">Customize what data to include in your export</p>
                            <div class="vs-checkbox-group">
                                <label class="vs-checkbox">
                                    <input type="checkbox" id="includeMetadata" checked>
                                    <span class="vs-checkbox-mark"></span>
                                    <span class="vs-checkbox-content">Include metadata (timestamps, models, etc.)</span>
                                </label>
                                <label class="vs-checkbox">
                                    <input type="checkbox" id="includeSettings" checked>
                                    <span class="vs-checkbox-mark"></span>
                                    <span class="vs-checkbox-content">Include settings and preferences</span>
                                </label>
                                <label class="vs-checkbox">
                                    <input type="checkbox" id="compressData">
                                    <span class="vs-checkbox-mark"></span>
                                    <span class="vs-checkbox-content">Compress data (smaller file size)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Export Preview Tab -->
                    <div class="vs-panel-item" id="preview-tab">
                        <div class="vs-form-group">
                            <label class="vs-label">Export preview</label>
                            <p class="vs-label-description">Review what will be included in your export</p>
                            <div class="vs-export-preview" id="exportPreview">
                                <div class="vs-preview-stats" id="previewStats">
                                    <!-- Will be populated dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VS Code style footer -->
                <div class="vs-panel-footer">
                    <div class="vs-actions">
                        <button class="vs-btn vs-btn-secondary" onclick="exportSystem.closeExportModal()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button class="vs-btn vs-btn-primary export-btn" disabled>
                            <i class="fas fa-download"></i> Export Conversations
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    updateExportOptions(format) {
        const preview = document.getElementById('exportPreview');
        if (!preview) return;

        const stats = this.calculateExportStats();
        const previewHTML = `
            <div class="vs-preview-stats">
                <div class="vs-stat-item">
                    <span class="vs-stat-number">${stats.conversationCount}</span>
                    <span class="vs-stat-label">Conversations</span>
                </div>
                <div class="vs-stat-item">
                    <span class="vs-stat-number">${stats.messageCount}</span>
                    <span class="vs-stat-label">Messages</span>
                </div>
                <div class="vs-stat-item">
                    <span class="vs-stat-number">${stats.estimatedSize}</span>
                    <span class="vs-stat-label">Est. Size</span>
                </div>
            </div>
            <div class="vs-format-info">
                <div class="vs-info-item">
                    <strong>Format:</strong> ${format.toUpperCase()}
                </div>
                <div class="vs-info-item">
                    <strong>Includes:</strong> ${this.getIncludedItems()}
                </div>
                <div class="vs-info-item">
                    <strong>Compatible with:</strong> ${this.getFormatCompatibility(format)}
                </div>
            </div>
        `;

        preview.innerHTML = previewHTML;

        // Enable export button if we have data to export
        const exportBtn = document.querySelector('.export-btn');
        if (exportBtn) {
            exportBtn.disabled = stats.conversationCount === 0;
        }
    }

    calculateExportStats() {
        const conversations = this.getConversationsForExport();
        const messageCount = conversations.reduce((total, conv) => total + (conv.messages?.length || 0), 0);
        const estimatedSize = this.estimateFileSize(conversations, 'json');
        
        return {
            conversationCount: conversations.length,
            messageCount,
            estimatedSize
        };
    }

    getIncludedItems() {
        const items = ['Messages', 'Timestamps'];
        
        if (document.getElementById('includeMetadata')?.checked) {
            items.push('Model info', 'Metadata');
        }
        
        if (document.getElementById('includeSettings')?.checked) {
            items.push('Settings', 'Preferences');
        }
        
        return items.join(', ');
    }

    getFormatCompatibility(format) {
        const compat = {
            json: 'AI Chat Studio v2.0, v1.0',
            csv: 'Excel, Google Sheets, data analysis tools',
            markdown: 'Any text editor, GitHub, documentation tools',
            pdf: 'Any PDF reader, printing, sharing'
        };
        return compat[format] || 'Various applications';
    }

    estimateFileSize(data, format) {
        const jsonSize = JSON.stringify(data).length;
        let multiplier = 1;
        
        switch (format) {
            case 'csv': multiplier = 0.3; break;
            case 'markdown': multiplier = 0.5; break;
            case 'pdf': multiplier = 2; break;
        }
        
        const bytes = Math.ceil(jsonSize * multiplier);
        
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return Math.round(bytes / 1024) + ' KB';
        return Math.round(bytes / (1024 * 1024)) + ' MB';
    }

    getConversationsForExport() {
        const selectedType = document.querySelector('input[name="exportType"]:checked')?.value || 'all';
        
        switch (selectedType) {
            case 'current':
                if (window.app && window.app.currentConversationId) {
                    const conversation = window.app.conversations.find(c => c.id === window.app.currentConversationId);
                    return conversation ? [conversation] : [];
                }
                return [];
                
            case 'selected':
                // This would be implemented with checkboxes for conversation selection
                return this.getSelectedConversations();
                
            case 'all':
            default:
                return window.app ? window.app.conversations : this.getAllConversationsFromStorage();
        }
    }

    getSelectedConversations() {
        // Implementation would depend on selected checkboxes
        // For now, return all conversations
        return this.getAllConversationsFromStorage();
    }

    getAllConversationsFromStorage() {
        const saved = localStorage.getItem('conversations');
        if (saved) {
            try {
                return JSON.parse(saved);
            } catch (e) {
                return [];
            }
        }
        return [];
    }

    async performExport(defaultType = 'all') {
        try {
            const format = document.querySelector('input[name="exportFormat"]:checked')?.value || 'json';
            const exportType = document.querySelector('input[name="exportType"]:checked')?.value || defaultType;
            const conversations = this.getConversationsForExport();
            
            if (conversations.length === 0) {
                if (window.app) {
                    window.app.showToast('No conversations to export', 'warning');
                }
                return;
            }

            // Show loading state
            const exportBtn = document.querySelector('.export-btn');
            if (exportBtn) {
                exportBtn.disabled = true;
                exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            }

            // Prepare export data
            const exportData = await this.prepareExportData(conversations, format);

            // Generate filename
            const filename = this.generateFilename(type, format);

            // Download file
            await this.downloadFile(exportData, filename, format);

            // Success feedback
            if (window.app) {
                window.app.showToast(`Successfully exported ${conversations.length} conversation(s)`, 'success');
            }

            this.closeExportModal();

        } catch (error) {
            if (window.app) {
                window.app.showToast('Export failed: ' + error.message, 'error');
            }
        } finally {
            // Reset button state
            const exportBtn = document.querySelector('.export-btn');
            if (exportBtn) {
                exportBtn.disabled = false;
                exportBtn.innerHTML = '<i class="fas fa-download"></i> Export Conversations';
            }
        }
    }

    async prepareExportData(conversations, format) {
        const includeMetadata = document.getElementById('includeMetadata')?.checked;
        const includeSettings = document.getElementById('includeSettings')?.checked;
        const compressData = document.getElementById('compressData')?.checked;

        const exportData = {
            version: '2.0.0',
            exported: new Date().toISOString(),
            format: format,
            conversationCount: conversations.length,
            messageCount: conversations.reduce((total, conv) => total + (conv.messages?.length || 0), 0)
        };

        // Add conversations
        exportData.conversations = conversations.map(conv => {
            const exportConv = {
                id: conv.id,
                title: conv.title,
                model: conv.model,
                created: conv.created,
                updated: conv.updated,
                messages: conv.messages || []
            };

            if (includeMetadata) {
                exportConv.metadata = {
                    pinned: conv.pinned || false,
                    tags: conv.tags || [],
                    wordCount: this.calculateWordCount(conv.messages || []),
                    messageCount: conv.messages?.length || 0
                };
            }

            return exportConv;
        });

        // Add settings if requested
        if (includeSettings) {
            exportData.settings = this.getSettingsData();
        }

        // Compress if requested
        if (compressData && format === 'json') {
            exportData = this.compressData(exportData);
        }

        // Format-specific processing
        switch (format) {
            case 'json':
                return JSON.stringify(exportData, null, 2);
                
            case 'csv':
                return this.convertToCSV(exportData.conversations);
                
            case 'markdown':
                return this.convertToMarkdown(exportData);
                
            case 'pdf':
                return this.convertToPDF(exportData);
                
            default:
                return JSON.stringify(exportData, null, 2);
        }
    }

    getSettingsData() {
        const settings = {};
        
        // Get user preferences
        ['selectedModel', 'temperature', 'maxTokens', 'systemPrompt', 'theme'].forEach(key => {
            const value = localStorage.getItem(key);
            if (value) {
                settings[key] = value;
            }
        });

        // Get API keys (masked)
        ['gemini', 'claude', 'gpt', 'deepseek', 'llama', 'mistral', 'cohere'].forEach(model => {
            const key = localStorage.getItem(`apiKey_${model}`);
            if (key) {
                settings[`apiKey_${model}`] = '***CONFIGURED***';
            }
        });

        return settings;
    }

    calculateWordCount(messages) {
        return messages.reduce((total, msg) => {
            return total + (msg.content?.split(/\s+/).length || 0);
        }, 0);
    }

    compressData(data) {
        // Simple compression for JSON data
        return {
            ...data,
            _compressed: true,
            conversations: data.conversations.map(conv => ({
                ...conv,
                // Remove empty fields and compress where possible
                messages: conv.messages?.map(msg => ({
                    role: msg.role,
                    content: msg.content,
                    timestamp: msg.timestamp
                })) || []
            }))
        };
    }

    convertToCSV(conversations) {
        const rows = [['Title', 'Model', 'Created', 'Updated', 'Message Count', 'First Message', 'Last Message']];
        
        conversations.forEach(conv => {
            const messages = conv.messages || [];
            const firstMessage = messages[0]?.content?.substring(0, 100) || '';
            const lastMessage = messages[messages.length - 1]?.content?.substring(0, 100) || '';
            
            rows.push([
                `"${conv.title.replace(/"/g, '""')}"`,
                conv.model,
                new Date(conv.created).toLocaleDateString(),
                new Date(conv.updated).toLocaleDateString(),
                messages.length,
                `"${firstMessage.replace(/"/g, '""')}"`,
                `"${lastMessage.replace(/"/g, '""')}"`
            ]);
        });
        
        return rows.map(row => row.join(',')).join('\n');
    }

    convertToMarkdown(data) {
        let markdown = `# AI Chat Studio Export\n\n`;
        markdown += `**Exported:** ${new Date(data.exported).toLocaleString()}\n`;
        markdown += `**Conversations:** ${data.conversationCount}\n`;
        markdown += `**Total Messages:** ${data.messageCount}\n\n`;
        
        if (data.settings) {
            markdown += `## Settings\n\n`;
            Object.entries(data.settings).forEach(([key, value]) => {
                markdown += `- **${key}:** ${value}\n`;
            });
            markdown += `\n`;
        }
        
        data.conversations.forEach((conv, index) => {
            markdown += `## ${index + 1}. ${conv.title}\n\n`;
            markdown += `**Model:** ${conv.model}  \n`;
            markdown += `**Created:** ${new Date(conv.created).toLocaleString()}  \n`;
            markdown += `**Updated:** ${new Date(conv.updated).toLocaleString()}  \n`;
            if (conv.metadata) {
                markdown += `**Messages:** ${conv.metadata.messageCount}  \n`;
                markdown += `**Words:** ${conv.metadata.wordCount}\n\n`;
            }
            
            if (conv.messages && conv.messages.length > 0) {
                markdown += `### Conversation\n\n`;
                conv.messages.forEach(msg => {
                    const role = msg.role === 'user' ? '**User**' : '**AI**';
                    markdown += `**${role}** - ${new Date(msg.timestamp).toLocaleString()}\n\n`;
                    markdown += `${msg.content}\n\n`;
                    markdown += `---\n\n`;
                });
            }
        });
        
        return markdown;
    }

    convertToPDF(data) {
        // In a real implementation, you'd use a library like jsPDF
        // For now, return HTML that can be printed as PDF
        let html = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>AI Chat Studio Export</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                h1, h2, h3 { color: #333; }
                .meta { color: #666; margin-bottom: 20px; }
                .message { margin-bottom: 20px; padding: 15px; border-left: 3px solid #667eea; }
                .user { background: #f0f8ff; }
                .ai { background: #f5f5f5; }
                .timestamp { font-size: 0.8em; color: #888; }
                @media print { body { margin: 20px; } }
            </style>
        </head>
        <body>
            <h1>AI Chat Studio Export</h1>
            <div class="meta">
                <p><strong>Exported:</strong> ${new Date(data.exported).toLocaleString()}</p>
                <p><strong>Conversations:</strong> ${data.conversationCount}</p>
                <p><strong>Total Messages:</strong> ${data.messageCount}</p>
            </div>
        `;
        
        data.conversations.forEach((conv, index) => {
            html += `<h2>${index + 1}. ${conv.title}</h2>`;
            html += `<div class="meta">`;
            html += `<p><strong>Model:</strong> ${conv.model}</p>`;
            html += `<p><strong>Created:</strong> ${new Date(conv.created).toLocaleString()}</p>`;
            html += `<p><strong>Updated:</strong> ${new Date(conv.updated).toLocaleString()}</p>`;
            html += `</div>`;
            
            conv.messages?.forEach(msg => {
                const roleClass = msg.role === 'user' ? 'user' : 'ai';
                html += `<div class="message ${roleClass}">`;
                html += `<strong>${msg.role === 'user' ? 'User' : 'AI'}</strong>`;
                html += ` <span class="timestamp">${new Date(msg.timestamp).toLocaleString()}</span>`;
                html += `<p>${msg.content.replace(/\n/g, '<br>')}</p>`;
                html += `</div>`;
            });
        });
        
        html += '</body></html>';
        return html;
    }

    generateFilename(type, format) {
        const timestamp = new Date().toISOString().split('T')[0];
        const prefix = type === 'current' ? 'current-chat' : 'all-conversations';
        return `ai-chat-hub-${prefix}-${timestamp}.${format}`;
    }

    async downloadFile(data, filename, format) {
        let blob;
        
        if (format === 'pdf') {
            // For PDF, create a blob with HTML content that can be printed
            blob = new Blob([data], { type: 'text/html' });
        } else if (format === 'csv') {
            blob = new Blob([data], { type: 'text/csv' });
        } else {
            blob = new Blob([data], { type: 'application/json' });
        }
        
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.style.display = 'none';
        
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        URL.revokeObjectURL(url);
    }

    // Import Modal Functions
    showImportModal() {
        const modal = document.getElementById('importExportModal');
        const title = document.getElementById('importExportTitle');
        const body = document.getElementById('importExportBody');

        if (!modal) {
            return;
        }
        if (!title || !body) {
            return;
        }

        title.textContent = 'Import Conversations';
        body.innerHTML = this.getImportModalContent();
        
        // Add VS Code styling class to modal
        modal.classList.add('import-export-modal');
        
        modal.style.display = 'flex';
        modal.classList.add('active');

        // Set up drag and drop
        this.setupDragAndDrop();
        
        // Ensure file input is accessible
        this.ensureFileInputAccessibility();
        
        // Re-setup event listeners for dynamically created elements
        this.setupModalEventListeners();
    }

    getImportModalContent() {
        return `
            <div class="vs-panel">
                <!-- VS Code style tabs -->
                <div class="vs-tab-bar">
                    <button class="vs-tab active" data-tab="file">
                        <i class="fas fa-upload"></i> Upload File
                    </button>
                    <button class="vs-tab" data-tab="paste">
                        <i class="fas fa-paste"></i> Paste Data
                    </button>
                    <button class="vs-tab" data-tab="url">
                        <i class="fas fa-link"></i> Import from URL
                    </button>
                </div>

                <div class="vs-panel-content">
                    <!-- File Upload Tab -->
                    <div class="vs-panel-item active" id="file-tab">
                        <div class="vs-form-group">
                            <label class="vs-label">Select a file to import</label>
                            <p class="vs-label-description">Choose a file from your computer to import conversations</p>
                            
                            <!-- Traditional file input approach -->
                            <div style="display: flex; gap: 12px; align-items: center; margin: 20px 0;">
                                <input type="file" id="importFileInput" accept=".json,.csv,.md,.html" style="display: none;">
                                <button class="vs-btn vs-btn-primary" onclick="document.getElementById('importFileInput').click()">
                                    <i class="fas fa-folder-open"></i> Browse Files
                                </button>
                                <button class="vs-btn vs-btn-secondary" onclick="exportSystem.clearSelectedFile()" id="clearImportBtn" style="display: none;">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                            
                            <!-- File info display -->
                            <div id="selectedFileInfo" class="vs-file-info" style="display: none; margin-top: 20px;">
                                <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: var(--surface); border: 1px solid var(--border-color); border-radius: 4px;">
                                    <div style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: var(--primary-color); border-radius: 4px; color: white;">
                                        <i class="fas fa-file"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div id="selectedFileName" style="font-weight: 500; color: var(--text);">No file selected</div>
                                        <div id="selectedFileSize" style="font-size: 12px; color: var(--text-secondary);"></div>
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        <button class="vs-btn vs-btn-secondary" onclick="document.getElementById('importFileInput').click()">
                                            <i class="fas fa-exchange-alt"></i> Change
                                        </button>
                                        <button class="vs-btn vs-btn-primary" id="uploadSelectedFile" onclick="exportSystem.uploadSelectedFile()">
                                            <i class="fas fa-upload"></i> Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paste Data Tab -->
                    <div class="vs-panel-item" id="paste-tab">
                        <div class="vs-form-group">
                            <label class="vs-label">Paste your JSON data:</label>
                            <textarea id="pasteData" class="vs-textarea" placeholder="Paste your exported JSON data here..." rows="12" style="width: 100%; min-height: 200px; resize: vertical; font-family: 'Courier New', monospace; font-size: 13px; line-height: 1.4;"></textarea>
                        </div>
                        <div class="vs-form-actions">
                            <button class="vs-btn vs-btn-secondary" onclick="exportSystem.clearPasteData()">
                                <i class="fas fa-eraser"></i> Clear
                            </button>
                            <button class="vs-btn vs-btn-primary" onclick="exportSystem.processPastedData()">
                                <i class="fas fa-download"></i> Import
                            </button>
                        </div>
                    </div>

                    <!-- URL Import Tab -->
                    <div class="vs-panel-item" id="url-tab">
                        <div class="vs-form-group">
                            <label class="vs-label" for="importUrl">Export File URL:</label>
                            <div class="vs-input-group" style="display: flex; gap: 8px;">
                                <input type="url" id="importUrl" class="vs-input" placeholder="https://example.com/your-export-file.json" style="flex: 1; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 4px; background: var(--surface); color: var(--text);">
                                <button class="vs-btn vs-btn-primary" onclick="exportSystem.importFromUrl()">
                                    <i class="fas fa-download"></i> Import
                                </button>
                            </div>
                        </div>
                        <div class="vs-notice" style="background: var(--surface); border: 1px solid var(--border-color); border-radius: 4px; padding: 12px; margin: 16px 0; font-size: 12px; color: var(--text-secondary);">
                            <i class="fas fa-shield-alt" style="margin-right: 8px;"></i>
                            <strong>Security:</strong> Only import from trusted sources. URLs must allow CORS for direct imports.
                        </div>
                    </div>
                </div>

                <!-- VS Code style footer -->
                <div class="vs-panel-footer">
                    <div class="vs-form-options">
                        <label class="vs-checkbox">
                            <input type="checkbox" id="mergeConversations" checked>
                            <span class="vs-checkbox-mark"></span>
                            Merge with existing conversations
                        </label>
                        <label class="vs-checkbox">
                            <input type="checkbox" id="overwriteDuplicates">
                            <span class="vs-checkbox-mark"></span>
                            Overwrite duplicate conversations
                        </label>
                        <label class="vs-checkbox">
                            <input type="checkbox" id="importSettings">
                            <span class="vs-checkbox-mark"></span>
                            Import settings and preferences
                        </label>
                    </div>
                    <div class="vs-actions">
                        <button class="vs-btn vs-btn-secondary" onclick="exportSystem.closeExportModal()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    setupDragAndDrop() {
        // Simplified - no drag and drop functionality for now
        // Focus on traditional file input approach
    }

    clearSelectedFile() {
        // Clear the file selection
        const fileInput = document.getElementById('importFileInput');
        const fileInfo = document.getElementById('selectedFileInfo');
        const clearBtn = document.getElementById('clearImportBtn');
        
        if (fileInput) {
            fileInput.value = '';
        }
        
        if (fileInfo) {
            fileInfo.style.display = 'none';
        }
        
        // Hide the clear button
        if (clearBtn) {
            clearBtn.style.display = 'none';
        }
        
        this.selectedImportFile = null;
    }

    switchImportTab(tabName) {
        // Remove active class from all VS Code style tab buttons and panels
        document.querySelectorAll('.vs-tab').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelectorAll('.vs-panel-item').forEach(panel => {
            panel.classList.remove('active');
        });
        
        // Add active class to clicked button and corresponding panel
        const activeBtn = document.querySelector(`.vs-tab[data-tab="${tabName}"]`);
        const activePanel = document.getElementById(`${tabName}-tab`);
        
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
        
        if (activePanel) {
            activePanel.classList.add('active');
        }
    }

    switchExportTab(tabName) {
        // Remove active class from all VS Code style tab buttons and panels
        document.querySelectorAll('.vs-tab').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelectorAll('.vs-panel-item').forEach(panel => {
            panel.classList.remove('active');
        });
        
        // Add active class to clicked button and corresponding panel
        const activeBtn = document.querySelector(`.vs-tab[data-tab="${tabName}"]`);
        const activePanel = document.getElementById(`${tabName}-tab`);
        
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
        
        if (activePanel) {
            activePanel.classList.add('active');
        }
        
        // Update preview when switching to preview tab
        if (tabName === 'preview') {
            setTimeout(() => {
                this.updateExportOptions('json'); // Default format
            }, 100);
        }
    }

    setupModalEventListeners() {
        // File input change event
        const importFileInput = document.getElementById('importFileInput');
        if (importFileInput) {
            importFileInput.addEventListener('change', (e) => {
                this.handleFileSelect(e);
            });
        }
        
        // Upload button
        const uploadBtn = document.getElementById('uploadSelectedFile');
        if (uploadBtn) {
            uploadBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.uploadSelectedFile();
            });
        }
        
        // VS Code style tab buttons
        const vsTabBtns = document.querySelectorAll('.vs-tab');
        if (vsTabBtns.length > 0) {
            vsTabBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const tabName = btn.dataset.tab;
                    this.switchImportTab(tabName);
                });
            });
        }
    }

    setupExportModalEventListeners() {
        // Export button
        const exportBtn = document.querySelector('.export-btn');
        if (exportBtn) {
            exportBtn.addEventListener('click', (e) => {
                this.performExport('all'); // Use default type
            });
        }

        // Format selection
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('export-format')) {
                this.updateExportOptions(e.target.value);
            }
        });

        // Export type selection
        document.addEventListener('change', (e) => {
            if (e.target.name === 'exportType') {
                this.updateExportOptions('json'); // Refresh preview
            }
        });

        // VS Code style tab buttons for export
        const vsTabBtns = document.querySelectorAll('.vs-tab');
        if (vsTabBtns.length > 0) {
            vsTabBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const tabName = btn.dataset.tab;
                    this.switchExportTab(tabName);
                });
            });
        }
    }

    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ensureFileInputAccessibility() {
        const fileInput = document.getElementById('importFileInput');
        if (fileInput) {
            // Ensure the file input is properly configured for click-through
            fileInput.style.position = 'absolute';
            fileInput.style.top = '0';
            fileInput.style.left = '0';
            fileInput.style.width = '100%';
            fileInput.style.height = '100%';
            fileInput.style.opacity = '0';
            fileInput.style.cursor = 'pointer';
            fileInput.style.zIndex = '1';
            
            // Add tabindex for accessibility
            fileInput.setAttribute('tabindex', '0');
        }
    }

    triggerFileDialog() {
        const fileInput = document.getElementById('importFileInput');
        if (!fileInput) {
            if (window.app) {
                window.app.showToast('File input not found. Please refresh the page.', 'error');
            }
            return;
        }
        
        try {
            // Ensure file input is accessible first
            this.ensureFileInputAccessibility();
            
            // Focus the file input first
            fileInput.focus();
            
            // Try to trigger the file dialog
            fileInput.click();
            
        } catch (error) {
            // Provide user guidance
            if (window.app) {
                window.app.showToast('File browser opening failed. Try Ctrl+O or refresh the page.', 'warning');
            }
        }
    }

    fallbackFileInputTrigger() {
        const fileInput = document.getElementById('importFileInput');
        if (fileInput) {
            try {
                // Fallback method: try to focus and use keyboard interaction
                fileInput.focus();
                
                // Create and dispatch a proper click event
                const clickEvent = new MouseEvent('click', {
                    view: window,
                    bubbles: true,
                    cancelable: true,
                    buttons: 1
                });
                
                fileInput.dispatchEvent(clickEvent);
                
            } catch (error) {
                // Last resort: show instructions to user
                if (window.app) {
                    window.app.showToast('Please use the file browser by pressing Ctrl+O or using the Change button', 'info');
                }
            }
        }
    }

    handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        this.handleFiles(files);
    }

    handleFileSelect(e) {
        const files = e.target.files;
        if (files.length > 0) {
            const file = files[0];
            this.selectedImportFile = file;
            
            // Show file info to user
            this.showSelectedFileInfo(file);
        } else {
            this.selectedImportFile = null;
            this.hideSelectedFileInfo();
        }
    }
    
    showSelectedFileInfo(file) {
        const fileInfo = document.getElementById('selectedFileInfo');
        const fileName = document.getElementById('selectedFileName');
        const fileSize = document.getElementById('selectedFileSize');
        const clearBtn = document.getElementById('clearImportBtn');
        
        if (fileInfo && fileName && fileSize) {
            fileName.textContent = file.name;
            fileSize.textContent = this.formatFileSize(file.size) + ' • ' + this.getFileExtension(file.name).toUpperCase();
            
            // Show the file info section
            fileInfo.style.display = 'block';
            
            // Show the clear button
            if (clearBtn) {
                clearBtn.style.display = 'inline-block';
            }
            
            // Add VS Code style animation
            fileInfo.style.animation = 'vs-fadeIn 0.3s ease-out';
            
            // Update upload button
            const uploadBtn = document.getElementById('uploadSelectedFile');
            if (uploadBtn) {
                // Enable the button
                uploadBtn.disabled = false;
            }
        }
    }
    
    hideSelectedFileInfo() {
        const fileInfo = document.getElementById('selectedFileInfo');
        if (fileInfo) {
            // Add fade out animation
            fileInfo.style.animation = 'vs-fadeOut 0.3s ease-in';
            setTimeout(() => {
                fileInfo.style.display = 'none';
            }, 300);
        }
    }
    
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    getFileExtension(filename) {
        return filename.split('.').pop().toLowerCase();
    }
    
    async uploadSelectedFile() {
        if (!this.selectedImportFile) {
            if (window.app) {
                window.app.showToast('Please select a file first', 'warning');
            }
            return;
        }
        
        // Show loading state
        const uploadBtn = document.getElementById('uploadSelectedFile');
        if (uploadBtn) {
            uploadBtn.disabled = true;
            uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        }
        
        try {
            await this.processImportFile(this.selectedImportFile);
            
        } catch (error) {
            if (window.app) {
                window.app.showToast('Upload failed: ' + error.message, 'error');
            }
        } finally {
            // Reset button state
            if (uploadBtn) {
                uploadBtn.disabled = false;
                uploadBtn.innerHTML = '<i class="fas fa-upload"></i> Upload & Import';
            }
            
            // Reset selected file after processing
            this.selectedImportFile = null;
            this.hideSelectedFileInfo();
            
            // Clear file input
            const fileInput = document.getElementById('importFileInput');
            if (fileInput) {
                fileInput.value = '';
            }
        }
    }

    handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            this.processImportFile(file);
        }
    }

    async processImportFile(file) {
        try {
            const content = await this.readFileContent(file);
            const format = this.detectFileFormat(file.name);
            
            const data = await this.parseImportData(content, format);
            await this.importData(data);
            
            this.closeExportModal();
            
        } catch (error) {
            if (window.app) {
                window.app.showToast('Import failed: ' + error.message, 'error');
            }
        }
    }

    readFileContent(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = () => reject(new Error('Failed to read file'));
            reader.readAsText(file);
        });
    }

    detectFileFormat(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        switch (ext) {
            case 'json': return 'json';
            case 'csv': return 'csv';
            case 'md': return 'markdown';
            case 'html': return 'html';
            default: return 'unknown';
        }
    }

    async parseImportData(content, format) {
        switch (format) {
            case 'json':
                return JSON.parse(content);
            case 'csv':
                return this.parseCSV(content);
            case 'markdown':
                return this.parseMarkdown(content);
            case 'html':
                return this.parseHTML(content);
            default:
                throw new Error('Unsupported file format');
        }
    }

    parseCSV(content) {
        // Simplified CSV parsing for basic conversation data
        const lines = content.split('\n');
        const headers = lines[0].split(',').map(h => h.trim().replace(/"/g, ''));
        
        const conversations = [];
        for (let i = 1; i < lines.length; i++) {
            if (lines[i].trim()) {
                const values = lines[i].split(',').map(v => v.trim().replace(/"/g, ''));
                if (values.length >= 4) {
                    conversations.push({
                        id: Date.now().toString() + i,
                        title: values[0],
                        model: values[1] || 'gemini',
                        created: new Date(values[2]).toISOString(),
                        updated: new Date(values[3]).toISOString(),
                        messages: []
                    });
                }
            }
        }
        
        return {
            version: '2.0.0',
            imported: new Date().toISOString(),
            format: 'csv',
            conversations
        };
    }

    parseMarkdown(content) {
        // Basic markdown parsing - would need more sophisticated parsing in reality
        const conversations = [{
            id: Date.now().toString(),
            title: 'Imported from Markdown',
            model: 'unknown',
            created: new Date().toISOString(),
            updated: new Date().toISOString(),
            messages: [{
                role: 'user',
                content: content.substring(0, 1000), // Limit content
                timestamp: new Date().toISOString()
            }]
        }];
        
        return {
            version: '2.0.0',
            imported: new Date().toISOString(),
            format: 'markdown',
            conversations
        };
    }

    parseHTML(content) {
        // Basic HTML parsing for PDF exports
        const conversations = [{
            id: Date.now().toString(),
            title: 'Imported from HTML',
            model: 'unknown',
            created: new Date().toISOString(),
            updated: new Date().toISOString(),
            messages: [{
                role: 'user',
                content: 'Imported from HTML document',
                timestamp: new Date().toISOString()
            }]
        }];
        
        return {
            version: '2.0.0',
            imported: new Date().toISOString(),
            format: 'html',
            conversations
        };
    }

    async importData(data) {
        const mergeConversations = document.getElementById('mergeConversations')?.checked;
        const overwriteDuplicates = document.getElementById('overwriteDuplicates')?.checked;
        const importSettings = document.getElementById('importSettings')?.checked;

        if (!data.conversations || !Array.isArray(data.conversations)) {
            throw new Error('Invalid import data: missing conversations array');
        }

        let importedCount = 0;
        const existingConversations = window.app ? window.app.conversations : [];

        for (const conv of data.conversations) {
            const existingIndex = existingConversations.findIndex(c => c.id === conv.id);
            
            if (existingIndex !== -1 && !overwriteDuplicates) {
                // Generate new ID to avoid conflicts
                conv.id = Date.now().toString() + Math.random().toString(36).substr(2, 9);
            } else if (existingIndex !== -1 && overwriteDuplicates) {
                // Replace existing conversation
                existingConversations[existingIndex] = conv;
                importedCount++;
            } else {
                // Add new conversation
                existingConversations.push(conv);
                importedCount++;
            }
        }

        // Update app data
        if (window.app) {
            window.app.conversations = existingConversations;
            window.app.saveConversations();
            window.app.updateConversationsList();
        } else {
            localStorage.setItem('conversations', JSON.stringify(existingConversations));
        }

        // Import settings if requested
        if (importSettings && data.settings) {
            Object.entries(data.settings).forEach(([key, value]) => {
                if (!key.startsWith('apiKey_')) { // Don't import API keys for security
                    localStorage.setItem(key, value);
                }
            });
        }

        if (window.app) {
            window.app.showToast(`Successfully imported ${importedCount} conversation(s)`, 'success');
        }
    }

    // Helper methods
    closeExportModal() {
        const modal = document.getElementById('importExportModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('active');
            modal.classList.remove('import-export-modal');
        }
    }
    
    // Public method to force test modal display
    testModalDisplay() {
        const modal = document.getElementById('importExportModal');
        const title = document.getElementById('importExportTitle');
        const body = document.getElementById('importExportBody');
        
        if (modal && title && body) {
            title.textContent = 'TEST MODAL - EXPORT SYSTEM';
            body.innerHTML = `
                <div style="padding: 2rem; text-align: center; background: var(--surface); border-radius: 8px;">
                    <h3>✅ Export System Test Successful!</h3>
                    <p style="color: var(--text-secondary); margin: 1rem 0;">If you can see this, the export system is working correctly.</p>
                    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem;">
                        <button onclick="window.exportSystem.closeExportModal()" style="padding: 0.5rem 1rem; background: var(--primary-color); color: white; border: none; border-radius: 4px; cursor: pointer;">Close</button>
                        <button onclick="window.testExportModalDirect()" style="padding: 0.5rem 1rem; background: var(--surface); color: var(--text); border: 1px solid var(--border-color); border-radius: 4px; cursor: pointer;">Test Again</button>
                    </div>
                </div>
            `;
            modal.style.display = 'flex';
            modal.classList.add('active');
            return true;
        } else {
            return false;
        }
    }

    clearPasteData() {
        const textarea = document.getElementById('pasteData');
        if (textarea) {
            textarea.value = '';
        }
    }

    async processPastedData() {
        const textarea = document.getElementById('pasteData');
        if (!textarea || !textarea.value.trim()) {
            if (window.app) {
                window.app.showToast('Please paste some data to import', 'warning');
            }
            return;
        }

        try {
            const data = JSON.parse(textarea.value);
            await this.importData(data);
            this.closeExportModal();
        } catch (error) {
            if (window.app) {
                window.app.showToast('Invalid JSON data: ' + error.message, 'error');
            }
        }
    }

    async importFromUrl() {
        const urlInput = document.getElementById('importUrl');
        if (!urlInput || !urlInput.value.trim()) {
            if (window.app) {
                window.app.showToast('Please enter a valid URL', 'warning');
            }
            return;
        }

        try {
            const response = await fetch(urlInput.value);
            if (!response.ok) {
                throw new Error('Failed to fetch data from URL');
            }
            
            const content = await response.text();
            const format = this.detectFileFormat(urlInput.value);
            
            const data = await this.parseImportData(content, format);
            await this.importData(data);
            
            this.closeExportModal();
            
        } catch (error) {
            if (window.app) {
                window.app.showToast('Failed to import from URL: ' + error.message, 'error');
            }
        }
    }
    
    // Test function for file upload
    testFileUpload() {
        const fileInput = document.getElementById('importFileInput');
        const modal = document.getElementById('importExportModal');
        const body = document.getElementById('importExportBody');
        
        if (modal && body) {
            // Trigger import modal to ensure all elements are created
            this.showImportModal();
            
            setTimeout(() => {
                // Test all event listeners
                const fileInput = document.getElementById('importFileInput');
                const browseBtn = document.getElementById('browseFileBtn');
                const uploadBtn = document.getElementById('uploadSelectedFile');
                
                // Simulate a mock file selection for testing
                if (fileInput) {
                    const mockFile = new File(['test content'], 'test.json', { type: 'application/json' });
                    const mockEvent = {
                        target: {
                            files: [mockFile]
                        }
                    };
                    this.handleFileSelect(mockEvent);
                }
            }, 100);
        }
        
        return true;
    }
}

// Initialize export system
document.addEventListener('DOMContentLoaded', () => {
    window.exportSystem = new ExportImportSystem();
    
    // Connect to main app if available
    const connectToApp = () => {
        if (window.app && window.exportSystem) {
            window.app.exportSystem = window.exportSystem;
        } else {
            // Retry connection after a short delay
            setTimeout(connectToApp, 100);
        }
    };
    connectToApp();
    
    // Global debug function for file upload testing
    window.debugFileUpload = () => {
        if (window.exportSystem) {
            // Test modal
            const modal = document.getElementById('importExportModal');
            
            if (modal) {
                // Test if modal can be shown
                window.exportSystem.showImportModal();
                
                setTimeout(() => {
                    const fileInput = document.getElementById('importFileInput');
                    
                    // Test if we can trigger file input directly
                    if (fileInput) {
                        try {
                            fileInput.click();
                        } catch (error) {
                            // Silent fail
                        }
                    }
                }, 100);
            }
        }
    };

    // Global test function for file input compatibility
    window.testFileInputCompatibility = () => {
        // Test basic file input creation
        const testInput = document.createElement('input');
        testInput.type = 'file';
        
        try {
            testInput.click();
        } catch (error) {
            // Silent fail
        }
    };
});
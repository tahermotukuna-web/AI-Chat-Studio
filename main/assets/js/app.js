// AI Chat Studio v2.0 - Enhanced Application
class AIChatHubv2 {
    constructor() {
        // Check if we're on the settings page - skip full initialization
        this.isSettingsPage = window.location.pathname.includes('settings.php');
        
        this.conversations = [];
        this.currentConversationId = null;
        this.currentModel = 'gemini';
        this.apiKey = '';
        this.messageHistory = [];
        this.isRecording = false;
        this.recognition = null;
        this.currentEditMessage = null;
        this.uploadedFiles = [];
        
        this.initializeApp();
    }

    initializeApp() {
        // Skip full initialization on settings page
        if (this.isSettingsPage) {
            this.loadTheme();
            return;
        }
        
        this.initializeElements();
        this.loadConversations();
        this.attachEventListeners();
        this.loadApiKey();
        this.loadTheme();
        this.updateCharCounter();
        
        // Auto-save conversations every 30 seconds
        setInterval(() => this.autoSaveConversations(), 30000);
    }

    initializeElements() {
        this.elements = {
            chatMessages: document.getElementById('chatMessages'),
            messageInput: document.getElementById('messageInput'),
            sendBtn: document.getElementById('sendBtn'),
            chatForm: document.getElementById('chatForm'),
            aiModelSelect: document.getElementById('aiModel'),
            conversationsList: document.getElementById('conversationsList'),
            newChatBtn: document.getElementById('newChatBtn'),
            clearHistoryBtn: document.getElementById('clearHistoryBtn'),
            loadingSpinner: document.getElementById('loadingSpinner'),
            toastContainer: document.getElementById('toastContainer'),

            fileUploadBtn: document.getElementById('fileUploadBtn'),
            regenerateBtn: document.getElementById('regenerateBtn'),
            shareChatBtn: document.getElementById('shareChatBtn'),
            templateBtn: document.getElementById('templateBtn'),
            clearInputBtn: document.getElementById('clearInputBtn'),
            charCount: document.getElementById('charCount'),
            conversationSearch: document.getElementById('conversationSearch'),
            conversationFilter: document.getElementById('conversationFilter'),
            modelInfo: document.getElementById('modelInfo'),
            typingIndicator: document.getElementById('typingIndicator'),
            themeToggle: document.getElementById('themeToggle')
        };

        // Hide clear history button by default
        this.updateClearHistoryButtonVisibility();
    }

    attachEventListeners() {
        // Chat form
        if (this.elements.chatForm) {
            this.elements.chatForm.addEventListener('submit', (e) => this.handleSendMessage(e));
        }
        if (this.elements.messageInput) {
            this.elements.messageInput.addEventListener('keydown', (e) => this.handleKeyDown(e));
            this.elements.messageInput.addEventListener('input', () => {
                this.updateCharCounter();
                this.autoResizeInput();
            });
            this.elements.messageInput.addEventListener('paste', () => {
                // Use setTimeout to allow paste content to be added first
                setTimeout(() => {
                    this.autoResizeInput();
                }, 10);
            });
            // Initial auto-resize
            this.autoResizeInput();
        }
        
        // Model and API
        if (this.elements.aiModelSelect) {
            this.elements.aiModelSelect.addEventListener('change', (e) => this.handleModelChange(e));
        }
        
        // Actions
        if (this.elements.newChatBtn) {
            this.elements.newChatBtn.addEventListener('click', () => this.createNewConversation());
        }
        if (this.elements.clearHistoryBtn) {
            this.elements.clearHistoryBtn.addEventListener('click', () => this.clearAllHistory());
        }
        if (this.elements.fileUploadBtn) {
            this.elements.fileUploadBtn.addEventListener('click', () => this.openFileUploadModal());
        }
        if (this.elements.regenerateBtn) {
            this.elements.regenerateBtn.addEventListener('click', () => this.regenerateLastResponse());
        }
        if (this.elements.shareChatBtn) {
            this.elements.shareChatBtn.addEventListener('click', () => this.shareConversation());
        }
        if (this.elements.templateBtn) {
            this.elements.templateBtn.addEventListener('click', () => this.openTemplateModal());
        }
        if (this.elements.clearInputBtn) {
            this.elements.clearInputBtn.addEventListener('click', () => this.clearInput());
        }
        
        // Chat action buttons in input tools area (for all screen sizes)
        const inputFileUploadBtn = document.getElementById('inputFileUploadBtn');
        if (inputFileUploadBtn) {
            inputFileUploadBtn.addEventListener('click', () => this.openFileUploadModal());
        }
        
        const inputShareBtn = document.getElementById('inputShareBtn');
        if (inputShareBtn) {
            inputShareBtn.addEventListener('click', () => this.shareConversation());
        }
        
        const inputRegenerateBtn = document.getElementById('inputRegenerateBtn');
        if (inputRegenerateBtn) {
            inputRegenerateBtn.addEventListener('click', () => this.regenerateLastResponse());
        }
        
        // Export/Import functions - connect to exportSystem
        const exportAllBtn = document.getElementById('exportAllBtn');
        if (exportAllBtn) {
            
            exportAllBtn.addEventListener('click', () => {
                
                
                if (window.exportSystem) {
                    
                    window.exportSystem.showExportModal('all');
                } else {
                    
                    this.showToast('Export system not loaded', 'error');
                }
            });
        }
        
        const importBtn = document.getElementById('importBtn');
        if (importBtn) {
            
            importBtn.addEventListener('click', () => {
                
                
                if (window.exportSystem) {
                    
                    window.exportSystem.showImportModal();
                } else {
                    
                    this.showToast('Import system not loaded', 'error');
                }
            });
        }
        
        // Sidebar
        if (this.elements.conversationSearch) {
            this.elements.conversationSearch.addEventListener('input', () => this.filterConversations());
        }
        if (this.elements.conversationFilter) {
            this.elements.conversationFilter.addEventListener('change', () => this.filterConversations());
        }
        
        // Conversation list event delegation
        this.setupConversationListListeners();
        
        // Theme
        if (this.elements.themeToggle) {
            this.elements.themeToggle.addEventListener('click', () => this.toggleTheme());
        }
        
        // File upload
        this.setupFileUploadListeners();
        
        // Message actions
        this.setupMessageActions();
        
        // Modal listeners
        this.setupModalListeners();
        
        // Navigation
        this.setupNavigationListeners();
    }

    setupModalListeners() {
        
        
        // File upload modal
        window.closeFileUploadModal = () => {
            
            this.closeFileUploadModal();
        };
        window.uploadFiles = () => {
            
            return this.processFileUpload();
        };
        
        // Template modal
        window.closeTemplateModal = () => {
            
            this.closeTemplateModal();
        };
        
        // Search modal
        window.closeSearchModal = () => {
            
            this.closeSearchModal();
        };
        
        // Edit message modal
        window.closeEditMessageModal = () => {
            
            this.closeEditMessageModal();
        };
        window.saveEditedMessage = () => {
            
            this.saveEditedMessage();
        };
        
        // Import/Export modal
        window.closeImportExportModal = () => {
            
            if (window.exportSystem) {
                window.exportSystem.closeExportModal();
            } else {
                this.closeImportExportModal();
            }
        };
        
        // Also add VS class removal to main app's modal close
        this.closeImportExportModal = () => {
            const modal = document.getElementById('importExportModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('active', 'import-export-modal');
            }
        };
        
        
    }

    setupNavigationListeners() {
        document.querySelectorAll('[data-page]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = link.getAttribute('data-page');
                this.navigateToPage(page);
            });
        });
        
        // Hamburger menu toggle for mobile
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.querySelector('.sidebar');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        
        if (hamburgerBtn && sidebar) {
            hamburgerBtn.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
                
            });
        }
        
        if (closeSidebarBtn && sidebar) {
            closeSidebarBtn.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
            });
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (sidebar && sidebar.classList.contains('mobile-open')) {
                if (!sidebar.contains(e.target) && !hamburgerBtn.contains(e.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });
    }

    navigateToPage(page) {
        switch(page) {
            case 'search':
                this.openSearchModal();
                break;
            case 'templates':
                this.openTemplateModal();
                break;
            default:
                this.showToast('Page not implemented yet', 'info');
        }
    }

    setupFileUploadListeners() {
        const fileInput = document.getElementById('fileInput');
        const uploadArea = document.getElementById('uploadArea');
        
        if (fileInput) {
            fileInput.addEventListener('change', (e) => this.handleFileSelect(e));
        }
        
        if (uploadArea) {
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                this.handleFileDrop(e);
            });
        }
    }

    setupMessageActions() {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('message-action-edit')) {
                const messageIndex = parseInt(e.target.dataset.index);
                this.editMessage(messageIndex);
            } else if (e.target.classList.contains('message-action-copy')) {
                const messageIndex = parseInt(e.target.dataset.index);
                this.copyMessage(messageIndex);
            } else if (e.target.classList.contains('message-action-share')) {
                const messageIndex = parseInt(e.target.dataset.index);
                this.shareMessage(messageIndex);
            }
        });
    }



    // Theme Management
    loadTheme() {
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
        this.updateThemeIcon(savedTheme);
    }

    toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        this.updateThemeIcon(newTheme);
        this.showToast(`Switched to ${newTheme} theme`, 'success');
    }

    updateThemeIcon(theme) {
        if (this.elements && this.elements.themeToggle) {
            this.elements.themeToggle.textContent = theme === 'dark' ? 'Light' : 'Dark';
        }
    }

    // Character Counter
    updateCharCounter() {
        if (this.elements && this.elements.messageInput && this.elements.charCount) {
            const count = this.elements.messageInput.value.length;
            this.elements.charCount.textContent = count;
            
            if (count > 9000) {
                this.elements.charCount.style.color = 'var(--error-color)';
            } else if (count > 8000) {
                this.elements.charCount.style.color = 'var(--warning-color)';
            } else {
                this.elements.charCount.style.color = 'var(--text-muted)';
            }
        }
    }

    // Auto-resize input textarea
    autoResizeInput() {
        const textarea = this.elements.messageInput;
        if (!textarea) return;
        
        // Reset height to calculate natural height
        textarea.style.height = 'auto';
        
        // Get the computed style to use consistent line height
        const computedStyle = window.getComputedStyle(textarea);
        const lineHeight = parseFloat(computedStyle.lineHeight);
        const paddingTop = parseFloat(computedStyle.paddingTop);
        const paddingBottom = parseFloat(computedStyle.paddingBottom);
        const borderTop = parseFloat(computedStyle.borderTopWidth);
        const borderBottom = parseFloat(computedStyle.borderBottomWidth);
        
        // Calculate natural height
        const scrollHeight = textarea.scrollHeight;
        const naturalHeight = scrollHeight + paddingTop + paddingBottom + borderTop + borderBottom;
        
        // Set minimum and maximum heights
        const minHeight = 64; // px
        const maxHeight = 200; // px
        
        // Apply height with constraints
        if (naturalHeight < minHeight) {
            textarea.style.height = minHeight + 'px';
        } else if (naturalHeight > maxHeight) {
            textarea.style.height = maxHeight + 'px';
            textarea.style.overflowY = 'auto'; // Show scrollbar when max height reached
        } else {
            textarea.style.height = naturalHeight + 'px';
            textarea.style.overflowY = 'hidden'; // Hide scrollbar when under max height
        }
        
        // Adjust input wrapper padding if needed
        const inputWrapper = textarea.closest('.input-wrapper');
        if (inputWrapper) {
            const currentPadding = parseFloat(window.getComputedStyle(inputWrapper).padding);
            if (naturalHeight > 80) {
                inputWrapper.style.padding = '8px 6px';
            } else {
                inputWrapper.style.padding = '6px';
            }
        }
    }

    // API Key Management
    loadApiKey() {
        this.currentModel = localStorage.getItem('selectedModel') || 'gemini';
        if (this.elements.aiModelSelect) {
            this.elements.aiModelSelect.value = this.currentModel;
        }
        
        // Enhanced API key loading with better error handling
        const storedKey = localStorage.getItem('apiKey_' + this.currentModel);
        this.apiKey = storedKey || '';
        
        // Debug logging (remove in production)
        
        
        
        

        
        // Dump all localStorage keys for debugging
        
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            const value = localStorage.getItem(key);

        }
        
        // Check if key exists in localStorage but is empty or null
        if (localStorage.getItem('apiKey_' + this.currentModel) === null) {
            
        } else if (localStorage.getItem('apiKey_' + this.currentModel) === '') {
            
        }
        
        
        
        this.updateModelInfo();
        this.updateApiKeyStatus();
    }

    // Enhanced API key validation and status checking
    validateApiKey(key, model) {
        if (!key || typeof key !== 'string') return false;
        
        // Remove any whitespace
        key = key.trim();
        
        // Enhanced model-specific validation patterns (more flexible)
        const patterns = {
            // Gemini: More flexible pattern to handle different key lengths
            gemini: /^AIza[0-9A-Za-z\-_]{20,}$/,
            // Claude: More flexible pattern
            claude: /^sk-ant-[a-zA-Z0-9\-]{50,}$/,
            // GPT: More flexible pattern
            gpt: /^sk-[a-zA-Z0-9]{20,}$/,
            // DeepSeek: More flexible pattern
            deepseek: /^sk-[a-zA-Z0-9]{20,}$/
        };
        
        if (patterns[model]) {
            return patterns[model].test(key);
        }
        
        // For unknown models, do basic length and character validation
        return key.length >= 20 && /^[a-zA-Z0-9\-_]+$/.test(key);
    }

    // Check API key status for current model
    updateApiKeyStatus() {
        const keyStatus = this.getApiKeyStatus(this.currentModel);
        this.updateStatusDisplay(keyStatus);
    }

    // Get comprehensive API key status
    getApiKeyStatus(model) {
        const storageKey = 'apiKey_' + model;
        const key = localStorage.getItem(storageKey);
        
        
        

        
        
        if (!key) {
            
            return {
                exists: false,
                valid: false,
                message: 'No API key configured',
                type: 'empty'
            };
        }
        
        const isValid = this.validateApiKey(key, model);
        
        
        return {
            exists: true,
            valid: isValid,
            message: isValid ? 'API key configured' : 'Invalid API key format',
            type: isValid ? 'valid' : 'invalid'
        };
    }

    // Update API key status display in UI
    updateStatusDisplay(status) {
        const statusElement = document.getElementById(`${this.currentModel}-status`);
        if (statusElement) {
            statusElement.textContent = status.message;
            statusElement.className = `vs-status ${status.type}`;
            
            // Update with appropriate icon
            const icon = status.type === 'valid' ? '✅' : 
                        status.type === 'invalid' ? '⚠️' : '❌';
            statusElement.innerHTML = `${icon} ${status.message}`;
        }
    }

    // Test API key validity
    async testApiKey(model = this.currentModel) {
        const status = this.getApiKeyStatus(model);
        
        if (!status.exists) {
            this.showToast(`No ${this.getModelName(model)} API key configured`, 'warning');
            return false;
        }
        
        if (!status.valid) {
            this.showToast(`Invalid ${this.getModelName(model)} API key format`, 'error');
            return false;
        }
        
        try {
            this.showToast(`Testing ${this.getModelName(model)} API key...`, 'info');
            
            // Simple test request to validate the key
            const testData = {
                model: model,
                message: 'Hello',
                api_key: localStorage.getItem('apiKey_' + model),
                history: [],
                temperature: 0.1,
                max_tokens: 10
            };
            
            const response = await fetch('api/chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(testData)
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showToast(`${this.getModelName(model)} API key is valid!`, 'success');
                return true;
            } else {
                this.showToast(`${this.getModelName(model)} API key test failed: ${data.error}`, 'error');
                return false;
            }
        } catch (error) {
            this.showToast(`API key test failed: ${error.message}`, 'error');
            return false;
        }
    }

    handleModelChange(e) {
        this.currentModel = e.target.value;
        localStorage.setItem('selectedModel', this.currentModel);
        
        // Enhanced API key retrieval with debugging
        const storedKey = localStorage.getItem('apiKey_' + this.currentModel);
        this.apiKey = storedKey || '';
        
        

        
        
        this.updateModelInfo();
        this.updateApiKeyStatus();
        
        // Show appropriate message based on API key status
        const status = this.getApiKeyStatus(this.currentModel);
        const modelName = this.getModelName(this.currentModel);
        
        if (!status.exists) {
            this.showToast(`Model changed to ${modelName}. Please configure API key in settings.`, 'warning');
        } else if (!status.valid) {
            this.showToast(`Model changed to ${modelName}. Current API key appears invalid.`, 'error');
        } else {
            this.showToast(`Model changed to ${modelName}`, 'info');
        }
    }

    updateModelInfo() {
        const modelInfo = {
            gemini: { name: 'Gemini 2.5 Flash', speed: 'Fast', cost: 'Low' },
            claude: { name: 'Claude 3.5 Sonnet', speed: 'Medium', cost: 'Medium' },
            gpt: { name: 'GPT-4 Turbo', speed: 'Medium', cost: 'High' },
            deepseek: { name: 'DeepSeek', speed: 'Fast', cost: 'Very Low' },
            llama: { name: 'Llama 3', speed: 'Medium', cost: 'Low' },
            mistral: { name: 'Mistral AI', speed: 'Fast', cost: 'Low' }
        };
        
        const info = modelInfo[this.currentModel];
        if (info && this.elements.modelInfo) {
            this.elements.modelInfo.innerHTML = `
                <span class="model-name">${info.name}</span>
                <span class="model-speed hide-on-mobile">Speed: ${info.speed}</span>
                <span class="model-cost hide-on-mobile">Cost: ${info.cost}</span>
            `;
        }
    }

    // Diagnostic function to check API key configuration
    async runDiagnostics() {
        

        
        
        

        
        // Check all localStorage keys
        
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            const value = localStorage.getItem(key);
            if (key && value) {

            } else {
                
            }
        }
        
        // Check API key status for current model
        
        const status = this.getApiKeyStatus(this.currentModel);
        
        
        // Check all models
        
        const models = ['gemini', 'claude', 'gpt', 'deepseek', 'llama', 'mistral'];
        models.forEach(model => {
            const key = localStorage.getItem('apiKey_' + model);
            const modelStatus = this.getApiKeyStatus(model);

        });
        
        // Check selected model
        const selectedModel = localStorage.getItem('selectedModel');
        
        
        
        // Test current API key if available
        if (this.apiKey && this.currentModel) {
            
            try {
                
                const isValid = await this.testApiKey(this.currentModel);
                
            } catch (error) {
                
            }
        } else {
            
            
        }
        
        
    }

    // Simple localStorage dump function
    dumpLocalStorage() {
        
        
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            const value = localStorage.getItem(key);
            
        }
        
    }

    getModelName(model) {
        const names = {
            'gemini': 'Google Gemini 2.5 Flash',
            'claude': 'Anthropic Claude 3.5 Sonnet',
            'gpt': 'OpenAI GPT-4 Turbo',
            'deepseek': 'DeepSeek',
            'llama': 'Meta Llama 3',
            'mistral': 'Mistral AI'
        };
        return names[model] || model;
    }

    // Conversation Management
    createNewConversation() {
        const id = Date.now().toString();
        const conversation = {
            id,
            title: 'New Chat',
            model: this.currentModel,
            messages: [],
            created: new Date().toISOString(),
            updated: new Date().toISOString(),
            pinned: false,
            tags: []
        };

        this.conversations.unshift(conversation);
        this.saveConversations();
        this.switchConversation(id);
        this.updateClearHistoryButtonVisibility();
        this.showToast('New conversation created', 'success');
    }

    switchConversation(id) {
        this.currentConversationId = id;
        const conversation = this.conversations.find(c => c.id === id);

        if (conversation) {
            this.messageHistory = conversation.messages || [];
            this.renderMessages();
            this.updateConversationsList();
            localStorage.setItem('currentConversation', id);
        }
    }

    async handleSendMessage(e) {
        e.preventDefault();

        const message = this.elements.messageInput.value.trim();
        if (!message) return;

        // CRITICAL FIX: Ensure API key is properly loaded before checking
        
        
        // Force refresh API key from localStorage
        const freshKey = localStorage.getItem('apiKey_' + this.currentModel);
        this.apiKey = freshKey || '';
        
        

        
        // Enhanced API key validation before sending
        const status = this.getApiKeyStatus(this.currentModel);
        
        
        
        if (!status.exists) {
            this.showToast(`No ${this.getModelName(this.currentModel)} API key configured. Please add one in Settings.`, 'error');
            // Optionally redirect to settings
            if (confirm(`Would you like to open Settings to configure your ${this.getModelName(this.currentModel)} API key?`)) {
                window.location.href = 'pages/settings.php';
            }
            return;
        }
        
        if (!status.valid) {
            this.showToast(`Invalid ${this.getModelName(this.currentModel)} API key format. Please check your key in Settings.`, 'error');
            if (confirm('Would you like to open Settings to fix your API key?')) {
                window.location.href = 'pages/settings.php';
            }
            return;
        }

        // Create new conversation if none exists
        if (!this.currentConversationId) {
            this.createNewConversation();
        }

        // Add user message
        const userMessage = {
            role: 'user',
            content: message,
            timestamp: new Date().toISOString(),
            files: [...this.uploadedFiles]
        };

        this.messageHistory.push(userMessage);
        this.renderMessages();
        this.elements.messageInput.value = '';
        this.autoResizeInput(); // Reset input height after sending
        this.elements.sendBtn.disabled = true;
        this.uploadedFiles = [];

        // Show typing indicator
        this.showTypingIndicator(true);

        try {
            const response = await this.sendMessageToAPI(message);
            
            // Add AI response
            const aiMessage = {
                role: 'ai',
                content: response,
                timestamp: new Date().toISOString(),
                model: this.currentModel
            };

            this.messageHistory.push(aiMessage);
            this.renderMessages();
            this.saveCurrentConversation();
            
            // Text-to-speech for AI response (if enabled in settings)
            if (window.voiceManager && window.voiceManager.voiceSettings.ttsEnabled) {
                window.voiceManager.speakText(response);
            }
            
        } catch (error) {
            this.showToast('Error: ' + error.message, 'error');
        } finally {
            this.showTypingIndicator(false);
            this.elements.sendBtn.disabled = false;
        }
    }

    async sendMessageToAPI(message) {
        const apiHistory = this.messageHistory.map(msg => ({
            role: msg.role === 'user' ? 'user' : 'assistant',
            content: msg.content
        }));

        const systemPrompt = localStorage.getItem('systemPrompt') || '';
        const temperature = parseFloat(localStorage.getItem('temperature') || '0.7');
        const maxTokens = parseInt(localStorage.getItem('maxTokens') || '1000');

        // Enhanced API key check before sending
        if (!this.apiKey) {
            throw new Error(`${this.getModelName(this.currentModel)} API key is missing. Please configure it in Settings.`);
        }

        // Double-check API key is still valid
        const status = this.getApiKeyStatus(this.currentModel);
        if (!status.exists) {
            throw new Error(`${this.getModelName(this.currentModel)} API key not found. Please configure it in Settings.`);
        }

        const requestData = {
            model: this.currentModel,
            message: systemPrompt ? `${systemPrompt}\n\nUser: ${message}` : message,
            api_key: this.apiKey,
            history: apiHistory,
            temperature: temperature,
            max_tokens: maxTokens,
            files: this.uploadedFiles
        };

        // Debug logging (removed)

        const response = await fetch('api/chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        });

        const data = await response.json();

        if (!data.success) {
            
            
            // More specific error messages
            if (data.error && data.error.includes('API key')) {
                throw new Error(`${this.getModelName(this.currentModel)} API key is invalid or expired. Please check your key in Settings.`);
            } else if (data.error && data.error.includes('rate limit')) {
                throw new Error(`${this.getModelName(this.currentModel)} rate limit exceeded. Please wait and try again.`);
            } else if (data.error && data.error.includes('quota')) {
                throw new Error(`${this.getModelName(this.currentModel)} quota exceeded. Please check your billing.`);
            } else {
                throw new Error(data.error || `${this.getModelName(this.currentModel)} API Error: An unknown error occurred`);
            }
        }

        return data.response;
    }

    // Enhanced Message Rendering
    renderMessages() {
        if (this.messageHistory.length === 0) {
            this.elements.chatMessages.innerHTML = this.getWelcomeMessageHTML();
            return;
        }

        this.elements.chatMessages.innerHTML = this.messageHistory.map((msg, index) => 
            this.createMessageElement(msg, index)
        ).join('');
        this.scrollToBottom();
    }

    createMessageElement(msg, index) {
        const isUser = msg.role === 'user';
        const avatar = isUser ? 'U' : this.getModelAvatar(msg.model || this.currentModel);
        const className = isUser ? 'message user' : 'message ai';

        const contentHtml = this.parseMessageContent(msg.content);
        const filesHtml = this.renderFileAttachments(msg.files || []);

        return `
            <div class="${className}" data-index="${index}">
                <div class="message-avatar">${avatar}</div>
                <div class="message-content">
                    <div class="message-bubble ${msg.role}">
                        ${contentHtml}
                        ${filesHtml}
                    </div>
                    <div class="message-meta">
                        <span>${this.formatTimestamp(msg.timestamp)}</span>
                        ${!isUser ? `<span class="model-badge">${this.getModelName(msg.model || this.currentModel)}</span>` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    getModelAvatar(model) {
        const avatars = {
            gemini: 'G',
            claude: 'C',
            gpt: 'O',
            deepseek: 'D',
            llama: 'L',
            mistral: 'M'
        };
        return avatars[model] || 'AI';
    }

    renderFileAttachments(files) {
        if (!files || files.length === 0) return '';
        
        return files.map(file => `
            <div class="file-attachment">
                <i class="fas ${this.getFileIcon(file.type)}"></i>
                <div class="file-info">
                    <h4>${file.name}</h4>
                    <p>${this.formatFileSize(file.size)}</p>
                </div>
                <button class="file-download" onclick="downloadFile('${file.name}', '${file.content}')">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        `).join('');
    }

    getFileIcon(type) {
        const icons = {
            'image': 'fa-image',
            'pdf': 'fa-file-pdf',
            'text': 'fa-file-alt',
            'document': 'fa-file-word',
            'csv': 'fa-file-csv',
            'json': 'fa-file-code'
        };
        return icons[type] || 'fa-file';
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;
        
        if (diff < 60000) return 'Just now';
        if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`;
        if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`;
        if (diff < 604800000) return date.toLocaleDateString();
        return date.toLocaleDateString();
    }

    parseMessageContent(content) {
        // Enhanced markdown parsing with better code highlighting
        let html = content
            .replace(/&/g, '&')
            .replace(/</g, '<')
            .replace(/>/g, '>');

        // Code blocks with language detection
        html = html.replace(/```(\w+)?\n([\s\S]*?)```/g, (match, lang, code) => {
            const language = lang || 'text';
            const trimmedCode = code.trim();
            return `<pre><code class="language-${language}">${trimmedCode}</code></pre>`;
        });

        // Inline code
        html = html.replace(/`([^`]+)`/g, '<code>$1</code>');

        // Bold and italic
        html = html.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
        html = html.replace(/\*([^*]+)\*/g, '<em>$1</em>');

        // Links
        html = html.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank" rel="noopener">$1</a>');

        // Line breaks
        html = html.replace(/\n/g, '<br>');

        return html;
    }

    scrollToBottom() {
        setTimeout(() => {
            this.elements.chatMessages.scrollTop = this.elements.chatMessages.scrollHeight;
        }, 100);
    }

    saveCurrentConversation() {
        if (!this.currentConversationId) return;

        const conversation = this.conversations.find(c => c.id === this.currentConversationId);
        if (conversation) {
            conversation.messages = this.messageHistory;
            conversation.updated = new Date().toISOString();
            conversation.model = this.currentModel;

            // Update title from first message if it's the first update
            if (conversation.title === 'New Chat' && this.messageHistory.length > 0) {
                const firstMessage = this.messageHistory[0].content;
                conversation.title = firstMessage.substring(0, 50) + (firstMessage.length > 50 ? '...' : '');
            }

            this.saveConversations();
            this.updateConversationsList();
        }
    }

    autoSaveConversations() {
        if (this.conversations.length > 0) {
            this.saveConversations();
        }
    }

    saveConversations() {
        localStorage.setItem('conversations', JSON.stringify(this.conversations));
    }

    loadConversations() {
        const saved = localStorage.getItem('conversations');
        if (saved) {
            try {
                this.conversations = JSON.parse(saved);
                this.updateConversationsList();
                this.updateClearHistoryButtonVisibility();

                // Load last conversation
                const lastConversationId = localStorage.getItem('currentConversation');
                if (lastConversationId && this.conversations.find(c => c.id === lastConversationId)) {
                    this.switchConversation(lastConversationId);
                }
            } catch (e) {
                
                this.conversations = [];
                this.updateClearHistoryButtonVisibility();
            }
        }
    }

    setupConversationListListeners() {
        // Use event delegation for conversation clicks
        this.elements.conversationsList.addEventListener('click', (e) => {
            const conversationItem = e.target.closest('.conversation-item');
            if (!conversationItem) return;

            const conversationId = conversationItem.dataset.id;
            if (!conversationId) return;

            // Check if delete button was clicked
            const deleteBtn = e.target.closest('.conversation-delete');
            if (deleteBtn) {
                this.handleDeleteConversation(conversationId);
                return;
            }

            // Switch to the clicked conversation
            this.switchConversation(conversationId);
        });
    }

    updateClearHistoryButtonVisibility() {
        if (this.elements && this.elements.clearHistoryBtn) {
            // Show button only if there are conversations
            this.elements.clearHistoryBtn.style.display = this.conversations.length > 0 ? 'block' : 'none';
        }
    }

    handleDeleteConversation(conversationId) {
        if (confirm('Delete this conversation?')) {
            this.conversations = this.conversations.filter(c => c.id !== conversationId);
            this.saveConversations();

            if (this.currentConversationId === conversationId) {
                this.currentConversationId = null;
                this.messageHistory = [];
                this.renderMessages();
                localStorage.removeItem('currentConversation');
            }

            this.updateConversationsList();
            this.updateClearHistoryButtonVisibility();
            this.showToast('Conversation deleted', 'success');
        }
    }

    updateConversationsList() {
        const filtered = this.getFilteredConversations();
        
        this.elements.conversationsList.innerHTML = filtered.map(conv => `
            <div class="conversation-item ${conv.id === this.currentConversationId ? 'active' : ''} ${conv.pinned ? 'pinned' : ''}" data-id="${conv.id}">
                <div class="conversation-content">
                    <strong>${conv.title}</strong>
                    <br>
                    <small style="color: var(--text-muted);">${this.getModelName(conv.model)} • ${this.formatTimestamp(conv.updated)}</small>
                    ${conv.tags ? `<div class="conversation-tags">${conv.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}</div>` : ''}
                </div>
                <button class="conversation-delete" data-id="${conv.id}" title="Delete conversation">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `).join('');

        if (filtered.length === 0) {
            this.elements.conversationsList.innerHTML = '<p style="padding: 1rem; text-align: center; color: var(--text-muted);">No conversations found</p>';
        }
    }

    getFilteredConversations() {
        let filtered = [...this.conversations];
        
        const searchTerm = this.elements.conversationSearch.value.toLowerCase();
        const filter = this.elements.conversationFilter.value;
        
        if (searchTerm) {
            filtered = filtered.filter(conv => 
                conv.title.toLowerCase().includes(searchTerm) ||
                conv.messages.some(msg => msg.content.toLowerCase().includes(searchTerm))
            );
        }
        
        if (filter !== 'all') {
            const now = new Date();
            switch(filter) {
                case 'today':
                    filtered = filtered.filter(conv => 
                        new Date(conv.created).toDateString() === now.toDateString()
                    );
                    break;
                case 'week':
                    filtered = filtered.filter(conv => 
                        (now - new Date(conv.created)) <= 7 * 24 * 60 * 60 * 1000
                    );
                    break;
                case 'pinned':
                    filtered = filtered.filter(conv => conv.pinned);
                    break;
            }
        }
        
        return filtered;
    }

    filterConversations() {
        this.updateConversationsList();
    }



    clearAllHistory() {
        if (confirm('Clear all conversations? This action cannot be undone.')) {
            this.conversations = [];
            this.currentConversationId = null;
            this.messageHistory = [];
            this.saveConversations();
            this.renderMessages();
            this.updateConversationsList();
            this.updateClearHistoryButtonVisibility();
            this.showToast('All conversations cleared', 'success');
        }
    }



    // File Upload
    openFileUploadModal() {
        
        const modal = document.getElementById('fileUploadModal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('active');
            this.initializeEnhancedUpload();
            
        } else {
            
            this.showToast('File upload modal not found', 'error');
        }
    }

    closeFileUploadModal() {
        
        const modal = document.getElementById('fileUploadModal');
        if (modal) {
            modal.classList.remove('active');
            modal.style.display = 'none';
        }
        this.uploadedFiles = [];
        this.updateEnhancedFileList();
        this.resetUploadModal();
        
    }

    initializeEnhancedUpload() {
        // Set up VS Code style tab switching for file upload modal
        this.setupFileUploadTabs();
        
        // Set up browse files button
        const browseBtn = document.getElementById('browseFilesBtn');
        const fileInput = document.getElementById('fileInput');
        
        if (browseBtn && fileInput) {
            browseBtn.addEventListener('click', () => {
                
                try {
                    fileInput.click();

                } catch (error) {

                    this.showToast('File browser opening failed. Try using Ctrl+O or refresh the page.', 'warning');
                }
            });
        }

        // Set up clear files button
        const clearBtn = document.getElementById('clearFilesBtn');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                this.clearAllFiles();
            });
        }

        // Update process upload button state
        this.updateProcessUploadButton();
    }

    setupFileUploadTabs() {
        const fileUploadModal = document.getElementById('fileUploadModal');
        if (!fileUploadModal) return;

        const tabs = fileUploadModal.querySelectorAll('.vs-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                const tabName = e.currentTarget.dataset.tab;
                this.switchFileUploadTab(tabName);
            });
        });
    }

    switchFileUploadTab(tabName) {
        const fileUploadModal = document.getElementById('fileUploadModal');
        if (!fileUploadModal) return;

        // Remove active class from all tabs and panels
        fileUploadModal.querySelectorAll('.vs-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        fileUploadModal.querySelectorAll('.vs-panel-item').forEach(panel => {
            panel.classList.remove('active');
        });

        // Add active class to clicked tab and corresponding panel
        const activeTab = fileUploadModal.querySelector(`.vs-tab[data-tab="${tabName}"]`);
        const activePanel = document.getElementById(`${tabName}-tab`);

        if (activeTab) {
            activeTab.classList.add('active');
        }
        if (activePanel) {
            activePanel.classList.add('active');
        }
    }

    updateProcessUploadButton() {
        const processBtn = document.getElementById('processUploadBtn');
        if (processBtn) {
            processBtn.disabled = this.uploadedFiles.length === 0;
        }
    }

    clearAllFiles() {
        this.uploadedFiles = [];
        this.updateEnhancedFileList();
        this.updateProcessUploadButton();
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.value = '';
        }
        this.showToast('All files cleared', 'info');
    }

    resetUploadModal() {
        // Reset file input
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.value = '';
        }

        // Hide file list section
        const fileListSection = document.getElementById('fileListSection');
        if (fileListSection) {
            fileListSection.style.display = 'none';
        }

        // Reset process button
        this.updateProcessUploadButton();
    }

    handleFileSelect(event) {
        const files = Array.from(event.target.files);
        this.processFiles(files);
    }

    handleFileDrop(event) {
        event.preventDefault();
        const files = Array.from(event.dataTransfer.files);
        this.processFiles(files);
    }

    processFiles(files) {
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const fileData = {
                    name: file.name,
                    type: this.getFileType(file.type),
                    size: file.size,
                    content: e.target.result
                };
                this.uploadedFiles.push(fileData);
                this.updateFileList();
            };
            reader.readAsDataURL(file);
        });
    }

    getFileType(mimeType) {
        if (mimeType.startsWith('image/')) return 'image';
        if (mimeType === 'application/pdf') return 'pdf';
        if (mimeType.includes('text/')) return 'text';
        if (mimeType.includes('word')) return 'document';
        if (mimeType.includes('csv')) return 'csv';
        if (mimeType.includes('json')) return 'json';
        return 'unknown';
    }

    updateFileList() {
        const fileList = document.getElementById('fileList');
        if (fileList && this.uploadedFiles.length > 0) {
            fileList.innerHTML = this.uploadedFiles.map((file, index) => `
                <div class="file-item">
                    <i class="fas ${this.getFileIcon(file.type)}"></i>
                    <span>${file.name}</span>
                    <button onclick="removeFile(${index})">×</button>
                </div>
            `).join('');
        }
    }

    updateEnhancedFileList() {
        const fileList = document.getElementById('fileList');
        const fileListSection = document.getElementById('fileListSection');
        
        if (fileList && this.uploadedFiles.length > 0) {
            fileList.innerHTML = this.uploadedFiles.map((file, index) => `
                <div class="file-item">
                    <i class="fas ${this.getFileIcon(file.type)}"></i>
                    <div class="file-details">
                        <strong>${file.name}</strong>
                        <small>${this.formatFileSize(file.size)} • ${this.getFileType(file.type)}</small>
                    </div>
                    <button onclick="window.app.removeFile(${index})" title="Remove file">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `).join('');
            
            if (fileListSection) {
                fileListSection.style.display = 'block';
            }
        } else {
            if (fileListSection) {
                fileListSection.style.display = 'none';
            }
        }
        
        this.updateProcessUploadButton();
    }

    removeFile(index) {
        this.uploadedFiles.splice(index, 1);
        this.updateEnhancedFileList();
        this.showToast('File removed', 'info');
    }

    processFileUpload() {
        if (this.uploadedFiles.length === 0) {
            this.showToast('Please select files to upload', 'warning');
            return;
        }

        this.closeFileUploadModal();
        this.showToast(`${this.uploadedFiles.length} file(s) ready for analysis`, 'success');
    }

    // Message Editing
    editMessage(messageIndex) {
        
        const message = this.messageHistory[messageIndex];
        
        
        if (message && message.role === 'user') {
            this.currentEditMessage = messageIndex;
            const modal = document.getElementById('editMessageModal');
            const input = document.getElementById('editMessageInput');
            
            
            
            
            
            if (modal && input) {
                input.value = message.content;
                
                // Force modal to be visible
                modal.style.display = 'flex';
                modal.style.opacity = '1';
                modal.style.zIndex = '10000';
                
                // Add active class
                modal.classList.add('active');
                
                
                
                
                // Focus on the input after a short delay
                setTimeout(() => {
                    if (input) {
                        input.focus();
                        input.select();
                        
                    }
                }, 100);
                
            } else {
                
                
                
            }
        } else {
            
        }
    }

    closeEditMessageModal() {
        const modal = document.getElementById('editMessageModal');
        if (modal) {
            modal.style.display = 'none';
        }
        this.currentEditMessage = null;
    }

    saveEditedMessage() {
        if (this.currentEditMessage === null) return;
        
        const input = document.getElementById('editMessageInput');
        const newContent = input.value.trim();
        
        if (!newContent) {
            this.showToast('Message cannot be empty', 'warning');
            return;
        }

        // Update the message
        this.messageHistory[this.currentEditMessage].content = newContent;
        this.messageHistory[this.currentEditMessage].timestamp = new Date().toISOString();
        
        // Remove all messages after the edited message
        this.messageHistory = this.messageHistory.slice(0, this.currentEditMessage + 1);
        
        // Re-render and send
        this.renderMessages();
        this.closeEditMessageModal();
        
        // Send the edited message
        this.sendMessageToAPI(newContent);
    }

    // Regenerate Last Response
    regenerateLastResponse() {
        // Find the last user message
        let lastUserIndex = -1;
        for (let i = this.messageHistory.length - 1; i >= 0; i--) {
            if (this.messageHistory[i].role === 'user') {
                lastUserIndex = i;
                break;
            }
        }
        
        if (lastUserIndex !== -1) {
            // Remove all messages after the last user message
            this.messageHistory = this.messageHistory.slice(0, lastUserIndex + 1);
            this.renderMessages();
            
            // Resend the message
            const message = this.messageHistory[lastUserIndex].content;
            this.sendMessageToAPI(message);
        } else {
            this.showToast('No message to regenerate', 'warning');
        }
    }

    // Copy Message
    copyMessage(messageIndex) {
        const message = this.messageHistory[messageIndex];
        if (message) {
            navigator.clipboard.writeText(message.content).then(() => {
                this.showToast('Message copied to clipboard', 'success');
            });
        }
    }

    // Share Functions
    shareConversation() {
        if (!this.currentConversationId || this.messageHistory.length === 0) {
            this.showToast('No conversation to share', 'warning');
            return;
        }

        const conversation = this.conversations.find(c => c.id === this.currentConversationId);
        const shareData = {
            title: conversation.title,
            messages: this.messageHistory,
            model: this.currentModel,
            exported: new Date().toISOString()
        };

        const shareUrl = this.createShareLink(shareData);
        
        if (navigator.share) {
            navigator.share({
                title: 'AI Chat Conversation',
                text: conversation.title,
                url: shareUrl
            });
        } else {
            navigator.clipboard.writeText(shareUrl).then(() => {
                this.showToast('Share link copied to clipboard', 'success');
            });
        }
    }

    shareMessage(messageIndex) {
        const message = this.messageHistory[messageIndex];
        if (message) {
            navigator.clipboard.writeText(message.content).then(() => {
                this.showToast('Message copied to clipboard', 'success');
            });
        }
    }

    createShareLink(data) {
        const encoded = btoa(JSON.stringify(data));
        return `${window.location.origin}${window.location.pathname}?shared=${encoded}`;
    }

    // Template Functions
    openTemplateModal() {
        const modal = document.getElementById('templateModal');
        if (modal) {
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
            this.loadTemplates();
        }
    }

    closeTemplateModal() {
        const modal = document.getElementById('templateModal');
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
        // Also call the templates system close method if it exists
        if (window.templates && typeof window.templates.closeTemplateModal === 'function') {
            window.templates.closeTemplateModal();
        }
    }

    loadTemplates() {
        // Call the templates system to load and render templates
        if (window.templates && typeof window.templates.renderTemplates === 'function') {
            window.templates.renderTemplates();
        } else if (typeof window.loadTemplateList === 'function') {
            window.loadTemplateList();
        }
    }

    // Search Functions
    openSearchModal() {
        const modal = document.getElementById('searchModal');
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    closeSearchModal() {
        const modal = document.getElementById('searchModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // UI Helpers
    showTypingIndicator(show) {
        if (this.elements.typingIndicator) {
            this.elements.typingIndicator.style.display = show ? 'flex' : 'none';
        }
    }

    showLoadingSpinner(show, message = 'AI is thinking...') {
        if (show) {
            const loadingMessage = document.getElementById('loadingMessage');
            if (loadingMessage) {
                loadingMessage.textContent = message;
            }
            this.elements.loadingSpinner.classList.add('active');
        } else {
            this.elements.loadingSpinner.classList.remove('active');
        }
    }

    showToast(message, type = 'info') {
        // Get or create toast container
        let toastContainer = document.getElementById('toastContainer');
        
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.style.cssText = 'position: fixed; bottom: 2rem; right: 2rem; display: flex; flex-direction: column; gap: 0.5rem; z-index: 10000;';
            document.body.appendChild(toastContainer);
        }
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        // Use consistent VS Code styling
        const typeStyles = {
            success: {
                background: '#0e4429',
                color: '#56d364',
                border: '#1a7f37'
            },
            error: {
                background: '#5a1d1d',
                color: '#ffa198',
                border: '#9e2928'
            },
            warning: {
                background: '#4a3a1a',
                color: '#ffcc02',
                border: '#b8860b'
            },
            info: {
                background: 'var(--card-bg)',
                color: 'var(--text-primary)',
                border: 'var(--border-color)'
            }
        };
        
        const style = typeStyles[type] || typeStyles.info;
        
        toast.style.cssText = `
            padding: 0.75rem 1rem;
            background: ${style.background};
            border: 1px solid ${style.border};
            border-radius: 4px;
            color: ${style.color};
            margin-bottom: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            font-size: 0.9rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideIn 0.3s ease;
        `;
        
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };
        
        toast.innerHTML = `<span>${icons[type] || '•'}</span><span>${message}</span>`;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    handleKeyDown(e) {
        if (e.key === 'Enter' && e.ctrlKey) {
            e.preventDefault();
            this.handleSendMessage(e);
        } else if (e.key === 'Enter' && e.shiftKey) {
            // Allow new line with Shift+Enter
            return;
        } else if (e.key === 'Enter') {
            e.preventDefault();
            // Only add new line, don't send
            const start = e.target.selectionStart;
            const end = e.target.selectionEnd;
            e.target.value = e.target.value.substring(0, start) + '\n' + e.target.value.substring(end);
            e.target.selectionStart = e.target.selectionEnd = start + 1;
        }
    }

    clearInput() {
        this.elements.messageInput.value = '';
        this.updateCharCounter();
        this.autoResizeInput();
        this.elements.messageInput.focus();
    }

    // Keyboard shortcuts
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'n':
                        e.preventDefault();
                        this.createNewConversation();
                        break;
                    case 'k':
                        e.preventDefault();
                        this.openSearchModal();
                        break;
                    case '/':
                        e.preventDefault();
                        this.elements.messageInput.focus();
                        break;
                }
            }
        });
    }

    getWelcomeMessageHTML() {
        return `
            <div class="welcome-message">
                <h2>Welcome to AI Chat Studio v2.0</h2>
                <p>Enhanced with file uploads, conversation templates, and advanced search capabilities!</p>
                <div class="feature-grid">
                    <div class="feature-card">
                        <i class="fas fa-cog"></i>
                        <h3>Voice Controls</h3>
                        <p>Configure in Settings</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-file-upload"></i>
                        <h3>File Upload</h3>
                        <p>Analyze documents & images</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-edit"></i>
                        <h3>Edit Messages</h3>
                        <p>Edit and regenerate responses</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-search"></i>
                        <h3>Smart Search</h3>
                        <p>Find conversations instantly</p>
                    </div>
                </div>
                <p style="margin-top: 2rem; font-size: 0.9rem; color: var(--text-muted);">
                    Go to <strong><a href="pages/settings.php" style="color: var(--primary-color); text-decoration: underline;">Settings</a></strong> to configure your API keys and voice settings.
                </p>
            </div>
        `;
    }

    // Settings page compatibility methods
    toggleKeyVisibility(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    }

    clearApiKey(model) {
        if (confirm(`Remove ${model} API key?`)) {
            localStorage.removeItem(`apiKey_${model}`);
            
            // Update UI if on settings page
            const status = document.getElementById(`${model}-status`);
            if (status) {
                status.innerHTML = '❌ Not configured';
                status.className = 'vs-status empty';
            }
            
            this.showToast(`${model} API key removed`, 'success');
        }
    }

    saveAllApiKeys() {
        const models = ['gemini', 'claude', 'gpt', 'deepseek'];
        let saveCount = 0;

        models.forEach(model => {
            const input = document.getElementById(`${model}-key`);
            if (input && input.value.trim()) {
                const key = input.value.trim();
                localStorage.setItem(`apiKey_${model}`, key);
                saveCount++;
            }
        });

        if (saveCount > 0) {
            this.showToast(`${saveCount} API key(s) saved successfully!`, 'success');
        } else {
            this.showToast('No API keys entered', 'warning');
        }
    }

    loadAllApiKeys() {
        const models = ['gemini', 'claude', 'gpt', 'deepseek'];
        models.forEach(model => {
            const key = localStorage.getItem(`apiKey_${model}`);
            const input = document.getElementById(`${model}-key`);
            const status = document.getElementById(`${model}-status`);
            
            if (input && key) {
                input.value = key;
                if (status) {
                    const isValid = this.validateApiKey(key, model);
                    status.innerHTML = isValid ? '✅ Valid API key' : '⚠️ Invalid format';
                    status.className = `vs-status ${isValid ? 'valid' : 'empty'}`;
                }
            }
        });
    }

    selectModel(model) {
        document.querySelectorAll('.vs-model-card').forEach(card => {
            if (card.getAttribute('data-model') === model) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        });
    }

    saveModelSelection() {
        const selected = document.querySelector('.vs-model-card.selected');
        if (selected) {
            const model = selected.getAttribute('data-model');
            localStorage.setItem('selectedModel', model);
            const modelNames = {
                'gemini': 'Google Gemini 2.5 Flash',
                'claude': 'Anthropic Claude',
                'gpt': 'OpenAI GPT-4 Turbo',
                'deepseek': 'DeepSeek'
            };
            this.showToast(`Default model changed to ${modelNames[model]}`, 'success');
        }
    }

    savePromptSettings() {
        const systemPrompt = document.getElementById('system-prompt')?.value || '';
        const temperature = document.getElementById('temperature')?.value || '0.7';
        const maxTokens = document.getElementById('max-tokens')?.value || '1000';

        localStorage.setItem('systemPrompt', systemPrompt);
        localStorage.setItem('temperature', temperature);
        localStorage.setItem('maxTokens', maxTokens);

        this.showToast('Prompt settings saved!', 'success');
    }

    resetPromptSettings() {
        if (confirm('Reset prompt settings to defaults?')) {
            document.getElementById('system-prompt').value = '';
            document.getElementById('temperature').value = '0.7';
            document.getElementById('max-tokens').value = '1000';
            
            localStorage.removeItem('systemPrompt');
            localStorage.removeItem('temperature');
            localStorage.removeItem('maxTokens');
            
            this.showToast('Prompt settings reset to defaults', 'success');
        }
    }
}

// Global functions for file operations
window.removeFile = function(index) {
    if (window.app) {
        window.app.uploadedFiles.splice(index, 1);
        window.app.updateEnhancedFileList();
    }
};

window.downloadFile = function(name, content) {
    const link = document.createElement('a');
    link.href = content;
    link.download = name;
    link.click();
};

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Don't overwrite window.app if we're on settings page and it already exists
    const isSettingsPage = window.location.pathname.includes('settings.php');
    if (isSettingsPage && window.app && window.app.toggleKeyVisibility) {
        // Just initialize the theme for settings page
        const app = new AIChatHubv2();
        app.loadTheme();
        return;
    }
    
    window.app = new AIChatHubv2();
    
    // Wait for export system to be available and connect it
    const connectExportSystem = () => {
        if (window.exportSystem && window.app) {
            // Connect export system to app
            window.app.exportSystem = window.exportSystem;
            
        } else {
            // Retry after a short delay
            setTimeout(connectExportSystem, 100);
        }
    };
    connectExportSystem();
    
    // Make diagnostic functions globally accessible for debugging
    window.runApiDiagnostics = () => {
        if (window.app) {
            window.app.runDiagnostics();
        }
    };
    
    window.dumpLocalStorage = () => {
        if (window.app) {
            window.app.dumpLocalStorage();
        }
    };
    
    window.checkApiKey = (model = 'gemini') => {
        if (window.app) {
            return window.app.getApiKeyStatus(model);
        }
        return null;
    };
    
    // Test function connections
    window.testFunctions = () => {
        
        
        

        
        // Test button elements

        
        // Test export system directly
        if (window.exportSystem) {
            // Export system available
        }
        
        // Test modal visibility functions
        if (window.app) {
            
            const fileModal = document.getElementById('fileUploadModal');
            if (fileModal) {
                fileModal.style.display = 'flex';
                setTimeout(() => {
                    fileModal.style.display = 'none';
                    
                }, 1000);
            }
            
            
            const importExportModal = document.getElementById('importExportModal');
            if (importExportModal) {
                importExportModal.style.display = 'flex';
                setTimeout(() => {
                    importExportModal.style.display = 'none';
                    
                }, 1000);
            }
        }
    };
    
    // Direct button test functions
    window.testExportButton = () => {
        
        const btn = document.getElementById('exportAllBtn');
        if (btn) {
            
            btn.click();
        } else {
            
        }
    };
    
    window.testImportButton = () => {
        
        const btn = document.getElementById('importBtn');
        if (btn) {
            
            btn.click();
        } else {
            
        }
    };
    
    window.testFileUploadButton = () => {
        
        const btn = document.getElementById('fileUploadBtn');
        if (btn) {
            
            btn.click();
        } else {
            
        }
    };
    
    // Direct modal test functions
    window.testExportModalDirect = () => {
        
        const modal = document.getElementById('importExportModal');
        const title = document.getElementById('importExportTitle');
        const body = document.getElementById('importExportBody');
        

        
        if (modal && title && body) {
            title.textContent = 'Export Conversations (Direct Test)';
            body.innerHTML = '<div style="padding: 2rem; text-align: center;"><h3>Export Test Content</h3><p>This is a direct test of the modal functionality.</p></div>';
            modal.style.display = 'flex';
            modal.classList.add('active');
            
        } else {
            
        }
    };
    
    window.testImportModalDirect = () => {
        
        const modal = document.getElementById('importExportModal');
        const title = document.getElementById('importExportTitle');
        const body = document.getElementById('importExportBody');
        

        
        if (modal && title && body) {
            title.textContent = 'Import Conversations (Direct Test)';
            body.innerHTML = '<div style="padding: 2rem; text-align: center;"><h3>Import Test Content</h3><p>This is a direct test of the import modal functionality.</p></div>';
            modal.style.display = 'flex';
            modal.classList.add('active');
            
        } else {
            
        }
    };
    
    // Close modal function
    window.closeAnyModal = () => {
        
        const modals = document.querySelectorAll('.modal');
        let closedCount = 0;
        modals.forEach(modal => {
            const wasVisible = modal.style.display === 'flex' || modal.classList.contains('active');
            if (wasVisible) {
                modal.style.display = 'none';
                modal.classList.remove('active');
                closedCount++;
                
            }
        });
        
        // Also test if we can manually show a modal
        
        const testModal = document.getElementById('importExportModal');
        
        if (testModal) {
            
            
        }
    };
    
    // Export system test function
    window.testExportSystem = () => {
        
        
        
        if (window.exportSystem) {
            
            return window.exportSystem.testModalDisplay();
        } else {
            
            return false;
        }
    };
    
    // File upload test function
    window.testFileUpload = () => {
        
        
        if (window.exportSystem) {
            
            return window.exportSystem.testFileUpload();
        } else {
            
            return false;
        }
    };
    
    // Force refresh connections
    window.refreshConnections = () => {
        
        
        // Reconnect export system
        if (window.exportSystem && window.app) {
            window.app.exportSystem = window.exportSystem;
            
        }
        
        // Test button connections
        
        const buttons = ['exportAllBtn', 'importBtn', 'fileUploadBtn'];
        buttons.forEach(id => {
            const btn = document.getElementById(id);
            
        });
        
        // Test modal elements
        
        const modals = ['importExportModal', 'fileUploadModal', 'templateModal'];
        modals.forEach(id => {
            const modal = document.getElementById(id);
            
        });
        
        
    };
    
    // Setup keyboard shortcuts
    if (window.app) {
        window.app.setupKeyboardShortcuts();
    }
    
});

// AI Chat Application
class AIChatApp {
    constructor() {
        this.conversations = [];
        this.currentConversationId = null;
        this.currentModel = 'gemini';
        this.apiKey = '';
        this.messageHistory = [];

        this.initializeElements();
        this.loadConversations();
        this.attachEventListeners();
        this.loadApiKey();
    }

    initializeElements() {
        this.chatMessages = document.getElementById('chatMessages');
        this.messageInput = document.getElementById('messageInput');
        this.sendBtn = document.getElementById('sendBtn');
        this.chatForm = document.getElementById('chatForm');
        this.aiModelSelect = document.getElementById('aiModel');
        this.apiKeyInput = document.getElementById('apiKey'); // Can be null if on main chat page
        this.toggleKeyBtn = document.getElementById('toggleKeyBtn'); // Can be null if on main chat page
        this.conversationsList = document.getElementById('conversationsList');
        this.newChatBtn = document.getElementById('newChatBtn');
        this.clearHistoryBtn = document.getElementById('clearHistoryBtn');
        this.loadingSpinner = document.getElementById('loadingSpinner');
        this.toastContainer = document.getElementById('toastContainer');
    }

    attachEventListeners() {
        if (this.chatForm) {
            this.chatForm.addEventListener('submit', (e) => this.handleSendMessage(e));
        }
        if (this.messageInput) {
            this.messageInput.addEventListener('keydown', (e) => this.handleKeyDown(e));
        }
        if (this.toggleKeyBtn) {
            this.toggleKeyBtn.addEventListener('click', () => this.toggleApiKeyVisibility());
        }
        if (this.aiModelSelect) {
            this.aiModelSelect.addEventListener('change', (e) => this.handleModelChange(e));
        }
        if (this.apiKeyInput) {
            this.apiKeyInput.addEventListener('change', () => this.saveApiKey());
        }
        if (this.newChatBtn) {
            this.newChatBtn.addEventListener('click', () => this.createNewConversation());
        }
        if (this.clearHistoryBtn) {
            this.clearHistoryBtn.addEventListener('click', () => this.clearAllHistory());
        }
        
        // Hamburger menu toggle for mobile
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.querySelector('.sidebar');
        
        const closeSidebar = () => {
            hamburgerBtn.classList.remove('active');
            sidebar.classList.remove('mobile-open');
        };
        
        if (hamburgerBtn && sidebar) {
            // Toggle on hamburger click
            hamburgerBtn.addEventListener('click', () => {
                hamburgerBtn.classList.toggle('active');
                sidebar.classList.toggle('mobile-open');
            });
            
            // Close button on sidebar
            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', closeSidebar);
            }
            
            // Close when clicking on a conversation
            sidebar.addEventListener('click', (e) => {
                if (e.target.classList.contains('conversation-item') || 
                    e.target.closest('.conversation-item')) {
                    closeSidebar();
                }
            });
            
            // Close when clicking on sidebar overlay (outside menu area)
            sidebar.addEventListener('click', (e) => {
                if (e.target === sidebar) {
                    closeSidebar();
                }
            });
        }
    }

    handleKeyDown(e) {
        if (e.key === 'Enter' && e.ctrlKey) {
            this.handleSendMessage(e);
        }
    }

    handleModelChange(e) {
        this.currentModel = e.target.value;
        localStorage.setItem('selectedModel', this.currentModel);
        this.loadApiKey();
        this.showToast('Model changed to ' + this.getModelName(this.currentModel), 'info');
    }

    toggleApiKeyVisibility() {
        const isPassword = this.apiKeyInput.type === 'password';
        this.apiKeyInput.type = isPassword ? 'text' : 'password';
        this.toggleKeyBtn.textContent = isPassword ? '🙈' : '👁️';
    }

    getModelName(model) {
        const names = {
            'gemini': 'Google Gemini',
            'claude': 'Anthropic Claude',
            'gpt': 'OpenAI GPT',
            'deepseek': 'DeepSeek'
        };
        return names[model] || model;
    }

    saveApiKey() {
        if (this.apiKeyInput) {
            this.apiKey = this.apiKeyInput.value;
            if (this.apiKey) {
                localStorage.setItem('apiKey_' + this.currentModel, this.apiKey);
                this.showToast('API key saved securely', 'success');
            }
        }
    }

    loadApiKey() {
        this.currentModel = localStorage.getItem('selectedModel') || 'gemini';
        if (this.aiModelSelect) {
            this.aiModelSelect.value = this.currentModel;
        }

        if (this.apiKeyInput) {
            const savedKey = localStorage.getItem('apiKey_' + this.currentModel);
            if (savedKey) {
                this.apiKeyInput.value = savedKey;
                this.apiKey = savedKey;
            }
        } else {
            // On main chat page, just load from localStorage directly
            this.apiKey = localStorage.getItem('apiKey_' + this.currentModel) || '';
        }
    }

    createNewConversation() {
        const id = Date.now().toString();
        const conversation = {
            id,
            title: 'New Chat',
            model: this.currentModel,
            messages: [],
            created: new Date().toISOString(),
            updated: new Date().toISOString()
        };

        this.conversations.unshift(conversation);
        this.saveConversations();
        this.switchConversation(id);
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

        const message = this.messageInput.value.trim();
        if (!message) return;

        if (!this.apiKey) {
            this.showToast('Please enter your API key', 'error');
            return;
        }

        // Create new conversation if none exists
        if (!this.currentConversationId) {
            this.createNewConversation();
        }

        // Add user message
        this.messageHistory.push({
            role: 'user',
            content: message,
            timestamp: new Date().toLocaleTimeString()
        });

        this.renderMessages();
        this.messageInput.value = '';
        this.sendBtn.disabled = true;

        // Show loading spinner
        this.showLoadingSpinner(true);

        try {
            const response = await this.sendMessageToAPI(message);

            // Add AI response
            this.messageHistory.push({
                role: 'ai',
                content: response,
                timestamp: new Date().toLocaleTimeString()
            });

            this.renderMessages();
            this.saveCurrentConversation();
        } catch (error) {
            this.showToast('Error: ' + error.message, 'error');
        } finally {
            this.showLoadingSpinner(false);
            this.sendBtn.disabled = false;
        }
    }

    async sendMessageToAPI(message) {
        const apiHistory = this.messageHistory.map(msg => ({
            role: msg.role === 'user' ? 'user' : 'assistant',
            content: msg.content
        }));

        const response = await fetch('api/chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                model: this.currentModel,
                message: message,
                api_key: this.apiKey,
                history: apiHistory
            })
        });

        const data = await response.json();

        if (!data.success) {
            throw new Error(data.error || 'An error occurred');
        }

        return data.response;
    }

    renderMessages() {
        if (this.messageHistory.length === 0) {
            this.chatMessages.innerHTML = `
                <div class="welcome-message">
                    <h2>Welcome to AI Chat Hub</h2>
                    <p>Start a conversation by typing a message below!</p>
                </div>
            `;
            return;
        }

        this.chatMessages.innerHTML = this.messageHistory.map(msg => this.createMessageElement(msg)).join('');
        this.scrollToBottom();
    }

    createMessageElement(msg) {
        const isUser = msg.role === 'user';
        const avatar = isUser ? '👤' : '🤖';
        const className = isUser ? 'message user' : 'message ai';

        const contentHtml = this.parseMessageContent(msg.content);

        return `
            <div class="${className}">
                <div class="message-avatar">${avatar}</div>
                <div class="message-content">
                    <div class="message-bubble ${msg.role}">
                        ${contentHtml}
                    </div>
                    <div class="message-meta">${msg.timestamp || ''}</div>
                </div>
            </div>
        `;
    }

    parseMessageContent(content) {
        // Convert markdown-like code blocks to HTML
        let html = content
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // Code blocks with language
        html = html.replace(/```(\w+)?\n([\s\S]*?)```/g, (match, lang, code) => {
            return `<pre><code class="language-${lang || 'text'}">${code.trim()}</code></pre>`;
        });

        // Inline code
        html = html.replace(/`([^`]+)`/g, '<code>$1</code>');

        // Line breaks
        html = html.replace(/\n/g, '<br>');

        // Bold
        html = html.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');

        // Italic
        html = html.replace(/\*([^*]+)\*/g, '<em>$1</em>');

        return html;
    }

    scrollToBottom() {
        setTimeout(() => {
            this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
        }, 100);
    }

    saveCurrentConversation() {
        if (!this.currentConversationId) return;

        const conversation = this.conversations.find(c => c.id === this.currentConversationId);
        if (conversation) {
            conversation.messages = this.messageHistory;
            conversation.updated = new Date().toISOString();

            // Update title from first message if it's the first update
            if (conversation.title === 'New Chat' && this.messageHistory.length > 0) {
                const firstMessage = this.messageHistory[0].content;
                conversation.title = firstMessage.substring(0, 50) + (firstMessage.length > 50 ? '...' : '');
            }

            this.saveConversations();
            this.updateConversationsList();
        }
    }

    loadConversations() {
        const saved = localStorage.getItem('conversations');
        if (saved) {
            try {
                this.conversations = JSON.parse(saved);
                this.updateConversationsList();

                // Load last conversation
                const lastConversationId = localStorage.getItem('currentConversation');
                if (lastConversationId && this.conversations.find(c => c.id === lastConversationId)) {
                    this.switchConversation(lastConversationId);
                }
            } catch (e) {
                console.error('Error loading conversations:', e);
                this.conversations = [];
            }
        }
    }

    saveConversations() {
        localStorage.setItem('conversations', JSON.stringify(this.conversations));
    }

    updateConversationsList() {
        this.conversationsList.innerHTML = this.conversations.map(conv => `
            <div class="conversation-item ${conv.id === this.currentConversationId ? 'active' : ''}" data-id="${conv.id}">
                <div style="flex: 1; cursor: pointer;" onclick="app.switchConversation('${conv.id}')">
                    <strong>${conv.title}</strong>
                    <br>
                    <small style="color: var(--text-muted);">${conv.model} • ${this.formatDate(conv.updated)}</small>
                </div>
                <button class="conversation-delete" onclick="app.deleteConversation('${conv.id}')">🗑️</button>
            </div>
        `).join('');

        if (this.conversations.length === 0) {
            this.conversationsList.innerHTML = '<p style="padding: 1rem; text-align: center; color: var(--text-muted);">No conversations yet</p>';
        }
    }

    deleteConversation(id) {
        if (confirm('Delete this conversation?')) {
            this.conversations = this.conversations.filter(c => c.id !== id);
            this.saveConversations();

            if (this.currentConversationId === id) {
                this.currentConversationId = null;
                this.messageHistory = [];
                this.renderMessages();
                localStorage.removeItem('currentConversation');
            }

            this.updateConversationsList();
            this.showToast('Conversation deleted', 'success');
        }
    }

    clearAllHistory() {
        if (confirm('Clear all conversations? This action cannot be undone.')) {
            this.conversations = [];
            this.currentConversationId = null;
            this.messageHistory = [];
            this.saveConversations();
            this.renderMessages();
            this.updateConversationsList();
            this.showToast('All conversations cleared', 'success');
        }
    }

    formatDate(isoString) {
        const date = new Date(isoString);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);

        if (date.toDateString() === today.toDateString()) {
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        } else if (date.toDateString() === yesterday.toDateString()) {
            return 'Yesterday';
        } else {
            return date.toLocaleDateString();
        }
    }

    showLoadingSpinner(show) {
        if (show) {
            this.loadingSpinner.classList.add('active');
        } else {
            this.loadingSpinner.classList.remove('active');
        }
    }

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <span>${this.getToastIcon(type)}</span>
            <span>${message}</span>
        `;

        this.toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('exit');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    getToastIcon(type) {
        const icons = {
            'success': '✓',
            'error': '✕',
            'warning': '⚠',
            'info': 'ℹ'
        };
        return icons[type] || '•';
    }

    // ===========================
    // Settings Management
    // ===========================

    toggleKeyVisibility(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    }

    clearApiKey(model) {
        if (confirm(`Remove ${model} API key?`)) {
            localStorage.removeItem(`apiKey_${model}`);
            this.showToast(`${model} API key removed`, 'success');
            if (typeof loadSettingsPage === 'function') {
                loadSettingsPage();
            }
        }
    }

    saveAllApiKeys() {
        const models = ['gemini', 'claude', 'gpt', 'deepseek'];
        let saveCount = 0;

        models.forEach(model => {
            const input = document.getElementById(`${model}-key`);
            if (input && input.value.trim()) {
                localStorage.setItem(`apiKey_${model}`, input.value.trim());
                saveCount++;
            }
        });

        if (saveCount > 0) {
            this.showToast(`${saveCount} API key(s) saved successfully`, 'success');
            if (typeof showSuccessMessage === 'function') {
                showSuccessMessage();
            }
            setTimeout(() => loadSettingsPage(), 500);
        } else {
            this.showToast('No API keys entered', 'warning');
        }
    }

    loadAllApiKeys() {
        if (typeof loadSettingsPage === 'function') {
            loadSettingsPage();
            this.showToast('Settings reloaded', 'info');
        }
    }

    selectModel(model) {
        document.querySelectorAll('.model-card').forEach(card => {
            if (card.getAttribute('data-model') === model) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        });
    }

    saveModelSelection() {
        const selected = document.querySelector('.model-card.selected');
        if (selected) {
            const model = selected.getAttribute('data-model');
            localStorage.setItem('selectedModel', model);
            this.currentModel = model;
            this.aiModelSelect.value = model;
            this.showToast(`Default model changed to ${this.getModelName(model)}`, 'success');
            if (typeof showSuccessMessage === 'function') {
                showSuccessMessage();
            }
        }
    }

    savePromptSettings() {
        const systemPrompt = document.getElementById('system-prompt')?.value || '';
        const temperature = document.getElementById('temperature')?.value || '0.7';
        const maxTokens = document.getElementById('max-tokens')?.value || '1000';

        localStorage.setItem('systemPrompt', systemPrompt);
        localStorage.setItem('temperature', temperature);
        localStorage.setItem('maxTokens', maxTokens);

        this.showToast('Prompt settings saved', 'success');
        if (typeof showSuccessMessage === 'function') {
            showSuccessMessage();
        }
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
            if (typeof showSuccessMessage === 'function') {
                showSuccessMessage();
            }
        }
    }

    loadSettingsPage() {
        if (typeof loadSettingsPage === 'function') {
            loadSettingsPage();
        }
    }
}

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.app = new AIChatApp();
    initializeQuickStart();
});

// ===========================
// Quick Start Guide Functions
// ===========================
function initializeQuickStart() {
    const quickstartModal = document.getElementById('quickstartModal');
    const closeBtn = document.getElementById('closeQuickstart');
    const dontShowAgain = document.getElementById('dontShowAgain');

    // Check if user has seen quickstart before
    const hasSeenQuickstart = localStorage.getItem('hasSeenQuickstart');
    
    if (!hasSeenQuickstart) {
        setTimeout(() => {
            quickstartModal.classList.add('active');
            // Analytics: quickstart modal shown
            console.log('[QUICKSTART] Modal shown on first visit');
            if (window.dataLayer) {
                window.dataLayer.push({ event: 'quickstart_shown', timestamp: new Date().toISOString() });
            }
        }, 500);
    }

    // Close button
    closeBtn.addEventListener('click', () => {
        if (dontShowAgain.checked) {
            localStorage.setItem('hasSeenQuickstart', 'true');
            console.log('[QUICKSTART] User marked "Don\'t show again"');
        }
        quickstartModal.classList.remove('active');
        console.log('[QUICKSTART] Modal closed via close button');
        if (window.dataLayer) {
            window.dataLayer.push({ event: 'quickstart_closed', method: 'close_button', timestamp: new Date().toISOString() });
        }
    });

    // Click outside to close
    quickstartModal.addEventListener('click', (e) => {
        if (e.target === quickstartModal) {
            if (dontShowAgain.checked) {
                localStorage.setItem('hasSeenQuickstart', 'true');
                console.log('[QUICKSTART] User marked "Don\'t show again" (click outside)');
            }
            quickstartModal.classList.remove('active');
            console.log('[QUICKSTART] Modal closed via click outside');
            if (window.dataLayer) {
                window.dataLayer.push({ event: 'quickstart_closed', method: 'click_outside', timestamp: new Date().toISOString() });
            }
        }
    });
}

function nextQuickstartStep() {
    const steps = document.querySelectorAll('.quickstart-step');
    let currentStep = document.querySelector('.quickstart-step.active');
    let currentIndex = Array.from(steps).indexOf(currentStep);

    if (currentIndex < steps.length - 1) {
        currentStep.classList.remove('active');
        steps[currentIndex + 1].classList.add('active');
        updateQuickstartUI(currentIndex + 1);
        console.log(`[QUICKSTART] Step ${currentIndex + 2} viewed (next button clicked)`);
        if (window.dataLayer) {
            window.dataLayer.push({ event: 'quickstart_step_viewed', step: currentIndex + 2, method: 'next', timestamp: new Date().toISOString() });
        }
    } else {
        const dontShowAgain = document.getElementById('dontShowAgain');
        if (dontShowAgain.checked) {
            localStorage.setItem('hasSeenQuickstart', 'true');
        }
        document.getElementById('quickstartModal').classList.remove('active');
        console.log('[QUICKSTART] Completed - modal closed via Get Started button');
        if (window.dataLayer) {
            window.dataLayer.push({ event: 'quickstart_completed', method: 'get_started', timestamp: new Date().toISOString() });
        }
    }
}

function previousQuickstartStep() {
    const steps = document.querySelectorAll('.quickstart-step');
    let currentStep = document.querySelector('.quickstart-step.active');
    let currentIndex = Array.from(steps).indexOf(currentStep);

    if (currentIndex > 0) {
        currentStep.classList.remove('active');
        steps[currentIndex - 1].classList.add('active');
        updateQuickstartUI(currentIndex - 1);
        console.log(`[QUICKSTART] Step ${currentIndex} viewed (previous button clicked)`);
        if (window.dataLayer) {
            window.dataLayer.push({ event: 'quickstart_step_viewed', step: currentIndex, method: 'previous', timestamp: new Date().toISOString() });
        }
    }
}

function goToQuickstartStep(stepNumber) {
    const steps = document.querySelectorAll('.quickstart-step');
    const currentStep = document.querySelector('.quickstart-step.active');
    currentStep.classList.remove('active');
    steps[stepNumber - 1].classList.add('active');
    updateQuickstartUI(stepNumber - 1);
    console.log(`[QUICKSTART] Step ${stepNumber} viewed (dot clicked)`);
    if (window.dataLayer) {
        window.dataLayer.push({ event: 'quickstart_step_viewed', step: stepNumber, method: 'dot_click', timestamp: new Date().toISOString() });
    }
}

function updateQuickstartUI(stepIndex) {
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === stepIndex);
    });

    if (stepIndex === 0) {
        prevBtn.style.display = 'none';
        nextBtn.textContent = 'Next →';
    } else if (stepIndex === document.querySelectorAll('.quickstart-step').length - 1) {
        prevBtn.style.display = 'block';
        nextBtn.textContent = 'Get Started! →';
    } else {
        prevBtn.style.display = 'block';
        nextBtn.textContent = 'Next →';
    }
}

function setQuickstartModel(model) {
    const options = document.querySelectorAll('.model-option');
    const selectedDiv = document.getElementById('selectedModel');
    const modelNames = {
        'gemini': 'Google Gemini 2.5 Flash ⚡',
        'claude': 'Anthropic Claude 🧠',
        'gpt': 'OpenAI GPT-4 Turbo 🤖',
        'deepseek': 'DeepSeek 🔍'
    };

    options.forEach(opt => opt.classList.remove('selected'));
    event.target.closest('.model-option').classList.add('selected');
    selectedDiv.textContent = '✓ Selected: ' + modelNames[model];

    if (window.app) {
        window.app.currentModel = model;
        window.app.aiModelSelect.value = model;
        localStorage.setItem('selectedModel', model);
    }
    console.log(`[QUICKSTART] Model selected: ${model} (${modelNames[model]})`);
    if (window.dataLayer) {
        window.dataLayer.push({ event: 'quickstart_model_selected', model: model, model_name: modelNames[model], timestamp: new Date().toISOString() });
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>Chat UI — Free Multi-Model AI Chat (Gemini, Claude, GPT, DeepSeek) | Chat-UI</title>
    <meta name="description" content="Chat UI: Unified multi-model AI chat interface — Google Gemini, Anthropic Claude, OpenAI GPT, and DeepSeek. Lightweight, privacy-focused, and freemium — save local conversations and start chatting without signup.">
    <meta name="keywords" content="chat ui,ai chat,gemini,claude,gpt,deepseek,multi-model ai,freemium,openai,self-hosted,local-storage,privacy-first">
    <meta name="category" content="AI & Productivity">
    <meta name="platform" content="Web, PHP, Windows, Linux, macOS">
    <meta name="author" content="AI Chat Hub">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://example.com/">
    <meta property="og:title" content="Chat UI — Free Multi-Model AI Chat (Gemini, Claude, GPT, DeepSeek)">
    <meta property="og:description" content="Chat UI: Multi-model AI chat interface for Gemini, Claude, GPT, and DeepSeek. Freemium, privacy-focused, save conversations locally.">
    <meta property="og:image" content="https://example.com/og-image.png">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://example.com/">
    <meta property="twitter:title" content="Chat UI — Free Multi-Model AI Chat (Gemini, Claude, GPT, DeepSeek)">
    <meta property="twitter:description" content="Chat UI: Multi-model AI chat interface for Gemini, Claude, GPT, and DeepSeek. Freemium, privacy-focused, save conversations locally.">
    <meta property="twitter:image" content="https://example.com/og-image.png">
    
    <!-- Additional SEO -->
    <meta name="theme-color" content="#667eea">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="canonical" href="https://example.com/">
    
    <!-- Structured Data / Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "Chat UI — AI Chat Hub",
        "description": "Chat UI is a freemium multi-model AI chat interface supporting Gemini, Claude, OpenAI GPT, and DeepSeek.",
        "url": "https://example.com/",
        "applicationCategory": "AI & Productivity",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD",
            "description": "Core features are free; premium add-ons require a paid license."
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "ratingCount": "100"
        }
    }
    </script>
    
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="app-container">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="nav-content">
                <button class="hamburger-menu" id="hamburgerBtn" title="Toggle sidebar menu" aria-label="Open sidebar menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="nav-brand">
                    <h1>🤖 AI Chat Hub</h1>
                </div>
                <ul class="nav-links">
                    <li><a href="#" data-page="chat" class="nav-link active">Chat</a></li>
                    <li><a href="pages/about.php" class="nav-link">About</a></li>
                    <li><a href="pages/faqs.php" class="nav-link">FAQs</a></li>
                    <li><a href="pages/settings.php" class="nav-link">⚙️ Settings</a></li>
                    <li><a href="pages/terms.php" class="nav-link">Terms</a></li>
                    <li><a href="pages/privacy.php" class="nav-link">Privacy</a></li>
                </ul>
            </div>
        </nav>

        <div class="main-content">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-header">
                    <h2>Conversations</h2>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn-new-chat" id="newChatBtn" title="Start a new conversation" aria-label="New chat conversation">
                            <span>+ New Chat</span>
                        </button>
                        <button class="btn-close-sidebar" id="closeSidebarBtn" title="Close menu" aria-label="Close sidebar menu">✕</button>
                    </div>
                </div>
                <div class="conversations-list" id="conversationsList">
                    <!-- Conversations will be added here by JS -->
                </div>
                <div class="sidebar-footer">
                    <button class="btn-clear-history" id="clearHistoryBtn" title="Remove all saved conversations" aria-label="Clear all chat history">
                        Clear History
                    </button>
                </div>
            </aside>

            <!-- Chat Area -->
            <div class="chat-container">
                <!-- Chat Messages Area -->
                <div class="chat-messages" id="chatMessages">
                    <div class="welcome-message">
                        <h2>Welcome to AI Chat Hub</h2>
                        <p>👉 Go to <strong><a href="pages/settings.php" style="color: var(--primary-color); text-decoration: underline;">⚙️ Settings</a></strong> to add your API keys and configure your preferred AI model.</p>
                        <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">Once configured, your API keys are stored locally in your browser for future use.</p>
                        <div class="model-info">
                            <div class="info-card">
                                <h3>Google Gemini 2.5 Flash</h3>
                                <p>Fast and accurate responses</p>
                            </div>
                            <div class="info-card">
                                <h3>Anthropic Claude</h3>
                                <p>Advanced reasoning capabilities</p>
                            </div>
                            <div class="info-card">
                                <h3>OpenAI GPT-4 Turbo</h3>
                                <p>Powerful general-purpose AI</p>
                            </div>
                            <div class="info-card">
                                <h3>DeepSeek</h3>
                                <p>Fast and cost-effective</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Input Area -->
                <div class="chat-input-area">
                    <form id="chatForm" class="chat-form">
                        <div class="input-wrapper">
                            <textarea 
                                id="messageInput" 
                                class="message-input" 
                                placeholder="Type your message here..." 
                                rows="3"
                            ></textarea>
                            <button type="submit" class="btn-send" id="sendBtn">
                                <span>Send</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                            </button>
                        </div>
                        <div class="input-footer">
                            <small>Press Ctrl+Enter to send</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner"></div>
        <p>AI is thinking...</p>
    </div>

    <!-- Toast Notifications -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Quick Start Guide Modal (First Time Visitor) -->
    <div class="quickstart-modal" id="quickstartModal">
        <div class="quickstart-content">
            <button class="quickstart-close" id="closeQuickstart">&times;</button>
            
            <div class="quickstart-header">
                <h2>🚀 Welcome to AI Chat Hub!</h2>
                <p>Get started in just 3 steps</p>
            </div>

            <div class="quickstart-steps">
                <!-- Step 1 -->
                <div class="quickstart-step active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Choose Your AI Model</h3>
                        <p>Select from 4 powerful AI models:</p>
                        <div class="model-list">
                            <div class="model-option" onclick="setQuickstartModel('gemini')">
                                <span class="model-icon">⚡</span>
                                <span class="model-name">Gemini 2.5 Flash</span>
                                <span class="model-desc">Fast & Accurate</span>
                            </div>
                            <div class="model-option" onclick="setQuickstartModel('claude')">
                                <span class="model-icon">🧠</span>
                                <span class="model-name">Claude</span>
                                <span class="model-desc">Best for Analysis</span>
                            </div>
                            <div class="model-option" onclick="setQuickstartModel('gpt')">
                                <span class="model-icon">🤖</span>
                                <span class="model-name">GPT-4 Turbo</span>
                                <span class="model-desc">Most Powerful</span>
                            </div>
                            <div class="model-option" onclick="setQuickstartModel('deepseek')">
                                <span class="model-icon">🔍</span>
                                <span class="model-name">DeepSeek</span>
                                <span class="model-desc">Cost Effective</span>
                            </div>
                        </div>
                        <div id="selectedModel" style="text-align: center; margin-top: 1rem; color: var(--primary-color); font-weight: 600;"></div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="quickstart-step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Get Your API Key</h3>
                        <p>Click to get a free API key from your chosen provider:</p>
                        <div class="api-links">
                            <a href="https://console.cloud.google.com" target="_blank" class="api-link">
                                <span>🔑 Google Console</span>
                                <span class="external-icon">↗</span>
                            </a>
                            <a href="https://console.anthropic.com" target="_blank" class="api-link">
                                <span>🔑 Anthropic Console</span>
                                <span class="external-icon">↗</span>
                            </a>
                            <a href="https://platform.openai.com" target="_blank" class="api-link">
                                <span>🔑 OpenAI Platform</span>
                                <span class="external-icon">↗</span>
                            </a>
                            <a href="https://platform.deepseek.com" target="_blank" class="api-link">
                                <span>🔑 DeepSeek Platform</span>
                                <span class="external-icon">↗</span>
                            </a>
                        </div>
                        <div class="step-note">
                            <strong>💡 Tip:</strong> All providers offer free tiers to get started!
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="quickstart-step" data-step="3">
                    <div class="step-content">
                        <h3>Start Chatting!</h3>
                        <div class="step-visual">
                            <div class="step-1">Paste API Key →</div>
                            <div class="step-arrow">→</div>
                            <div class="step-2">Type Message →</div>
                            <div class="step-arrow">→</div>
                            <div class="step-3">Get Response!</div>
                        </div>
                        <p style="margin-top: 1.5rem; text-align: center;">
                            <strong>That's it!</strong> Your conversations auto-save locally.
                        </p>
                        <div class="feature-highlights">
                            <div class="feature">✅ No Sign-Up</div>
                            <div class="feature">✅ Chats Saved</div>
                            <div class="feature">✅ Fully Private</div>
                            <div class="feature">✅ Multi-AI</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quickstart-nav">
                <button class="nav-btn" id="prevBtn" onclick="previousQuickstartStep()" style="display: none;">← Back</button>
                <div class="step-indicator">
                    <span class="dot active" onclick="goToQuickstartStep(1)"></span>
                    <span class="dot" onclick="goToQuickstartStep(2)"></span>
                    <span class="dot" onclick="goToQuickstartStep(3)"></span>
                </div>
                <button class="nav-btn next" id="nextBtn" onclick="nextQuickstartStep()">Next →</button>
            </div>

            <div class="quickstart-footer">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" id="dontShowAgain" />
                    <span>Don't show again</span>
                </label>
            </div>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>

<?php
// Redesigned Settings Page - Modern UI with Gradients and Cards
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - AI Chat Hub</title>
    <meta name="description" content="Configure your API keys, select preferred AI model, and customize prompt settings.">
    <meta name="keywords" content="AI Chat, Settings, API Key, Configuration">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Settings Page Modern Redesign */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--dark-bg) 0%, rgba(102, 126, 234, 0.05) 100%);
            min-height: 100vh;
        }

        .settings-page-wrapper {
            padding: 3rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .settings-header {
            margin-bottom: 3rem;
            text-align: left;
        }

        .settings-header h1 {
            font-size: 2.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
            font-weight: 800;
        }

        .settings-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .settings-layout {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 2.5rem;
        }

        /* Sidebar Tabs */
        .settings-tabs {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .settings-tab {
            padding: 1.25rem 1.5rem;
            background: rgba(255, 255, 255, 0.02);
            border: 2px solid var(--border-color);
            border-radius: 1rem;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: left;
        }

        .settings-tab:hover {
            border-color: var(--primary-color);
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(6px);
        }

        .settings-tab.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-color: transparent;
            color: white;
            box-shadow: 0 10px 28px rgba(102, 126, 234, 0.35);
        }

        /* Content Area */
        .settings-content-area {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            padding: 3rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
            max-height: calc(100vh - 200px);
        }

        .settings-section {
            display: none;
            animation: fadeInScale 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .settings-section.active {
            display: block;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: translateY(15px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .settings-section h2 {
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* API Key Card Grid */
        .api-keys-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .api-key-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.06), rgba(240, 147, 251, 0.06));
            border: 2px solid var(--border-color);
            border-radius: 1.25rem;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .api-key-card:hover {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.12), rgba(240, 147, 251, 0.12));
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(102, 126, 234, 0.2);
        }

        .api-key-card-header {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .api-key-icon {
            font-size: 2.5rem;
        }

        .api-key-card h3 {
            font-size: 1.15rem;
            color: var(--text-primary);
            font-weight: 700;
        }

        .api-key-card p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.35rem;
        }

        .api-key-input-group {
            margin: 1.5rem 0;
        }

        .api-key-input-group input {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.85rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
            font-family: 'Monaco', 'Courier New', monospace;
        }

        .api-key-input-group input:focus {
            outline: none;
            background: rgba(102, 126, 234, 0.12);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
        }

        .api-key-actions {
            display: flex;
            gap: 0.75rem;
        }

        .api-key-actions button {
            flex: 1;
            padding: 0.8rem;
            background: rgba(102, 126, 234, 0.12);
            border: 1.5px solid var(--border-color);
            border-radius: 0.65rem;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.25s ease;
            font-weight: 600;
        }

        .api-key-actions button:hover {
            background: rgba(102, 126, 234, 0.25);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .api-key-actions button.danger:hover {
            background: rgba(245, 101, 101, 0.2);
            border-color: var(--error-color);
            color: var(--error-color);
        }

        .api-key-status {
            padding: 0.9rem 1rem;
            border-radius: 0.65rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            background: rgba(72, 187, 120, 0.12);
            color: var(--success-color);
            border: 1.5px solid rgba(72, 187, 120, 0.3);
            font-weight: 600;
        }

        .api-key-status.empty {
            background: rgba(245, 101, 101, 0.12);
            border-color: rgba(245, 101, 101, 0.3);
            color: var(--error-color);
        }

        .api-provider-link {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.65rem 1rem;
            background: rgba(102, 126, 234, 0.15);
            border-radius: 0.65rem;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 700;
            transition: all 0.25s ease;
            border: 1px solid rgba(102, 126, 234, 0.35);
        }

        .api-provider-link:hover {
            background: rgba(102, 126, 234, 0.3);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Model Selection Grid */
        .model-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.75rem;
            margin-bottom: 2.5rem;
        }

        .model-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.06), rgba(240, 147, 251, 0.06));
            border: 2px solid var(--border-color);
            border-radius: 1.25rem;
            padding: 2.25rem;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .model-card:hover {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(240, 147, 251, 0.15));
            transform: translateY(-8px);
            box-shadow: 0 18px 44px rgba(102, 126, 234, 0.28);
        }

        .model-card.selected {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-color: transparent;
            color: white;
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.3);
        }

        .model-card h4 {
            font-size: 1.3rem;
            margin-bottom: 0.9rem;
            color: var(--text-primary);
            font-weight: 700;
        }

        .model-card.selected h4 {
            color: white;
        }

        .model-card p {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .model-card.selected p {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Settings Group */
        .settings-group {
            margin-bottom: 2.5rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .settings-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .settings-group label {
            display: block;
            margin-bottom: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1.05rem;
        }

        .settings-group input,
        .settings-group select,
        .settings-group textarea {
            width: 100%;
            padding: 1.1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.85rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .settings-group input:focus,
        .settings-group select:focus,
        .settings-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(102, 126, 234, 0.12);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
        }

        .settings-group textarea {
            resize: vertical;
            min-height: 150px;
            font-family: 'Monaco', 'Courier New', monospace;
        }

        .settings-description {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 0.75rem;
            line-height: 1.7;
        }

        /* Button Group */
        .button-group {
            display: flex;
            gap: 1.25rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .button-group button {
            padding: 1.15rem 2.5rem;
            border: none;
            border-radius: 0.85rem;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex: 1;
            min-width: 160px;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--success-color), #38a169);
            color: white;
            box-shadow: 0 10px 24px rgba(72, 187, 120, 0.35);
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 32px rgba(72, 187, 120, 0.45);
        }

        .btn-save:active {
            transform: translateY(-1px);
        }

        .btn-reset {
            background: rgba(255, 255, 255, 0.06);
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
        }

        .btn-reset:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Success Message */
        .success-message {
            padding: 1.2rem 1.5rem;
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.12), rgba(72, 187, 120, 0.06));
            border: 1.5px solid rgba(72, 187, 120, 0.35);
            border-radius: 0.85rem;
            color: var(--success-color);
            margin-bottom: 2rem;
            display: none;
            animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 700;
        }

        .success-message.show {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .settings-layout {
                grid-template-columns: 1fr;
            }

            .settings-tabs {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.75rem;
                position: static;
                top: auto;
            }

            .settings-tab {
                padding: 1rem;
                font-size: 0.95rem;
            }

            .api-keys-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            }
        }

        @media (max-width: 640px) {
            .settings-page-wrapper {
                padding: 1.5rem 1rem;
            }

            .settings-header h1 {
                font-size: 1.8rem;
            }

            .settings-header p {
                font-size: 1rem;
            }

            .settings-content-area {
                padding: 1.5rem;
                border-radius: 1rem;
            }

            .settings-section h2 {
                font-size: 1.4rem;
            }

            .api-keys-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .model-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .button-group button {
                width: 100%;
            }

            .settings-tabs {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="nav-content">
                <div class="nav-brand">
                    <h1>🤖 AI Chat Hub</h1>
                </div>
                <button class="hamburger-menu" id="hamburgerBtn" title="Toggle sidebar menu" aria-label="Open sidebar menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="nav-links">
                    <li><a href="../index.php" class="nav-link">Chat</a></li>
                    <li><a href="about.php" class="nav-link">About</a></li>
                    <li><a href="faqs.php" class="nav-link">FAQs</a></li>
                    <li><a href="settings.php" class="nav-link active">Settings</a></li>
                    <li><a href="terms.php" class="nav-link">Terms</a></li>
                    <li><a href="privacy.php" class="nav-link">Privacy</a></li>
                </ul>
            </div>
        </nav>

    <!-- Settings Content -->
    <div class="settings-page-wrapper">
        <!-- Header -->
        <div class="settings-header">
            <h1>⚙️ Settings & Configuration</h1>
            <p>Manage your API keys, select your preferred AI model, and customize your chat experience</p>
        </div>

        <!-- Settings Layout -->
        <div class="settings-layout">
            <!-- Sidebar Tabs -->
            <div class="settings-tabs">
                <button class="settings-tab active" data-tab="api-keys">🔑 API Keys</button>
                <button class="settings-tab" data-tab="model">🤖 Model</button>
                <button class="settings-tab" data-tab="prompts">📝 Prompts</button>
            </div>

            <!-- Content Area -->
            <div class="settings-content-area">
                <div class="success-message" id="successMessage">
                    ✓ Settings saved successfully!
                </div>

                <!-- API Keys Section -->
                <div class="settings-section active" id="api-keys-section">
                    <h2>🔑 API Key Management</h2>
                    
                    <div class="api-keys-grid">
                        <!-- Gemini Card -->
                        <div class="api-key-card">
                            <div class="api-key-card-header">
                                <div class="api-key-icon">⚡</div>
                                <div>
                                    <h3>Google Gemini</h3>
                                    <p>2.5 Flash Model</p>
                                </div>
                            </div>
                            <div class="api-key-input-group">
                                <input type="password" id="gemini-key" placeholder="Paste your Gemini API key here">
                                <div class="api-key-actions">
                                    <button onclick="app.toggleKeyVisibility('gemini-key')" title="Show/hide">👁️</button>
                                    <button onclick="app.clearApiKey('gemini')" class="danger" title="Delete">🗑️</button>
                                </div>
                            </div>
                            <div class="api-key-status" id="gemini-status">❌ Not configured</div>
                            <a href="https://console.cloud.google.com/apis/library" target="_blank" class="api-provider-link">Get API Key →</a>
                        </div>

                        <!-- Claude Card -->
                        <div class="api-key-card">
                            <div class="api-key-card-header">
                                <div class="api-key-icon">🧠</div>
                                <div>
                                    <h3>Anthropic Claude</h3>
                                    <p>Advanced Reasoning</p>
                                </div>
                            </div>
                            <div class="api-key-input-group">
                                <input type="password" id="claude-key" placeholder="Paste your Claude API key here">
                                <div class="api-key-actions">
                                    <button onclick="app.toggleKeyVisibility('claude-key')" title="Show/hide">👁️</button>
                                    <button onclick="app.clearApiKey('claude')" class="danger" title="Delete">🗑️</button>
                                </div>
                            </div>
                            <div class="api-key-status" id="claude-status">❌ Not configured</div>
                            <a href="https://console.anthropic.com/" target="_blank" class="api-provider-link">Get API Key →</a>
                        </div>

                        <!-- GPT Card -->
                        <div class="api-key-card">
                            <div class="api-key-card-header">
                                <div class="api-key-icon">🤖</div>
                                <div>
                                    <h3>OpenAI GPT</h3>
                                    <p>GPT-4 Turbo</p>
                                </div>
                            </div>
                            <div class="api-key-input-group">
                                <input type="password" id="gpt-key" placeholder="Paste your GPT API key here">
                                <div class="api-key-actions">
                                    <button onclick="app.toggleKeyVisibility('gpt-key')" title="Show/hide">👁️</button>
                                    <button onclick="app.clearApiKey('gpt')" class="danger" title="Delete">🗑️</button>
                                </div>
                            </div>
                            <div class="api-key-status" id="gpt-status">❌ Not configured</div>
                            <a href="https://platform.openai.com/account/api-keys" target="_blank" class="api-provider-link">Get API Key →</a>
                        </div>

                        <!-- DeepSeek Card -->
                        <div class="api-key-card">
                            <div class="api-key-card-header">
                                <div class="api-key-icon">🔍</div>
                                <div>
                                    <h3>DeepSeek</h3>
                                    <p>Fast & Cost-Effective</p>
                                </div>
                            </div>
                            <div class="api-key-input-group">
                                <input type="password" id="deepseek-key" placeholder="Paste your DeepSeek API key here">
                                <div class="api-key-actions">
                                    <button onclick="app.toggleKeyVisibility('deepseek-key')" title="Show/hide">👁️</button>
                                    <button onclick="app.clearApiKey('deepseek')" class="danger" title="Delete">🗑️</button>
                                </div>
                            </div>
                            <div class="api-key-status" id="deepseek-status">❌ Not configured</div>
                            <a href="https://platform.deepseek.com/" target="_blank" class="api-provider-link">Get API Key →</a>
                        </div>
                    </div>

                    <div class="button-group">
                        <button class="btn-save" onclick="app.saveAllApiKeys()">💾 Save All API Keys</button>
                        <button class="btn-reset" onclick="app.loadAllApiKeys()">↻ Reset</button>
                    </div>
                </div>

                <!-- Model Selection Section -->
                <div class="settings-section" id="model-section">
                    <h2>🤖 Select Your Default Model</h2>
                    <p style="color: var(--text-muted); margin-bottom: 2rem;">Choose which AI model will be used for new conversations</p>
                    
                    <div class="model-grid">
                        <div class="model-card" data-model="gemini" onclick="app.selectModel('gemini')">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                            <h4>Gemini 2.5 Flash</h4>
                            <p>Fast, accurate responses with latest capabilities</p>
                        </div>
                        <div class="model-card" data-model="claude" onclick="app.selectModel('claude')">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🧠</div>
                            <h4>Claude</h4>
                            <p>Advanced reasoning and nuanced understanding</p>
                        </div>
                        <div class="model-card" data-model="gpt" onclick="app.selectModel('gpt')">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🤖</div>
                            <h4>GPT-4 Turbo</h4>
                            <p>Powerful general-purpose AI assistant</p>
                        </div>
                        <div class="model-card" data-model="deepseek" onclick="app.selectModel('deepseek')">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                            <h4>DeepSeek</h4>
                            <p>Fast and cost-effective responses</p>
                        </div>
                    </div>

                    <div class="button-group">
                        <button class="btn-save" onclick="app.saveModelSelection()">💾 Save Model Selection</button>
                    </div>
                </div>

                <!-- Prompts Section -->
                <div class="settings-section" id="prompts-section">
                    <h2>📝 Prompt & Behavior Settings</h2>
                    
                    <div class="settings-group">
                        <label for="system-prompt">System Prompt (Optional)</label>
                        <textarea id="system-prompt" placeholder="Example: 'You are a helpful coding assistant. Always provide code examples with explanations.'" title="Custom instructions for the AI model"></textarea>
                        <p class="settings-description">💡 This prompt is sent with every message to guide the AI's behavior and personality. Leave empty for default behavior.</p>
                    </div>

                    <div class="settings-group">
                        <label for="temperature">Temperature: <span id="tempValue">0.7</span></label>
                        <input type="range" id="temperature" min="0" max="2" step="0.1" value="0.7" title="Control response creativity">
                        <p class="settings-description">
                            <strong>0.0-0.5:</strong> More focused and deterministic | 
                            <strong>0.7:</strong> Balanced (recommended) | 
                            <strong>1.5-2.0:</strong> More creative and random
                        </p>
                    </div>

                    <div class="settings-group">
                        <label for="max-tokens">Max Tokens: <span id="tokenValue">1000</span></label>
                        <input type="range" id="max-tokens" min="100" max="4000" step="100" value="1000" title="Maximum response length">
                        <p class="settings-description">Controls the maximum length of AI responses. Higher values = longer responses (1000-2000 recommended)</p>
                    </div>

                    <div class="button-group">
                        <button class="btn-save" onclick="app.savePromptSettings()">💾 Save Settings</button>
                        <button class="btn-reset" onclick="app.resetPromptSettings()">↻ Reset to Defaults</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/app.js"></script>
    <script>
        // Settings page functionality (standalone, doesn't require app.js app class)
        
        // Create toast notification system for settings page
        const createToast = (message, type = 'info') => {
            const container = document.getElementById('toastContainer') || createToastContainer();
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            const icons = { 'success': '✓', 'error': '✕', 'warning': '⚠', 'info': 'ℹ' };
            toast.innerHTML = `<span>${icons[type] || '•'}</span><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('exit');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };

        const createToastContainer = () => {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.style.cssText = 'position: fixed; bottom: 2rem; right: 2rem; display: flex; flex-direction: column; gap: 0.5rem; z-index: 10000;';
            document.body.appendChild(container);
            return container;
        };

        // Settings page API functions
        const settingsAPI = {
            toggleKeyVisibility(inputId) {
                const input = document.getElementById(inputId);
                if (input) {
                    input.type = input.type === 'password' ? 'text' : 'password';
                }
            },

            clearApiKey(model) {
                if (confirm(`Remove ${model} API key?`)) {
                    localStorage.removeItem(`apiKey_${model}`);
                    createToast(`${model} API key removed`, 'success');
                    loadSettingsPage();
                }
            },

            saveAllApiKeys() {
                const models = ['gemini', 'claude', 'gpt', 'deepseek'];
                let saveCount = 0;

                models.forEach(model => {
                    const input = document.getElementById(`${model}-key`);
                    if (input && input.value.trim()) {
                        localStorage.setItem(`apiKey_${model}`, input.value.trim());
                        
                        // Update status immediately
                        const status = document.getElementById(`${model}-status`);
                        if (status) {
                            status.textContent = '✓ Configured';
                            status.classList.remove('empty');
                        }
                        saveCount++;
                    }
                });

                if (saveCount > 0) {
                    createToast(`${saveCount} API key(s) saved successfully!`, 'success');
                    showSuccessMessage();
                } else {
                    createToast('No API keys entered', 'warning');
                }
            },

            loadAllApiKeys() {
                loadSettingsPage();
                createToast('Settings reloaded', 'info');
            },

            selectModel(model) {
                document.querySelectorAll('.model-card').forEach(card => {
                    if (card.getAttribute('data-model') === model) {
                        card.classList.add('selected');
                    } else {
                        card.classList.remove('selected');
                    }
                });
            },

            saveModelSelection() {
                const selected = document.querySelector('.model-card.selected');
                if (selected) {
                    const model = selected.getAttribute('data-model');
                    localStorage.setItem('selectedModel', model);
                    const modelNames = {
                        'gemini': 'Google Gemini 2.5 Flash',
                        'claude': 'Anthropic Claude',
                        'gpt': 'OpenAI GPT-4 Turbo',
                        'deepseek': 'DeepSeek'
                    };
                    createToast(`Default model changed to ${modelNames[model]}`, 'success');
                    showSuccessMessage();
                }
            },

            savePromptSettings() {
                const systemPrompt = document.getElementById('system-prompt')?.value || '';
                const temperature = document.getElementById('temperature')?.value || '0.7';
                const maxTokens = document.getElementById('max-tokens')?.value || '1000';

                localStorage.setItem('systemPrompt', systemPrompt);
                localStorage.setItem('temperature', temperature);
                localStorage.setItem('maxTokens', maxTokens);

                createToast('Prompt settings saved!', 'success');
                showSuccessMessage();
            },

            resetPromptSettings() {
                if (confirm('Reset prompt settings to defaults?')) {
                    document.getElementById('system-prompt').value = '';
                    document.getElementById('temperature').value = '0.7';
                    document.getElementById('max-tokens').value = '1000';
                    
                    localStorage.removeItem('systemPrompt');
                    localStorage.removeItem('temperature');
                    localStorage.removeItem('maxTokens');
                    
                    createToast('Prompt settings reset to defaults', 'success');
                    showSuccessMessage();
                }
            }
        };

        // Make functions globally available for onclick handlers
        window.app = settingsAPI;

        document.addEventListener('DOMContentLoaded', () => {
            // Range slider value displays
            const tempSlider = document.getElementById('temperature');
            const tokenSlider = document.getElementById('max-tokens');
            
            if (tempSlider) {
                tempSlider.addEventListener('input', (e) => {
                    document.getElementById('tempValue').textContent = e.target.value;
                });
            }
            
            if (tokenSlider) {
                tokenSlider.addEventListener('input', (e) => {
                    document.getElementById('tokenValue').textContent = e.target.value;
                });
            }

            // Tab switching
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabName = tab.getAttribute('data-tab');
                    switchSettingsTab(tabName);
                });
            });

            // Load current settings
            loadSettingsPage();
        });

        function switchSettingsTab(tabName) {
            // Deactivate all tabs and sections
            document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));

            // Activate clicked tab and corresponding section
            document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
            document.getElementById(`${tabName}-section`).classList.add('active');
        }

        function loadSettingsPage() {
            // Load API keys from localStorage
            ['gemini', 'claude', 'gpt', 'deepseek'].forEach(model => {
                const key = localStorage.getItem(`apiKey_${model}`);
                const input = document.getElementById(`${model}-key`);
                const status = document.getElementById(`${model}-status`);
                
                if (input && status) {
                    if (key) {
                        input.value = key;
                        status.textContent = '✓ Configured';
                        status.classList.remove('empty');
                    } else {
                        input.value = '';
                        status.textContent = '❌ Not configured';
                        status.classList.add('empty');
                    }
                }
            });

            // Load selected model
            const selectedModel = localStorage.getItem('selectedModel') || 'gemini';
            const modelCards = document.querySelectorAll('.model-card');
            modelCards.forEach(card => {
                if (card.getAttribute('data-model') === selectedModel) {
                    card.classList.add('selected');
                } else {
                    card.classList.remove('selected');
                }
            });

            // Load prompt settings
            const systemPrompt = localStorage.getItem('systemPrompt') || '';
            const temperature = localStorage.getItem('temperature') || '0.7';
            const maxTokens = localStorage.getItem('maxTokens') || '1000';

            if (document.getElementById('system-prompt')) {
                document.getElementById('system-prompt').value = systemPrompt;
            }
            if (document.getElementById('temperature')) {
                document.getElementById('temperature').value = temperature;
            }
            if (document.getElementById('max-tokens')) {
                document.getElementById('max-tokens').value = maxTokens;
            }
        }

        // Show success message
        function showSuccessMessage() {
            const msg = document.getElementById('successMessage');
            if (msg) {
                msg.classList.add('show');
                setTimeout(() => msg.classList.remove('show'), 3000);
            }
        }
    </script>
</body>
</html>

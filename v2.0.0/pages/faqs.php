<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - AI Chat Studio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <script src="../assets/js/theme.js"></script>
    <style>
        /* VS Code Inspired Page Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-bg);
            min-height: 100vh;
            font-family: 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
        }

        .vs-page-wrapper {
            padding: 0;
            max-width: none;
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--dark-bg);
            overflow: hidden;
        }

        .vs-page-header {
            background: var(--card-bg);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .vs-page-header h1 {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-weight: 400;
        }

        .vs-page-header p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* VS Code Layout */
        .vs-layout {
            display: flex;
            flex: 1;
            height: 100%;
            background: var(--dark-bg);
        }

        /* VS Code Sidebar */
        .vs-sidebar {
            width: 200px;
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            max-height: calc(100vh - 150px);
        }

        .vs-sidebar-tabs {
            display: flex;
            flex-direction: column;
            padding: 0.5rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .vs-sidebar-tab {
            padding: 0.75rem 1rem;
            background: transparent;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 400;
            transition: all 0.15s ease;
            text-align: left;
            border-left: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .vs-sidebar-tab:hover {
            background: var(--surface);
            color: var(--text-primary);
        }

        .vs-sidebar-tab.active {
            background: var(--primary-color);
            color: white;
            border-left-color: var(--primary-color);
        }

        .vs-sidebar-tab-icon {
            font-size: 1rem;
            width: 16px;
            text-align: center;
        }

        /* Sidebar Footer */
        .vs-sidebar-footer {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            background: var(--card-bg);
        }

        .vs-sidebar-footer-nav {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .vs-sidebar-footer-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.15s ease;
        }

        .vs-sidebar-footer-link:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .vs-sidebar-footer-link.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* VS Code Content Panel */
        .vs-content-panel {
            flex: 1;
            background: var(--dark-bg);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .vs-panel-header {
            background: var(--card-bg);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .vs-panel-title {
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .vs-panel-content {
            flex: 1;
            padding: 1.5rem;
            padding-bottom: 100px;
            overflow-y: auto;
        }

        .vs-panel-content::-webkit-scrollbar {
            width: 8px;
        }

        .vs-panel-content::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        .vs-panel-content::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        /* VS Code Sections */
        .vs-section {
            display: none;
            animation: vsFadeIn 0.2s ease;
            padding-bottom: 2rem;
        }

        .vs-section.active {
            display: block;
        }

        @keyframes vsFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .vs-section-title {
            font-size: 1.3rem;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            font-weight: 400;
        }

        /* FAQ Items */
        .vs-faq-item {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            margin-bottom: 8px;
            transition: all 0.15s ease;
        }

        .vs-faq-item:hover {
            border-color: var(--primary-color);
        }

        .vs-faq-question {
            padding: 1rem 1.25rem;
            background: var(--surface);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        .vs-faq-question h3 {
            margin: 0;
            font-size: 0.95rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        .vs-faq-toggle {
            font-size: 1rem;
            color: var(--primary-color);
            transition: transform 0.2s ease;
        }

        .vs-faq-item.active .vs-faq-toggle {
            transform: rotate(180deg);
        }

        .vs-faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: var(--dark-bg);
        }

        .vs-faq-item.active .vs-faq-answer {
            max-height: 500px;
        }

        .vs-faq-answer p {
            padding: 1.25rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.7;
            font-size: 0.9rem;
        }

        .vs-faq-answer code {
            background: var(--card-bg);
            padding: 0.2rem 0.4rem;
            font-family: 'Consolas', monospace;
            color: #569cd6;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .vs-layout {
                flex-direction: column;
            }

            .vs-sidebar {
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .vs-sidebar-tabs {
                flex-direction: row;
                overflow-x: auto;
                padding: 0.5rem;
            }

            .vs-sidebar-tab {
                flex-shrink: 0;
                border-left: none;
                border-bottom: 2px solid transparent;
            }

            .vs-sidebar-tab.active {
                border-left: none;
                border-bottom-color: var(--primary-color);
            }

            .vs-panel-content {
                padding: 1rem;
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
                    <h1>AI Chat Studio</h1>
                </div>
            </div>
        </nav>

        <div class="vs-page-wrapper">
            <div class="vs-page-header">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about AI Chat Studio</p>
            </div>

            <div class="vs-layout">
                <!-- Sidebar -->
                <div class="vs-sidebar">
                    <div class="vs-sidebar-tabs">
                        <button class="vs-sidebar-tab active" data-tab="general">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-question-circle"></i></span>
                            <span>General</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="apikeys">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-key"></i></span>
                            <span>API Keys</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="usage">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-gear"></i></span>
                            <span>Usage</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="technical">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-code"></i></span>
                            <span>Technical</span>
                        </button>
                    </div>

                    <div class="vs-sidebar-footer">
                        <div class="vs-sidebar-footer-nav">
                            <a href="../index.php" class="vs-sidebar-footer-link" title="Chat">C</a>
                            <a href="about.php" class="vs-sidebar-footer-link" title="About">A</a>
                            <a href="faqs.php" class="vs-sidebar-footer-link active" title="FAQs">Q</a>
                            <a href="settings.php" class="vs-sidebar-footer-link" title="Settings">S</a>
                            <a href="terms.php" class="vs-sidebar-footer-link" title="Terms">T</a>
                            <a href="privacy.php" class="vs-sidebar-footer-link" title="Privacy">P</a>
                        </div>
                    </div>
                </div>

                <!-- Content Panel -->
                <div class="vs-content-panel">
                    <div class="vs-panel-header">
                        <div class="vs-panel-title">
                            <span id="panel-icon">G</span>
                            <span id="panel-text">General Questions</span>
                        </div>
                    </div>

                    <div class="vs-panel-content">
                        <!-- General Section -->
                        <div class="vs-section active" id="general-section">
                            <h2 class="vs-section-title">General Questions</h2>
                            
                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>Do I need to create an account?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>No! AI Chat Studio doesn't require any account creation or registration. Simply enter your API key and start chatting immediately. Your conversation history is stored locally in your browser.</p>
                                </div>
                            </div>

                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>Can I switch between different AI models?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>Absolutely! You can switch between Gemini, Claude, GPT, and DeepSeek using the model selector dropdown. Each model can have its own API key stored independently. Your conversation history is preserved when switching models.</p>
                                </div>
                            </div>

                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>Can I use this on mobile devices?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>Yes! AI Chat Studio is fully responsive and works on mobile devices including smartphones and tablets. The interface adapts automatically to different screen sizes for optimal usability on any device.</p>
                                </div>
                            </div>

                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>How much does it cost to use AI Chat Studio?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>AI Chat Studio itself is completely free to use! However, you'll need API keys from the individual AI providers (Gemini, Claude, GPT, etc.), which may have their own pricing plans. Consult each provider's website for their current rates and free tier availability.</p>
                                </div>
                            </div>
                        </div>

                        <!-- API Keys Section -->
                        <div class="vs-section" id="apikeys-section">
                            <h2 class="vs-section-title">API Key Questions</h2>
                            
                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>Is my API key safe?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>Yes, your API key is stored only in your browser's local storage and is never sent to our servers. However, we recommend using read-only API keys or keys with limited permissions when possible. Always keep your keys confidential and never share them with others.</p>
                                </div>
                            </div>

                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>How do I get API keys?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>
                                        Visit the official websites of each AI provider:<br><br>
                                        • <strong>Google Gemini:</strong> aistudio.google.com<br>
                                        • <strong>Anthropic Claude:</strong> console.anthropic.com<br>
                                        • <strong>OpenAI GPT:</strong> platform.openai.com<br>
                                        • <strong>DeepSeek:</strong> platform.deepseek.com<br><br>
                                        Sign up, create an API key, and add it to AI Chat Studio.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Usage Section -->
                        <div class="vs-section" id="usage-section">
                            <h2 class="vs-section-title">Usage Questions</h2>
                            
                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>Where is my conversation history stored?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>Your conversation history is stored entirely in your browser's local storage. It never leaves your device and isn't stored on any server. If you clear your browser data, your history will be deleted. You can also manually clear all conversations from the application.</p>
                                </div>
                            </div>

                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>Can I export my conversation history?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>Yes! AI Chat Studio includes export functionality. You can export your conversations in various formats including JSON and text. Use the Export button in the sidebar to save your chat history.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Section -->
                        <div class="vs-section" id="technical-section">
                            <h2 class="vs-section-title">Technical Questions</h2>
                            
                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>What if I get an error message?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>Common errors include invalid API keys, rate limiting, or network issues. Verify your API key is correct and has appropriate permissions. If the issue persists, check the specific AI provider's status page or documentation. Make sure your internet connection is stable.</p>
                                </div>
                            </div>

                            <div class="vs-faq-item">
                                <div class="vs-faq-question" onclick="this.parentElement.classList.toggle('active')">
                                    <h3>Is there an API or backend integration available?</h3>
                                    <span class="vs-faq-toggle">▼</span>
                                </div>
                                <div class="vs-faq-answer">
                                    <p>AI Chat Studio is designed as a standalone web application. However, all communication with AI providers happens through their official APIs. The backend uses PHP with cURL to securely relay requests to the respective AI services.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tab switching
            document.querySelectorAll('.vs-sidebar-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabName = tab.getAttribute('data-tab');
                    switchTab(tabName);
                });
            });
        });

        function switchTab(tabName) {
            // Deactivate all tabs and sections
            document.querySelectorAll('.vs-sidebar-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.vs-section').forEach(s => s.classList.remove('active'));

            // Activate clicked tab and corresponding section
            document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
            document.getElementById(`${tabName}-section`).classList.add('active');

            // Update panel title
            updatePanelTitle(tabName);
        }

        function updatePanelTitle(tabName) {
            const titles = {
                'general': { icon: '<i class="fas fa-question-circle"></i>', text: 'General Questions' },
                'apikeys': { icon: '<i class="fas fa-key"></i>', text: 'API Key Questions' },
                'usage': { icon: '<i class="fas fa-gear"></i>', text: 'Usage Questions' },
                'technical': { icon: '<i class="fas fa-code"></i>', text: 'Technical Questions' }
            };
            
            const title = titles[tabName] || { icon: '<i class="fas fa-circle-question"></i>', text: 'FAQs' };
            document.getElementById('panel-icon').innerHTML = title.icon;
            document.getElementById('panel-text').textContent = title.text;
        }
    </script>
</body>
</html>

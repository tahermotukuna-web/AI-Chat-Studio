<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - AI Chat Studio</title>
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
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* VS Code Cards */
        .vs-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0;
            padding: 0;
            margin-bottom: 1rem;
        }

        .vs-card-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: var(--surface);
            border-bottom: 1px solid var(--border-color);
        }

        .vs-card-icon {
            font-size: 14px;
            width: 16px;
            text-align: center;
            color: #569cd6;
        }

        .vs-card h3 {
            font-size: 13px;
            color: var(--text-primary);
            font-weight: 600;
            margin: 0;
        }

        .vs-card-content {
            padding: 16px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .vs-card-content p {
            margin-bottom: 1rem;
        }

        .vs-card-content p:last-child {
            margin-bottom: 0;
        }

        /* Feature Grid */
        .vs-feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .vs-feature-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 1.25rem;
            transition: all 0.15s ease;
        }

        .vs-feature-card:hover {
            border-color: var(--primary-color);
        }

        .vs-feature-card h4 {
            color: var(--text-primary);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .vs-feature-card p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            line-height: 1.5;
            margin: 0;
        }

        /* VS Code List */
        .vs-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .vs-list li {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .vs-list li:last-child {
            border-bottom: none;
        }

        .vs-list-icon {
            color: var(--success-color);
            font-weight: bold;
        }

        /* VS Code Links */
        .vs-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 0;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 11px;
            transition: none;
        }

        .vs-link:hover {
            background: var(--background);
            border-color: var(--primary-color);
        }

        /* Warning Box */
        .vs-warning {
            background: #4a3a1a;
            border: 1px solid #b8860b;
            padding: 1rem;
            color: #ffcc02;
            font-size: 0.9rem;
            margin-top: 1rem;
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

            .vs-feature-grid {
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
                    <h1>AI Chat Studio</h1>
                </div>
            </div>
        </nav>

        <div class="vs-page-wrapper">
            <div class="vs-page-header">
                <h1>About AI Chat Studio</h1>
                <p>Your Ultimate Multi-Model AI Chat Interface</p>
            </div>

            <div class="vs-layout">
                <!-- Sidebar -->
                <div class="vs-sidebar">
                    <div class="vs-sidebar-tabs">
                        <button class="vs-sidebar-tab active" data-tab="overview">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-info-circle"></i></span>
                            <span>Overview</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="features">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-star"></i></span>
                            <span>Features</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="howto">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-cogs"></i></span>
                            <span>How It Works</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="security">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-shield-alt"></i></span>
                            <span>Security</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="apikeys">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-key"></i></span>
                            <span>API Keys</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="tech">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-code"></i></span>
                            <span>Technology</span>
                        </button>
                    </div>

                    <div class="vs-sidebar-footer">
                        <div class="vs-sidebar-footer-nav">
                            <a href="../index.php" class="vs-sidebar-footer-link" title="Chat">C</a>
                            <a href="about.php" class="vs-sidebar-footer-link active" title="About">A</a>
                            <a href="faqs.php" class="vs-sidebar-footer-link" title="FAQs">Q</a>
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
                            <span id="panel-icon">O</span>
                            <span id="panel-text">Overview</span>
                        </div>
                    </div>

                    <div class="vs-panel-content">
                        <!-- Overview Section -->
                        <div class="vs-section active" id="overview-section">
                            <h2 class="vs-section-title">What is AI Chat Studio?</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <i class="fas fa-book vs-card-icon"></i>
                                    <h3>About the Platform</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>AI Chat Studio is a modern, comprehensive web application that provides seamless access to multiple leading AI models in a single interface. Whether you're using Google Gemini, Anthropic Claude, OpenAI GPT, or DeepSeek, our platform brings them all together with a beautiful, intuitive design.</p>
                                    <p>Our mission is to democratize access to advanced AI technology by creating a unified chat interface that eliminates the need to juggle multiple platforms while maintaining a premium user experience.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Features Section -->
                        <div class="vs-section" id="features-section">
                            <h2 class="vs-section-title">Key Features</h2>
                            
                            <div class="vs-feature-grid">
                                <div class="vs-feature-card">
                                    <h4><i class="fas fa-robot"></i> Multi-Model Support</h4>
                                    <p>Support for Gemini, Claude, GPT, and DeepSeek AI models</p>
                                </div>
                                <div class="vs-feature-card">
                                    <h4><i class="fas fa-palette"></i> Modern Interface</h4>
                                    <p>Clean, responsive UI with dark/light themes</p>
                                </div>
                                <div class="vs-feature-card">
                                    <h4><i class="fas fa-database"></i> Local Storage</h4>
                                    <p>Conversation history stored in your browser</p>
                                </div>
                                <div class="vs-feature-card">
                                    <h4><i class="fas fa-folder-open"></i> File Uploads</h4>
                                    <p>Analyze documents and images with AI</p>
                                </div>
                                <div class="vs-feature-card">
                                    <h4><i class="fas fa-lock"></i> Secure Keys</h4>
                                    <p>API keys stored locally, never on servers</p>
                                </div>
                                <div class="vs-feature-card">
                                    <h4><i class="fas fa-code"></i> Markdown Support</h4>
                                    <p>Code blocks and syntax highlighting</p>
                                </div>
                                <div class="vs-feature-card">
                                    <h4><i class="fas fa-microphone"></i> Voice Controls</h4>
                                    <p>Speech-to-text and text-to-speech</p>
                                </div>
                                <div class="vs-feature-card">
                                    <h4><i class="fas fa-gift"></i> Free to Use</h4>
                                    <p>Completely free and open platform</p>
                                </div>
                            </div>
                        </div>

                        <!-- How It Works Section -->
                        <div class="vs-section" id="howto-section">
                            <h2 class="vs-section-title">How It Works</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <i class="fas fa-list-ol vs-card-icon"></i>
                                    <h3>Getting Started</h3>
                                </div>
                                <div class="vs-card-content">
                                    <ul class="vs-list">
                                        <li><span class="vs-list-icon">1</span> Select your preferred AI model from the dropdown menu</li>
                                        <li><span class="vs-list-icon">2</span> Enter your API key for that service (stored securely in your browser)</li>
                                        <li><span class="vs-list-icon">3</span> Type your message in the chat box</li>
                                        <li><span class="vs-list-icon">4</span> Click Send or press Ctrl+Enter</li>
                                        <li><span class="vs-list-icon">5</span> Watch as the AI responds in real-time</li>
                                        <li><span class="vs-list-icon">6</span> Your conversation history is automatically saved locally</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="vs-section" id="security-section">
                            <h2 class="vs-section-title">Privacy & Security</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <i class="fas fa-shield-alt vs-card-icon"></i>
                                    <h3>Your Data is Protected</h3>
                                </div>
                                <div class="vs-card-content">
                                    <ul class="vs-list">
                                        <li><i class="fas fa-check vs-list-icon"></i> API keys are stored locally in your browser (not on our servers)</li>
                                        <li><i class="fas fa-check vs-list-icon"></i> Conversation history never leaves your device unless you export it</li>
                                        <li><i class="fas fa-check vs-list-icon"></i> All data is encrypted at rest in your browser's local storage</li>
                                        <li><i class="fas fa-check vs-list-icon"></i> We don't collect or track your conversations</li>
                                        <li><i class="fas fa-check vs-list-icon"></i> No user accounts or registration required</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- API Keys Section -->
                        <div class="vs-section" id="apikeys-section">
                            <h2 class="vs-section-title">Getting API Keys</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <i class="fas fa-key vs-card-icon"></i>
                                    <h3>API Key Sources</h3>
                                </div>
                                <div class="vs-card-content">
                                    <ul class="vs-list">
                                        <li><i class="fab fa-google vs-list-icon"></i> <strong>Google Gemini:</strong> aistudio.google.com</li>
                                        <li><i class="fas fa-brain vs-list-icon"></i> <strong>Anthropic Claude:</strong> console.anthropic.com</li>
                                        <li><i class="fas fa-robot vs-list-icon"></i> <strong>OpenAI GPT:</strong> platform.openai.com</li>
                                        <li><i class="fas fa-search vs-list-icon"></i> <strong>DeepSeek:</strong> platform.deepseek.com</li>
                                    </ul>
                                    
                                    <div class="vs-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Never share your API keys with anyone. Keep them private and secure.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Technology Section -->
                        <div class="vs-section" id="tech-section">
                            <h2 class="vs-section-title">Technology Stack</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <i class="fas fa-cogs vs-card-icon"></i>
                                    <h3>Built With</h3>
                                </div>
                                <div class="vs-card-content">
                                    <ul class="vs-list">
                                        <li><i class="fas fa-check vs-list-icon"></i> PHP Backend for secure API integration</li>
                                        <li><i class="fas fa-check vs-list-icon"></i> Vanilla JavaScript (no frameworks required)</li>
                                        <li><i class="fas fa-check vs-list-icon"></i> HTML5 & CSS3 for beautiful responsive design</li>
                                        <li><i class="fas fa-check vs-list-icon"></i> Browser Local Storage for data persistence</li>
                                    </ul>
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
                'overview': { icon: '<i class="fas fa-info-circle"></i>', text: 'Overview' },
                'features': { icon: '<i class="fas fa-star"></i>', text: 'Key Features' },
                'howto': { icon: '<i class="fas fa-cogs"></i>', text: 'How It Works' },
                'security': { icon: '<i class="fas fa-shield-alt"></i>', text: 'Privacy & Security' },
                'apikeys': { icon: '<i class="fas fa-key"></i>', text: 'Getting API Keys' },
                'tech': { icon: '<i class="fas fa-code"></i>', text: 'Technology Stack' }
            };
            
            const title = titles[tabName] || { icon: '<i class="fas fa-info-circle"></i>', text: 'About' };
            document.getElementById('panel-icon').innerHTML = title.icon;
            document.getElementById('panel-text').textContent = title.text;
        }
    </script>
</body>
</html>

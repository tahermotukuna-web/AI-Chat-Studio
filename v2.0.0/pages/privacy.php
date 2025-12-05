<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - AI Chat Studio</title>
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

        .vs-last-updated {
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 0.5rem;
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

        /* VS Code Cards */
        .vs-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
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
            line-height: 1.7;
        }

        .vs-card-content p {
            margin-bottom: 1rem;
        }

        .vs-card-content p:last-child {
            margin-bottom: 0;
        }

        /* Highlight Box */
        .vs-highlight {
            background: #0e4429;
            border: 1px solid #1a7f37;
            padding: 1rem;
            color: #56d364;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .vs-highlight strong {
            color: #7ee787;
        }

        /* VS Code List */
        .vs-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
        }

        .vs-list li {
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .vs-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: var(--primary-color);
        }

        .vs-numbered-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
            counter-reset: item;
        }

        .vs-numbered-list li {
            padding: 0.5rem 0;
            padding-left: 2rem;
            position: relative;
            color: var(--text-secondary);
            font-size: 0.9rem;
            counter-increment: item;
        }

        .vs-numbered-list li::before {
            content: counter(item) ".";
            position: absolute;
            left: 0;
            color: var(--primary-color);
            font-weight: 500;
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
                <h1>Privacy Policy</h1>
                <p>Your privacy is important to us</p>
                <div class="vs-last-updated">Last updated: November 29, 2025</div>
            </div>

            <div class="vs-layout">
                <!-- Sidebar -->
                <div class="vs-sidebar">
                    <div class="vs-sidebar-tabs">
                        <button class="vs-sidebar-tab active" data-tab="summary">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-lock"></i></span>
                            <span>Summary</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="collect">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-chart-bar"></i></span>
                            <span>What We Collect</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="notcollect">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-times-circle"></i></span>
                            <span>Not Collected</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="storage">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-database"></i></span>
                            <span>Data Storage</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="thirdparty">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-link"></i></span>
                            <span>Third Party</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="security">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-shield-alt"></i></span>
                            <span>Security</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="rights">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-balance-scale"></i></span>
                            <span>Your Rights</span>
                        </button>
                    </div>

                    <div class="vs-sidebar-footer">
                        <div class="vs-sidebar-footer-nav">
                            <a href="../index.php" class="vs-sidebar-footer-link" title="Chat">C</a>
                            <a href="about.php" class="vs-sidebar-footer-link" title="About">A</a>
                            <a href="faqs.php" class="vs-sidebar-footer-link" title="FAQs">Q</a>
                            <a href="settings.php" class="vs-sidebar-footer-link" title="Settings">S</a>
                            <a href="terms.php" class="vs-sidebar-footer-link" title="Terms">T</a>
                            <a href="privacy.php" class="vs-sidebar-footer-link active" title="Privacy">P</a>
                        </div>
                    </div>
                </div>

                <!-- Content Panel -->
                <div class="vs-content-panel">
                    <div class="vs-panel-header">
                        <div class="vs-panel-title">
                            <span id="panel-icon"><i class="fas fa-lock"></i></span>
                            <span id="panel-text">Quick Summary</span>
                        </div>
                    </div>

                    <div class="vs-panel-content">
                        <!-- Summary Section -->
                        <div class="vs-section active" id="summary-section">
                            <h2 class="vs-section-title">Quick Summary</h2>
                            
                            <div class="vs-highlight">
                                <strong><i class="fas fa-lock"></i> Your Privacy is Protected:</strong> AI Chat Studio does NOT collect, store, or transmit your personal data to our servers. All your conversations and API keys are stored locally in your browser. We don't use cookies for tracking or analytics.
                            </div>

                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-book-open"></i></span>
                                    <h3>Introduction</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>AI Chat Studio ("we," "us," "our," or "Company") operates the AI Chat Studio website. This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.</p>
                                </div>
                            </div>
                        </div>

                        <!-- What We Collect Section -->
                        <div class="vs-section" id="collect-section">
                            <h2 class="vs-section-title">What We Collect</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-chart-bar"></i></span>
                                    <h3>Minimal Data Collection</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>AI Chat Studio collects minimal information:</p>
                                    <ol class="vs-numbered-list">
                                        <li><strong>Browser Local Storage Data:</strong> Your conversation history and API key preferences are stored only in your browser's local storage</li>
                                        <li><strong>No Server Storage:</strong> We do not store any conversation data or personal information on our servers</li>
                                        <li><strong>No Cookies:</strong> We do not use tracking cookies or analytics</li>
                                        <li><strong>No Account Information:</strong> We don't collect names, emails, or personal identifiers</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Not Collected Section -->
                        <div class="vs-section" id="notcollect-section">
                            <h2 class="vs-section-title">What We Do NOT Collect</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-times-circle"></i></span>
                                    <h3>Explicitly Not Collected</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>We explicitly do NOT collect:</p>
                                    <ol class="vs-numbered-list">
                                        <li>Your API keys (they remain in your browser only)</li>
                                        <li>Your conversations or chat messages</li>
                                        <li>Your personal information or contact details</li>
                                        <li>Your IP address or device information</li>
                                        <li>Usage analytics or behavior tracking data</li>
                                        <li>Cookies or tracking pixels</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Data Storage Section -->
                        <div class="vs-section" id="storage-section">
                            <h2 class="vs-section-title">Data Storage</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-database"></i></span>
                                    <h3>Local Browser Storage</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p><strong>Local Browser Storage:</strong> All data related to your use of AI Chat Studio is stored exclusively in your web browser's local storage. This means:</p>
                                    <ol class="vs-numbered-list">
                                        <li>Your conversation history stays on your device</li>
                                        <li>Your API keys are never sent to our servers</li>
                                        <li>Clearing your browser data will delete all stored information</li>
                                        <li>You have complete control over this data</li>
                                        <li>Different browsers maintain separate storage</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Third Party Section -->
                        <div class="vs-section" id="thirdparty-section">
                            <h2 class="vs-section-title">Third-Party APIs</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-link"></i></span>
                                    <h3>External AI Services</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>When you use AI Chat Studio, messages are sent directly to third-party AI service providers:</p>
                                    <ol class="vs-numbered-list">
                                        <li><strong>Google Gemini:</strong> Subject to Google's Privacy Policy</li>
                                        <li><strong>Anthropic Claude:</strong> Subject to Anthropic's Privacy Policy</li>
                                        <li><strong>OpenAI GPT:</strong> Subject to OpenAI's Privacy Policy</li>
                                        <li><strong>DeepSeek:</strong> Subject to DeepSeek's Privacy Policy</li>
                                    </ol>
                                    <p>We recommend reviewing each provider's privacy policy. AI Chat Studio acts as a client interface and is not responsible for how third parties handle your data.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="vs-section" id="security-section">
                            <h2 class="vs-section-title">Security</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-shield-alt"></i></span>
                                    <h3>Data Security</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>The security of your data is important to us but remember that no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your personal data, we cannot guarantee its absolute security.</p>
                                    <p><strong>Your Responsibilities:</strong></p>
                                    <ol class="vs-numbered-list">
                                        <li>Never share your API keys with anyone</li>
                                        <li>Keep your browser and device secure</li>
                                        <li>Use strong, unique API keys when possible</li>
                                        <li>Clear your browser data if using a shared computer</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Rights Section -->
                        <div class="vs-section" id="rights-section">
                            <h2 class="vs-section-title">Your Rights</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-balance-scale"></i></span>
                                    <h3>GDPR Compliance</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>For users in the European Union and other jurisdictions with similar data protection laws:</p>
                                    <ol class="vs-numbered-list">
                                        <li>Your data rights are protected to the maximum extent possible</li>
                                        <li>We do not process personal data requiring GDPR compliance</li>
                                        <li>All data remains local to your device</li>
                                        <li>You have complete control over your data through browser storage management</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-flag-usa"></i></span>
                                    <h3>California Privacy Rights</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>Under the California Consumer Privacy Act (CCPA), California residents have the right to know what personal information is collected, used, shared or sold. Since AI Chat Studio does not collect or store personal information on our servers, CCPA rights regarding data deletion, access, and portability are limited to managing your local browser storage.</p>
                                </div>
                            </div>

                            <div class="vs-highlight">
                                <strong>Summary:</strong> Your privacy is our priority. AI Chat Studio doesn't collect, store, or track your personal data. Everything stays in your browser. We encourage you to review this policy regularly and contact us if you have concerns.
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
                'summary': { icon: '<i class="fas fa-lock"></i>', text: 'Quick Summary' },
                'collect': { icon: '<i class="fas fa-chart-bar"></i>', text: 'What We Collect' },
                'notcollect': { icon: '<i class="fas fa-times-circle"></i>', text: 'What We Do NOT Collect' },
                'storage': { icon: '<i class="fas fa-database"></i>', text: 'Data Storage' },
                'thirdparty': { icon: '<i class="fas fa-link"></i>', text: 'Third-Party APIs' },
                'security': { icon: '<i class="fas fa-shield-alt"></i>', text: 'Security' },
                'rights': { icon: '<i class="fas fa-balance-scale"></i>', text: 'Your Rights' }
            };
            
            const title = titles[tabName] || { icon: '<i class="fas fa-user-shield"></i>', text: 'Privacy' };
            document.getElementById('panel-icon').innerHTML = title.icon;
            document.getElementById('panel-text').textContent = title.text;
        }
    </script>
</body>
</html>

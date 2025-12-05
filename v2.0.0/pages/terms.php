<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - AI Chat Studio</title>
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
                <h1>Terms of Service</h1>
                <p>Please read these terms carefully before using AI Chat Studio</p>
                <div class="vs-last-updated">Last updated: November 29, 2025</div>
            </div>

            <div class="vs-layout">
                <!-- Sidebar -->
                <div class="vs-sidebar">
                    <div class="vs-sidebar-tabs">
                        <button class="vs-sidebar-tab active" data-tab="acceptance">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-handshake"></i></span>
                            <span>Acceptance</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="license">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-file-contract"></i></span>
                            <span>License</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="apikeys">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-key"></i></span>
                            <span>API Keys</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="thirdparty">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-users"></i></span>
                            <span>Third Party</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="content">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-file-text"></i></span>
                            <span>Content</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="liability">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-shield-alt"></i></span>
                            <span>Liability</span>
                        </button>
                        <button class="vs-sidebar-tab" data-tab="prohibited">
                            <span class="vs-sidebar-tab-icon"><i class="fas fa-ban"></i></span>
                            <span>Prohibited</span>
                        </button>
                    </div>

                    <div class="vs-sidebar-footer">
                        <div class="vs-sidebar-footer-nav">
                            <a href="../index.php" class="vs-sidebar-footer-link" title="Chat">C</a>
                            <a href="about.php" class="vs-sidebar-footer-link" title="About">A</a>
                            <a href="faqs.php" class="vs-sidebar-footer-link" title="FAQs">Q</a>
                            <a href="settings.php" class="vs-sidebar-footer-link" title="Settings">S</a>
                            <a href="terms.php" class="vs-sidebar-footer-link active" title="Terms">T</a>
                            <a href="privacy.php" class="vs-sidebar-footer-link" title="Privacy">P</a>
                        </div>
                    </div>
                </div>

                <!-- Content Panel -->
                <div class="vs-content-panel">
                    <div class="vs-panel-header">
                        <div class="vs-panel-title">
                            <span id="panel-icon">1</span>
                            <span id="panel-text">Acceptance of Terms</span>
                        </div>
                    </div>

                    <div class="vs-panel-content">
                        <!-- Acceptance Section -->
                        <div class="vs-section active" id="acceptance-section">
                            <h2 class="vs-section-title">1. Acceptance of Terms</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-file-contract"></i></span>
                                    <h3>Agreement</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>By accessing and using AI Chat Studio, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
                                </div>
                            </div>
                        </div>

                        <!-- License Section -->
                        <div class="vs-section" id="license-section">
                            <h2 class="vs-section-title">2. Use License</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-certificate"></i></span>
                                    <h3>License Terms</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>Permission is granted to temporarily download one copy of the materials (information or software) on AI Chat Studio for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
                                    <ol class="vs-numbered-list">
                                        <li>Modify or copy the materials</li>
                                        <li>Use the materials for any commercial purpose, or for any public display</li>
                                        <li>Attempt to decompile or reverse engineer any software contained on the site</li>
                                        <li>Remove any copyright or other proprietary notations from the materials</li>
                                        <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
                                        <li>Use automated tools (bots, scrapers) to access the service</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- API Keys Section -->
                        <div class="vs-section" id="apikeys-section">
                            <h2 class="vs-section-title">3. API Key Responsibility</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-key"></i></span>
                                    <h3>Your Responsibilities</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p><strong>You are entirely responsible for:</strong></p>
                                    <ol class="vs-numbered-list">
                                        <li>Obtaining and maintaining API keys from third-party providers</li>
                                        <li>Keeping your API keys confidential and secure</li>
                                        <li>All charges and fees incurred by your use of third-party AI services</li>
                                        <li>Complying with each AI provider's terms of service</li>
                                        <li>Monitoring your account usage and API quota</li>
                                    </ol>
                                    <p><strong>AI Chat Studio does not:</strong> Store your API keys on our servers, charge you for API usage, or guarantee the availability or functionality of third-party AI services.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Third Party Section -->
                        <div class="vs-section" id="thirdparty-section">
                            <h2 class="vs-section-title">4. Third-Party Services</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-link"></i></span>
                                    <h3>External Services</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>AI Chat Studio is a client interface for third-party AI services including but not limited to Google Gemini, Anthropic Claude, OpenAI GPT, and DeepSeek. We are not affiliated with, endorsed by, or responsible for these services. Each service has its own terms of service and privacy policy that you must comply with.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="vs-section" id="content-section">
                            <h2 class="vs-section-title">5. Content</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-file-text"></i></span>
                                    <h3>User & AI Content</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p><strong>User-Generated Content:</strong> You retain all rights to any content you create and submit through AI Chat Studio. However, by using the service, you grant us a limited license to store and display your content within your local browser storage.</p>
                                    <p><strong>AI-Generated Content:</strong> Content generated by AI models is the responsibility of the respective AI provider. We make no claims about the accuracy, quality, or legality of AI-generated responses.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Liability Section -->
                        <div class="vs-section" id="liability-section">
                            <h2 class="vs-section-title">6. Disclaimer & Liability</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                    <h3>Disclaimer of Warranties</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>AI Chat Studio is provided on an "AS IS" and "AS AVAILABLE" basis. We make no warranties, expressed or implied, and hereby disclaim and negate all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>
                                </div>
                            </div>

                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-shield-alt"></i></span>
                                    <h3>Limitations of Liability</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>In no event shall AI Chat Studio or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on AI Chat Studio, even if we or an authorized representative has been notified orally or in writing of the possibility of such damage.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Prohibited Section -->
                        <div class="vs-section" id="prohibited-section">
                            <h2 class="vs-section-title">7. Prohibited Uses</h2>
                            
                            <div class="vs-card">
                                <div class="vs-card-header">
                                    <span class="vs-card-icon"><i class="fas fa-ban"></i></span>
                                    <h3>You Agree Not To</h3>
                                </div>
                                <div class="vs-card-content">
                                    <p>You agree not to use AI Chat Studio:</p>
                                    <ol class="vs-numbered-list">
                                        <li>For any illegal purpose or in violation of any laws</li>
                                        <li>To harass, abuse, or threaten others</li>
                                        <li>To create malicious or deceptive content</li>
                                        <li>To generate content that violates copyright or intellectual property rights</li>
                                        <li>To attempt to gain unauthorized access to systems or services</li>
                                        <li>To engage in any form of fraud or deception</li>
                                    </ol>
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
                'acceptance': { icon: '<i class="fas fa-handshake"></i>', text: 'Acceptance of Terms' },
                'license': { icon: '<i class="fas fa-certificate"></i>', text: 'Use License' },
                'apikeys': { icon: '<i class="fas fa-key"></i>', text: 'API Key Responsibility' },
                'thirdparty': { icon: '<i class="fas fa-users"></i>', text: 'Third-Party Services' },
                'content': { icon: '<i class="fas fa-file-text"></i>', text: 'Content' },
                'liability': { icon: '<i class="fas fa-shield-alt"></i>', text: 'Disclaimer & Liability' },
                'prohibited': { icon: '<i class="fas fa-ban"></i>', text: 'Prohibited Uses' }
            };
            
            const title = titles[tabName] || { icon: '<i class="fas fa-file-contract"></i>', text: 'Terms' };
            document.getElementById('panel-icon').innerHTML = title.icon;
            document.getElementById('panel-text').textContent = title.text;
        }
    </script>
</body>
</html>

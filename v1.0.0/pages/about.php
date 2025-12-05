<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - AI Chat Studio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .page-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
            border-bottom: 2px solid var(--border-color);
        }

        .page-header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-content {
            line-height: 1.8;
        }

        .content-section {
            margin-bottom: 3rem;
        }

        .content-section h2 {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .content-section p {
            margin-bottom: 1rem;
            color: var(--text-secondary);
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 0.75rem 0;
            padding-left: 2rem;
            position: relative;
            color: var(--text-secondary);
        }

        .feature-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--success-color);
            font-weight: bold;
        }

        .footer-link {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .footer-link a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-link a:hover {
            color: var(--tertiary-color);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="nav-content">
                <div class="nav-brand">
                    <h1>🤖 AI Chat Studio</h1>
                </div>
                <ul class="nav-links">
                    <li><a href="../index.php" class="nav-link">Chat</a></li>
                    <li><a href="about.php" class="nav-link active">About</a></li>
                    <li><a href="faqs.php" class="nav-link">FAQs</a></li>
                    <li><a href="terms.php" class="nav-link">Terms</a></li>
                    <li><a href="privacy.php" class="nav-link">Privacy</a></li>
                </ul>
            </div>
        </nav>

        <div class="main-content" style="display: block; flex: 1; overflow-y: auto;">
            <div class="page-container">
                <div class="page-header">
                    <h1>About AI Chat Studio</h1>
                    <p>Your Ultimate Multi-Model AI Chat Interface</p>
                </div>

                <div class="page-content">
                    <div class="content-section">
                        <h2>What is AI Chat Studio?</h2>
                        <p>
                            AI Chat Studio is a modern, comprehensive web application that provides seamless access to multiple leading AI models in a single interface. Whether you're using Google Gemini, Anthropic Claude, OpenAI GPT, or DeepSeek, our platform brings them all together with a beautiful, intuitive design.
                        </p>
                        <p>
                            Our mission is to democratize access to advanced AI technology by creating a unified chat interface that eliminates the need to juggle multiple platforms while maintaining a premium user experience.
                        </p>
                    </div>

                    <div class="content-section">
                        <h2>Key Features</h2>
                        <ul class="feature-list">
                            <li>Support for multiple AI models (Gemini, Claude, GPT, DeepSeek)</li>
                            <li>Clean, modern, and responsive user interface</li>
                            <li>Local browser storage for conversation history</li>
                            <li>Organize conversations in an easy-to-use sidebar</li>
                            <li>Real-time API integration with proper error handling</li>
                            <li>Secure API key management and storage</li>
                            <li>Markdown support for formatted responses</li>
                            <li>Support for code blocks and syntax highlighting</li>
                            <li>Cross-conversation history and management</li>
                            <li>Completely free and open to use</li>
                        </ul>
                    </div>

                    <div class="content-section">
                        <h2>How It Works</h2>
                        <p>
                            Using AI Chat Studio is simple and straightforward:
                        </p>
                        <ol style="margin-left: 2rem; color: var(--text-secondary);">
                            <li style="margin-bottom: 0.75rem;">Select your preferred AI model from the dropdown menu</li>
                            <li style="margin-bottom: 0.75rem;">Enter your API key for that service (stored securely in your browser)</li>
                            <li style="margin-bottom: 0.75rem;">Type your message in the chat box</li>
                            <li style="margin-bottom: 0.75rem;">Click Send or press Ctrl+Enter</li>
                            <li style="margin-bottom: 0.75rem;">Watch as the AI responds in real-time</li>
                            <li>Your conversation history is automatically saved locally</li>
                        </ol>
                    </p>
                    </div>

                    <div class="content-section">
                        <h2>Privacy & Security</h2>
                        <p>
                            Your privacy is our top priority. Here's what you should know:
                        </p>
                        <ul class="feature-list">
                            <li>API keys are stored locally in your browser (not on our servers)</li>
                            <li>Conversation history never leaves your device unless you export it</li>
                            <li>All data is encrypted at rest in your browser's local storage</li>
                            <li>We don't collect or track your conversations</li>
                            <li>No user accounts or registration required</li>
                        </ul>
                    </div>

                    <div class="content-section">
                        <h2>Getting API Keys</h2>
                        <p>To use AI Chat Studio, you'll need API keys from your chosen AI service providers:</p>
                        <ul class="feature-list">
                            <li><strong>Google Gemini:</strong> aistudio.google.com</li>
                            <li><strong>Anthropic Claude:</strong> console.anthropic.com</li>
                            <li><strong>OpenAI GPT:</strong> platform.openai.com</li>
                            <li><strong>DeepSeek:</strong> platform.deepseek.com</li>
                        </ul>
                        <p style="margin-top: 1rem; color: var(--warning-color);">
                            ⚠️ Never share your API keys with anyone. Keep them private and secure.
                        </p>
                    </div>

                    <div class="content-section">
                        <h2>Technology Stack</h2>
                        <p>
                            AI Chat Studio is built with modern, reliable technologies:
                        </p>
                        <ul class="feature-list">
                            <li>PHP Backend for secure API integration</li>
                            <li>Vanilla JavaScript (no frameworks required)</li>
                            <li>HTML5 & CSS3 for beautiful responsive design</li>
                            <li>Browser Local Storage for data persistence</li>
                        </ul>
                    </div>

                    <div class="footer-link">
                        <p>Have questions? Check out our <a href="faqs.php">FAQs</a> or review our <a href="privacy.php">Privacy Policy</a>.</p>
                        <p><a href="../index.php">← Back to Chat</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>
</body>
</html>

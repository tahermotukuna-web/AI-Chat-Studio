<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - AI Chat Studio</title>
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

        .faq-item {
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .faq-question {
            padding: 1.5rem;
            background-color: var(--card-bg);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            user-select: none;
        }

        .faq-question:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        .faq-question h3 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--text-primary);
        }

        .faq-toggle {
            font-size: 1.5rem;
            color: var(--primary-color);
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-toggle {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background-color: var(--dark-bg);
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
        }

        .faq-answer p {
            padding: 1.5rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.8;
        }

        .faq-answer code {
            background-color: var(--card-bg);
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-family: monospace;
            color: var(--tertiary-color);
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
                    <li><a href="about.php" class="nav-link">About</a></li>
                    <li><a href="faqs.php" class="nav-link active">FAQs</a></li>
                    <li><a href="terms.php" class="nav-link">Terms</a></li>
                    <li><a href="privacy.php" class="nav-link">Privacy</a></li>
                </ul>
            </div>
        </nav>

        <div class="main-content" style="display: block; flex: 1; overflow-y: auto;">
            <div class="page-container">
                <div class="page-header">
                    <h1>Frequently Asked Questions</h1>
                    <p>Find answers to common questions about AI Chat Studio</p>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>Do I need to create an account?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>No! AI Chat Studio doesn't require any account creation or registration. Simply enter your API key and start chatting immediately. Your conversation history is stored locally in your browser.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>Is my API key safe?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, your API key is stored only in your browser's local storage and is never sent to our servers. However, we recommend using read-only API keys or keys with limited permissions when possible. Always keep your keys confidential and never share them with others.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>How do I get API keys?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Visit the official websites of each AI provider:
                            <br><br>
                            • <strong>Google Gemini:</strong> console.cloud.google.com
                            <br>
                            • <strong>Anthropic Claude:</strong> console.anthropic.com
                            <br>
                            • <strong>OpenAI GPT:</strong> platform.openai.com
                            <br>
                            • <strong>DeepSeek:</strong> platform.deepseek.com
                            <br><br>
                            Sign up, create an API key, and add it to AI Chat Studio.
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>Can I switch between different AI models?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely! You can switch between Gemini, Claude, GPT, and DeepSeek using the model selector dropdown. Each model can have its own API key stored independently. Your conversation history is preserved when switching models.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>Where is my conversation history stored?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Your conversation history is stored entirely in your browser's local storage. It never leaves your device and isn't stored on any server. If you clear your browser data, your history will be deleted. You can also manually clear all conversations from the application.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>Can I use this on mobile devices?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! AI Chat Studio is fully responsive and works on mobile devices including smartphones and tablets. The interface adapts automatically to different screen sizes for optimal usability on any device.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>How much does it cost to use AI Chat Studio?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>AI Chat Studio itself is completely free to use! However, you'll need API keys from the individual AI providers (Gemini, Claude, GPT, etc.), which may have their own pricing plans. Consult each provider's website for their current rates and free tier availability.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>What if I get an error message?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Common errors include invalid API keys, rate limiting, or network issues. Verify your API key is correct and has appropriate permissions. If the issue persists, check the specific AI provider's status page or documentation. Make sure your internet connection is stable.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>Can I export my conversation history?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Currently, conversations are stored in your browser's local storage. You can copy and paste conversations manually, or we recommend implementing browser developer tools export functionality if needed for your use case.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                        <h3>Is there an API or backend integration available?</h3>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>AI Chat Studio is designed as a standalone web application. However, all communication with AI providers happens through their official APIs. The backend uses PHP with cURL to securely relay requests to the respective AI services.</p>
                    </div>
                </div>

                <div class="footer-link">
                    <p>Still have questions? Visit our <a href="about.php">About page</a> or review our <a href="privacy.php">Privacy Policy</a>.</p>
                    <p><a href="../index.php">← Back to Chat</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>
</body>
</html>

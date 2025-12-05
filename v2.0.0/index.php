<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>AI Chat Studio — Enhanced Multi-Model AI Chat Interface</title>
    <meta name="description" content="AI Chat Studio: Enhanced multi-model AI chat with voice input, file uploads, conversation templates, export/import, and advanced search capabilities.">
    <meta name="keywords" content="ai chat,voice chat,file upload,conversation templates,export chat,ai assistant">
    <meta name="category" content="AI & Productivity">
    <meta name="platform" content="Web, PHP, Windows, Linux, macOS">
    <meta name="author" content="AI Chat Studio">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#667eea">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/icons/icon.svg">
    
    <!-- Additional SEO -->
    <link rel="canonical" href="https://example.com/">
    
    <!-- Structured Data / Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "AI Chat Studio",
        "description": "Enhanced multi-model AI chat interface with advanced features including voice input, file uploads, and conversation management.",
        "url": "https://example.com/",
        "applicationCategory": "AI & Productivity",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD",
            "description": "Free enhanced AI chat with premium features."
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.9",
            "ratingCount": "150"
        }
    }
    </script>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link rel="stylesheet" href="assets/css/themes.css"> -->
    <link rel="stylesheet" href="assets/css/prism-tomorrow.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <!-- Enhanced Navigation Bar -->
        <nav class="navbar">
            <div class="nav-content">
                <button class="hamburger-menu" id="hamburgerBtn" title="Toggle sidebar menu" aria-label="Open sidebar menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="nav-brand">
                    <h1>AI Chat Studio</h1>
                </div>
                <ul class="nav-links">
                    <li><a href="#" data-page="chat" class="nav-link active">Chat</a></li>
                    <li><a href="#" data-page="templates" class="nav-link">Templates</a></li>
                    <li><a href="pages/settings.php" class="nav-link">Settings</a></li>
                </ul>
            </div>
        </nav>

        <div class="main-content">
            <!-- Enhanced Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-header">
                    <div class="sidebar-actions">
                        <button class="btn-new-chat" id="newChatBtn" title="Start new conversation" aria-label="New chat conversation">
                            <i class="fas fa-plus"></i> New Chat
                        </button>
                        <button class="btn-sidebar-action" id="exportAllBtn" title="Export all conversations" aria-label="Export all">
                            <i class="fas fa-download"></i>
                        </button>
                        <button class="btn-sidebar-action" id="importBtn" title="Import conversations" aria-label="Import">
                            <i class="fas fa-upload"></i>
                        </button>
                        <button class="btn-close-sidebar" id="closeSidebarBtn" title="Close menu" aria-label="Close sidebar menu">×</button>
                    </div>
                </div>
                
                <div class="sidebar-filters">
                    <input type="text" id="conversationSearch" placeholder="Search conversations..." class="search-input">
                    <select id="conversationFilter" class="filter-select">
                        <option value="all">All Conversations</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="pinned">Pinned</option>
                    </select>
                </div>
                
                <div class="conversations-list" id="conversationsList">
                    <!-- Conversations will be added here by JS -->
                </div>
                <div class="sidebar-footer">
                    <button class="btn-clear-history" id="clearHistoryBtn" title="Remove all saved conversations" aria-label="Clear all chat history">
                        <i class="fas fa-trash"></i> Clear History
                    </button>
                </div>
            </aside>

            <!-- Enhanced Chat Area -->
            <div class="chat-container">
                <!-- Hidden model selector for JS functionality -->
                <select id="aiModel" class="model-select" style="display: none;" title="Select AI Model">
                    <option value="gemini">Gemini 2.5 Flash</option>
                    <option value="claude">Claude 3.5 Sonnet</option>
                    <option value="gpt">GPT-4 Turbo</option>
                    <option value="deepseek">DeepSeek</option>
                    <option value="llama">Llama 3</option>
                    <option value="mistral">Mistral AI</option>
                </select>
                <div class="model-info" id="modelInfo" style="display: none;"></div>

                <!-- Chat Messages Area -->
                <div class="chat-messages" id="chatMessages">
                    <div class="welcome-message">
                        <div class="welcome-header">
                            <h2>AI Chat Studio</h2>
                            <p>Multi-model AI conversation interface</p>
                        </div>
                        <div class="feature-grid">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-microphone"></i>
                                </div>
                                <h3>Voice Input</h3>
                                <p>Speech-to-text with real-time transcription</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-file"></i>
                                </div>
                                <h3>File Upload</h3>
                                <p>Upload and analyze documents and images</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <h3>Message Editing</h3>
                                <p>Edit and regenerate previous responses</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h3>Smart Search</h3>
                                <p>Find conversations and messages instantly</p>
                            </div>
                        </div>
                        <div class="setup-hint">
                            <p><i class="fas fa-info-circle"></i> Configure your API keys in <a href="pages/settings.php" class="vs-link">Settings</a> to begin chatting</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Chat Input Area -->
                <div class="chat-input-area">
                    <div class="input-tools">
                        <button class="tool-btn" id="templateBtn" title="Conversation templates">
                            <i class="fas fa-list"></i>
                        </button>
                        <button class="tool-btn" id="clearInputBtn" title="Clear input">
                            <i class="fas fa-eraser"></i>
                        </button>
                        <!-- Chat action buttons - moved to input tools area -->
                        <button class="tool-btn" id="inputFileUploadBtn" title="Upload file">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <button class="tool-btn" id="inputShareBtn" title="Share conversation">
                            <i class="fas fa-share"></i>
                        </button>
                        <button class="tool-btn" id="inputRegenerateBtn" title="Regenerate last response">
                            <i class="fas fa-redo"></i>
                        </button>
                        <a href="pages/settings.php" class="tool-btn" id="inputSettingsBtn" title="Settings">
                            <i class="fas fa-cog"></i>
                        </a>
                    </div>
                    <form id="chatForm" class="chat-form">
                        <div class="input-wrapper">
                            <textarea 
                                id="messageInput" 
                                class="message-input" 
                                placeholder="Type your message... (Ctrl+Enter to send, Shift+Enter for new line)" 
                                rows="1"
                                maxlength="10000"
                            ></textarea>
                            <div class="input-actions">

                                <button type="submit" class="btn-send" id="sendBtn">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="input-footer">
                            <small>Characters: <span id="charCount">0</span>/10000 | Ctrl+Enter to send</small>
                            <div class="typing-indicator" id="typingIndicator" style="display: none;">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner-container">
            <div class="spinner"></div>
            <div class="loading-text">
                <p id="loadingMessage">AI is thinking...</p>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Toast Notifications -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Enhanced File Upload Modal - VS Code Style -->
    <div class="modal" id="fileUploadModal">
        <div class="modal-content import-export-modal">
            <div class="modal-header">
                <h3 id="fileUploadTitle">Upload Files for Analysis</h3>
                <button class="modal-close" onclick="closeFileUploadModal()" aria-label="Close upload modal">×</button>
            </div>
            <div class="modal-body" id="fileUploadBody">
                <div class="vs-panel">
                    <!-- VS Code style tabs -->
                    <div class="vs-tab-bar">
                        <button class="vs-tab active" data-tab="upload">
                            <i class="fas fa-upload"></i> Upload Files
                        </button>
                        <button class="vs-tab" data-tab="settings">
                            <i class="fas fa-cog"></i> Settings
                        </button>
                    </div>

                    <div class="vs-panel-content">
                        <!-- File Upload Tab -->
                        <div class="vs-panel-item active" id="upload-tab">
                            <div class="vs-form-group">
                                <label class="vs-label">Select files to upload</label>
                                <p class="vs-label-description">Choose files from your computer to upload for analysis</p>
                                
                                <!-- Traditional file input approach -->
                                <div style="display: flex; gap: 12px; align-items: center; margin: 20px 0;">
                                    <input type="file" id="fileInput" multiple accept=".txt,.pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.csv,.json" style="display: none;">
                                    <button class="vs-btn vs-btn-primary" onclick="document.getElementById('fileInput').click()">
                                        <i class="fas fa-folder-open"></i> Browse Files
                                    </button>
                                    <button class="vs-btn vs-btn-secondary" onclick="window.app.clearAllFiles()" id="clearUploadBtn" style="display: none;">
                                        <i class="fas fa-times"></i> Clear All
                                    </button>
                                </div>
                                
                                <!-- File info display -->
                                <div id="selectedUploadFileInfo" class="vs-file-info" style="display: none; margin-top: 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: var(--surface); border: 1px solid var(--border-color); border-radius: 4px;">
                                        <div style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: var(--primary-color); border-radius: 4px; color: white;">
                                            <i class="fas fa-file"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <div id="selectedUploadFileName" style="font-weight: 500; color: var(--text);">No files selected</div>
                                            <div id="selectedUploadFileSize" style="font-size: 12px; color: var(--text-secondary);"></div>
                                        </div>
                                        <div style="display: flex; gap: 8px;">
                                            <button class="vs-btn vs-btn-secondary" onclick="document.getElementById('fileInput').click()">
                                                <i class="fas fa-exchange-alt"></i> Change
                                            </button>
                                            <button class="vs-btn vs-btn-primary" id="uploadSelectedFiles" onclick="processFileUpload()">
                                                <i class="fas fa-upload"></i> Process Files
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- File List Section -->
                                <div class="file-list-section" id="uploadFileListSection" style="display: none; margin-top: 16px;">
                                    <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: var(--surface); border: 1px solid var(--border-color); border-radius: 4px;">
                                        <div style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: var(--primary-color); border-radius: 4px; color: white;">
                                            <i class="fas fa-files"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <div id="uploadFileListTitle" style="font-weight: 500; color: var(--text);">Selected Files</div>
                                            <div id="uploadFileCount" style="font-size: 12px; color: var(--text-secondary);"></div>
                                        </div>
                                        <div style="display: flex; gap: 8px;">
                                            <button class="vs-btn vs-btn-secondary" onclick="window.app.clearAllFiles()">
                                                <i class="fas fa-trash"></i> Clear All
                                            </button>
                                        </div>
                                    </div>
                                    <div style="margin-top: 12px; max-height: 200px; overflow-y: auto; border: 1px solid var(--border-color); border-radius: 4px; background: var(--background);">
                                        <div class="file-list" id="uploadFileList"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div class="vs-panel-item" id="settings-tab">
                            <div class="vs-form-group">
                                <label class="vs-label">Upload Options</label>
                                <p class="vs-label-description">Configure how your files will be processed</p>
                                <div class="vs-checkbox-group">
                                    <label class="vs-checkbox">
                                        <input type="checkbox" id="analyzeContent" checked>
                                        <span class="vs-checkbox-mark"></span>
                                        <span class="vs-checkbox-content">Analyze file content with AI</span>
                                    </label>
                                    <label class="vs-checkbox">
                                        <input type="checkbox" id="extractText">
                                        <span class="vs-checkbox-mark"></span>
                                        <span class="vs-checkbox-content">Extract text for search</span>
                                    </label>
                                    <label class="vs-checkbox">
                                        <input type="checkbox" id="processImages">
                                        <span class="vs-checkbox-mark"></span>
                                        <span class="vs-checkbox-content">Process images and charts</span>
                                    </label>
                                    <label class="vs-checkbox">
                                        <input type="checkbox" id="maintainStructure">
                                        <span class="vs-checkbox-mark"></span>
                                        <span class="vs-checkbox-content">Maintain file structure and formatting</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- VS Code style footer -->
                    <div class="vs-panel-footer">
                        <div class="vs-actions">
                            <button class="vs-btn vs-btn-secondary" onclick="closeFileUploadModal()">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <button class="vs-btn vs-btn-primary" id="processUploadBtn" onclick="processFileUpload()" disabled>
                                <i class="fas fa-upload"></i> Process Upload
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Selection Modal -->
    <div class="modal" id="templateModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Conversation Templates</h3>
                <button class="modal-close" onclick="closeTemplateModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="template-categories">
                    <button class="category-btn active" data-category="all">All</button>
                    <button class="category-btn" data-category="coding"><i class="fas fa-code"></i> Coding</button>
                    <button class="category-btn" data-category="writing"><i class="fas fa-edit"></i> Writing</button>
                    <button class="category-btn" data-category="analysis"><i class="fas fa-chart-bar"></i> Analysis</button>
                    <button class="category-btn" data-category="creative"><i class="fas fa-palette"></i> Creative</button>
                </div>
                <div class="template-list" id="templateList"></div>
            </div>
        </div>
    </div>

    <!-- Search Modal -->
    <div class="modal" id="searchModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Search Conversations</h3>
                <button class="modal-close" onclick="closeSearchModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="search-controls">
                    <input type="text" id="globalSearch" placeholder="Search messages..." class="search-input">
                    <select id="searchFilter" class="filter-select">
                        <option value="all">All Models</option>
                        <option value="gemini">Gemini</option>
                        <option value="claude">Claude</option>
                        <option value="gpt">GPT</option>
                        <option value="deepseek">DeepSeek</option>
                    </select>
                    <input type="date" id="searchDateFrom" class="date-input">
                    <input type="date" id="searchDateTo" class="date-input">
                </div>
                <div class="search-results" id="searchResults"></div>
            </div>
        </div>
    </div>

    <!-- Message Edit Modal -->
    <div class="modal" id="editMessageModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Message</h3>
                <button class="modal-close" onclick="closeEditMessageModal()">×</button>
            </div>
            <div class="modal-body">
                <textarea id="editMessageInput" class="edit-textarea" rows="6"></textarea>
                <p class="edit-note">Editing this message will regenerate the AI response.</p>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeEditMessageModal()">Cancel</button>
                <button class="btn-primary" onclick="saveEditedMessage()">Save & Regenerate</button>
            </div>
        </div>
    </div>

    <!-- Import/Export Modal -->
    <div class="modal" id="importExportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="importExportTitle">Export Conversations</h3>
                <button class="modal-close" onclick="closeImportExportModal()">×</button>
            </div>
            <div class="modal-body" id="importExportBody">
                <!-- Content will be dynamically loaded -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/voice.js"></script>
    <script src="assets/js/templates.js"></script>
    <script src="assets/js/search.js"></script>
    <script src="assets/js/export.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>
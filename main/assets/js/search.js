/**
 * AI Chat Studio v2.0 - Advanced Search System
 * Provides intelligent search across conversations and messages
 */

class AdvancedSearch {
    constructor() {
        this.searchIndex = [];
        this.currentResults = [];
        this.searchFilters = {
            query: '',
            dateFrom: null,
            dateTo: null,
            model: 'all',
            messageType: 'all', // user, ai, or all
            conversationTitle: ''
        };
        this.debounceTimer = null;
        this.init();
    }

    init() {
        this.buildSearchIndex();
        this.setupEventListeners();
        this.setupSearchShortcuts();
    }

    setupEventListeners() {
        // Global search input
        const globalSearch = document.getElementById('globalSearch');
        if (globalSearch) {
            globalSearch.addEventListener('input', (e) => {
                this.handleSearchInput(e.target.value);
            });
        }

        // Search filters
        const searchFilter = document.getElementById('searchFilter');
        if (searchFilter) {
            searchFilter.addEventListener('change', (e) => {
                this.searchFilters.model = e.target.value;
                this.performSearch();
            });
        }

        const searchDateFrom = document.getElementById('searchDateFrom');
        const searchDateTo = document.getElementById('searchDateTo');
        
        if (searchDateFrom) {
            searchDateFrom.addEventListener('change', (e) => {
                this.searchFilters.dateFrom = e.target.value ? new Date(e.target.value) : null;
                this.performSearch();
            });
        }

        if (searchDateTo) {
            searchDateTo.addEventListener('change', (e) => {
                this.searchFilters.dateTo = e.target.value ? new Date(e.target.value) : null;
                this.performSearch();
            });
        }

        // Clear search button
        const clearSearch = document.getElementById('clearSearch');
        if (clearSearch) {
            clearSearch.addEventListener('click', () => {
                this.clearSearch();
            });
        }

        // Export search results
        const exportSearch = document.getElementById('exportSearch');
        if (exportSearch) {
            exportSearch.addEventListener('click', () => {
                this.exportSearchResults();
            });
        }
    }

    setupSearchShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + K to open search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.openSearchModal();
            }
            
            // Escape to close search
            if (e.key === 'Escape') {
                this.closeSearchModal();
            }
        });
    }

    buildSearchIndex() {
        this.searchIndex = [];
        
        const conversations = this.getAllConversations();
        
        conversations.forEach(conversation => {
            // Index conversation title
            this.searchIndex.push({
                type: 'conversation',
                conversationId: conversation.id,
                title: conversation.title,
                content: conversation.title,
                timestamp: conversation.created,
                model: conversation.model,
                relevance: 0.9 // High relevance for conversation titles
            });

            // Index messages
            if (conversation.messages) {
                conversation.messages.forEach((message, index) => {
                    // Create content with message and context
                    let context = '';
                    if (index > 0) {
                        context = conversation.messages[index - 1].content.substring(0, 100);
                    }
                    
                    this.searchIndex.push({
                        type: 'message',
                        conversationId: conversation.id,
                        conversationTitle: conversation.title,
                        messageIndex: index,
                        role: message.role,
                        content: message.content,
                        timestamp: message.timestamp,
                        model: message.model || conversation.model,
                        context: context,
                        relevance: 0.7 // Lower relevance for individual messages
                    });
                });
            }
        });
    }

    getAllConversations() {
        if (window.app && window.app.conversations) {
            return window.app.conversations;
        }
        
        // Fallback to localStorage
        const saved = localStorage.getItem('conversations');
        if (saved) {
            try {
                return JSON.parse(saved);
            } catch (e) {
                console.error('Error loading conversations for search:', e);
                return [];
            }
        }
        
        return [];
    }

    handleSearchInput(query) {
        this.searchFilters.query = query.trim();
        
        // Debounce search
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => {
            this.performSearch();
        }, 300);
    }

    performSearch() {
        if (!this.searchFilters.query) {
            this.displayResults([]);
            return;
        }

        const results = this.searchAcrossIndex();
        this.currentResults = results;
        this.displayResults(results);
        
        // Update search stats
        this.updateSearchStats(results.length);
    }

    searchAcrossIndex() {
        const query = this.searchFilters.query.toLowerCase();
        const results = [];

        // Tokenize query
        const queryTokens = query.split(/\s+/).filter(token => token.length > 2);
        
        this.searchIndex.forEach(item => {
            let score = 0;
            let matched = false;

            // Check if item passes filters
            if (!this.passesFilters(item)) {
                return;
            }

            // Exact phrase match (highest score)
            if (item.content.toLowerCase().includes(query)) {
                score += 10;
                matched = true;
            }

            // Individual token matches
            queryTokens.forEach(token => {
                if (item.content.toLowerCase().includes(token)) {
                    score += 2;
                    matched = true;
                }
                
                // Title/conversation title bonus
                if (item.type === 'conversation' && item.title.toLowerCase().includes(token)) {
                    score += 3;
                }
                
                // Context bonus
                if (item.context && item.context.toLowerCase().includes(token)) {
                    score += 1;
                }
            });

            // Fuzzy matching for close matches
            queryTokens.forEach(token => {
                const closeMatches = this.findCloseMatches(token, item.content.toLowerCase());
                score += closeMatches.length * 0.5;
            });

            if (matched || score > 0) {
                results.push({
                    ...item,
                    score: score * item.relevance,
                    matchType: this.getMatchType(item.content.toLowerCase(), query),
                    highlightedContent: this.highlightMatches(item.content, query)
                });
            }
        });

        // Sort by score (highest first)
        return results.sort((a, b) => b.score - a.score);
    }

    passesFilters(item) {
        // Model filter
        if (this.searchFilters.model !== 'all' && item.model !== this.searchFilters.model) {
            return false;
        }

        // Message type filter
        if (this.searchFilters.messageType !== 'all') {
            if (item.type === 'conversation') return false;
            if (item.role !== this.searchFilters.messageType) return false;
        }

        // Date range filter
        if (this.searchFilters.dateFrom || this.searchFilters.dateTo) {
            const itemDate = new Date(item.timestamp);
            
            if (this.searchFilters.dateFrom && itemDate < this.searchFilters.dateFrom) {
                return false;
            }
            
            if (this.searchFilters.dateTo) {
                const endOfDay = new Date(this.searchFilters.dateTo);
                endOfDay.setHours(23, 59, 59, 999);
                if (itemDate > endOfDay) {
                    return false;
                }
            }
        }

        return true;
    }

    findCloseMatches(token, content) {
        const matches = [];
        const words = content.split(/\s+/);
        
        words.forEach(word => {
            if (this.levenshteinDistance(token, word) <= 2) {
                matches.push(word);
            }
        });
        
        return matches;
    }

    levenshteinDistance(str1, str2) {
        const matrix = [];
        
        for (let i = 0; i <= str2.length; i++) {
            matrix[i] = [i];
        }
        
        for (let j = 0; j <= str1.length; j++) {
            matrix[0][j] = j;
        }
        
        for (let i = 1; i <= str2.length; i++) {
            for (let j = 1; j <= str1.length; j++) {
                if (str2.charAt(i - 1) === str1.charAt(j - 1)) {
                    matrix[i][j] = matrix[i - 1][j - 1];
                } else {
                    matrix[i][j] = Math.min(
                        matrix[i - 1][j - 1] + 1,
                        matrix[i][j - 1] + 1,
                        matrix[i - 1][j] + 1
                    );
                }
            }
        }
        
        return matrix[str2.length][str1.length];
    }

    getMatchType(content, query) {
        if (content.includes(query.toLowerCase())) {
            return 'exact';
        }
        
        const queryTokens = query.toLowerCase().split(/\s+/);
        const matchCount = queryTokens.filter(token => content.includes(token)).length;
        
        if (matchCount === queryTokens.length) {
            return 'all-words';
        } else if (matchCount > 0) {
            return 'partial';
        }
        
        return 'fuzzy';
    }

    highlightMatches(content, query) {
        let highlighted = content;
        const queryTokens = query.toLowerCase().split(/\s+/);
        
        queryTokens.forEach(token => {
            if (token.length > 2) {
                const regex = new RegExp(`(${this.escapeRegExp(token)})`, 'gi');
                highlighted = highlighted.replace(regex, '<mark>$1</mark>');
            }
        });
        
        return highlighted;
    }

    escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    displayResults(results) {
        const container = document.getElementById('searchResults');
        if (!container) return;

        if (results.length === 0) {
            if (this.searchFilters.query) {
                container.innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h3>No results found</h3>
                        <p>No conversations or messages match your search criteria.</p>
                        <div class="search-suggestions">
                            <h4>Search suggestions:</h4>
                            <ul>
                                <li>Try different keywords</li>
                                <li>Remove some filters</li>
                                <li>Check your spelling</li>
                                <li>Use more general terms</li>
                            </ul>
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="search-instructions">
                        <i class="fas fa-search"></i>
                        <h3>Search Your Conversations</h3>
                        <p>Type in the search box above to find specific conversations or messages.</p>
                        <div class="search-features">
                            <div class="feature">
                                <i class="fas fa-filter"></i>
                                <span>Filter by date, model, or message type</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-bolt"></i>
                                <span>Instant results as you type</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-highlight"></i>
                                <span>Highlights matching terms</span>
                            </div>
                        </div>
                    </div>
                `;
            }
            return;
        }

        const html = results.map(result => this.createResultHTML(result)).join('');
        container.innerHTML = html;
    }

    createResultHTML(result) {
        const timestamp = new Date(result.timestamp).toLocaleString();
        const typeIcon = result.type === 'conversation' ? 'fas fa-comments' : (result.role === 'user' ? 'fas fa-user' : 'fas fa-robot');
        const typeLabel = result.type === 'conversation' ? 'Conversation' : (result.role === 'user' ? 'User Message' : 'AI Response');
        
        return `
            <div class="search-result" data-conversation="${result.conversationId}" data-index="${result.messageIndex || ''}">
                <div class="result-header">
                    <div class="result-type">
                        <span class="type-icon">${typeIcon}</span>
                        <span class="type-label">${typeLabel}</span>
                        <span class="model-badge">${this.getModelName(result.model)}</span>
                    </div>
                    <div class="result-meta">
                        <span class="match-score">Score: ${result.score.toFixed(1)}</span>
                        <span class="timestamp">${timestamp}</span>
                        ${result.matchType ? `<span class="match-type ${result.matchType}">${result.matchType}</span>` : ''}
                    </div>
                </div>
                <div class="result-content">
                    <h4 class="result-title">${result.type === 'conversation' ? result.title : result.conversationTitle}</h4>
                    <p class="result-text">${result.highlightedContent}</p>
                    ${result.context ? `<p class="result-context"><em>Context: ${result.context.substring(0, 100)}...</em></p>` : ''}
                </div>
                <div class="result-actions">
                    <button class="btn-view" onclick="search.openConversation('${result.conversationId}', ${result.messageIndex || 0})">
                        <i class="fas fa-eye"></i> View
                    </button>
                    <button class="btn-copy" onclick="search.copyResult(${this.currentResults.indexOf(result)})">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                    <button class="btn-share" onclick="search.shareResult(${this.currentResults.indexOf(result)})">
                        <i class="fas fa-share"></i> Share
                    </button>
                </div>
            </div>
        `;
    }

    openConversation(conversationId, messageIndex = 0) {
        this.closeSearchModal();
        
        if (window.app) {
            window.app.switchConversation(conversationId);
            
            // Scroll to specific message if provided
            if (messageIndex > 0) {
                setTimeout(() => {
                    const messageElements = document.querySelectorAll('.message');
                    if (messageElements[messageIndex]) {
                        messageElements[messageIndex].scrollIntoView({ behavior: 'smooth', block: 'center' });
                        messageElements[messageIndex].classList.add('highlighted');
                        setTimeout(() => {
                            messageElements[messageIndex].classList.remove('highlighted');
                        }, 2000);
                    }
                }, 100);
            }
        }
    }

    copyResult(resultIndex) {
        const result = this.currentResults[resultIndex];
        if (result) {
            let textToCopy = '';
            
            if (result.type === 'conversation') {
                textToCopy = `Conversation: ${result.title}\nCreated: ${new Date(result.timestamp).toLocaleString()}\n\nContent:\n${result.content}`;
            } else {
                textToCopy = `From conversation: ${result.conversationTitle}\nRole: ${result.role}\nTimestamp: ${new Date(result.timestamp).toLocaleString()}\n\nContent:\n${result.content}`;
            }
            
            navigator.clipboard.writeText(textToCopy).then(() => {
                if (window.app) {
                    window.app.showToast('Result copied to clipboard', 'success');
                }
            });
        }
    }

    shareResult(resultIndex) {
        const result = this.currentResults[resultIndex];
        if (result) {
            const shareData = {
                type: result.type,
                title: result.type === 'conversation' ? result.title : result.conversationTitle,
                content: result.content,
                timestamp: result.timestamp,
                model: result.model
            };
            
            const shareUrl = this.createShareLink(shareData);
            
            if (navigator.share) {
                navigator.share({
                    title: 'AI Chat Search Result',
                    text: `${result.type}: ${result.type === 'conversation' ? result.title : result.conversationTitle}`,
                    url: shareUrl
                });
            } else {
                navigator.clipboard.writeText(shareUrl).then(() => {
                    if (window.app) {
                        window.app.showToast('Share link copied to clipboard', 'success');
                    }
                });
            }
        }
    }

    createShareLink(data) {
        const encoded = btoa(JSON.stringify(data));
        return `${window.location.origin}${window.location.pathname}?shared=${encoded}`;
    }

    updateSearchStats(resultCount) {
        const statsElement = document.getElementById('searchStats');
        if (statsElement) {
            statsElement.textContent = `Found ${resultCount} result${resultCount !== 1 ? 's' : ''}`;
        }
    }

    clearSearch() {
        // Clear inputs
        const globalSearch = document.getElementById('globalSearch');
        const searchDateFrom = document.getElementById('searchDateFrom');
        const searchDateTo = document.getElementById('searchDateTo');
        const searchFilter = document.getElementById('searchFilter');
        
        if (globalSearch) globalSearch.value = '';
        if (searchDateFrom) searchDateFrom.value = '';
        if (searchDateTo) searchDateTo.value = '';
        if (searchFilter) searchFilter.value = 'all';
        
        // Reset filters
        this.searchFilters = {
            query: '',
            dateFrom: null,
            dateTo: null,
            model: 'all',
            messageType: 'all',
            conversationTitle: ''
        };
        
        // Clear results
        this.displayResults([]);
    }

    exportSearchResults() {
        if (this.currentResults.length === 0) {
            if (window.app) {
                window.app.showToast('No search results to export', 'warning');
            }
            return;
        }

        const exportData = {
            query: this.searchFilters.query,
            timestamp: new Date().toISOString(),
            filters: this.searchFilters,
            results: this.currentResults.map(result => ({
                type: result.type,
                title: result.type === 'conversation' ? result.title : result.conversationTitle,
                content: result.content,
                timestamp: result.timestamp,
                model: result.model,
                score: result.score
            }))
        };

        const blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        
        const a = document.createElement('a');
        a.href = url;
        a.download = `search-results-${new Date().toISOString().split('T')[0]}.json`;
        a.click();
        
        URL.revokeObjectURL(url);
        
        if (window.app) {
            window.app.showToast('Search results exported', 'success');
        }
    }

    getModelName(model) {
        const names = {
            'gemini': 'Gemini',
            'claude': 'Claude',
            'gpt': 'GPT',
            'deepseek': 'DeepSeek',
            'llama': 'Llama',
            'mistral': 'Mistral'
        };
        return names[model] || model;
    }

    // Public methods for modal control
    openSearchModal() {
        const modal = document.getElementById('searchModal');
        if (modal) {
            modal.style.display = 'flex';
            const searchInput = document.getElementById('globalSearch');
            if (searchInput) {
                searchInput.focus();
            }
        }
    }

    closeSearchModal() {
        const modal = document.getElementById('searchModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Rebuild index when conversations change
    rebuildIndex() {
        this.buildSearchIndex();
        if (this.searchFilters.query) {
            this.performSearch();
        }
    }
}

// Initialize search system
document.addEventListener('DOMContentLoaded', () => {
    window.search = new AdvancedSearch();
    
    // Global function for opening search
    window.openSearchModal = () => {
        if (window.search) {
            window.search.openSearchModal();
        }
    };
});

// Add search-specific CSS
const searchStyles = `
<style>
.search-result {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all var(--transition-normal);
}

.search-result:hover {
    border-color: var(--primary-color);
    box-shadow: var(--shadow-sm);
    transform: translateY(-2px);
}

.result-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.result-type {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.type-icon {
    font-size: 1.2rem;
}

.type-label {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.model-badge {
    background: rgba(102, 126, 234, 0.1);
    color: var(--primary-color);
    padding: 0.2rem 0.5rem;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 600;
}

.result-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.match-score {
    font-weight: 600;
}

.match-type {
    padding: 0.2rem 0.5rem;
    border-radius: var(--radius-sm);
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.match-type.exact {
    background: var(--success-color);
    color: white;
}

.match-type.all-words {
    background: var(--info-color);
    color: white;
}

.match-type.partial {
    background: var(--warning-color);
    color: white;
}

.match-type.fuzzy {
    background: var(--text-muted);
    color: var(--dark-bg);
}

.result-content {
    margin-bottom: 1rem;
}

.result-title {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
}

.result-text {
    color: var(--text-secondary);
    line-height: 1.5;
    margin-bottom: 0.5rem;
}

.result-context {
    color: var(--text-muted);
    font-size: 0.85rem;
    font-style: italic;
}

.result-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.result-actions button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.85rem;
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-view {
    background: var(--primary-color);
    color: white;
}

.btn-view:hover {
    background: var(--secondary-color);
}

.btn-copy, .btn-share {
    background: var(--card-bg);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.btn-copy:hover, .btn-share:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.no-results, .search-instructions {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-muted);
}

.no-results i, .search-instructions i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-results h3, .search-instructions h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.search-suggestions {
    margin-top: 2rem;
    text-align: left;
    max-width: 300px;
    margin-left: auto;
    margin-right: auto;
}

.search-suggestions h4 {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.search-suggestions ul {
    list-style: none;
    padding: 0;
}

.search-suggestions li {
    padding: 0.25rem 0;
    position: relative;
    padding-left: 1.5rem;
}

.search-suggestions li::before {
    content: '→';
    position: absolute;
    left: 0;
    color: var(--primary-color);
}

.search-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 2rem;
}

.feature {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--card-bg);
    border-radius: var(--radius-md);
}

.feature i {
    color: var(--primary-color);
    font-size: 1.2rem;
    width: 24px;
    text-align: center;
}

.search-controls {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    align-items: flex-end;
    flex-wrap: wrap;
}

.search-controls input,
.search-controls select {
    flex: 1;
    min-width: 200px;
}

#searchStats {
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-style: italic;
}

mark {
    background: var(--primary-color);
    color: white;
    padding: 0.1rem 0.2rem;
    border-radius: 0.2rem;
}

.highlighted {
    animation: highlight-pulse 2s ease-in-out;
}

@keyframes highlight-pulse {
    0%, 100% { background-color: transparent; }
    50% { background-color: rgba(102, 126, 234, 0.2); }
}

@media (max-width: 640px) {
    .result-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .result-actions {
        flex-direction: column;
    }
    
    .result-actions button {
        justify-content: center;
    }
    
    .search-controls {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-controls input,
    .search-controls select {
        min-width: auto;
    }
}
</style>
`;

// Inject styles
document.head.insertAdjacentHTML('beforeend', searchStyles);
/**
 * AI Chat Studio v2.0 - Conversation Templates System
 * Provides pre-built prompts for common use cases
 */

class ConversationTemplates {
    constructor() {
        this.templates = this.getDefaultTemplates();
        this.currentCategory = 'all';
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadCustomTemplates();
    }

    setupEventListeners() {
        // Category filter buttons
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const category = e.target.dataset.category;
                this.filterByCategory(category);
            });
        });
    }

    getDefaultTemplates() {
        return {
            coding: [
                {
                    id: 'code-review',
                    title: 'Code Review',
                    description: 'Get detailed code review feedback',
                    category: 'coding',
                    prompt: 'Please review my code and provide detailed feedback on:\n1. Code quality and best practices\n2. Potential bugs or issues\n3. Performance optimizations\n4. Security considerations\n5. Suggestions for improvement\n\nHere is my code:\n\n```\n[PASTE YOUR CODE HERE]\n```\n\nPlease provide a comprehensive review with specific examples and actionable suggestions.'
                },
                {
                    id: 'debug-help',
                    title: 'Debug Assistant',
                    description: 'Get help debugging code issues',
                    category: 'coding',
                    prompt: 'I need help debugging this code. Please:\n\n1. Analyze the code for potential issues\n2. Identify the most likely cause of the problem\n3. Provide step-by-step debugging steps\n4. Suggest solutions with code examples\n5. Explain how to prevent similar issues\n\nHere is my code and error:\n\n```\n[PASTE YOUR CODE HERE]\n```\n\nError message:\n[PASTE ERROR MESSAGE HERE]'
                },
                {
                    id: 'algorithm-explainer',
                    title: 'Algorithm Explainer',
                    description: 'Understand algorithms and data structures',
                    category: 'coding',
                    prompt: 'Please explain this algorithm/data structure in detail:\n\n1. What it is and how it works\n2. Time and space complexity analysis\n3. Step-by-step execution with examples\n4. Real-world use cases\n5. Advantages and disadvantages\n6. Comparison with alternatives\n\nAlgorithm/Data Structure:\n[DESCRIBE YOUR ALGORITHM]\n\nPlease provide clear explanations with examples and visualizations.'
                },
                {
                    id: 'refactor-code',
                    title: 'Code Refactoring',
                    description: 'Improve code structure and quality',
                    category: 'coding',
                    prompt: 'Please refactor this code to improve:\n\n1. Code readability and maintainability\n2. Performance optimization\n3. Following SOLID principles\n4. Best practices and design patterns\n5. Error handling and edge cases\n\nOriginal code:\n```\n[PASTE YOUR CODE HERE]\n```\n\nPlease provide:\n- Refactored code with explanations\n- Before/after comparison\n- Benefits of the changes\n- Potential trade-offs'
                },
                {
                    id: 'unit-test-generator',
                    title: 'Unit Test Generator',
                    description: 'Generate comprehensive unit tests',
                    category: 'coding',
                    prompt: 'Please create comprehensive unit tests for this code:\n\n```\n[PASTE YOUR CODE HERE]\n```\n\nPlease generate:\n1. Test cases covering normal scenarios\n2. Edge cases and boundary conditions\n3. Error handling tests\n4. Performance tests if applicable\n5. Test coverage analysis\n\nUse [SPECIFY TESTING FRAMEWORK] and follow best practices.'
                },
                {
                    id: 'architecture-review',
                    title: 'Architecture Review',
                    description: 'Review software architecture and design',
                    category: 'coding',
                    prompt: 'Please review this software architecture:\n\n[DESCRIBE YOUR ARCHITECTURE]\n\nPlease analyze:\n1. Overall design patterns used\n2. Scalability and maintainability\n3. Security considerations\n4. Performance implications\n5. Code organization and structure\n6. Dependencies and coupling\n7. Suggestions for improvement\n\nProvide actionable recommendations with examples.'
                }
            ],
            writing: [
                {
                    id: 'blog-post',
                    title: 'Blog Post Writer',
                    description: 'Write engaging blog posts',
                    category: 'writing',
                    prompt: 'Please write a comprehensive blog post on: [TOPIC]\n\nTarget audience: [AUDIENCE]\nTone: [TONE - formal, casual, technical, etc.]\nLength: [DESIRED LENGTH]\n\nPlease include:\n1. Compelling headline and subheadings\n2. Introduction that hooks the reader\n3. Well-structured main content\n4. Practical examples and tips\n5. Conclusion with key takeaways\n6. SEO-friendly optimization\n\nTopic: [YOUR TOPIC]\nAudience: [YOUR AUDIENCE]\nKey points to cover: [LIST POINTS]'
                },
                {
                    id: 'copywriting',
                    title: 'Copywriting Assistant',
                    description: 'Create persuasive marketing copy',
                    category: 'writing',
                    prompt: 'Please help me write persuasive copy for:\n\n[DESCRIBE YOUR MARKETING PIECE - ad, email, website, etc.]\n\nTarget audience: [AUDIENCE]\nProduct/Service: [WHAT YOU\'RE PROMOTING]\nGoal: [CONVERSION GOAL]\n\nPlease create:\n1. Attention-grabbing headline\n2. Compelling opening\n3. Benefits-focused body copy\n4. Strong call-to-action\n5. Social proof elements\n6. Urgency or scarcity triggers\n\nProduct details: [PRODUCT INFO]\nUnique selling points: [USP LIST]\nTarget pain points: [PAIN POINTS]'
                },
                {
                    id: 'technical-writing',
                    title: 'Technical Documentation',
                    description: 'Create clear technical documentation',
                    category: 'writing',
                    prompt: 'Please help me write technical documentation for: [SUBJECT]\n\nTarget audience: [TECHNICAL LEVEL]\nFormat needed: [FORMAT - API docs, user guide, etc.]\n\nPlease include:\n1. Clear overview and purpose\n2. Prerequisites and requirements\n3. Step-by-step instructions\n4. Code examples and snippets\n5. Troubleshooting section\n6. API references if applicable\n7. Screenshots or diagrams descriptions\n\nSubject: [WHAT YOU\'RE DOCUMENTING]\nKey features/topics: [LIST TOPICS]\nExisting context: [ANY EXISTING INFO]'
                },
                {
                    id: 'creative-writing',
                    title: 'Creative Writing',
                    description: 'Help with creative writing projects',
                    category: 'writing',
                    prompt: 'I\'d like help with creative writing on: [TOPIC/GENRE]\n\nType: [story, poem, script, etc.]\nStyle: [DESIRED STYLE]\nLength: [DESIRED LENGTH]\nTheme: [THEME IF ANY]\n\nPlease provide:\n1. Creative brainstorming and ideas\n2. Character development suggestions\n3. Plot structure and pacing\n4. Dialogue examples\n5. Descriptive language enhancement\n6. Plot twist or climax development\n\nProject details: [YOUR PROJECT INFO]\nInspiration: [ANY INSPIRATION SOURCES]\nConstraints: [ANY CONSTRAINTS]'
                },
                {
                    id: 'academic-writing',
                    title: 'Academic Writing',
                    description: 'Assistance with academic papers',
                    category: 'writing',
                    prompt: 'Please help me with academic writing on: [TOPIC]\n\nType: [essay, research paper, thesis, etc.]\nAcademic level: [UNDERGRADUATE, GRADUATE, etc.]\nCitation style: [APA, MLA, Chicago, etc.]\nLength: [REQUIRED LENGTH]\n\nPlease assist with:\n1. Thesis statement development\n2. Argument structure and flow\n3. Evidence and source integration\n4. Academic tone and style\n5. Conclusion development\n6. Citation formatting\n\nTopic: [RESEARCH TOPIC]\nResearch question: [MAIN QUESTION]\nAvailable sources: [LIST SOURCES]\nAssignment requirements: [SPECIFIC REQUIREMENTS]'
                }
            ],
            analysis: [
                {
                    id: 'data-analysis',
                    title: 'Data Analysis',
                    description: 'Analyze datasets and extract insights',
                    category: 'analysis',
                    prompt: 'Please help me analyze this dataset:\n\n[DESCRIBE YOUR DATA]\n\nPlease provide:\n1. Data overview and summary statistics\n2. Key patterns and trends identified\n3. Correlation analysis\n4. Outlier detection\n5. Visualization recommendations\n6. Statistical significance tests\n7. Actionable insights and recommendations\n\nDataset details:\n- Size: [NUMBER OF ROWES/COLUMNS]\n- Variables: [LIST VARIABLES]\n- Data types: [NUMERIC, CATEGORICAL, etc.]\n- Research question: [WHAT YOU WANT TO ANSWER]\n\n[PASTE SAMPLE DATA OR DATA DESCRIPTION]'
                },
                {
                    id: 'market-research',
                    title: 'Market Research',
                    description: 'Conduct market analysis and research',
                    category: 'analysis',
                    prompt: 'Please help me conduct market research for: [PRODUCT/SERVICE]\n\nMarket: [TARGET MARKET]\nResearch objectives: [WHAT YOU WANT TO LEARN]\n\nPlease provide:\n1. Market size and growth projections\n2. Target audience analysis\n3. Competitive landscape overview\n4. SWOT analysis\n5. Market trends and opportunities\n6. Risk assessment\n7. Strategic recommendations\n\nProduct/Service: [WHAT YOU\'RE ANALYZING]\nTarget market: [MARKET SEGMENT]\nGeographic scope: [GLOBAL/NATIONAL/LOCAL]\nBudget constraints: [IF ANY]'
                },
                {
                    id: 'performance-review',
                    title: 'Performance Analysis',
                    description: 'Review performance metrics and KPIs',
                    category: 'analysis',
                    prompt: 'Please help me analyze performance data:\n\n[DESCRIBE PERFORMANCE METRICS]\n\nPlease analyze:\n1. Performance trends over time\n2. Key performance indicators (KPIs)\n3. Bottlenecks and areas for improvement\n4. Benchmark comparisons\n5. Predictive insights\n6. Action plan for optimization\n\nMetrics to analyze:\n- [LIST KEY METRICS]\n- Time period: [TIME RANGE]\n- Baseline/benchmark: [IF AVAILABLE]\n- Goals/objectives: [WHAT YOU\'RE TRYING TO ACHIEVE]\n\n[PASTE PERFORMANCE DATA]'
                },
                {
                    id: 'process-improvement',
                    title: 'Process Improvement',
                    description: 'Analyze and improve business processes',
                    category: 'analysis',
                    prompt: 'Please help me improve this process: [PROCESS NAME]\n\nCurrent process: [DESCRIBE CURRENT PROCESS]\nPain points: [CURRENT ISSUES]\nGoals: [WHAT YOU WANT TO ACHIEVE]\n\nPlease provide:\n1. Current state analysis\n2. Process mapping and flow\n3. Bottleneck identification\n4. Waste elimination opportunities\n5. Efficiency improvement suggestions\n6. Implementation roadmap\n7. Success metrics and KPIs\n\nProcess details:\n- Department/team: [WHO\'S INVOLVED]\n- Tools/systems used: [CURRENT TOOLS]\n- Volume/frequency: [HOW OFTEN IT RUNS]\n- Timeline constraints: [DEADLINES]'
                }
            ],
            creative: [
                {
                    id: 'brainstorming',
                    title: 'Idea Brainstorming',
                    description: 'Generate creative ideas and solutions',
                    category: 'creative',
                    prompt: 'Please help me brainstorm ideas for: [TOPIC/CHALLENGE]\n\nCategory: [product, marketing, content, etc.]\nConstraints: [ANY LIMITATIONS]\nTarget audience: [WHO YOU\'RE TARGETING]\n\nPlease provide:\n1. 10+ creative ideas with explanations\n2. Feasibility assessment for each\n3. Potential impact and benefits\n4. Resource requirements\n5. Implementation timeline\n6. Success metrics\n\nChallenge: [YOUR CHALLENGE OR TOPIC]\nContext: [BACKGROUND INFO]\nDesired outcome: [WHAT SUCCESS LOOKS LIKE]'
                },
                {
                    id: 'content-strategy',
                    title: 'Content Strategy',
                    description: 'Develop content marketing strategies',
                    category: 'creative',
                    prompt: 'Please help me create a content strategy for: [BUSINESS/TOPIC]\n\nBusiness type: [WHAT TYPE OF BUSINESS]\nTarget audience: [AUDIENCE PROFILE]\nGoals: [WHAT YOU WANT TO ACHIEVE]\n\nPlease develop:\n1. Content pillars and themes\n2. Editorial calendar suggestions\n3. Content formats and distribution channels\n4. SEO and social media integration\n5. Content performance metrics\n6. Content creation workflow\n\nBusiness details:\n- Industry: [YOUR INDUSTRY]\n- Products/services: [WHAT YOU OFFER]\n- Current content: [WHAT YOU HAVE NOW]\n- Competitors: [WHO YOU\'RE COMPETING WITH]'
                },
                {
                    id: 'user-experience',
                    title: 'UX/UI Design',
                    description: 'Improve user experience and interface design',
                    category: 'creative',
                    prompt: 'Please help me improve the UX/UI for: [PRODUCT/WEBSITE/APP]\n\nCurrent issues: [PROBLEMS YOU\'RE FACING]\nTarget users: [USER PROFILE]\nPlatform: [web, mobile, desktop]\n\nPlease provide:\n1. User journey mapping\n2. Interface layout improvements\n3. User flow optimization\n4. Accessibility recommendations\n5. Visual design suggestions\n6. Usability testing plan\n\nProduct details:\n- Current design: [DESCRIBE CURRENT STATE]\n- Key features: [MAIN FUNCTIONALITY]\n- User goals: [WHAT USERS WANT TO ACCOMPLISH]\n- Technical constraints: [ANY LIMITATIONS]'
                },
                {
                    id: 'marketing-campaign',
                    title: 'Marketing Campaign',
                    description: 'Design comprehensive marketing campaigns',
                    category: 'creative',
                    prompt: 'Please help me create a marketing campaign for: [PRODUCT/SERVICE]\n\nCampaign objective: [WHAT YOU WANT TO ACHIEVE]\nTarget audience: [WHO YOU\'RE TARGETING]\nBudget range: [BUDGET CONSTRAINTS]\nTimeline: [CAMPAIGN DURATION]\n\nPlease develop:\n1. Campaign strategy and positioning\n2. Multi-channel marketing plan\n3. Creative concepts and messaging\n4. Content calendar and assets\n5. Budget allocation across channels\n6. KPIs and success metrics\n7. Testing and optimization plan\n\nCampaign details:\n- Product/service: [WHAT YOU\'RE PROMOTING]\n- Unique value proposition: [YOUR USP]\n- Market position: [HOW YOU FIT IN THE MARKET]\n- Current marketing: [EXISTING EFFORTS]'
                }
            ]
        };
    }

    loadCustomTemplates() {
        const saved = localStorage.getItem('customTemplates');
        if (saved) {
            try {
                const custom = JSON.parse(saved);
                // Merge custom templates with defaults
                this.templates = { ...this.templates, ...custom };
            } catch (e) {
                console.error('Error loading custom templates:', e);
            }
        }
    }

    saveCustomTemplates() {
        const customTemplates = {};
        Object.keys(this.templates).forEach(category => {
            customTemplates[category] = this.templates[category].filter(t => t.custom);
        });
        localStorage.setItem('customTemplates', JSON.stringify(customTemplates));
    }

    filterByCategory(category) {
        this.currentCategory = category;
        
        // Update active category button
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.category === category) {
                btn.classList.add('active');
            }
        });

        this.renderTemplates();
    }

    renderTemplates() {
        const container = document.getElementById('templateList');
        if (!container) return;

        let allTemplates = [];
        
        // Collect templates from all categories
        Object.keys(this.templates).forEach(category => {
            if (this.currentCategory === 'all' || category === this.currentCategory) {
                allTemplates = allTemplates.concat(this.templates[category]);
            }
        });

        // Sort templates (custom templates first, then by title)
        allTemplates.sort((a, b) => {
            if (a.custom && !b.custom) return -1;
            if (!a.custom && b.custom) return 1;
            return a.title.localeCompare(b.title);
        });

        if (allTemplates.length === 0) {
            container.innerHTML = `
                <div class="no-templates">
                    <p>No templates found in this category.</p>
                    <button class="btn-primary" onclick="templates.showAddTemplateModal()">Add Custom Template</button>
                </div>
            `;
            return;
        }

        container.innerHTML = allTemplates.map(template => `
            <div class="template-card" data-id="${template.id}">
                <div class="template-header">
                    <div class="template-info">
                        <h3>${template.title}</h3>
                        <p>${template.description}</p>
                    </div>
                    ${template.custom ? '<div class="custom-badge">Custom</div>' : ''}
                </div>
                <div class="template-preview">
                    <p>${template.prompt.substring(0, 150)}${template.prompt.length > 150 ? '...' : ''}</p>
                </div>
                <div class="template-actions">
                    <button class="btn-use" onclick="templates.useTemplate('${template.id}')">
                        Use Template
                    </button>
                    <button class="btn-preview" onclick="templates.previewTemplate('${template.id}')">
                        Preview
                    </button>
                    ${template.custom ? `
                        <button class="btn-edit" onclick="templates.editTemplate('${template.id}')">
                            Edit
                        </button>
                        <button class="btn-delete" onclick="templates.deleteTemplate('${template.id}')">
                            Delete
                        </button>
                    ` : ''}
                </div>
            </div>
        `).join('');
    }

    useTemplate(templateId) {
        const template = this.findTemplate(templateId);
        if (!template) return;

        // Close template modal
        this.closeTemplateModal();
        
        // Insert template into message input
        const messageInput = document.getElementById('messageInput');
        if (messageInput) {
            messageInput.value = template.prompt;
            messageInput.focus();
            messageInput.dispatchEvent(new Event('input'));
        }

        // Show toast notification
        if (window.app) {
            window.app.showToast(`Template "${template.title}" loaded`, 'success');
        }
    }

    previewTemplate(templateId) {
        const template = this.findTemplate(templateId);
        if (!template) return;

        // Remove any existing preview modals
        const existingModal = document.querySelector('.preview-modal');
        if (existingModal) {
            existingModal.remove();
        }

        const modal = document.createElement('div');
        modal.className = 'modal preview-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>${template.title}</h3>
                    <button class="modal-close" onclick="this.closest('.modal').remove()">×</button>
                </div>
                <div class="modal-body">
                    <div class="template-meta">
                        <span class="category-badge">${template.category}</span>
                        ${template.custom ? '<span class="custom-badge">Custom</span>' : ''}
                    </div>
                    <p class="template-description">${template.description}</p>
                    <div class="template-content">
                        <h4>Template Content:</h4>
                        <div class="template-prompt">${this.escapeHtml(template.prompt)}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" onclick="this.closest('.modal').remove()">Close</button>
                    <button class="btn-primary" onclick="templates.useTemplate('${template.id}'); this.closest('.modal').remove();">
                        Use This Template
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        
        // Force show the modal
        setTimeout(() => {
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.classList.add('active');
        }, 10);
    }

    showAddTemplateModal() {
        const modal = document.createElement('div');
        modal.className = 'modal add-template-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add Custom Template</h3>
                    <button class="modal-close" onclick="this.closest('.modal').remove()">×</button>
                </div>
                <div class="modal-body">
                    <form id="addTemplateForm">
                        <div class="form-group">
                            <label for="templateTitle">Title</label>
                            <input type="text" id="templateTitle" required placeholder="Enter template title">
                        </div>
                        <div class="form-group">
                            <label for="templateDescription">Description</label>
                            <input type="text" id="templateDescription" required placeholder="Brief description">
                        </div>
                        <div class="form-group">
                            <label for="templateCategory">Category</label>
                            <select id="templateCategory" required>
                                <option value="coding">Coding</option>
                                <option value="writing">Writing</option>
                                <option value="analysis">Analysis</option>
                                <option value="creative">Creative</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="templatePrompt">Template Content</label>
                            <textarea id="templatePrompt" rows="8" required placeholder="Enter your template content..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" onclick="this.closest('.modal').remove()">Cancel</button>
                    <button class="btn-primary" onclick="templates.saveTemplate()">Save Template</button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        modal.style.display = 'flex';
    }

    saveTemplate() {
        const form = document.getElementById('addTemplateForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const template = {
            id: 'custom_' + Date.now(),
            title: document.getElementById('templateTitle').value,
            description: document.getElementById('templateDescription').value,
            category: document.getElementById('templateCategory').value,
            prompt: document.getElementById('templatePrompt').value,
            custom: true
        };

        // Add to templates
        if (!this.templates[template.category]) {
            this.templates[template.category] = [];
        }
        this.templates[template.category].push(template);

        // Save to localStorage
        this.saveCustomTemplates();

        // Close modal and refresh
        document.querySelector('.add-template-modal').remove();
        this.renderTemplates();

        if (window.app) {
            window.app.showToast(`Template "${template.title}" added`, 'success');
        }
    }

    editTemplate(templateId) {
        const template = this.findTemplate(templateId);
        if (!template) return;

        // Similar to add template but pre-filled
        this.showAddTemplateModal();
        
        document.getElementById('templateTitle').value = template.title;
        document.getElementById('templateDescription').value = template.description;
        document.getElementById('templateCategory').value = template.category;
        document.getElementById('templatePrompt').value = template.prompt;

        // Change save handler to update instead of create
        const saveBtn = document.querySelector('.add-template-modal .btn-primary');
        saveBtn.textContent = 'Update Template';
        saveBtn.onclick = () => this.updateTemplate(templateId);
    }

    updateTemplate(templateId) {
        const template = this.findTemplate(templateId);
        if (!template) return;

        // Update template data
        template.title = document.getElementById('templateTitle').value;
        template.description = document.getElementById('templateDescription').value;
        template.category = document.getElementById('templateCategory').value;
        template.prompt = document.getElementById('templatePrompt').value;

        // Save to localStorage
        this.saveCustomTemplates();

        // Close modal and refresh
        document.querySelector('.add-template-modal').remove();
        this.renderTemplates();

        if (window.app) {
            window.app.showToast(`Template "${template.title}" updated`, 'success');
        }
    }

    deleteTemplate(templateId) {
        if (!confirm('Are you sure you want to delete this template?')) return;

        // Find and remove template
        for (const category in this.templates) {
            const index = this.templates[category].findIndex(t => t.id === templateId);
            if (index !== -1) {
                const template = this.templates[category][index];
                this.templates[category].splice(index, 1);
                
                // Save to localStorage
                this.saveCustomTemplates();
                this.renderTemplates();
                
                if (window.app) {
                    window.app.showToast(`Template "${template.title}" deleted`, 'success');
                }
                return;
            }
        }
    }

    findTemplate(templateId) {
        for (const category in this.templates) {
            const template = this.templates[category].find(t => t.id === templateId);
            if (template) return template;
        }
        return null;
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    closeTemplateModal() {
        const modal = document.getElementById('templateModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    exportTemplates() {
        const exportData = {
            version: '2.0',
            exported: new Date().toISOString(),
            templates: this.templates
        };

        const blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        
        const a = document.createElement('a');
        a.href = url;
        a.download = `ai-chat-templates-${new Date().toISOString().split('T')[0]}.json`;
        a.click();
        
        URL.revokeObjectURL(url);
    }

    importTemplates(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const importData = JSON.parse(e.target.result);
                
                if (importData.templates) {
                    // Merge with existing templates
                    Object.keys(importData.templates).forEach(category => {
                        if (!this.templates[category]) {
                            this.templates[category] = [];
                        }
                        this.templates[category] = [...this.templates[category], ...importData.templates[category]];
                    });
                    
                    this.saveCustomTemplates();
                    this.renderTemplates();
                    
                    if (window.app) {
                        window.app.showToast('Templates imported successfully', 'success');
                    }
                }
            } catch (error) {
                if (window.app) {
                    window.app.showToast('Error importing templates: ' + error.message, 'error');
                }
            }
        };
        reader.readAsText(file);
    }
}

// Initialize templates system when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.templates = new ConversationTemplates();
    
    // Global function for loading template list
    window.loadTemplateList = () => {
        if (window.templates) {
            window.templates.renderTemplates();
        }
    };
});

// Add template-specific CSS
const templateStyles = `
<style>
.template-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all var(--transition-normal);
}

.template-card:hover {
    border-color: var(--primary-color);
    box-shadow: var(--shadow-sm);
    transform: translateY(-2px);
}

.template-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.template-info h3 {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.template-info p {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.custom-badge {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: auto;
}

.template-preview {
    margin-bottom: 1rem;
}

.template-preview p {
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.5;
    font-style: italic;
}

.template-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.template-actions button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-use {
    background: #0e639c;
    color: #ffffff;
}

.btn-use:hover {
    background: #1177bb;
}

.btn-preview {
    background: #3c3c3c;
    color: #cccccc;
    border: 1px solid #3c3c3c;
}

.btn-preview:hover {
    background: #505050;
    color: #ffffff;
}

.btn-edit, .btn-delete {
    background: #3c3c3c;
    color: #cccccc;
    border: 1px solid #3c3c3c;
}

.btn-edit:hover {
    background: #0e639c;
    color: #ffffff;
    border-color: #0e639c;
}

.btn-delete:hover {
    background: #f14c4c;
    color: #ffffff;
    border-color: #f14c4c;
}

.category-badge {
    background: rgba(102, 126, 234, 0.1);
    color: var(--primary-color);
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-md);
    font-size: 0.8rem;
    font-weight: 600;
}

.no-templates {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-muted);
}

.no-templates p {
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

.preview-modal .template-content {
    margin-top: 1.5rem;
}

.preview-modal .template-prompt {
    background: var(--dark-bg);
    padding: 1rem;
    border-radius: var(--radius-md);
    font-family: monospace;
    font-size: 0.9rem;
    line-height: 1.5;
    max-height: 300px;
    overflow-y: auto;
    white-space: pre-wrap;
}

/* Ensure preview modal is visible */
.preview-modal {
    display: flex !important;
    opacity: 1 !important;
    visibility: visible !important;
    z-index: 10001 !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: rgba(0, 0, 0, 0.8) !important;
    backdrop-filter: blur(10px) !important;
    align-items: center !important;
    justify-content: center !important;
}

.preview-modal .modal-content {
    background: var(--surface) !important;
    border: 1px solid var(--border-color) !important;
    box-shadow: var(--shadow-lg) !important;
    max-width: 800px !important;
    max-height: 90vh !important;
    width: 90% !important;
    overflow: hidden !important;
    display: flex !important;
    flex-direction: column !important;
    transform: scale(1) !important;
}

.add-template-modal .form-group {
    margin-bottom: 1.5rem;
}

.add-template-modal label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-weight: 600;
}

.add-template-modal input,
.add-template-modal select,
.add-template-modal textarea {
    width: 100%;
    padding: 0.75rem;
    background: var(--dark-bg);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    transition: all var(--transition-normal);
}

.add-template-modal input:focus,
.add-template-modal select:focus,
.add-template-modal textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.template-categories {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.category-btn {
    padding: 0.5rem 1rem;
    background: #3c3c3c;
    border: 1px solid #3c3c3c;
    border-radius: 4px;
    color: #cccccc;
    cursor: pointer;
    transition: all 0.15s ease;
    font-size: 0.9rem;
}

.category-btn:hover,
.category-btn.active {
    background: #0e639c;
    color: #ffffff;
    border-color: #0e639c;
}

@media (max-width: 640px) {
    .template-actions {
        flex-direction: column;
    }
    
    .template-actions button {
        justify-content: center;
    }
    
    .template-categories {
        flex-direction: column;
    }
}
</style>
`;

// Inject styles
document.head.insertAdjacentHTML('beforeend', templateStyles);
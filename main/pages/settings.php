<?php
// Redesigned Settings Page - Modern UI with Gradients and Cards
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - AI Chat Studio</title>
    <meta name="description" content="Configure your API keys, select preferred AI model, and customize prompt settings.">
    <meta name="keywords" content="AI Chat, Settings, API Key, Configuration">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/app.js"></script>
    <style>
        /* Visual Studio Code Inspired Settings Page */
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

        .settings-page-wrapper {
            padding: 0;
            max-width: none;
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--dark-bg);
            overflow: hidden;
            position: relative;
        }

        .settings-header {
            background: var(--card-bg);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            margin: 0;
        }

        .settings-header h1 {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-weight: 400;
        }

        .settings-header p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Visual Studio Layout */
        .vs-settings-layout {
            display: flex;
            flex: 1;
            height: 100%;
            background: var(--dark-bg);
        }

        /* VS Code Style Sidebar */
        .vs-sidebar {
            width: 200px;
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            max-height: calc(100vh - 150px);
            position: relative;
        }

        .vs-sidebar-tabs {
            display: flex;
            flex-direction: column;
            padding: 0.5rem 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 0;
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

        .voice-tab-highlight {
            position: relative;
            animation: voiceTabPulse 2s infinite;
        }

        .voice-tab-highlight:hover {
            animation: none;
        }

        @keyframes voiceTabPulse {
            0% {
                box-shadow: 0 0 0 0 var(--primary-color);
            }
            70% {
                box-shadow: 0 0 0 10px transparent;
            }
            100% {
                box-shadow: 0 0 0 0 transparent;
            }
        }

        .vs-sidebar-tab-icon {
            font-size: 1rem;
            width: 16px;
            text-align: center;
        }

        /* Sidebar Footer Navigation */
        .vs-sidebar-footer {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            background: var(--card-bg);
            position: relative;
            z-index: 10;
            flex-shrink: 0;
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
            position: relative;
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

        .vs-sidebar-footer-link[title]:hover::after {
            content: attr(title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: var(--card-bg);
            color: var(--text-primary);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 1000;
            border: 1px solid var(--border-color);
            margin-left: 8px;
        }

        /* VS Code Content Panel */
        .vs-content-panel {
            flex: 1;
            background: var(--dark-bg);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-height: 0;
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
            overflow-x: hidden;
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

        .vs-panel-content::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* VS Code Style Sections */
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
            margin-bottom: 2rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Authentic VS Code Style API Key Cards */
        .vs-api-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 8px;
            margin-bottom: 2rem;
        }

        .vs-api-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0;
            padding: 0;
            transition: none;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .vs-api-card-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: var(--surface);
            border-bottom: 1px solid var(--border-color);
            margin: 0;
        }

        .vs-api-icon {
            font-size: 14px;
            width: 16px;
            text-align: center;
            font-weight: bold;
            color: #569cd6;
        }

        .vs-api-card h3 {
            font-size: 13px;
            color: var(--text-primary);
            font-weight: 600;
            margin: 0;
            text-transform: none;
        }

        .vs-api-card p {
            font-size: 11px;
            color: var(--text-secondary);
            margin: 0;
            margin-left: auto;
        }

        .vs-api-card-content {
            padding: 20px;
        }

        .vs-input-group {
            margin: 0 0 16px 0;
        }

        .vs-input-group label {
            display: block;
            font-size: 13px;
            color: #cccccc;
            margin-bottom: 8px;
            font-weight: 500;
            white-space: nowrap;
        }

        .vs-input-group input {
            width: 100%;
            padding: 8px 12px;
            background: var(--background);
            border: 1px solid var(--border-color);
            border-radius: 0;
            color: var(--text-primary);
            font-size: 12px;
            transition: none;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .vs-input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: var(--background);
            box-shadow: 0 0 0 1px var(--primary-color);
        }

        .vs-input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: var(--background);
            box-shadow: 0 0 0 1px var(--primary-color);
        }

        .vs-input-group input::placeholder {
            color: var(--text-muted);
        }

        /* Authentic VS Code Buttons */
        .vs-button-group {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            margin-bottom: 12px;
        }

        .vs-btn {
            padding: 2px 12px;
            background: var(--primary-color);
            border: 1px solid var(--primary-color);
            border-radius: 0;
            color: #ffffff;
            cursor: pointer;
            font-size: 11px;
            font-weight: 400;
            transition: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            text-transform: none;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.2;
            height: 28px;
            white-space: nowrap;
        }

        .vs-btn:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            filter: brightness(1.1);
        }

        .vs-btn:active {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .vs-btn.secondary {
            background: var(--surface);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .vs-btn.secondary:hover {
            background: var(--surface);
            border-color: var(--primary-color);
            filter: brightness(1.1);
        }

        .vs-btn.secondary:active {
            background: var(--background);
            border-color: var(--border-color);
        }

        .vs-btn.danger {
            background: var(--error-color);
            border-color: var(--error-color);
            color: #ffffff;
        }

        .vs-btn.danger:hover {
            background: #b8282c;
            border-color: #b8282c;
            filter: brightness(1.1);
        }

        .vs-btn.danger:active {
            background: #a02626;
            border-color: #a02626;
        }

        .vs-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* VS Code Status Indicators */
        .vs-status {
            padding: 6px 8px;
            border-radius: 0;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--card-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            font-weight: 400;
            margin-top: 8px;
            margin-bottom: 8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .vs-status.empty {
            background: var(--card-bg);
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .vs-status.valid {
            background: #0e4429;
            color: #56d364;
            border-color: #1a7f37;
        }

        .vs-status.error {
            background: #5a1d1d;
            color: #ffa198;
            border-color: #9e2928;
        }

        .vs-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 8px;
            padding: 6px 12px;
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 0;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 11px;
            font-weight: 400;
            transition: none;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .vs-link:hover {
            background: var(--background);
            border-color: var(--primary-color);
            color: var(--secondary-color);
        }



        /* VS Code Model Selection */
        .vs-model-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .vs-model-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 1.5rem;
            cursor: pointer;
            text-align: center;
            transition: all 0.15s ease;
        }

        .vs-model-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 1px var(--shadow-glow);
        }

        .vs-model-card.selected {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .vs-model-card h4 {
            font-size: 1rem;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        .vs-model-card.selected h4 {
            color: white;
        }

        .vs-model-card p {
            font-size: 0.8rem;
            color: var(--text-secondary);
            line-height: 1.4;
            margin: 0;
        }

        .vs-model-card.selected p {
            color: rgba(255, 255, 255, 0.8);
        }

        .vs-model-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        /* VS Code Form Elements */
        .vs-form-group {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .vs-form-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .vs-form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .vs-form-group input,
        .vs-form-group select,
        .vs-form-group textarea {
            width: 100%;
            padding: 0.75rem;
            background: var(--dark-bg);
            border: 1px solid var(--border-color);
            border-radius: 2px;
            color: var(--text-primary);
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.15s ease;
            margin-bottom: 0.5rem;
        }

        .vs-form-group input:focus,
        .vs-form-group select:focus,
        .vs-form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 1px var(--shadow-glow);
            background: var(--dark-bg);
        }

        .vs-form-group textarea {
            resize: vertical;
            min-height: 120px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            line-height: 1.4;
        }

        /* Enhanced VS Code Style Radio Buttons and Checkboxes */
        .vs-radio-option,
        .vs-checkbox-option {
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.15s ease;
            position: relative;
            border: 1px solid transparent;
            border-radius: 4px;
            margin-bottom: 8px;
            background: rgba(255, 255, 255, 0.02);
        }

        .vs-radio-option:hover,
        .vs-checkbox-option:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .vs-radio-option:active,
        .vs-checkbox-option:active {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .option-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .option-input {
            margin: 0;
            align-self: flex-start;
        }

        .option-title {
            flex: 1;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
            line-height: 1.2;
        }

        .option-content {
            margin-left: 20px;
            color: var(--text-secondary);
            font-size: 0.8rem;
            line-height: 1.4;
        }

        .option-input[type="radio"],
        .option-input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 12px;
            height: 12px;
            border: 1px solid var(--border-color);
            background: var(--dark-bg);
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            margin: 0;
            transition: all 0.15s ease;
        }

        .option-input[type="radio"] {
            border-radius: 50%;
        }

        .option-input[type="checkbox"] {
            border-radius: 3px;
        }

        .option-input[type="radio"]:checked,
        .option-input[type="checkbox"]:checked {
            border-color: var(--primary-color);
            background: var(--primary-color);
        }

        .option-input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: white;
        }

        .option-input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 10px;
            font-weight: bold;
        }

        .option-input[type="radio"]:focus,
        .option-input[type="checkbox"]:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 122, 204, 0.3);
        }

        /* Toggle Switch Styles for Better UX */
        .vs-toggle-option {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 0;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .vs-toggle-option:hover {
            background: rgba(0, 122, 204, 0.05);
            border-radius: 4px;
            padding-left: 8px;
            padding-right: 8px;
            margin: 0 -8px;
        }

        .vs-toggle-option input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 44px;
            height: 24px;
            border: 2px solid var(--border-color);
            background: var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .vs-toggle-option input[type="checkbox"]::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background: var(--text-muted);
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .vs-toggle-option input[type="checkbox"]:checked {
            border-color: var(--primary-color);
            background: var(--primary-color);
        }

        .vs-toggle-option input[type="checkbox"]:checked::after {
            transform: translateX(20px);
            background: white;
        }

        .vs-toggle-option input[type="checkbox"]:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 122, 204, 0.3);
        }

        .vs-toggle-content {
            flex: 1;
        }

        .vs-toggle-content strong {
            color: var(--text-primary);
            font-size: 0.9rem;
            font-weight: 500;
            display: block;
            margin-bottom: 4px;
        }

        .vs-toggle-content small {
            color: var(--text-secondary);
            font-size: 0.8rem;
            line-height: 1.4;
        }

        /* Enhanced Voice Section - VS Code Style */
        .voice-toggle-option {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 12px;
            transition: all 0.15s ease;
            position: relative;
        }

        .voice-toggle-option:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .voice-toggle-option:active {
            transform: translateY(0);
        }

        .voice-section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .voice-section-icon {
            font-size: 20px;
            color: var(--primary-color);
        }

        .voice-section-title {
            font-size: 18px;
            font-weight: 400;
            color: var(--text-primary);
        }

        /* Enhanced VS Code Select Styling */
        .vs-enhanced-select {
            width: 100%;
            padding: 12px;
            background: var(--dark-bg);
            border: 2px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        .vs-enhanced-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 122, 204, 0.3);
            background-color: var(--dark-bg);
        }

        .vs-enhanced-select:hover {
            border-color: var(--text-muted);
        }

        /* Enhanced Input Styling */
        .vs-enhanced-input {
            width: 100%;
            padding: 12px;
            background: var(--dark-bg);
            border: 2px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .vs-enhanced-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 122, 204, 0.3);
        }

        .vs-enhanced-input:hover {
            border-color: var(--text-muted);
        }

        /* Enhanced Button Grid */
        .vs-enhanced-button-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .vs-enhanced-btn {
            padding: 12px 16px;
            border: 2px solid;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
        }

        .vs-enhanced-btn.secondary {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .vs-enhanced-btn.secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            transform: translateY(-1px);
        }

        .vs-enhanced-btn.secondary:active {
            transform: translateY(0);
        }

        /* Theme Header Section */
        .theme-header-section {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .theme-icon-section {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            border-radius: 8px;
            font-size: 24px;
        }

        .theme-info-section h3 {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-primary);
            margin: 0 0 4px 0;
        }

        .theme-info-section p {
            margin: 0;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        /* Voice Settings Groups */
        .voice-settings-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Audio Controls Group */
        .audio-controls-group {
            display: flex;
            flex-direction: column;
            gap: 24px;
            background: rgba(255, 255, 255, 0.02);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .vs-range-control {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .vs-range-control label {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        /* Voice Settings Link Styling */
        .voice-settings-link {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .vs-settings-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.15s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .vs-settings-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .settings-icon {
            font-size: 1rem;
            color: var(--primary-color);
        }



        /* Accessibility Controls Styling */
        .accessibility-controls {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .accessibility-option {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 16px;
            transition: all 0.15s ease;
        }

        .accessibility-option:hover {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 1px rgba(0, 122, 204, 0.2);
        }

        /* Hamburger menu base styles - hidden by default on desktop */
        .hamburger-menu {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            flex-direction: column;
            gap: 3px;
            margin-right: 12px;
            margin-left: 0;
            border-radius: 3px;
            transition: background-color 0.15s ease;
        }
        
        .hamburger-menu span {
            width: 16px;
            height: 2px;
            background: var(--text-primary, #cccccc);
            border-radius: 1px;
            transition: all 0.3s ease;
        }
        
        .hamburger-menu:hover {
            background-color: var(--primary-color, #007acc);
        }

        /* Fix mobile hamburger menu styles */
        @media (max-width: 768px) {
            .hamburger-menu {
                display: flex !important;
                position: relative;
                z-index: 1001;
                margin-right: 12px;
                margin-left: 0;
            }
            
            .vs-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 100%;
                max-width: 100vw;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
                box-shadow: none;
            }
            
            .vs-sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .vs-sidebar-overlay {
                display: none;
            }
            
            .hamburger-menu.clicked span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }
            
            .hamburger-menu.clicked span:nth-child(2) {
                opacity: 0;
            }
            
            .hamburger-menu.clicked span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }
        }

        .vs-description {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
            line-height: 1.5;
        }

        .vs-range-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        .vs-range-value {
            background: var(--surface);
            padding: 0.25rem 0.5rem;
            border-radius: 2px;
            font-size: 0.8rem;
            color: var(--text-primary);
            min-width: 40px;
            text-align: center;
        }

        .vs-range-group input[type="range"] {
            flex: 1;
            margin: 0;
        }

        .vs-range-group input[type="range"]::-webkit-slider-thumb {
            background: var(--primary-color);
            width: 16px;
            height: 16px;
            border-radius: 50%;
        }

        .vs-range-group input[type="range"]::-webkit-slider-track {
            background: var(--border-color);
            height: 4px;
        }

        /* VS Code Action Buttons */
        .vs-action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .vs-action-btn {
            padding: 0.75rem 1.5rem;
            border: 1px solid;
            border-radius: 2px;
            font-size: 0.9rem;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.15s ease;
            flex: 0 0 auto;
            min-width: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .vs-action-btn.primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
        }

        .vs-action-btn.primary:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .vs-action-btn.secondary {
            background: var(--surface);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .vs-action-btn.secondary:hover {
            background: var(--text-muted);
            border-color: var(--text-muted);
        }

        .vs-action-btn:active {
            transform: translateY(1px);
        }

        .btn-icon {
            font-size: 1rem;
            margin-right: 0.25rem;
        }

        /* Enhanced button styles for better visibility */
        #saveVoiceBtn {
            box-shadow: 0 2px 4px rgba(0, 122, 204, 0.2);
            font-weight: 600;
            text-transform: none;
            min-width: 160px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: 2px solid var(--primary-color);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        #saveVoiceBtn:hover {
            box-shadow: 0 4px 12px rgba(0, 122, 204, 0.4);
            transform: translateY(-2px);
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        }

        #saveVoiceBtn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        #saveVoiceBtn:hover:before {
            left: 100%;
        }

        /* Special highlighting for voice section action buttons */
        #voice-section .vs-action-buttons {
            background: rgba(0, 122, 204, 0.05);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--primary-color);
            margin-top: 2rem;
        }

        /* VS Code Success Message */
        .vs-success-message {
            padding: 0.75rem 1rem;
            background: #0e4429;
            border: 1px solid #1a7f37;
            border-radius: 2px;
            color: #56d364;
            margin-bottom: 1rem;
            display: none;
            animation: vsSlideDown 0.2s ease;
            font-weight: 400;
            font-size: 0.9rem;
        }

        .vs-success-message.show {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @keyframes vsSlideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* VS Code Responsive Design */
        @media (max-width: 1024px) {
            .vs-sidebar {
                width: 160px;
            }
            
            .vs-api-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .vs-settings-layout {
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
                text-align: center;
            }
            
            .vs-sidebar-tab.active {
                border-left: none;
                border-bottom-color: #007acc;
            }
            
            .vs-panel-content {
                padding: 1rem;
            }
            
            .vs-api-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .vs-model-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }
            
            .vs-action-buttons {
                flex-direction: column;
            }
            
            .vs-action-btn {
                width: 100%;
            }

            .hide-on-mobile {
                display: none;
            }
            
            /* Enhanced mobile hamburger menu styles */
            .hamburger-menu {
                display: flex !important;
                position: relative;
                z-index: 1001;
                border-radius: 4px;
                margin-right: 12px;
                margin-left: 0;
            }
            
            .hamburger-menu:hover {
                background: var(--primary-color);
            }
            
            .hamburger-menu.clicked span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }
            
            .hamburger-menu.clicked span:nth-child(2) {
                opacity: 0;
            }
            
            .hamburger-menu.clicked span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }
        }

        @media (max-width: 480px) {
            .vs-header {
                padding: 1rem;
            }
            
            .vs-header h1 {
                font-size: 1.2rem;
            }
            
            .vs-model-grid {
                grid-template-columns: 1fr;
            }
            
            .vs-panel-content {
                padding: 0.75rem;
            }
            
            .vs-action-buttons {
                gap: 0.5rem;
            }
            
            .vs-action-btn {
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
            }
        }

        /* Additional improvements for better touch targets on mobile */
        @media (max-width: 640px) {
            .vs-radio-option,
            .vs-checkbox-option,
            .vs-toggle-option {
                padding: 16px 0;
                min-height: 44px; /* Better touch target size */
            }
            
            .vs-radio-option:hover,
            .vs-checkbox-option:hover,
            .vs-toggle-option:hover {
                padding-left: 12px;
                padding-right: 12px;
                margin: 0 -12px;
            }
            
            .accessibility-option {
                padding: 20px;
                margin-bottom: 16px;
            }
            
            .voice-toggle-option {
                padding: 20px;
                margin-bottom: 16px;
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
                <button class="hamburger-menu" id="hamburgerBtn" title="Toggle sidebar menu" aria-label="Open sidebar menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </nav>

    <!-- VS Code Settings Layout -->
        <div class="settings-page-wrapper">
        <!-- Mobile Sidebar Overlay -->
        <div class="vs-sidebar-overlay" id="vsSidebarOverlay"></div>
        
        <!-- VS Code Header -->
        <div class="settings-header">
            <h1>Settings</h1>
            <p>Configure your AI models, API keys, and chat preferences</p>

        </div>

        <!-- VS Code Layout -->
        <div class="vs-settings-layout">
            <!-- VS Code Sidebar -->
            <div class="vs-sidebar">
                <div class="vs-sidebar-tabs">
                    <button class="vs-sidebar-tab active" data-tab="api-keys">
                        <span class="vs-sidebar-tab-icon">K</span>
                        <span>API Keys</span>
                    </button>
                    <button class="vs-sidebar-tab" data-tab="model">
                        <span class="vs-sidebar-tab-icon">M</span>
                        <span>Models</span>
                    </button>
                    <button class="vs-sidebar-tab" data-tab="prompts">
                        <span class="vs-sidebar-tab-icon">P</span>
                        <span>Prompts</span>
                    </button>
                    <button class="vs-sidebar-tab" data-tab="voice">
                        <span class="vs-sidebar-tab-icon">V</span>
                        <span>Voice</span>
                    </button>
                    <button class="vs-sidebar-tab" data-tab="colors">
                        <span class="vs-sidebar-tab-icon">C</span>
                        <span>Colors</span>
                    </button>
                </div>
                
                <!-- Sidebar Footer Navigation -->
                <div class="vs-sidebar-footer">
                    <div class="vs-sidebar-footer-nav">
                        <a href="../index.php" class="vs-sidebar-footer-link" title="Chat">C</a>
                        <a href="about.php" class="vs-sidebar-footer-link" title="About">A</a>
                        <a href="faqs.php" class="vs-sidebar-footer-link" title="FAQs">Q</a>
                        <a href="settings.php" class="vs-sidebar-footer-link active" title="Settings">S</a>
                        <a href="terms.php" class="vs-sidebar-footer-link" title="Terms">T</a>
                        <a href="privacy.php" class="vs-sidebar-footer-link" title="Privacy">P</a>
                    </div>
                </div>
            </div>

            <!-- VS Code Content Panel -->
            <div class="vs-content-panel">
                <div class="vs-panel-header">
                    <div class="vs-panel-title" id="panel-title">
                        <span id="panel-icon">K</span>
                        <span id="panel-text">API Key Management</span>
                    </div>
                </div>

                <div class="vs-panel-content">
                    <div class="vs-success-message" id="successMessage">
                        Settings saved successfully!
                    </div>

                    <!-- API Keys Section -->
                    <div class="vs-section active" id="api-keys-section">
                        <h2 class="vs-section-title">
                            <span>Manage API Key's</span>
                        </h2>
                        
                        <div class="vs-api-grid">
                            <!-- Gemini Card -->
                            <div class="vs-api-card">
                                <div class="vs-api-card-header">
                                    <div class="vs-api-icon">G</div>
                                    <h3>Google Gemini</h3>
                                    <p>2.5 Flash Model</p>
                                </div>
                                <div class="vs-api-card-content">
                                    <div class="vs-input-group">
                                       
                                        <input type="password" id="gemini-key" placeholder="Paste your Gemini API key here" class="vs-enhanced-input">
                                    </div>
                                    <div class="vs-button-group">
                                        <button class="vs-btn secondary" onclick="app.toggleKeyVisibility('gemini-key')" title="Show/hide">Show/Hide</button>
                                        <button class="vs-btn" onclick="app.testApiKey('gemini')" title="Test API Key">Test</button>
                                        <button class="vs-btn danger" onclick="app.clearApiKey('gemini')" title="Delete" id="gemini-delete-btn" style="display: none;">Delete</button>
                                    </div>
                                    <div class="vs-status empty" id="gemini-status">Not configured</div>
                                    <a href="https://aistudio.google.com" target="_blank" class="vs-link">Get API Key →</a>
                                </div>
                            </div>

                            <!-- Claude Card -->
                            <div class="vs-api-card">
                                <div class="vs-api-card-header">
                                    <div class="vs-api-icon">C</div>
                                    <h3>Anthropic Claude</h3>
                                    <p>Advanced Reasoning</p>
                                </div>
                                <div class="vs-api-card-content">
                                    <div class="vs-input-group">
                                       
                                        <input type="password" id="claude-key" placeholder="Paste your Claude API key here" class="vs-enhanced-input">
                                    </div>
                                    <div class="vs-button-group">
                                        <button class="vs-btn secondary" onclick="app.toggleKeyVisibility('claude-key')" title="Show/hide">Show/Hide</button>
                                        <button class="vs-btn" onclick="app.testApiKey('claude')" title="Test API Key">Test</button>
                                        <button class="vs-btn danger" onclick="app.clearApiKey('claude')" title="Delete" id="claude-delete-btn" style="display: none;">Delete</button>
                                    </div>
                                    <div class="vs-status empty" id="claude-status">Not configured</div>
                                    <a href="https://console.anthropic.com/" target="_blank" class="vs-link">Get API Key →</a>
                                </div>
                            </div>

                            <!-- GPT Card -->
                            <div class="vs-api-card">
                                <div class="vs-api-card-header">
                                    <div class="vs-api-icon">O</div>
                                    <h3>OpenAI GPT</h3>
                                    <p>GPT-4 Turbo</p>
                                </div>
                                <div class="vs-api-card-content">
                                    <div class="vs-input-group">
                                       
                                        <input type="password" id="gpt-key" placeholder="Paste your GPT API key here" class="vs-enhanced-input">
                                    </div>
                                    <div class="vs-button-group">
                                        <button class="vs-btn secondary" onclick="app.toggleKeyVisibility('gpt-key')" title="Show/hide">Show/Hide</button>
                                        <button class="vs-btn" onclick="app.testApiKey('gpt')" title="Test API Key">Test</button>
                                        <button class="vs-btn danger" onclick="app.clearApiKey('gpt')" title="Delete" id="gpt-delete-btn" style="display: none;">Delete</button>
                                    </div>
                                    <div class="vs-status empty" id="gpt-status">Not configured</div>
                                    <a href="https://platform.openai.com/account/api-keys" target="_blank" class="vs-link">Get API Key →</a>
                                </div>
                            </div>

                            <!-- DeepSeek Card -->
                            <div class="vs-api-card">
                                <div class="vs-api-card-header">
                                    <div class="vs-api-icon">D</div>
                                    <h3>DeepSeek</h3>
                                    <p>Fast & Cost-Effective</p>
                                </div>
                                <div class="vs-api-card-content">
                                    <div class="vs-input-group">
                                       
                                        <input type="password" id="deepseek-key" placeholder="Paste your DeepSeek API key here" class="vs-enhanced-input">
                                    </div>
                                    <div class="vs-button-group">
                                        <button class="vs-btn secondary" onclick="app.toggleKeyVisibility('deepseek-key')" title="Show/hide">Show/Hide</button>
                                        <button class="vs-btn" onclick="app.testApiKey('deepseek')" title="Test API Key">Test</button>
                                        <button class="vs-btn danger" onclick="app.clearApiKey('deepseek')" title="Delete" id="deepseek-delete-btn" style="display: none;">Delete</button>
                                    </div>
                                    <div class="vs-status empty" id="deepseek-status">Not configured</div>
                                    <a href="https://platform.deepseek.com/" target="_blank" class="vs-link">Get API Key →</a>
                                </div>
                            </div>
                        </div>

                        <div class="vs-action-buttons">
                            <button class="vs-action-btn primary" onclick="app.saveAllApiKeys()">Save All API Keys</button>
                            <button class="vs-action-btn secondary" onclick="app.loadAllApiKeys()">Reset</button>
                        </div>
                    </div>

                    <!-- Model Selection Section -->
                    <div class="vs-section" id="model-section">
                        <h2 class="vs-section-title">
                            <span>Select Default Model</span>
                        </h2>
                        <p class="vs-description" style="margin-bottom: 1.5rem;">Choose which AI model will be used for new conversations</p>
                        
                        <div class="vs-model-grid">
                            <div class="vs-model-card" data-model="gemini" onclick="app.selectModel('gemini')">
                                <div class="vs-model-icon">G</div>
                                <h4>Gemini 2.5 Flash</h4>
                                <p>Fast, accurate responses <span class="hide-on-mobile">• Speed: Fast • Cost: Low</span></p>
                            </div>
                            <div class="vs-model-card" data-model="claude" onclick="app.selectModel('claude')">
                                <div class="vs-model-icon">C</div>
                                <h4>Claude</h4>
                                <p>Advanced reasoning</p>
                            </div>
                            <div class="vs-model-card" data-model="gpt" onclick="app.selectModel('gpt')">
                                <div class="vs-model-icon">O</div>
                                <h4>GPT-4 Turbo</h4>
                                <p>General-purpose AI</p>
                            </div>
                            <div class="vs-model-card" data-model="deepseek" onclick="app.selectModel('deepseek')">
                                <div class="vs-model-icon">D</div>
                                <h4>DeepSeek</h4>
                                <p>Fast & cost-effective</p>
                            </div>
                        </div>

                        <div class="vs-action-buttons">
                            <button class="vs-action-btn primary" onclick="app.saveModelSelection()">Save Model Selection</button>
                        </div>
                    </div>

                    <!-- Prompts Section -->
                    <div class="vs-section" id="prompts-section">
                        <h2 class="vs-section-title">
                            <span>Prompt & Behavior Settings</span>
                        </h2>
                        
                        <div class="vs-form-group">
                            <label for="system-prompt">System Prompt (Optional)</label>
                            <textarea id="system-prompt" placeholder="Example: 'You are a helpful coding assistant. Always provide code examples with explanations.'" title="Custom instructions for the AI model"></textarea>
                            <p class="vs-description">This prompt is sent with every message to guide the AI's behavior. Leave empty for default behavior.</p>
                        </div>

                        <div class="vs-form-group">
                            <label for="temperature">Temperature: <span id="tempValue">0.7</span></label>
                            <div class="vs-range-group">
                                <input type="range" id="temperature" min="0" max="2" step="0.1" value="0.7" title="Control response creativity">
                                <span class="vs-range-value" id="tempValue">0.7</span>
                            </div>
                            <p class="vs-description">
                                <strong>0.0-0.5:</strong> Focused | 
                                <strong>0.7:</strong> Balanced | 
                                <strong>1.5-2.0:</strong> Creative
                            </p>
                        </div>

                        <div class="vs-form-group">
                            <label for="max-tokens">Max Tokens: <span id="tokenValue">1000</span></label>
                            <div class="vs-range-group">
                                <input type="range" id="max-tokens" min="100" max="4000" step="100" value="1000" title="Maximum response length">
                                <span class="vs-range-value" id="tokenValue">1000</span>
                            </div>
                            <p class="vs-description">Controls the maximum length of AI responses (1000-2000 recommended)</p>
                        </div>

                        <div class="vs-action-buttons">
                            <button class="vs-action-btn primary" onclick="app.savePromptSettings()">Save Settings</button>
                            <button class="vs-action-btn secondary" onclick="app.resetPromptSettings()">Reset to Defaults</button>
                        </div>
                    </div>

                    <!-- Enhanced Voice Settings Section - VS Code Style -->
                    <div class="vs-section" id="voice-section">
                        <h2 class="vs-section-title">
                            <span>Customize Voice & Audio</span>
                        </h2>
                        
                        <!-- Speech Recognition Section -->
                        <div class="vs-form-group">
                            <label>Speech Recognition</label>
                            
                            <div class="vs-checkbox-option">
                                <div class="option-header">
                                    <input type="checkbox" id="voice-input-enabled" class="option-input">
                                    <div class="option-title">Enable Speech Recognition</div>
                                </div>
                                <div class="option-content">Allow voice input for typing messages using your microphone</div>
                            </div>

                            <div class="vs-checkbox-option">
                                <div class="option-header">
                                    <input type="checkbox" id="continuous-mode" class="option-input">
                                    <div class="option-title">Continuous Listening Mode</div>
                                </div>
                                <div class="option-content">Keep microphone active for ongoing conversation</div>
                            </div>

                            <div class="vs-checkbox-option">
                                <div class="option-header">
                                    <input type="checkbox" id="voice-commands-enabled" class="option-input">
                                    <div class="option-title">Voice Command Controls</div>
                                </div>
                                <div class="option-content">Enable voice commands like "stop" and "clear"</div>
                            </div>

                            <div class="voice-input-field">
                                <label for="wake-word">Activation Phrase</label>
                                <input type="text" id="wake-word" placeholder="e.g., hey chat" class="vs-enhanced-input">
                                <p class="vs-description">Word or phrase to activate voice recognition</p>
                            </div>

                            <!-- Settings Icon Link -->
                            <div class="voice-settings-link">
                                <a href="#" class="vs-settings-link" title="Voice Settings" onclick="document.querySelector('.audio-control-group').scrollIntoView({behavior: 'smooth'}); return false;">
                                    <span class="settings-icon">⚙</span>
                                    <span>Advanced Voice Settings</span>
                                </a>
                            </div>
                        </div>

                        <!-- Text-to-Speech Section -->
                        <div class="vs-form-group">
                            <label>Text-to-Speech Output</label>
                            
                            <div class="vs-checkbox-option">
                                <div class="option-header">
                                    <input type="checkbox" id="tts-enabled" class="option-input">
                                    <div class="option-title">Enable TTS System</div>
                                </div>
                                <div class="option-content">Allow AI responses to be read aloud automatically</div>
                            </div>

                            <div class="vs-checkbox-option">
                                <div class="option-header">
                                    <input type="checkbox" id="auto-speak" class="option-input">
                                    <div class="option-title">Auto-Read Responses</div>
                                </div>
                                <div class="option-content">Automatically read AI responses as they appear</div>
                            </div>

                            <div class="voice-select-group">
                                <label for="tts-voice">Voice Selection</label>
                                <select id="tts-voice" class="vs-enhanced-select">
                                    <option value="">System Default Voice</option>
                                    <!-- Voice options will be populated by JavaScript -->
                                </select>
                            </div>

                            <div class="voice-select-group">
                                <label for="speech-language">Recognition Language</label>
                                <select id="speech-language" class="vs-enhanced-select">
                                    <option value="en-US">English (US)</option>
                                    <option value="en-GB">English (UK)</option>
                                    <option value="es-ES">Spanish</option>
                                    <option value="fr-FR">French</option>
                                    <option value="de-DE">German</option>
                                    <option value="it-IT">Italian</option>
                                    <option value="pt-BR">Portuguese (Brazil)</option>
                                    <option value="zh-CN">Chinese (Simplified)</option>
                                    <option value="ja-JP">Japanese</option>
                                    <option value="ko-KR">Korean</option>
                                </select>
                            </div>
                        </div>

                        <!-- Audio Configuration -->
                        <div class="vs-form-group">
                            <label>Audio Configuration</label>
                            
                            <div class="audio-control-group">
                                <label for="tts-rate">Speech Speed: <span id="ttsRateValue">1.0</span></label>
                                <div class="vs-range-group">
                                    <input type="range" id="tts-rate" min="0.5" max="2.0" step="0.1" value="1.0">
                                    <span class="vs-range-value" id="ttsRateValue">1.0</span>
                                </div>
                                <p class="vs-description">
                                    <strong>0.5:</strong> Slow | 
                                    <strong>1.0:</strong> Normal | 
                                    <strong>2.0:</strong> Fast
                                </p>
                            </div>

                            <div class="audio-control-group">
                                <label for="tts-volume">Volume Level: <span id="ttsVolumeValue">1.0</span></label>
                                <div class="vs-range-group">
                                    <input type="range" id="tts-volume" min="0" max="1" step="0.1" value="1.0">
                                    <span class="vs-range-value" id="ttsVolumeValue">1.0</span>
                                </div>
                            </div>

                            <div class="audio-control-group">
                                <label for="tts-pitch">Voice Pitch: <span id="ttsPitchValue">1.0</span></label>
                                <div class="vs-range-group">
                                    <input type="range" id="tts-pitch" min="0.5" max="2.0" step="0.1" value="1.0">
                                    <span class="vs-range-value" id="ttsPitchValue">1.0</span>
                                </div>
                                <p class="vs-description">
                                    <strong>0.5:</strong> Low | 
                                    <strong>1.0:</strong> Normal | 
                                    <strong>2.0:</strong> High
                                </p>
                            </div>
                        </div>

                        <!-- Testing & Actions -->
                        <div class="vs-form-group">
                            <label>Testing & Actions</label>
                            
                            <div class="vs-enhanced-button-grid">
                                <button class="vs-enhanced-btn secondary" onclick="settingsAPI.testVoice()">
                                    <span class="btn-icon">▶</span>
                                    Test Voice Output
                                </button>
                                <button class="vs-enhanced-btn secondary" onclick="settingsAPI.stopVoice()">
                                    <span class="btn-icon">■</span>
                                    Stop Audio
                                </button>
                            </div>

                            <div class="vs-action-buttons">
                                <button class="vs-action-btn primary" onclick="settingsAPI.saveVoiceSettings()" id="saveVoiceBtn">
                                    Save Voice Settings
                                </button>
                                <button class="vs-action-btn secondary" onclick="settingsAPI.resetVoiceSettings()">
                                    Reset to Defaults
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Colors Section - VS Code Style -->
                    <div class="vs-section" id="colors-section">
                        <h2 class="vs-section-title">
                            <span>Customize Theme & Colors</span>
                        </h2>
                        
                        <!-- VS Code Style Theme Selection -->
                        <div class="vs-form-group">
                            <div class="theme-header-section">
                                <div class="theme-icon-section">
                                    <span class="theme-icon">C</span>
                                </div>
                                <div class="theme-info-section">
                                    <h3>Color Theme</h3>
                                    <p class="vs-description">Choose from various color themes to customize your interface appearance</p>
                                </div>
                            </div>
                        </div>

                        <div class="vs-form-group">
                            <label for="theme-selector">Select Theme</label>
                            <select id="theme-selector" class="vs-enhanced-select">
                                <option value="dark">Dark Theme</option>
                                <option value="light">Light Theme</option>
                                <option value="midnight">Midnight Blue</option>
                                <option value="forest">Forest Green</option>
                                <option value="sunset">Sunset Orange</option>
                                <option value="purple">Purple Dream</option>
                                <option value="ocean">Ocean Blue</option>
                                <option value="rose">Rose Pink</option>
                                <option value="matrix">Matrix Green</option>
                            </select>
                            <p class="vs-description">Preview different color schemes for the interface</p>
                        </div>

                        <div class="vs-form-group">
                            <label>Quick Actions</label>
                            <div class="vs-enhanced-button-grid">
                                <button class="vs-enhanced-btn secondary" onclick="settingsAPI.toggleTheme()">
                                    <span class="btn-icon">↔</span>
                                    Toggle Dark/Light
                                </button>
                                <button class="vs-enhanced-btn secondary" onclick="settingsAPI.openThemeCustomizer()">
                                    <span class="btn-icon">⚙</span>
                                    Customize Theme
                                </button>
                            </div>
                        </div>

                        <div class="vs-form-group">
                            <label>Accessibility Options</label>
                            <div class="accessibility-controls">
                                <div class="accessibility-option">
                                    <div class="option-header">
                                        <input type="checkbox" id="high-contrast" class="option-input">
                                        <div class="option-title">High Contrast</div>
                                    </div>
                                    <div class="option-content">Enhances color contrast for better readability</div>
                                </div>

                                <div class="accessibility-option">
                                    <div class="option-header">
                                        <input type="checkbox" id="color-blind-friendly" class="option-input">
                                        <div class="option-title">Color Blind Friendly</div>
                                    </div>
                                    <div class="option-content">Uses colors that work for all types of color blindness</div>
                                </div>

                                <div class="accessibility-option">
                                    <div class="option-header">
                                        <input type="checkbox" id="reduce-motion" class="option-input">
                                        <div class="option-title">Reduce Motion</div>
                                    </div>
                                    <div class="option-content">Minimizes animations and transitions</div>
                                </div>

                                <div class="accessibility-option">
                                    <div class="option-header">
                                        <input type="checkbox" id="animations-enabled" checked class="option-input">
                                        <div class="option-title">Enable Animations</div>
                                    </div>
                                    <div class="option-content">Turn on smooth transitions and micro-interactions</div>
                                </div>
                            </div>
                        </div>

                        <div class="vs-action-buttons">
                            <button class="vs-action-btn primary" onclick="settingsAPI.saveColorSettings()">
                                Save Color Settings
                            </button>
                            <button class="vs-action-btn secondary" onclick="settingsAPI.resetColorSettings()">
                                Reset to Defaults
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div> <!-- End of settings-page-wrapper -->
    </div> <!-- End of main-content -->


    <script>
        // Settings page functionality (standalone, doesn't require app.js app class)
        
        // Create toast notification system for settings page
        const createToast = (message, type = 'info') => {
            const container = document.getElementById('toastContainer') || createToastContainer();
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.style.cssText = 'padding: 12px 16px; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 6px; color: var(--text-primary); margin-bottom: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); animation: slideIn 0.3s ease;';
            const icons = { 'success': '✓', 'error': '✕', 'warning': '⚠', 'info': 'ℹ' };
            toast.innerHTML = `<span style="margin-right: 8px;">${icons[type] || '•'}</span><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
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



        // Enhanced API key validation function
        const validateApiKey = (key, model) => {
            if (!key || typeof key !== 'string') return false;
            
            key = key.trim();
            
            // Enhanced model-specific validation patterns (more flexible)
            const patterns = {
                // Gemini: More flexible pattern to handle different key lengths
                gemini: /^AIza[0-9A-Za-z\-_]{20,}$/,
                // Claude: More flexible pattern
                claude: /^sk-ant-[a-zA-Z0-9\-]{50,}$/,
                // GPT: More flexible pattern
                gpt: /^sk-[a-zA-Z0-9]{20,}$/,
                // DeepSeek: More flexible pattern
                deepseek: /^sk-[a-zA-Z0-9]{20,}$/
            };
            
            if (patterns[model]) {
                return patterns[model].test(key);
            }
            
            return key.length >= 20 && /^[a-zA-Z0-9\-_]+$/.test(key);
        };

        // Test API key function
        const testApiKey = async (model) => {
            const input = document.getElementById(`${model}-key`);
            if (!input || !input.value.trim()) {
                createToast(`No ${model} API key entered`, 'warning');
                return false;
            }

            const key = input.value.trim();
            if (!validateApiKey(key, model)) {
                createToast(`Invalid ${model} API key format`, 'error');
                return false;
            }

            try {
                createToast(`Testing ${model} API key...`, 'info');
                
                const testData = {
                    model: model,
                    message: 'Hello',
                    api_key: key,
                    history: [],
                    temperature: 0.1,
                    max_tokens: 10
                };
                
                const response = await fetch('../api/chat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(testData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    createToast(`${model} API key is valid!`, 'success');
                    return true;
                } else {
                    createToast(`${model} API key test failed: ${data.error}`, 'error');
                    return false;
                }
            } catch (error) {
                createToast(`API key test failed: ${error.message}`, 'error');
                return false;
            }
        };

        // Settings page API functions
        const settingsAPI = {
            // Color/Theme functions
            toggleTheme() {
                if (window.themeManager) {
                    window.themeManager.toggleTheme();
                    this.loadColorSettings();
                } else {
                    createToast('Theme manager not available', 'error');
                }
            },

            openThemeCustomizer() {
                if (window.themeManager && typeof window.themeManager.openThemeCustomizer === 'function') {
                    try {
                        window.themeManager.openThemeCustomizer();
                    } catch (error) {
                        createToast('Error opening theme customizer: ' + error.message, 'error');
                    }
                } else {
                    // Try to wait a bit and check again, or initialize manually
                    setTimeout(() => {
                        if (window.themeManager && typeof window.themeManager.openThemeCustomizer === 'function') {
                            try {
                                window.themeManager.openThemeCustomizer();
                            } catch (error) {
                                createToast('Error opening theme customizer: ' + error.message, 'error');
                            }
                        } else {
                            // Fallback: show a simplified theme selector
                            this.showFallbackThemeSelector();
                        }
                    }, 100);
                }
            },

            showFallbackThemeSelector() {
                const theme = prompt('Enter theme name:\nAvailable themes: dark, light, midnight, forest, sunset, purple, ocean, rose, matrix');
                
                if (theme && ['dark', 'light', 'midnight', 'forest', 'sunset', 'purple', 'ocean', 'rose', 'matrix'].includes(theme.toLowerCase())) {
                    this.applyTheme(theme.toLowerCase());
                    createToast(`Applied ${theme} theme`, 'success');
                } else if (theme) {
                    createToast('Invalid theme name', 'warning');
                }
            },

            applyTheme(themeName) {
                // Apply theme by updating CSS custom properties directly
                const themes = {
                    dark: {
                        '--primary-color': '#007acc',
                        '--secondary-color': '#569cd6', 
                        '--background': '#1e1e1e',
                        '--card-bg': '#252526',
                        '--text-primary': '#cccccc',
                        '--text-secondary': '#9d9d9d',
                        '--text-muted': '#6c6c6c',
                        '--border-color': '#3e3e42'
                    },
                    light: {
                        '--primary-color': '#3b82f6',
                        '--secondary-color': '#6366f1',
                        '--background': '#ffffff', 
                        '--card-bg': '#ffffff',
                        '--text-primary': '#1f2937',
                        '--text-secondary': '#4b5563',
                        '--text-muted': '#6b7280',
                        '--border-color': '#f8f8f8'
                    },
                    midnight: {
                        '--primary-color': '#4c51bf',
                        '--secondary-color': '#553c9a',
                        '--background': '#1a202c',
                        '--card-bg': '#2d3748', 
                        '--text-primary': '#f7fafc',
                        '--text-secondary': '#e2e8f0',
                        '--text-muted': '#a0aec0',
                        '--border-color': '#4a5568'
                    },
                    forest: {
                        '--primary-color': '#38a169',
                        '--secondary-color': '#2f855a',
                        '--background': '#0f2017',
                        '--card-bg': '#1a2e1f',
                        '--text-primary': '#f0fff4',
                        '--text-secondary': '#c6f6d5', 
                        '--text-muted': '#9ae6b4',
                        '--border-color': '#2f855a'
                    },
                    sunset: {
                        '--primary-color': '#ed8936',
                        '--secondary-color': '#dd6b20',
                        '--background': '#1c1917',
                        '--card-bg': '#292524',
                        '--text-primary': '#fef7ed',
                        '--text-secondary': '#fed7aa',
                        '--text-muted': '#fdba74',
                        '--border-color': '#44403c'
                    },
                    purple: {
                        '--primary-color': '#805ad5',
                        '--secondary-color': '#6b46c1',
                        '--background': '#1a1120',
                        '--card-bg': '#2d1b3d',
                        '--text-primary': '#faf5ff',
                        '--text-secondary': '#e9d8fd',
                        '--text-muted': '#d6bcfa',
                        '--border-color': '#44337a'
                    },
                    ocean: {
                        '--primary-color': '#3182ce',
                        '--secondary-color': '#2c5282',
                        '--background': '#0a0e1a',
                        '--card-bg': '#1e293b',
                        '--text-primary': '#e6fffa',
                        '--text-secondary': '#b2f5ea',
                        '--text-muted': '#81e6d9',
                        '--border-color': '#334155'
                    },
                    rose: {
                        '--primary-color': '#e53e3e',
                        '--secondary-color': '#c53030',
                        '--background': '#1a0a0a',
                        '--card-bg': '#2d1b1b',
                        '--text-primary': '#fff5f5',
                        '--text-secondary': '#fed7d7',
                        '--text-muted': '#feb2b2',
                        '--border-color': '#742a2a'
                    },
                    matrix: {
                        '--primary-color': '#00ff41',
                        '--secondary-color': '#00cc33',
                        '--background': '#000000',
                        '--card-bg': '#001100',
                        '--text-primary': '#00ff41',
                        '--text-secondary': '#00cc33',
                        '--text-muted': '#009900',
                        '--border-color': '#003300'
                    }
                };

                const selectedTheme = themes[themeName];
                if (selectedTheme) {
                    const root = document.documentElement;
                    Object.entries(selectedTheme).forEach(([property, value]) => {
                        root.style.setProperty(property, value);
                    });
                    
                    // Update theme selector if it exists
                    const themeSelector = document.getElementById('theme-selector');
                    if (themeSelector) {
                        themeSelector.value = themeName;
                    }
                    
                    // Save to localStorage
                    localStorage.setItem('selectedTheme', themeName);
                }
            },

            saveColorSettings() {
                const theme = document.getElementById('theme-selector')?.value || 'dark';
                const highContrast = document.getElementById('high-contrast')?.checked || false;
                const colorBlindFriendly = document.getElementById('color-blind-friendly')?.checked || false;
                const reduceMotion = document.getElementById('reduce-motion')?.checked || false;
                const animationsEnabled = document.getElementById('animations-enabled')?.checked || true;

                // Save color settings
                localStorage.setItem('selectedTheme', theme);
                localStorage.setItem('highContrast', highContrast);
                localStorage.setItem('colorBlindFriendly', colorBlindFriendly);
                localStorage.setItem('reducedMotion', reduceMotion);
                localStorage.setItem('animationsEnabled', animationsEnabled);

                // Apply theme using the fallback method
                try {
                    if (window.themeManager && typeof window.themeManager.applyTheme === 'function') {
                        window.themeManager.applyTheme(theme);
                    } else {
                        settingsAPI.applyTheme(theme);
                    }
                } catch (error) {
                    settingsAPI.applyTheme(theme);
                }

                createToast('Color settings saved!', 'success');
                showSuccessMessage();
            },

            resetColorSettings() {
                if (confirm('Reset color settings to defaults?')) {
                    // Reset form values
                    document.getElementById('theme-selector').value = 'dark';
                    document.getElementById('high-contrast').checked = false;
                    document.getElementById('color-blind-friendly').checked = false;
                    document.getElementById('reduce-motion').checked = false;
                    document.getElementById('animations-enabled').checked = true;

                    // Clear localStorage
                    localStorage.removeItem('selectedTheme');
                    localStorage.removeItem('highContrast');
                    localStorage.removeItem('colorBlindFriendly');
                    localStorage.removeItem('reducedMotion');
                    localStorage.removeItem('animationsEnabled');

                    // Apply default theme
                    try {
                        if (window.themeManager && typeof window.themeManager.applyTheme === 'function') {
                            window.themeManager.applyTheme('dark');
                        } else {
                            settingsAPI.applyTheme('dark');
                        }
                    } catch (error) {
                        settingsAPI.applyTheme('dark');
                    }

                    createToast('Color settings reset to defaults', 'success');
                    showSuccessMessage();
                }
            },

            loadColorSettings() {
                // Load current theme
                const currentTheme = localStorage.getItem('selectedTheme') || 'dark';
                const themeSelector = document.getElementById('theme-selector');
                if (themeSelector) {
                    themeSelector.value = currentTheme;
                }

                // Load accessibility settings
                const highContrast = localStorage.getItem('highContrast') === 'true';
                const colorBlindFriendly = localStorage.getItem('colorBlindFriendly') === 'true';
                const reduceMotion = localStorage.getItem('reducedMotion') === 'true';
                const animationsEnabled = localStorage.getItem('animationsEnabled') !== 'false';

                const highContrastEl = document.getElementById('high-contrast');
                const colorBlindFriendlyEl = document.getElementById('color-blind-friendly');
                const reduceMotionEl = document.getElementById('reduce-motion');
                const animationsEnabledEl = document.getElementById('animations-enabled');

                if (highContrastEl) highContrastEl.checked = highContrast;
                if (colorBlindFriendlyEl) colorBlindFriendlyEl.checked = colorBlindFriendly;
                if (reduceMotionEl) reduceMotionEl.checked = reduceMotion;
                if (animationsEnabledEl) animationsEnabledEl.checked = animationsEnabled;
            },
            toggleKeyVisibility(inputId) {
                const input = document.getElementById(inputId);
                if (input) {
                    input.type = input.type === 'password' ? 'text' : 'password';
                }
            },

            clearApiKey(model) {
                if (confirm(`Remove ${model} API key?`)) {
                    localStorage.removeItem(`apiKey_${model}`);
                    
                    // Update UI immediately
                    const input = document.getElementById(`${model}-key`);
                    const status = document.getElementById(`${model}-status`);
                    const deleteBtn = document.getElementById(`${model}-delete-btn`);
                    
                    if (input) input.value = '';
                    if (status) {
                        status.innerHTML = 'Not configured';
                        status.className = 'vs-status empty';
                    }
                    if (deleteBtn) {
                        deleteBtn.style.display = 'none';
                    }
                    
                    createToast(`${model} API key removed`, 'success');
                }
            },

            saveAllApiKeys() {
                const models = ['gemini', 'claude', 'gpt', 'deepseek'];
                let saveCount = 0;
                let validCount = 0;

                models.forEach(model => {
                    const input = document.getElementById(`${model}-key`);
                    const status = document.getElementById(`${model}-status`);
                    const deleteBtn = document.getElementById(`${model}-delete-btn`);
                    
                    if (input && input.value.trim()) {
                        const key = input.value.trim();
                        localStorage.setItem(`apiKey_${model}`, key);
                        
                        // Real-time validation
                        const isValid = validateApiKey ? validateApiKey(key, model) : true;
                        
                        if (status) {
                            if (isValid) {
                                status.innerHTML = 'Valid API key';
                                status.className = 'vs-status';
                                validCount++;
                            } else {
                                status.innerHTML = '⚠️ Invalid format';
                                status.className = 'vs-status empty';
                            }
                        }
                        
                        // Show delete button when key is saved
                        if (deleteBtn) {
                            deleteBtn.style.display = 'inline-flex';
                        }
                        
                        saveCount++;
                    } else {
                        if (status) {
                            status.innerHTML = 'Not configured';
                            status.className = 'vs-status empty';
                        }
                        
                        // Hide delete button when no key
                        if (deleteBtn) {
                            deleteBtn.style.display = 'none';
                        }
                    }
                });

                if (saveCount > 0) {
                    if (validCount === saveCount) {
                        createToast(`${saveCount} API key(s) saved and validated successfully!`, 'success');
                    } else if (validCount > 0) {
                        createToast(`${saveCount} API key(s) saved (${validCount} valid)`, 'warning');
                    } else {
                        createToast(`${saveCount} API key(s) saved but format validation failed`, 'error');
                    }
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
                document.querySelectorAll('.vs-model-card').forEach(card => {
                    if (card.getAttribute('data-model') === model) {
                        card.classList.add('selected');
                    } else {
                        card.classList.remove('selected');
                    }
                });
            },

            saveModelSelection() {
                const selected = document.querySelector('.vs-model-card.selected');
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
            },

            // Voice Settings Functions
            saveVoiceSettings() {
                const voiceSettings = {
                    voiceInputEnabled: document.getElementById('voice-input-enabled')?.checked || false,
                    continuousMode: document.getElementById('continuous-mode')?.checked || false,
                    voiceCommandsEnabled: document.getElementById('voice-commands-enabled')?.checked || false,
                    wakeWord: document.getElementById('wake-word')?.value || 'hey chat',
                    ttsEnabled: document.getElementById('tts-enabled')?.checked || false,
                    autoSpeak: document.getElementById('auto-speak')?.checked || false,
                    ttsVoice: document.getElementById('tts-voice')?.value || '',
                    speechLanguage: document.getElementById('speech-language')?.value || 'en-US',
                    ttsRate: parseFloat(document.getElementById('tts-rate')?.value || '1.0'),
                    ttsVolume: parseFloat(document.getElementById('tts-volume')?.value || '1.0'),
                    ttsPitch: parseFloat(document.getElementById('tts-pitch')?.value || '1.0')
                };

                localStorage.setItem('voiceSettings', JSON.stringify(voiceSettings));
                
                // Add visual feedback to the save button
                const saveBtn = document.getElementById('saveVoiceBtn');
                if (saveBtn) {
                    const originalText = saveBtn.innerHTML;
                    saveBtn.innerHTML = '<span class="btn-icon">✅</span>Saved!';
                    saveBtn.style.background = '#0e4429';
                    saveBtn.style.borderColor = '#1a7f37';
                    
                    setTimeout(() => {
                        saveBtn.innerHTML = originalText;
                        saveBtn.style.background = '';
                        saveBtn.style.borderColor = '';
                    }, 1500);
                }
                
                createToast('Voice settings saved successfully! 🎤', 'success');
                showSuccessMessage();
            },

            resetVoiceSettings() {
                if (confirm('Reset voice settings to defaults?')) {
                    // Set defaults (TTS disabled by default)
                    document.getElementById('voice-input-enabled').checked = false;
                    document.getElementById('continuous-mode').checked = false;
                    document.getElementById('voice-commands-enabled').checked = false;
                    document.getElementById('wake-word').value = 'hey chat';
                    document.getElementById('tts-enabled').checked = false;
                    document.getElementById('auto-speak').checked = false;
                    document.getElementById('tts-voice').value = '';
                    document.getElementById('speech-language').value = 'en-US';
                    document.getElementById('tts-rate').value = '1.0';
                    document.getElementById('tts-volume').value = '1.0';
                    document.getElementById('tts-pitch').value = '1.0';
                    
                    // Update display values
                    document.getElementById('ttsRateValue').textContent = '1.0';
                    document.getElementById('ttsVolumeValue').textContent = '1.0';
                    document.getElementById('ttsPitchValue').textContent = '1.0';
                    
                    localStorage.removeItem('voiceSettings');
                    createToast('Voice settings reset to defaults', 'success');
                    showSuccessMessage();
                }
            },

            testVoice() {
                if ('speechSynthesis' in window) {
                    const testText = "Hello! This is a test of the text-to-speech system. How does this voice sound to you?";
                    const utterance = new SpeechSynthesisUtterance(testText);
                    
                    // Load voice settings
                    const settings = this.getVoiceSettings();
                    utterance.rate = settings.ttsRate;
                    utterance.volume = settings.ttsVolume;
                    utterance.pitch = settings.ttsPitch;
                    
                    // Set voice if selected
                    const selectedVoice = document.getElementById('tts-voice')?.value;
                    if (selectedVoice) {
                        const voices = speechSynthesis.getVoices();
                        const voice = voices.find(v => v.name === selectedVoice);
                        if (voice) utterance.voice = voice;
                    }
                    
                    speechSynthesis.speak(utterance);
                    createToast('Testing voice...', 'info');
                } else {
                    createToast('Speech synthesis not supported in this browser', 'error');
                }
            },

            stopVoice() {
                if ('speechSynthesis' in window) {
                    speechSynthesis.cancel();
                    createToast('Voice stopped', 'info');
                }
            },

            getVoiceSettings() {
                const saved = localStorage.getItem('voiceSettings');
                if (saved) {
                    try {
                        return JSON.parse(saved);
                    } catch (e) {
                        // Error loading voice settings
                    }
                }
                
                // Return defaults (TTS disabled)
                return {
                    voiceInputEnabled: false,
                    continuousMode: false,
                    voiceCommandsEnabled: false,
                    wakeWord: 'hey chat',
                    ttsEnabled: false,
                    autoSpeak: false,
                    ttsVoice: '',
                    speechLanguage: 'en-US',
                    ttsRate: 1.0,
                    ttsVolume: 1.0,
                    ttsPitch: 1.0
                };
            },

            loadVoiceSettings() {
                const settings = this.getVoiceSettings();
                
                document.getElementById('voice-input-enabled').checked = settings.voiceInputEnabled;
                document.getElementById('continuous-mode').checked = settings.continuousMode;
                document.getElementById('voice-commands-enabled').checked = settings.voiceCommandsEnabled;
                document.getElementById('wake-word').value = settings.wakeWord;
                document.getElementById('tts-enabled').checked = settings.ttsEnabled;
                document.getElementById('auto-speak').checked = settings.autoSpeak;
                document.getElementById('tts-voice').value = settings.ttsVoice;
                document.getElementById('speech-language').value = settings.speechLanguage;
                document.getElementById('tts-rate').value = settings.ttsRate;
                document.getElementById('tts-volume').value = settings.ttsVolume;
                document.getElementById('tts-pitch').value = settings.ttsPitch;
                
                // Update display values
                document.getElementById('ttsRateValue').textContent = settings.ttsRate;
                document.getElementById('ttsVolumeValue').textContent = settings.ttsVolume;
                document.getElementById('ttsPitchValue').textContent = settings.ttsPitch;
                
                // Load available voices
                this.loadAvailableVoices();
            },

            loadAvailableVoices() {
                if ('speechSynthesis' in window) {
                    const voices = speechSynthesis.getVoices();
                    const voiceSelect = document.getElementById('tts-voice');
                    
                    if (voiceSelect && voices.length > 0) {
                        // Clear existing options except the first one
                        voiceSelect.innerHTML = '<option value="">Default Voice</option>';
                        
                        const currentVoice = document.getElementById('tts-voice').value;
                        
                        voices.forEach((voice, index) => {
                            const option = document.createElement('option');
                            option.value = voice.name;
                            option.textContent = `${voice.name} (${voice.lang})`;
                            
                            if (currentVoice === voice.name) {
                                option.selected = true;
                            }
                            
                            voiceSelect.appendChild(option);
                        });
                    }
                }
            }
        };

        // Make functions globally available for onclick handlers
        window.app = {
            ...settingsAPI,
            testApiKey: testApiKey,
            validateApiKey: validateApiKey
        };

        // Ensure toggleKeyVisibility is properly exposed
        window.app.toggleKeyVisibility = settingsAPI.toggleKeyVisibility;

        // Ensure showToast is available for theme manager
        window.app.showToast = (message, type) => {
            createToast(message, type);
        };

        document.addEventListener('DOMContentLoaded', () => {
            // Ensure theme manager is available
            initializeThemeManager();
            
            // Setup hamburger menu functionality for settings page
            setupHamburgerMenu();
            


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

            // Voice range sliders
            const ttsRateSlider = document.getElementById('tts-rate');
            const ttsVolumeSlider = document.getElementById('tts-volume');
            const ttsPitchSlider = document.getElementById('tts-pitch');
            
            if (ttsRateSlider) {
                ttsRateSlider.addEventListener('input', (e) => {
                    document.getElementById('ttsRateValue').textContent = e.target.value;
                });
            }
            
            if (ttsVolumeSlider) {
                ttsVolumeSlider.addEventListener('input', (e) => {
                    document.getElementById('ttsVolumeValue').textContent = e.target.value;
                });
            }
            
            if (ttsPitchSlider) {
                ttsPitchSlider.addEventListener('input', (e) => {
                    document.getElementById('ttsPitchValue').textContent = e.target.value;
                });
            }

            // Tab switching
            document.querySelectorAll('.vs-sidebar-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabName = tab.getAttribute('data-tab');
                    switchSettingsTab(tabName);
                    

                });
            });

            // Load current settings
            loadSettingsPage();
            
            // Add real-time validation for API key inputs
            ['gemini', 'claude', 'gpt', 'deepseek'].forEach(model => {
                const input = document.getElementById(`${model}-key`);
                const status = document.getElementById(`${model}-status`);
                const deleteBtn = document.getElementById(`${model}-delete-btn`);
                
                if (input && status) {
                    input.addEventListener('input', (e) => {
                        const key = e.target.value.trim();
                        const hasKey = key.length > 0;
                        
                        // Update status display
                        if (!hasKey) {
                            status.innerHTML = 'Not configured';
                            status.className = 'vs-status empty';
                        } else if (validateApiKey && validateApiKey(key, model)) {
                            status.innerHTML = 'Valid format';
                            status.className = 'vs-status';
                        } else {
                            status.innerHTML = '⚠️ Invalid format';
                            status.className = 'vs-status empty';
                        }
                        
                        // Show/hide delete button based on whether there's a key
                        if (deleteBtn) {
                            deleteBtn.style.display = hasKey ? 'inline-flex' : 'none';
                        }
                    });
                }
            });
            
            // Load voice settings
            settingsAPI.loadVoiceSettings();
            
            // Load voices when available
            if ('speechSynthesis' in window) {
                speechSynthesis.onvoiceschanged = () => {
                    settingsAPI.loadAvailableVoices();
                };
                // Initial load attempt
                settingsAPI.loadAvailableVoices();
            }

            // Load color settings
            settingsAPI.loadColorSettings();

            // Theme selector change event
            const themeSelector = document.getElementById('theme-selector');
            if (themeSelector) {
                themeSelector.addEventListener('change', (e) => {
                    const theme = e.target.value;
                    if (window.themeManager && typeof window.themeManager.applyTheme === 'function') {
                        try {
                            window.themeManager.applyTheme(theme);
                        } catch (error) {
                            settingsAPI.applyTheme(theme);
                        }
                    } else {
                        settingsAPI.applyTheme(theme);
                    }
                });
            }
        });

        function switchSettingsTab(tabName) {
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
                'api-keys': { icon: 'K', text: 'API Key Management' },
                'model': { icon: 'M', text: 'Model Selection' },
                'prompts': { icon: 'P', text: 'Prompt Settings' },
                'voice': { icon: 'V', text: 'Voice & Audio Settings' },
                'colors': { icon: 'C', text: 'Theme & Colors' }
            };
            
            const title = titles[tabName] || { icon: 'S', text: 'Settings' };
            const panelIcon = document.getElementById('panel-icon');
            const panelText = document.getElementById('panel-text');
            
            if (panelIcon) panelIcon.textContent = title.icon;
            if (panelText) panelText.textContent = title.text;
        }

        function loadSettingsPage() {
            // Load API keys from localStorage with enhanced status
            ['gemini', 'claude', 'gpt', 'deepseek'].forEach(model => {
                const key = localStorage.getItem(`apiKey_${model}`);
                const input = document.getElementById(`${model}-key`);
                const status = document.getElementById(`${model}-status`);
                const deleteBtn = document.getElementById(`${model}-delete-btn`);
                
                if (input && status) {
                    if (key) {
                        input.value = key;
                        
                        // Enhanced validation and status
                        const isValid = validateApiKey ? validateApiKey(key, model) : true;
                        if (isValid) {
                            status.innerHTML = 'Valid API key';
                            status.className = 'vs-status';
                        } else {
                            status.innerHTML = '⚠️ Invalid format';
                            status.className = 'vs-status empty';
                        }
                        
                        // Show delete button when key exists
                        if (deleteBtn) {
                            deleteBtn.style.display = 'inline-flex';
                        }
                    } else {
                        input.value = '';
                        status.innerHTML = 'Not configured';
                        status.className = 'vs-status empty';
                        
                        // Hide delete button when no key
                        if (deleteBtn) {
                            deleteBtn.style.display = 'none';
                        }
                    }
                }
            });

            // Load selected model
            const selectedModel = localStorage.getItem('selectedModel') || 'gemini';
            const modelCards = document.querySelectorAll('.vs-model-card');
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

        // Setup hamburger menu functionality for settings page
        function setupHamburgerMenu() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const sidebar = document.querySelector('.vs-sidebar');
            const overlay = document.getElementById('vsSidebarOverlay');
            
            if (hamburgerBtn && sidebar) {
                // Toggle sidebar on hamburger click
                hamburgerBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isOpen = sidebar.classList.contains('mobile-open');
                    
                    if (isOpen) {
                        // Close sidebar
                        sidebar.classList.remove('mobile-open');
                        hamburgerBtn.classList.remove('clicked');
                        if (overlay) {
                            overlay.classList.remove('mobile-open');
                        }
                    } else {
                        // Open sidebar
                        sidebar.classList.add('mobile-open');
                        hamburgerBtn.classList.add('clicked');
                        if (overlay) {
                            overlay.classList.add('mobile-open');
                        }
                    }
                });

                // Close sidebar when clicking overlay
                if (overlay) {
                    overlay.addEventListener('click', () => {
                        sidebar.classList.remove('mobile-open');
                        hamburgerBtn.classList.remove('clicked');
                        overlay.classList.remove('mobile-open');
                    });
                }

                // Close sidebar when clicking outside
                document.addEventListener('click', (e) => {
                    if (sidebar.classList.contains('mobile-open')) {
                        if (!sidebar.contains(e.target) && !hamburgerBtn.contains(e.target)) {
                            sidebar.classList.remove('mobile-open');
                            hamburgerBtn.classList.remove('clicked');
                            if (overlay) {
                                overlay.classList.remove('mobile-open');
                            }
                        }
                    }
                });

                // Handle escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
                        sidebar.classList.remove('mobile-open');
                        hamburgerBtn.classList.remove('clicked');
                        if (overlay) {
                            overlay.classList.remove('mobile-open');
                        }
                    }
                });

                // Hamburger menu functionality set up for settings page
            } else {
                // Hamburger menu elements not found on settings page
            }
        }

        // Initialize theme manager function
        function initializeThemeManager() {
            // Check if theme manager exists, if not try to load it
            if (!window.themeManager) {
                // Try to create a basic theme manager instance as fallback
                try {
                    // Check if ThemeManager class exists
                    if (typeof ThemeManager !== 'undefined') {
                        window.themeManager = new ThemeManager();
                        
                        // Override the theme manager's showToast to use our settings page version
                        if (window.themeManager.showToast) {
                            window.themeManager.showToast = (message, type) => {
                                createToast(message, type);
                            };
                        }
                        
                        // Also override the app's showToast to use our settings version
                        if (window.app && window.app.showToast) {
                            window.app.showToast = (message, type) => {
                                createToast(message, type);
                            };
                        }
                    } else {
                        // Create a minimal fallback theme manager
                        window.themeManager = {
                            openThemeCustomizer: () => {
                                settingsAPI.showFallbackThemeSelector();
                            },
                            applyTheme: (theme) => {
                                settingsAPI.applyTheme(theme);
                            },
                            toggleTheme: () => {
                                const currentTheme = localStorage.getItem('selectedTheme') || 'dark';
                                const themes = ['dark', 'light', 'midnight', 'forest', 'sunset', 'purple', 'ocean', 'rose', 'matrix'];
                                const currentIndex = themes.indexOf(currentTheme);
                                const nextTheme = themes[(currentIndex + 1) % themes.length];
                                settingsAPI.applyTheme(nextTheme);
                            }
                        };
                    }
                } catch (error) {
                    
                    // Create minimal fallback
                    window.themeManager = {
                        openThemeCustomizer: () => {
                            settingsAPI.showFallbackThemeSelector();
                        },
                        applyTheme: (theme) => {
                            settingsAPI.applyTheme(theme);
                        },
                        toggleTheme: () => {
                            createToast('Theme toggle not available', 'warning');
                        }
                    };
                }
            }
        }
    </script>
</body>
</html>

/**
 * AI Chat Studio v2.0 - Voice Manager (Settings-based)
 * Core voice functionality without interface - managed through settings page
 */

class VoiceManager {
    constructor() {
        this.isListening = false;
        this.isSpeaking = false;
        this.recognition = null;
        this.synthesis = window.speechSynthesis;
        this.voices = [];
        this.currentVoice = null;
        
        // Default settings with TTS disabled
        this.voiceSettings = {
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
        
        this.init();
    }

    init() {
        this.loadVoiceSettings();
        this.setupSpeechRecognition();
        this.setupSpeechSynthesis();
        this.loadVoices();
    }

    loadVoiceSettings() {
        const saved = localStorage.getItem('voiceSettings');
        if (saved) {
            try {
                this.voiceSettings = { ...this.voiceSettings, ...JSON.parse(saved) };
            } catch (e) {
                console.error('Error loading voice settings:', e);
            }
        }
    }

    saveVoiceSettings() {
        localStorage.setItem('voiceSettings', JSON.stringify(this.voiceSettings));
    }

    setupSpeechRecognition() {
        // Check for browser support
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            console.warn('Speech recognition not supported');
            return;
        }

        this.recognition = new SpeechRecognition();
        
        // Configure recognition
        this.recognition.continuous = this.voiceSettings.continuousMode;
        this.recognition.interimResults = true;
        this.recognition.lang = this.voiceSettings.speechLanguage;
        this.recognition.maxAlternatives = 1;

        // Event handlers
        this.recognition.onstart = () => {
            this.isListening = true;
            console.log('Voice recognition started');
        };

        this.recognition.onend = () => {
            this.isListening = false;
            console.log('Voice recognition ended');
            
            // Auto-restart if continuous mode is enabled
            if (this.voiceSettings.continuousMode && !this.isManualStop) {
                setTimeout(() => this.startListening(), 100);
            }
        };

        this.recognition.onresult = (event) => {
            this.handleSpeechResult(event);
        };

        this.recognition.onerror = (event) => {
            this.handleSpeechError(event);
        };

        this.recognition.onnomatch = () => {
            console.log('No speech detected');
        };
    }

    setupSpeechSynthesis() {
        if (!this.synthesis) {
            console.warn('Speech synthesis not supported');
            return;
        }

        // Load voices when they become available
        this.synthesis.onvoiceschanged = () => {
            this.loadVoices();
        };

        this.loadVoices(); // Initial load attempt
    }

    loadVoices() {
        this.voices = this.synthesis.getVoices();
        
        // Set default voice
        if (this.voices.length > 0 && !this.currentVoice && this.voiceSettings.ttsVoice) {
            this.currentVoice = this.voices.find(voice => voice.name === this.voiceSettings.ttsVoice) || null;
        }
    }

    handleSpeechResult(event) {
        let interimTranscript = '';
        let finalTranscript = '';

        for (let i = event.resultIndex; i < event.results.length; i++) {
            const transcript = event.results[i][0].transcript;
            
            if (event.results[i].isFinal) {
                finalTranscript += transcript;
            } else {
                interimTranscript += transcript;
            }
        }

        // Check for wake word
        if (this.voiceSettings.wakeWord && !this.isWakeWordDetected(finalTranscript + interimTranscript)) {
            return;
        }

        // Process final transcript
        if (finalTranscript) {
            this.processVoiceCommand(finalTranscript.trim());
        }
    }

    handleSpeechError(event) {
        console.error('Speech recognition error:', event.error);
        
        let errorMessage = 'Speech recognition error';
        switch (event.error) {
            case 'no-speech':
                errorMessage = 'No speech detected';
                break;
            case 'audio-capture':
                errorMessage = 'Microphone access denied';
                break;
            case 'not-allowed':
                errorMessage = 'Microphone permission denied';
                break;
            case 'network':
                errorMessage = 'Network error occurred';
                break;
        }
        
        console.log('Voice error:', errorMessage);
    }

    isWakeWordDetected(transcript) {
        if (!this.voiceSettings.wakeWord) return true;
        
        const wakeWord = this.voiceSettings.wakeWord.toLowerCase();
        const cleanTranscript = transcript.toLowerCase().trim();
        
        return cleanTranscript.includes(wakeWord) || cleanTranscript.startsWith(wakeWord);
    }

    processVoiceCommand(transcript) {
        const command = transcript.toLowerCase();
        
        // Remove wake word from command
        let cleanCommand = command;
        if (this.voiceSettings.wakeWord) {
            cleanCommand = cleanCommand.replace(this.voiceSettings.wakeWord, '').trim();
        }

        // Check for voice commands
        if (this.voiceSettings.voiceCommandsEnabled) {
            if (this.isStopCommand(cleanCommand)) {
                this.stopListening();
                this.stopSpeaking();
                return;
            }
            
            if (this.isClearCommand(cleanCommand)) {
                this.clearInput();
                return;
            }
            
            if (this.isNewChatCommand(cleanCommand)) {
                this.createNewChat();
                return;
            }
        }

        // Send to chat if we're in chat context
        const messageInput = document.getElementById('messageInput');
        if (messageInput && this.voiceSettings.voiceInputEnabled) {
            if (this.voiceSettings.continuousMode) {
                // In continuous mode, replace current input
                messageInput.value = cleanCommand;
            } else {
                // In single mode, append to current input
                messageInput.value += (messageInput.value ? ' ' : '') + cleanCommand;
            }
            
            messageInput.focus();
            
            // Auto-send if configured
            if (!this.voiceSettings.continuousMode && this.isSendCommand(cleanCommand)) {
                this.sendMessage();
            }
        }

        console.log('Voice command processed:', transcript.trim());
    }

    isStopCommand(command) {
        const stopWords = ['stop', 'stop listening', 'quit', 'exit', 'cancel'];
        return stopWords.some(word => command.includes(word));
    }

    isClearCommand(command) {
        const clearWords = ['clear', 'clear input', 'delete', 'erase'];
        return clearWords.some(word => command.includes(word));
    }

    isNewChatCommand(command) {
        const newChatWords = ['new chat', 'start over', 'fresh chat', 'reset'];
        return newChatWords.some(word => command.includes(word));
    }

    isSendCommand(command) {
        const sendWords = ['send', 'submit', 'go', 'enter', 'send message'];
        return sendWords.some(word => command.includes(word));
    }

    // Public methods for external use
    startListening() {
        if (!this.recognition) {
            console.warn('Speech recognition not supported');
            return false;
        }

        if (this.isListening) {
            return true;
        }

        try {
            this.isManualStop = false;
            this.recognition.start();
            return true;
        } catch (error) {
            console.error('Error starting recognition:', error);
            return false;
        }
    }

    stopListening() {
        if (this.recognition && this.isListening) {
            this.isManualStop = true;
            this.recognition.stop();
            return true;
        }
        return false;
    }

    speakText(text, options = {}) {
        if (!this.synthesis || !this.voiceSettings.ttsEnabled) {
            console.warn('Speech synthesis not supported or disabled');
            return;
        }

        // Cancel any ongoing speech
        this.synthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(text);
        
        // Apply voice settings
        utterance.rate = options.rate || this.voiceSettings.ttsRate;
        utterance.pitch = options.pitch || this.voiceSettings.ttsPitch;
        utterance.volume = options.volume || this.voiceSettings.ttsVolume;
        
        if (options.voice || this.currentVoice) {
            utterance.voice = options.voice || this.currentVoice;
        }

        // Event handlers
        utterance.onstart = () => {
            this.isSpeaking = true;
        };

        utterance.onend = () => {
            this.isSpeaking = false;
        };

        utterance.onerror = (event) => {
            console.error('Speech synthesis error:', event.error);
            this.isSpeaking = false;
        };

        this.synthesis.speak(utterance);
        return utterance;
    }

    stopSpeaking() {
        if (this.synthesis) {
            this.synthesis.cancel();
            this.isSpeaking = false;
        }
    }

    // Helper methods that interact with the main app
    clearInput() {
        const messageInput = document.getElementById('messageInput');
        if (messageInput) {
            messageInput.value = '';
        }
    }

    createNewChat() {
        if (window.app && typeof window.app.createNewConversation === 'function') {
            window.app.createNewConversation();
        }
    }

    sendMessage() {
        const chatForm = document.getElementById('chatForm');
        if (chatForm) {
            chatForm.dispatchEvent(new Event('submit'));
        }
    }

    updateCharCounter() {
        if (window.app && typeof window.app.updateCharCounter === 'function') {
            window.app.updateCharCounter();
        }
    }
}

// Initialize voice manager
document.addEventListener('DOMContentLoaded', () => {
    window.voiceManager = new VoiceManager();
});
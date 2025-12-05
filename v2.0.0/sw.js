/**
 * AI Chat Studio - Service Worker
 * Provides offline functionality, caching, and background sync
 */

const CACHE_NAME = 'ai-chat-hub-v2.0.0';
const STATIC_CACHE = 'ai-chat-hub-static-v2.0.0';
const DYNAMIC_CACHE = 'ai-chat-hub-dynamic-v2.0.0';

// Assets to cache immediately
const STATIC_ASSETS = [
    './',
    './index.php',
    './assets/css/style.css',
    './assets/js/app.js',
    './assets/js/templates.js',
    './assets/js/search.js',
    './assets/js/export.js',
    './assets/js/theme.js',
    './assets/js/voice.js',
    './api/chat.php',
    './manifest.json',
    './assets/js/prism.js',
    './assets/css/prism.css'
];

// Routes that should be cached
const CACHE_ROUTES = [
    /^\/$/,
    /^\/index\.php$/,
    /^\/assets\//,
    /^\/pages\//,
    /^\/api\/chat\.php$/
];

// Routes that should always be network-first
const NETWORK_FIRST_ROUTES = [
    /^\/api\//
];

// Install event
self.addEventListener('install', event => {
    console.log('[SW] Installing service worker');
    
    event.waitUntil(
        Promise.all([
            // Cache static assets
            caches.open(STATIC_CACHE).then(cache => {
                console.log('[SW] Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            }),
            // Skip waiting to activate immediately
            self.skipWaiting()
        ])
    );
});

// Activate event
self.addEventListener('activate', event => {
    console.log('[SW] Activating service worker');
    
    event.waitUntil(
        Promise.all([
            // Clean up old caches
            cleanupOldCaches(),
            // Claim all clients immediately
            self.clients.claim()
        ])
    );
});

// Fetch event
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);
    
    // Skip non-GET requests
    if (request.method !== 'GET') {
        return;
    }
    
    // Skip external requests
    if (url.origin !== location.origin) {
        return;
    }
    
    // Choose caching strategy
    if (isNetworkFirstRoute(url.pathname)) {
        event.respondWith(networkFirstStrategy(request));
    } else if (isCacheRoute(url.pathname)) {
        event.respondWith(cacheFirstStrategy(request));
    } else {
        event.respondWith(staleWhileRevalidateStrategy(request));
    }
});

// Cache-first strategy (static assets)
async function cacheFirstStrategy(request) {
    try {
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        const networkResponse = await fetch(request);
        const cache = await caches.open(DYNAMIC_CACHE);
        cache.put(request, networkResponse.clone());
        
        return networkResponse;
    } catch (error) {
        console.error('[SW] Cache-first strategy failed:', error);
        return await getOfflineFallback(request);
    }
}

// Network-first strategy (API calls, dynamic content)
async function networkFirstStrategy(request) {
    try {
        const networkResponse = await fetch(request);
        
        // Cache successful responses
        if (networkResponse.ok) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
        }
        
        return networkResponse;
    } catch (error) {
        console.log('[SW] Network failed, trying cache for:', request.url);
        
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        return await getOfflineFallback(request);
    }
}

// Stale-while-revalidate strategy
async function staleWhileRevalidateStrategy(request) {
    const cache = await caches.open(DYNAMIC_CACHE);
    const cachedResponse = await cache.match(request);
    
    const fetchPromise = fetch(request).then(networkResponse => {
        if (networkResponse.ok) {
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    }).catch(() => {
        // Network failed, ignore
    });
    
    return cachedResponse || await fetchPromise || await getOfflineFallback(request);
}

// Background sync for failed requests
self.addEventListener('sync', event => {
    console.log('[SW] Background sync triggered:', event.tag);
    
    if (event.tag === 'chat-sync') {
        event.waitUntil(syncChatData());
    }
    
    if (event.tag === 'settings-sync') {
        event.waitUntil(syncSettings());
    }
});

// Push notifications
self.addEventListener('push', event => {
    console.log('[SW] Push notification received');
    
    const options = {
        body: event.data ? event.data.text() : 'New notification',
        icon: './assets/icons/icon-192x192.png',
        badge: './assets/icons/badge-72x72.png',
        tag: 'ai-chat-hub',
        data: {
            url: './index.php'
        },
        actions: [
            {
                action: 'open',
                title: 'Open App'
            },
            {
                action: 'dismiss',
                title: 'Dismiss'
            }
        ]
    };
    
    event.waitUntil(
        self.registration.showNotification('AI Chat Studio', options)
    );
});

// Notification click handler
self.addEventListener('notificationclick', event => {
    console.log('[SW] Notification clicked:', event.action);
    
    event.notification.close();
    
    if (event.action === 'open' || !event.action) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url || './')
        );
    }
});

// Message handler for client communication
self.addEventListener('message', event => {
    console.log('[SW] Message received:', event.data);
    
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    
    if (event.data && event.data.type === 'GET_VERSION') {
        event.ports[0].postMessage({ version: CACHE_NAME });
    }
    
    if (event.data && event.data.type === 'CACHE_URLS') {
        event.waitUntil(cacheUrls(event.data.urls));
    }
    
    if (event.data && event.data.type === 'CLEAR_CACHE') {
        event.waitUntil(clearAllCaches());
    }
});

// Helper functions
function isCacheRoute(pathname) {
    return CACHE_ROUTES.some(pattern => pattern.test(pathname));
}

function isNetworkFirstRoute(pathname) {
    return NETWORK_FIRST_ROUTES.some(pattern => pattern.test(pathname));
}

async function cleanupOldCaches() {
    const cacheNames = await caches.keys();
    const oldCaches = cacheNames.filter(name => {
        return name.startsWith('ai-chat-hub-') && 
               name !== CACHE_NAME && 
               name !== STATIC_CACHE && 
               name !== DYNAMIC_CACHE;
    });
    
    return Promise.all(
        oldCaches.map(name => {
            console.log('[SW] Deleting old cache:', name);
            return caches.delete(name);
        })
    );
}

async function getOfflineFallback(request) {
    // Return appropriate offline page
    if (request.destination === 'document') {
        return caches.match('./offline.html') || 
               new Response('Offline - Service worker active', {
                   status: 503,
                   headers: { 'Content-Type': 'text/plain' }
               });
    }
    
    if (request.destination === 'image') {
        return new Response('', {
            status: 204
        });
    }
    
    return new Response('Resource not available offline', {
        status: 503,
        headers: { 'Content-Type': 'text/plain' }
    });
}

async function syncChatData() {
    try {
        // Get any pending chat data from IndexedDB
        const pendingData = await getPendingChatData();
        
        if (pendingData.length > 0) {
            // Sync each pending item
            for (const item of pendingData) {
                try {
                    await fetch('/api/chat.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(item.data)
                    });
                    
                    // Remove from pending queue
                    await removePendingChatData(item.id);
                } catch (error) {
                    console.error('[SW] Failed to sync chat data:', error);
                }
            }
        }
    } catch (error) {
        console.error('[SW] Chat sync failed:', error);
    }
}

async function syncSettings() {
    try {
        // Sync settings that were changed while offline
        const pendingSettings = await getPendingSettings();
        
        for (const setting of pendingSettings) {
            try {
                // Apply setting locally
                localStorage.setItem(setting.key, setting.value);
                await removePendingSetting(setting.id);
            } catch (error) {
                console.error('[SW] Failed to sync setting:', error);
            }
        }
    } catch (error) {
        console.error('[SW] Settings sync failed:', error);
    }
}

async function cacheUrls(urls) {
    try {
        const cache = await caches.open(STATIC_CACHE);
        await cache.addAll(urls);
        console.log('[SW] Cached URLs:', urls);
    } catch (error) {
        console.error('[SW] Failed to cache URLs:', error);
    }
}

async function clearAllCaches() {
    try {
        const cacheNames = await caches.keys();
        await Promise.all(
            cacheNames.map(name => caches.delete(name))
        );
        console.log('[SW] All caches cleared');
    } catch (error) {
        console.error('[SW] Failed to clear caches:', error);
    }
}

// IndexedDB helpers for offline data storage
async function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open('AIChatHubDB', 1);
        
        request.onerror = () => reject(request.error);
        request.onsuccess = () => resolve(request.result);
        
        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            
            // Create object stores
            if (!db.objectStoreNames.contains('pendingChat')) {
                const store = db.createObjectStore('pendingChat', { keyPath: 'id', autoIncrement: true });
                store.createIndex('timestamp', 'timestamp');
            }
            
            if (!db.objectStoreNames.contains('pendingSettings')) {
                const store = db.createObjectStore('pendingSettings', { keyPath: 'id', autoIncrement: true });
                store.createIndex('key', 'key', { unique: true });
            }
        };
    });
}

async function getPendingChatData() {
    try {
        const db = await openDB();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(['pendingChat'], 'readonly');
            const store = transaction.objectStore('pendingChat');
            const request = store.getAll();
            
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    } catch (error) {
        console.error('[SW] Failed to get pending chat data:', error);
        return [];
    }
}

async function removePendingChatData(id) {
    try {
        const db = await openDB();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(['pendingChat'], 'readwrite');
            const store = transaction.objectStore('pendingChat');
            const request = store.delete(id);
            
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    } catch (error) {
        console.error('[SW] Failed to remove pending chat data:', error);
    }
}

async function getPendingSettings() {
    try {
        const db = await openDB();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(['pendingSettings'], 'readonly');
            const store = transaction.objectStore('pendingSettings');
            const request = store.getAll();
            
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    } catch (error) {
        console.error('[SW] Failed to get pending settings:', error);
        return [];
    }
}

async function removePendingSetting(id) {
    try {
        const db = await openDB();
        return new Promise((resolve, reject) => {
            const transaction = db.transaction(['pendingSettings'], 'readwrite');
            const store = transaction.objectStore('pendingSettings');
            const request = store.delete(id);
            
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    } catch (error) {
        console.error('[SW] Failed to remove pending setting:', error);
    }
}

// Periodic background sync (if supported)
if ('periodicSync' in self.registration) {
    self.addEventListener('periodicsync', event => {
        console.log('[SW] Periodic sync triggered:', event.tag);
        
        if (event.tag === 'chat-backup') {
            event.waitUntil(backupChatData());
        }
    });
}

async function backupChatData() {
    try {
        // Get chat data and store locally for backup
        const chatData = await getChatData();
        const backupData = {
            timestamp: Date.now(),
            data: chatData
        };
        
        // Store in cache for offline access
        const cache = await caches.open(DYNAMIC_CACHE);
        await cache.put('./backup-chat-data', new Response(JSON.stringify(backupData)));
        
        console.log('[SW] Chat data backed up');
    } catch (error) {
        console.error('[SW] Failed to backup chat data:', error);
    }
}

async function getChatData() {
    try {
        // This would integrate with the main app's data storage
        const response = await fetch('./api/backup-chat.php');
        return await response.json();
    } catch (error) {
        console.error('[SW] Failed to get chat data:', error);
        return { conversations: [] };
    }
}

// Error handling
self.addEventListener('error', event => {
    console.error('[SW] Service worker error:', event.error);
});

self.addEventListener('unhandledrejection', event => {
    console.error('[SW] Unhandled promise rejection:', event.reason);
});

console.log('[SW] Service worker loaded');
// Service Worker
importScripts('https://www.gstatic.com/firebasejs/12.3.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/12.3.0/firebase-messaging-compat.js');
importScripts('firebase-variables.js');

const siteDomain = tsSiteUrl;

const firebaseConfig = {
    apiKey: tsApiKey,
    authDomain: tsAuthDomain,
    projectId: tsProjectId,
    storageBucket: tsStorageBucket,
    messagingSenderId: tsMessagingSenderId,
    appId: tsAppId,
};

function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open("fcm_notifications", 1);
        request.onupgradeneeded = event => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains("locks")) {
                db.createObjectStore("locks");
            }
        };
        request.onsuccess = event => resolve(event.target.result);
        request.onerror = event => reject(event.target.error);
    });
}

async function setLock(key) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction("locks", "readwrite");
        const store = tx.objectStore("locks");
        store.put(Date.now(), key);
        tx.oncomplete = () => resolve(true);
        tx.onerror = () => reject(false);
    });
}

async function getLock(key, maxAgeMs = 5000) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction("locks", "readonly");
        const store = tx.objectStore("locks");
        const request = store.get(key);
        request.onsuccess = () => {
            const value = request.result;
            if (!value) return resolve(false);
            const age = Date.now() - value;
            resolve(age < maxAgeMs); // kilit hala geçerli mi
        };
        request.onerror = () => reject(false);
    });
}

// // Initialize Firebase
const app = firebase.initializeApp(firebaseConfig);

// Initialize Firebase Cloud Messaging and get a reference to the service
const messaging = firebase.messaging()

async function bildirimGoster(payload) {

    const locked = await getLock('notification_lock');
    if (locked) return; // başka bir sekme zaten gösteriyor

    await setLock('notification_lock');

    const notificationTitle = payload.data.title || "Yeni bildirim";
    const notificationOptions = {
        body: payload.data.body || "",
        icon: siteDomain + '/dist/img/favicon.ico',
        data: payload.data,
    };

    self.registration.showNotification(notificationTitle,
        notificationOptions);
}

messaging.onBackgroundMessage(async (payload) => {
    await bildirimGoster(payload);
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();
    event.waitUntil(
        clients.matchAll({ type: "window", includeUncontrolled: true }).then(clientList => {
            let tip = event.notification.data.tip || "standart";
            let id = event.notification.data.id || "0";
            let url = siteDomain;
            switch (tip) {
                case "cihaz":
                    url = siteDomain + "/cihazlarim";
                    break;
                case "cagri":
                    if (id != "" && id != "0") {
                        url = siteDomain + "/cagrikayitlari/detay/" + id;
                    } else {
                        url = siteDomain + "/cagrikayitlari";
                    }
                    break;
                default:
                    break;
            }
            for (const client of clientList) {
                if (client.url.includes(url) && "focus" in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow("https://" + url);
            }
        })
    );
});
self.addEventListener('message', async (event) => {
    const data = event.data;
    if (!data || data.type !== 'SHOW_NOTIFICATION') return;

    const payload = data.payload;
    await bildirimGoster(payload);
});
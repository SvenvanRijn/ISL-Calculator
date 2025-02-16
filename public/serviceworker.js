self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('pwa-cache-v1').then((cache) => {
            return cache.addAll([
                '/',
                '/css/style.css',
                '/js/app.js',
                '/images/*',
            ]);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request).then((response) => {
                // Prevent caching redirects
                if (response.redirected) {
                  return fetch(response.url); // Make a new request to the final URL
                }
                return response;
            }).catch((error) => {
                console.error("Fetch failed:", error);
                return new Response("Offline content unavailable", { status: 503 });
            });
        })
    );
});

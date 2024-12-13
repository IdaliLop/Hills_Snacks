const CACHE_NAME = "v1";
const urlsToCache = [
  "/",
  "index.php",
  "../Views/admin/indexAdmin.php",
  "../css/indexAd.css",
  "../css/header.css",
  "/index.js",
  "/funciones.js",
  "../Util/img/LogoHills.png",
  "../Util/img/LogoHills.png"
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) =>
      Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            return caches.delete(cache);
          }
        })
      )
    )
  );
});

self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});
// Muestra el mensaje de error que llega en la dirección (?error=...) arriba del formulario.
(function () {
    var parametros = new URLSearchParams(window.location.search);
    var texto = parametros.get('error');
    var formulario = document.querySelector('form');
    if (texto && formulario) {
        var caja = document.createElement('div');
        caja.setAttribute('role', 'alert');
        caja.style.cssText = 'background:#fdecea;color:#b71c1c;border:1px solid #f5c6cb;border-radius:6px;padding:10px;margin:10px 0;text-align:center;font-size:14px';
        caja.textContent = texto;
        formulario.insertBefore(caja, formulario.firstChild.nextSibling);
    }
})();

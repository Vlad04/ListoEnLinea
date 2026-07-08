(function () {

    const faviconHTML = `
        <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon2-32x32.png">
        <link rel="shortcut icon" href="assets/img/icono/favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icono/apple-touch-icon.png">
        <link rel="manifest" href="assets/img/icono/site.webmanifest">
    `;

    document.head.insertAdjacentHTML("beforeend", faviconHTML);

})();
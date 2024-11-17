function getCookie(name) {
    let cookieArr = document.cookie.split(";");
    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");
        if (name === cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
}
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
let anyError = (message, route = null, routeMessage = null) => {
    let body = `<div class="toast-message">
    <div class="d-flex align-items-center px-2">
        <a class="px-2">
            <i class="error-icon icon-bg-red" style="zoom:1.3"></i>
        </a>
        <p class="text-secondary p-1 mb-0">
            ${message}`;
    if (route) {
        body += `<a href="${route}" class="text-primary ps-3 fs-4 text-underline-hover">${routeMessage}</a>`;
    }
    body += `</p>
        <a class="toasterHideBtn cursor-pointer d-flex text-warning px-1 bg-grey-400-hover rounded-circle">✖</a>
    </div>
</div>`;
    return body;
};
let anySuccess = (message, route = null, routeMessage = null) => {
    let body = `<div class="toast-message">
    <div class="d-flex align-items-center px-2">
        <a class="px-2">
            <i class="okey-icon icon-bg-green" style="zoom:1.3"></i>
        </a>
        <p class="text-secondary p-1 mb-0">
           ${message}`;
    if (route) {
        body += `<a href="${route}" class="text-primary ps-3 fs-4 text-underline-hover">${routeMessage}</a>`;
    }
    body += `</p><a class="toasterHideBtn cursor-pointer d-flex text-warning px-1 bg-grey-400-hover rounded-circle">✖</a>
    </div>
</div>`;
    return body;
}
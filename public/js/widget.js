
window.onmessage = function(e) {
    document.getElementById("widget").classList = "widget " + e.data;
};

function w3_open() {
    document.getElementById("side-bar").style.display = "block";
    document.getElementById('sidebar-button').innerText = "×";
    document.getElementById('sidebar-button').onclick = function() { w3_close(); };
}

function w3_close() {
    document.getElementById("side-bar").style.display = "none";
    document.getElementById('sidebar-button').innerText = "☰";
    document.getElementById('sidebar-button').onclick = function() { w3_open(); };
}

(function () {


})();


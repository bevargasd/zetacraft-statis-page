//types of ipadress
//0.0.0.0:25565
//mc.your-site.com
//mc.your-site.com:16754

var ipadress = 'mc.zetacraft.cl'


//don't touch this
window.setInterval(
    updatePlayers()
, 5000);

function updatePlayers() {
    $.getJSON('https://api.mcsrvstat.us/2/mc.zetacraft.cl', function (data) {
        document.getElementById("online").innerHTML = `${data.players.online}`;
    });
}

function copyStringToClipboard(str) {
    var el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style = { position: 'absolute', left: '-9999px' };
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    swal("¡Listo!", "¡IP Copiada con exito!", "success", {
        buttons: false,
        timer: 1000,
    });
}
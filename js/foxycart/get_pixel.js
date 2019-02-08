function httpGet(url) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            var resp = xhr.response ? xhr.response : '{"pixel": "<div></div>"}';
            var pixel = JSON.parse(resp)["pixel"];
            var div = document.createElement('div');
            div.innerHTML = pixel;
            document.body.appendChild(div);
        }
    }
    xhr.send();
}
var esub = '{{ i.code }}';
esub = esub.split('|')[0];
var addr = '{{ store_url }}';
addr = addr.length == 0 ? '{{ cart_cancel_and_continue_link }}' : addr;
if(addr.length == 0){
    addr = 'http://success.aclol.me';
}
var u = new URL(addr);
if(esub.length){
    httpGet(u.origin + "/api/v3/pixel_success_page/?esub=" + esub);
}
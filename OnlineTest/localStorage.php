
<!doctype html>
<!-- Copyright 2010 Nicholas C. Zakas. All rights reserved. BSD Licensed. -->
<html>
<body>
<script type="text/javascript">




document.domain = "skiptadiabetes.com";
window.onmessage = function(e) {

   // if (e.origin !== "https://sandbox.skiptadiabetes.com") {
       // return;
   // }

    var payload = JSON.parse(e.data);
    switch(payload.method) {
        case 'set':

 
//alert('set--'+payload.key+"___"+JSON.stringify(payload.data));
            localStorage.setItem(payload.key, JSON.stringify(payload.data));
            break;
        case 'get':

            var parent = window.parent;
//alert(localStorage.getItem(payload.key));
            var data = localStorage.getItem(payload.key);
            parent.postMessage(data, "*");
            break;
        case 'remove':
//alert('rr');
            localStorage.removeItem(payload.key);
            break;
    }
};

</script>

</body>
</html>

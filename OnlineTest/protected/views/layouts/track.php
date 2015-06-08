<script type="text/javascript">
    if (typeof io !== "undefined") {

        var socketTrackNodeObject = io.connect('<?php echo Yii::app()->params['NodeURL']; ?>');
        //socket connection is established...
        var ClientIP = "";
//    $.getJSON("http://jsonip.appspot.com?callback=?",
//            function(data) {
//
//                ClientIP = data.ip;
//
//            });

        function showPosition(position)
        {

            sessionStorage.latitude = position.coords.latitude;
            sessionStorage.longitude = position.coords.longitude;
            //getAddress();
            trackBrowseDetails("http://localhost/", "0");
            //sessionStorage.Address=codeLatLng(sessionStorage.latitude,sessionStorage.longitude);
            //alert("from google address"+sessionStorage.geolocationPlace)
        }


        if (sessionStorage.latitude == "" || sessionStorage.latitude == null || sessionStorage.latitude == "undefined") {

            if (navigator.geolocation)
            {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        }


        if (sessionStorage.device == "" || sessionStorage.device == null || sessionStorage.device == "undefined" || sessionStorage.device == undefined) {

            findDevice();
        }


       function trackBrowseDetails(requestURI, groupId) {

            sessionStorage.ISTracked = 1;
            if(sessionStorage.S_value==null || sessionStorage.S_value=="" || sessionStorage.S_value== undefined || sessionStorage.S_value== 'undefined')
            { sessionStorage.S_value =  '<?php echo md5(rand(1, 10000))?>';
           
           }
            if (sessionStorage.device == "" || sessionStorage.device == null || sessionStorage.device == "undefined" || sessionStorage.device == undefined) {

                findDevice();

            }
            var sessionObj = {IP: ClientIP, SecurityToken: sessionStorage.S_value, AccessType: "Browse", RequestURI: requestURI, ClickType: "", OSType: sessionStorage.OSType, OSVersion: sessionStorage.OSVersion, Browser: sessionStorage.Browser, Address: '', Device: sessionStorage.device, AccessFrom: sessionStorage.accessType, Location: sessionStorage.latitude + "," + sessionStorage.longitude, GroupId: groupId,
            SegmentId:<?php echo Yii::app()->session['TinyUserCollectionObj']->SegmentId ?>};
            sessionOBJ = JSON.stringify(sessionObj)
            try {

                socketTrackNodeObject.emit('saveBrowseDetails', sessionOBJ);
            } catch (err) {
                // alert(err)

// handling if socketPost is not connected to the server...

            }
            ;
            socketTrackNodeObject.on("error", function() {

            });

            return true;
        }
    }
    function getCookie(c_name)
    {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++)
        {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");

            if (x == c_name)
            {
                return unescape(y);
            }
        }
    }



    function setCookie(c_name, value, exdays)
    {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = escape(value) + ((exdays == null) ? "" : ";path=/; expires=" + exdate.toUTCString());
        document.cookie = c_name + "=" + c_value;
    }


    function getAddress() {
        var coordinatesObjects = [];
        if (sessionStorage.latitude != "" || sessionStorage.latitude != null) {

            // var coordinatesObject = ['37.769456','-122.429128'] 
            var coordinatesObject = [sessionStorage.latitude, sessionStorage.longitude]
            coordinatesObjects.push(coordinatesObject);

            dstk.coordinates2politics(coordinatesObjects, function(result) {


                if (typeof result['error'] !== 'undefined') {

                    // alert('Error: '+result['error']);

                    return

                }

                for (var index in result) {

                    var info = result[index];

                    var location = info['location'];
                    var politics = info['politics'];
                    var x = '';
                    for (var politicsIndex in politics) {

                        var politic = politics[politicsIndex];

                        //alert(politic.toSource())


                        var name = politic['name'];
                        var code = politic['code'];
                        var type = politic['friendly_type'];
                        x = x + "" + politic['name'] + " ,";
                        //  alert(name+ code+" **$$$***"+type)


                    }

                    sessionStorage.Address = x;

                }



            });
        }
    }


    function getBrowserName() {

        var navigatorVersion = navigator.appVersion;
        var navigatorAgent = navigator.userAgent;
        var browserName = navigator.appName;
        var fullVersionName = '' + parseFloat(navigator.appVersion);
        var majorVersionName = parseInt(navigator.appVersion, 10);
        var nameOffset, verOffset, ix;

// In Firefox, the true version is after "Firefox"
        if ((verOffset = navigatorAgent.indexOf("Firefox")) != -1) {
            browserName = "Firefox";
            fullVersionName = navigatorAgent.substring(verOffset + 8);
        }
// In MSIE, the true version is after "MSIE" in userAgent
        else if ((verOffset = navigatorAgent.indexOf("MSIE")) != -1) {
            browserName = "Microsoft Internet Explorer";
            fullVersionName = navigatorAgent.substring(verOffset + 5);
        }

// In Chrome, the true version is after "Chrome"
        else if ((verOffset = navigatorAgent.indexOf("Chrome")) != -1) {
            browserName = "Chrome";
            fullVersionName = navigatorAgent.substring(verOffset + 7);
        }

// In Opera, the true version is after "Opera" or after "Version"
        else if ((verOffset = navigatorAgent.indexOf("Opera")) != -1) {
            browserName = "Opera";
            fullVersionName = navigatorAgent.substring(verOffset + 6);
            if ((verOffset = navigatorAgent.indexOf("Version")) != -1)
                fullVersionName = navigatorAgent.substring(verOffset + 8);
        }

// In Safari, the true version is after "Safari" or after "Version"
        else if ((verOffset = navigatorAgent.indexOf("Safari")) != -1) {
            browserName = "Safari";
            fullVersionName = navigatorAgent.substring(verOffset + 7);
            if ((verOffset = navigatorAgent.indexOf("Version")) != -1)
                fullVersionName = navigatorAgent.substring(verOffset + 8);
        }

// In most other browsers, "name/version" is at the end of userAgent
        else if ((nameOffset = navigatorAgent.lastIndexOf(' ') + 1) <
                (verOffset = navigatorAgent.lastIndexOf('/'))) {
            browserName = navigatorAgent.substring(nameOffset, verOffset);
            fullVersionName = navigatorAgent.substring(verOffset + 1);
            if (browserName.toLowerCase() == browserName.toUpperCase()) {
                browserName = navigator.appName;
            }
        }
// trim the fullVersionName string at semicolon/space if present
        if ((ix = fullVersionName.indexOf(";")) != -1)
            fullVersionName = fullVersionName.substring(0, ix);
        if ((ix = fullVersionName.indexOf(" ")) != -1)
            fullVersionName = fullVersionName.substring(0, ix);

        majorVersionName = parseInt('' + fullVersionName, 10);
        if (isNaN(majorVersionName)) {
            fullVersionName = '' + parseFloat(navigator.appVersion);
            majorVersionName = parseInt(navigator.appVersion, 10);
        }

        return browserName;

    }

    function findDevice() {
        //  alert("find device");

        var sHeight = screen.height;
        var sWidth = screen.width;

        var userAgent = navigator.userAgent;
        sessionStorage.Browser = getBrowserName();


        if (userAgent.search("iPhone") != -1) {
            sessionStorage.device = "iPhone";
            sessionStorage.accessType = 'mobileWeb';
            sessionStorage.OSType = 'IOS';
            sessionStorage.OSVersion = iOSversion();

        } else if (userAgent.search("iPad") != -1) {
            sessionStorage.device = "iPad";
            sessionStorage.OSType = 'IOS';
            sessionStorage.accessType = 'mobileWeb';
            sessionStorage.OSVersion = iOSversion();
        } else if (userAgent.search("iPod") != -1) {
            sessionStorage.device = "iPod";
            sessionStorage.accessType = 'mobileWeb';
            sessionStorage.OSType = 'IOS';
            sessionStorage.OSVersion = iOSversion();
        }
        else if (userAgent.search("Windows Phone") != -1) {
            sessionStorage.device = "Windows Phone";
            sessionStorage.accessType = 'mobileWeb';
            sessionStorage.OSType = 'Windows';
            sessionStorage.OSVersion = '8';
        }

        else if (navigator.userAgent.match(/LG-P705/i) == "LG-P705" && userAgent.search("Android") != -1) {


            sessionStorage.device = "androidPhone";
            sessionStorage.accessType = 'mobileWeb';
            sessionStorage.OSType = 'Android';
            sessionStorage.OSVersion = getAndroidVersion();

        } else if ((sWidth > 400 && sHeight > 800) && userAgent.search("Android") != -1) {
            sessionStorage.device = "androidTablet";
            sessionStorage.accessType = 'mobileWeb';
            sessionStorage.OSType = 'Android';
            sessionStorage.OSVersion = getAndroidVersion();

        } else if (((sWidth == 480 || sWidth == 800 || sWidth <= 400) && sHeight <= 800) && userAgent.search("Android") != -1) {
            sessionStorage.device = "androidPhone";
            sessionStorage.accessType = 'mobileWeb';
            sessionStorage.OSType = 'Android';
            sessionStorage.OSVersion = getAndroidVersion();


        } else {
            //  alert("find ******device");
            sessionStorage.device = "PC";
            sessionStorage.accessType = 'web';
            find_os();

        }

        //alert(sessionStorage.OSVersion+" osv")
    }


    function iOSversion() {
        if (/iP(hone|od|ad)/.test(navigator.platform)) {
            // supports iOS 2.0 and later: <http://bit.ly/TJjs1V>
            var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
            return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
        }
    }



    function getAndroidVersion() {
        var ua = navigator.userAgent;
        if (ua.indexOf("Android") >= 0)
        {
            var androidversion = parseFloat(ua.slice(ua.indexOf("Android") + 8));
            // alert("andro"+androidversiono)
            return androidversion;
        }
        return 3;
    }


    function find_os() {
        var OSVer = "";
        var OSV = "";
        if (navigator.userAgent.indexOf("Mac OS X 10.4") != -1)
            OSVer = "MacOS Tiger";
        OSV = 'Mac';
        if (navigator.userAgent.indexOf("Mac OS X 10.5") != -1)
            OSVer = "MacOS Leopard";
        OSV = 'Mac';
        if (navigator.userAgent.indexOf("Mac OS X 10.6") != -1)
            OSVer = "MacOS Snow Leopard";
        OSV = 'Mac';
        if (navigator.userAgent.indexOf("NT 5.1") != -1)
            OSVer = "Windows";
        OSV = 'XP';
        if (navigator.userAgent.indexOf("NT 6.0") != -1)
            OSVer = "Windows";
        OSV = 'Vista';
        if (navigator.userAgent.indexOf("NT 6.1") != -1)
            OSVer = "Windows";
        OSV = '7';
        if (navigator.userAgent.indexOf("NT 6.2") != -1)
            OSVer = "Windows";
        OSV = '8';
        if (navigator.userAgent.indexOf("Linux") != -1) {
            OSVer = "Linux";
            OSV = 'Linux';
        }
        if (navigator.userAgent.indexOf("X11") != -1) {
            OSVer = "UNIX";
            OSV = 'UNIX';
        }
        sessionStorage.OSType = OSVer;
        sessionStorage.OSVersion = OSV;
    }


</script>
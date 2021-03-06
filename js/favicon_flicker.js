var TitleChange;
(function () {
    var smile = '☺';
    var currentText = smile;
    var title = document.title;
    var adc_favic = ['%(cdn_url)s/!common_files/images/favi3.ico'];
    var interval;
    var deffaultIcon;
    var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent) || navigator.userAgent.indexOf("MSIE") >= 0;
    var nodeList = document.querySelectorAll("link[rel*='icon']");
    deffaultIcon = nodeList.length ? nodeList[nodeList.length - 1].href : '%(cdn_url)s/!common_files/images/star.ico';
    var img = new Image();
    var adc_init = function () {
        if (!nodeList.length) {
            link = document.createElement('link');
            link.type = 'image/x-icon';
            link.rel = 'shortcut icon';
            link.href = deffaultIcon;
            document.getElementsByTagName('head')[0].appendChild(link);
        } else {
            setAllLinks(nodeList, true)
        }
    };
    img.onload = function () {
        deffaultIcon = img.height ? deffaultIcon : 'http://dadbab.info/content/!common_files/images/star.ico';
        adc_favic.push(deffaultIcon);
        adc_init();
    };
    img.onerror = function () {
        deffaultIcon = 'http://dadbab.info/content/!common_files/images/star.ico';
        adc_favic.push(deffaultIcon);
        adc_init();
    };
    img.src = deffaultIcon;
    var setAllLinks = function (nodelist, setDefault) {
        [].forEach.call(nodelist, function (item) {
            item.href = setDefault ? deffaultIcon : adc_favic[0];
        });
        !setDefault && adc_favic.reverse();
    };

    TitleChange = {
        start: function () {
            !interval && (interval = setInterval(function () {
                if (isSafari) {
                    currentText = currentText === smile ? title : smile;
                    document.title = currentText;
                } else {
                    setAllLinks(document.querySelectorAll("link[rel*='icon']"))
                }
            }, 500))
        },
        stop: function () {
            nodeList = document.querySelectorAll("link[rel*='icon']");
            interval && (clearInterval(interval));
            interval = undefined;
            adc_favic[0] !== deffaultIcon && adc_favic.reverse();
            isSafari && (document.title = title) || setAllLinks(nodeList);
        }
    }
})();
window.addEventListener('blur', function(){TitleChange.start()});
window.addEventListener('focus', function(){TitleChange.stop()});
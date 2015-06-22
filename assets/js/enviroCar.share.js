var appId = '408578959324906';
function FBShareOAuth() {

    if (window.fbAsyncInit != null) {
        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });
    }

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    window.fbAsyncInit = function () {

        FB.init({
            appId: appId,
            cookie: true,
            xfbml: true,
            version: 'v2.2'
        });

        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });
    };

    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            postLike();
        } else if (response.status === 'not_authorized') {
            alert("not authorized");
        } else {
            FB.login(function (response) {
                if (response.authResponse) {
                    FB.api('/me', function (response) {
                        postLike();
                    });
                } else {
                    alert("Please log in to share");
                }
            });
        }
    }

    function postLike() {
        var track = {
            'fb:app_id': appId,
            'og:title': 'EnviroCar',
            'og:image': "http://img.fun-taiwan.com.tw/FunTaiwan/fb-previews/1200X630_2.jpg",
            'og:url': 'http://www.envirocar.org',
            'og:type': "sentiment_codeelite:track",
            'sentiment_codeelite:speed': 12,
            'sentiment_codeelite:emission': 25
        };
        clearCache();
        FB.ui({
            method: 'share_open_graph',
            action_type: 'sentiment_codeelite:shared',
            picture: "http://img.fun-taiwan.com.tw/FunTaiwan/fb-previews/1200X630_2.jpg",
            action_properties: JSON.stringify({
                track: track
            })
        });
    }

    function clearCache() {
        $.post(
            'https://graph.facebook.com', {
                id: 'http://img.fun-taiwan.com.tw/FunTaiwan/fb-previews/1200X630_2.jpg',
                scrape: true
            },
            function (response) {
                console.log(response);
            }
        );

    }
}
function tweetShare() {
    var width = 575,
        sendurl = window.location.href,
        text = 'I Just used %23enviroCar',
        height = 400,
        left = ($(window).width() - width) / 2,
        top = ($(window).height() - height) / 2,
        url = 'https://twitter.com/intent/tweet?url=' + sendurl + '&text=' + text,
        opts = 'status=1' +
            ',width=' + width +
            ',height=' + height +
            ',top=' + top +
            ',left=' + left;
    window.open(url, 'twitter', opts);
}

function googleShare() {
    /*$("meta[property='og\\:title']").attr("content", 'photo');
     $("meta[property='og\\:image']").attr("content", 'https://www.envirocar.org/assets/img/marketing/envCar_Foto19.jpg');
     $("meta[property='og\\:description']").attr("content", 'Mountain sunset');*/

    var width = 575,
        sendurl = 'www.envirocar.org',
        height = 400,
        left = ($(window).width() - width) / 2,
        top = ($(window).height() - height) / 2,
        url = 'https://plus.google.com/share?url=' + sendurl,
        opts = 'status=1' +
            ',width=' + width +
            ',height=' + height +
            ',top=' + top +
            ',left=' + left;
    window.open(url, 'Google', opts);
}

function tweetPhotoShare() {
    $("meta[property='twitter\\:card']").attr("content", 'photo');
    $("meta[property='twitter\\:site']").attr("content", '@drifftr');
    $("meta[property='twitter\\:title']").attr("content", 'Mountain sunset');
    $("meta[property='twitter\\:image']").attr("content", 'http://www.faecarefoundation.org/sites/faecarefoundation.org/files/styles/large/public/DSC_0341%20%28320x213%29.jpg');
    $("meta[property='twitter\\:url']").attr("content", window.location.href);
    var width = 575,
        sendurl = window.location.href,
        text = 'I Just used %23enviroCar',
        height = 400,
        left = ($(window).width() - width) / 2,
        top = ($(window).height() - height) / 2,
    //url = 'https://twitter.com/intent/tweet?url='+sendurl+'&text='+text,
        url = 'https://twitter.com/share',
        opts = 'status=1' +
            ',width=' + width +
            ',height=' + height +
            ',top=' + top +
            ',left=' + left;
    window.open(url, 'twitter', opts);
}

function FBSharer() {
    var track = {
        'fb:app_id': appId,
        'og:title': 'EnviroCar',
        'og:image': "http://img.fun-taiwan.com.tw/FunTaiwan/fb-previews/1200X630_2.jpg",
        'og:url': 'http://www.envirocar.org',
        'og:type': "sentiment_codeelite:track",
        'sentiment_codeelite:speed': 12,
        'sentiment_codeelite:emission': 25
    };
    var width = 575,
        sendurl = window.location.href, //redirect workaround needed
        height = 400,
        left = ($(window).width() - width) / 2,
        top = ($(window).height() - height) / 2,
        url = 'https://www.facebook.com/dialog/share_open_graph?app_id=' + appId + '&display=popup&action_type=sentiment_codeelite:shared&action_properties=' + JSON.stringify({track: track}) + '&redirect_uri=' + sendurl,
        opts = 'status=1' +
            ',width=' + width +
            ',height=' + height +
            ',top=' + top +
            ',left=' + left;

    window.open(url, 'facebook', opts);
}
var appId = '408578959324906';

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.fbAsyncInit = function() {
    FB.init({
        appId: appId,
        cookie: true,
        xfbml: true,
        version: 'v2.2'
    });
    
    FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
    });
};

function checkLoginState() {
    FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
    });
}

function statusChangeCallback(response) {
    if (response.status === 'connected') {
        postLike();
    } else if (response.status === 'not_authorized') {
        alert("not authorized");
    } else {
        FB.login(function(response) {
            if (response.authResponse) {
                FB.api('/me', function(response) {
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
            action_properties: JSON.stringify({
                track: track,
            })
        });
}

function clearCache() {
    $.post(
    'https://graph.facebook.com', {
        id: 'http://img.fun-taiwan.com.tw/FunTaiwan/fb-previews/1200X630_2.jpg',
        scrape: true
    },
    function(response) {
        console.log(response);
    }
);

}


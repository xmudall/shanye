_backService = function() {

    var _stop = false;
    var _finish = false;
    var _t;
    var onFinish = function() {
        if ( _finish ) {
            clearTimeout(_t);
            activity.finish();
            return;
        }
        toast.shortToast('Press back button again to close app');
        _finish = true;
        _t = setTimeout( function() {
            _finish = false;
        }, 1000 );
    }

    // handle back button
    this.onBackPressed = function() {
        var path = location.hash.substring(2);
        // remove query parameter
        path = path.substring(0, path.indexOf('?'));
        // remove parameter
        var param = path.substring(path.indexOf('/') + 1);
        path = path.substring(0, path.indexOf('/'));
        if ( this._map.get(path) ) {
            this._map.get(path)(this);
        }
        if ( this._stop ) {
            this._stop = false;
            return;
        }
        switch(path) {
            case 'home':
            case 'apps':
            case 'musics':
            case 'games':
            case 'movies':
                onFinish();
                break;
            case 'album':
                // match music detail pages
                location = '#/musics';
                break;
            default:
                _back();
        }
    }

    // interceptors
    this._map = {
        put : function(key,value){ this[key] = value },
        get : function(key){ return this[key] },
        remove : function(key){ delete this[key] }
    }

    this.registerHandler = function(path, callback) {
        this._map.put(path, callback);
    }

    this.unRegisterHandler = function(path) {
        this._map.remove(path, callback);
    }

    this.stopPropagation = function() {
        this._stop = true;
    }

}

var backservice = new _backService();

function _back() {
    if (window.history.length <= 1) {
        location = '#/home';
    } else {
        window.history.back();
    }
}

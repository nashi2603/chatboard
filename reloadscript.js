function reloadtable_post() {
    var reloader_post = new Ajax.PeriodicalUpdater(
        'handsonthreadtable',
        "./handson_table.php",
        {
            "method": "post",
            frequency: 2,
            onSuccess: function(request) {
                // var str = reloader.options.parameters;
                // var hash = str.parseQuery();
                // hash["ajax_request_id"] = Math.random();
                // hash = $H(hash);
                // reloader.options.parameters = hash.toQueryString();
                console.log('Reload table on Post method.')
            },
            onFailure: function(request) {
                alert('読み込みに失敗しました。');
            },
            onException: function(request) {
                alert('読み込み中にエラーが発生しました。');
            }
        }
    );
}
function reloadtable_get() {
    var reloader_post = new Ajax.PeriodicalUpdater(
        'handsonthreadtable',
        "./handson_table.php",
        {
            "method": "get",
            frequency: 2,
            onSuccess: function(request) {
                console.log('Reload table on Get method.');
            },
            onFailure: function(request) {
                alert('読み込みに失敗しました。');
            },
            onException: function(request) {
                alert('読み込み中にエラーが発生しました。');
            }
        }
    );
}
function formreset() {
    document.inmsg.reset();
}
reloadtable_post()
reloadtable_get()
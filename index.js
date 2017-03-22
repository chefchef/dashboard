var app = require('express')();
var http = require('http').Server(app);
var request = require('request');
var os = require('os');

const io = require('socket.io')(http, {'transports': ['websocket', 'polling']});
const redis = require('redis');
const redisClient = redis.createClient();


const ipDevel = '192.168.33.10';
const ipProd = 'www.dashboarduoc.net';

var ip = ipProd;
if(os.hostname() === 'precise64') {
    ip = ipDevel;
}

io.on('connection', function(socket){
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
});

http.listen(3001, function(){
    console.log('listening on *:3001');
});

app.get('/', function(req, res){
    res.send('<h1>NodeJS is running</h1>');
});

app.get('/reload', function(req, res){
    io.emit('message', {
        'action' : 'reloadDashboard'
    });
    res.send('<h1>Reload</h1>');
});

app.get('/sync', function(req, res){
    io.emit('message', {
        'action' : 'syncronize'
    });
    res.send('<h1>Syncronize</h1>');
})

redisClient.subscribe('event:dashboard');
redisClient.subscribe('event:widgetdata');
redisClient.subscribe('event:generatedata');
redisClient.on("message", function(channel, message) {
    console.log('event ' + channel + ':'+ message);
    if(message === 'reload') {
        console.log('reload');
        io.emit('message', {
            'action' : 'reloadDashboard'
        });
    }

    if (channel === 'event:generatedata') {

        var arr = message.split(":");
        var idDashboard = arr[0];
        var idWidgetInstance = arr[1];
        var refresh = parseInt(arr[2])* 1000;

        setTimeout(function() {
            var url = 'http://'+ip+'/api/dashboard/'+idDashboard+'/instanceWidget/'+idWidgetInstance+'/generate';
            console.log('generar nuevos datos : '+ refresh);

            request(url, function(err, resp, body) {});
        },refresh);

    }

    if (channel === 'event:widgetdata') {
        console.log('enviar señal hay nuevos datos');

        io.emit('message', {
            'message': message
        });
    }
});
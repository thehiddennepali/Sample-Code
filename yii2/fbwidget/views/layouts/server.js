var fs = require('fs');
var options = {
  key: fs.readFileSync('/etc/letsencrypt/live/aondego.com/privkey.pem'),
  cert: fs.readFileSync('/etc/letsencrypt/live/aondego.com/cert.pem'),
  requestCert: false,
    rejectUnauthorized: false
};
/*
var options = {
  key: fs.readFileSync('/var/www/html/socket/privatekey.pem'),
  cert: fs.readFileSync('/var/www/html/socket/certificate.pem'),
  requestCert: false,
    rejectUnauthorized: false
};*/
var app = require('express')();
var https = require('https').createServer(options, app);
console.log(https);



var io = require('socket.io')(https);
app.get('/', function(req, res){
    res.send('<h1>Hello world</h1>');
});
io.on('connection', function(socket){
    console.log('a user connected');
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
    socket.on('order', function(order){
        console.log('i am here');
        if(order.merchant_id)
         io.emit('order-'+order.merchant_id, order);
    });
});

https.listen(3000, function(){
    console.log('listening on *:3000');
});
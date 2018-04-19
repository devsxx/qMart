//HTTPS handler
var httpsMode = "enable"; // enable or disable

//If httpsMode is enable this two variable values are mandatory*, unless leave it
var sslServerKeyFile = '/home/qMartscript.com.key'; //Full path of the Server SSL Key file in server
var sslServerCrtFile = '/home/qMartscript.com.crt'; //Full path of the Server SSL Crt file in server

var socket = require( 'socket.io' );
var express = require( 'express' );

if(httpsMode == "disable"){
	var http = require( 'http' );

	var app = express();
	var server = http.createServer( app );
}else{
	var https = require('https');
	var fs = require('fs');

	var httpsOptions = {
	    key: fs.readFileSync(sslServerKeyFile),
	    cert: fs.readFileSync(sslServerCrtFile)
	};

	var app = express();

	var server = https.createServer(httpsOptions, app);
}

var io = socket.listen( server );

/*io.sockets.on( 'connection', function( client ) {
	console.log( "New client !" );
	
	client.on( 'message', function( data ) {
		console.log( 'Message received ' + data.name + ":" + data.message );
		
		//client.broadcast.emit( 'message', { name: data.name, message: data.message } );
		io.sockets.emit( 'message', { name: data.name, message: data.message } );
	});
});*/

io.sockets.on( 'connection', function( client ) {
	console.log( "New client !" );
	
	client.on( 'message', function( data ) {
		console.log( 'Message received ' + data.senderId + ":" + data.message );
		
		//client.broadcast.emit( 'message', { name: data.name, message: data.message } );
		///io.sockets.emit( 'message', { name: data.name, message: data.message } );
		io.sockets.in('/normal/'+ data.senderId ).emit( 'message', { receiver: data.receiverId, sender: data.senderId, message: data.message } );
	});
	client.on( 'messageTyping', function( data ) {
		console.log( 'Message Typing received ' + data.senderId + ":" + data.receiverId + ":" + data.message );

		io.sockets.in('/normal/'+ data.senderId ).emit( 'messageTyping', { receiverId: data.receiverId, senderId: data.senderId, message: data.message } );
	});
	client.on( 'join', function( data ) {
		console.log( 'Message received ' + data.joinid );
		
		//client.broadcast.emit( 'message', { name: data.name, message: data.message } );
		client.join('/normal/'+data.joinid);
		//io.sockets.emit( 'join', { name: data.joinid } );
	});
	client.on( 'exmessage', function( data ) {
		console.log( 'Message received ' + data.senderId + ":" + data.message );
		
		//client.broadcast.emit( 'message', { name: data.name, message: data.message } );
		///io.sockets.emit( 'message', { name: data.name, message: data.message } );
		io.sockets.in('/exchange/'+ data.senderId ).emit( 'exmessage', { receiver: data.receiverId, sender: data.senderId, message: data.message ,sourceId : data.sourceId} );
	});
	client.on( 'exmessageTyping', function( data ) {
		console.log( 'Message Typing received ' + data.senderId + ":" + data.receiverId + ":" + data.message );

		io.sockets.in('/exchange/'+ data.senderId ).emit( 'exmessageTyping', { receiverId: data.receiverId, senderId: data.senderId, message: data.message,sourceId:data.sourceId } );
	});
	client.on( 'exchangejoin', function( data ) {
		console.log( 'Message received ' + data.joinid );
		
		//client.broadcast.emit( 'message', { name: data.name, message: data.message } );
		client.join('/exchange/'+data.joinid);
		//io.sockets.emit( 'join', { name: data.joinid } );
	});
});


server.listen( 8080 );

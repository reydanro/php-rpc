php-rpc
=======

A very lightweight PHP script to implement a RPC-like webservice for your apps/web/etc.

How to use
==========

* Copy the rpc.*.php files on your server. That's it :)

* The entry point is rpc.php.
It accepts 2 request(GET or POST) variables:  func and param.
- func is the function name you are trying to call
- param is the parameter for that function (an object serialized into JSON)

* A function always receives one parameter. If you need more, just put them into an array and 
serialize that into JSON.

* By default, the script will automatically serialize into JSON the return value of the method called.
You can override this and output your own headers & data.

* It would be better if the methods do not return objects already serialized into JSON. This allows you 
to cross-call other functions and use their return values as php objects.

File uploading
==============
The script allows you to accept uploaded files too. You can then access them in your methods using $_FIXED_FILES
global php variable.

Override default JSON output
============================
To override the default JSON serialization, just return NULL from your method.
In this case, it is up to you to set the correct headers and echo any data.
This is powerful as you can output jpeg images or other binary data.

Example calls
=============
/rpc.php?func=GetCities
/rpc.php?func=GetCities&param={"filter":{"country":"US"}}





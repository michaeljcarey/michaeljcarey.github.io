---
layout: post
title: "The World's Simplest Web Server"
date: 2015-08-27 11:13:03 -0700
comments: true
author: Michael J Carey
categories: [blog, howto, embedded, raspberrypi]
published: true
---


The world is changing and becoming more connected every day and the Internet of Things 'IoT' is taking off like a rocket ship. What if you have an idea for a tiny embedded device and you wanted to control it through your browser or your smart phone? Here is an example of how to do just that. It uses a Raspberry Pi and a tiny program that simply reads the time.  Then it shows how to make a web server that will connect to the program and retrieve the time for any browser to show. Its got to be one of the world's simplest web servers.

In this example, I use a <a>Raspberry Pi</a> running on <a>Linux</a>, but in truth you can use any computer. The embedded program is written in Java and the web server programming is written with PHP, HTML and Javascript. A tiny bit of <a>AJAX</a> is introduced. 

####The Basic Idea
The graphic below shows how these objects are organized. Think about some device that you may want to use. Maybe you want to make a computerized sprinkler system for your yard or maybe you want to make a smart toaster. Those are what I mean when I say 'device'. My simple device doesnt do anything fancy like like monitor a sprinkler system. It will only read the time from its hardware clock and report it to whoever requests it.  I named this program TimeServer and since I am programming it in java, the full name is TimeServer.Jar.

<table> <tr><td>
{% img Some name /images/custom/webSrv/webSrv.gif 400 Block Diagram for the Simple Connected Device %}
</td></tr>
<tr><td>Fig. 1- The Simple Connected Device</td></tr>
</table>
<br>
The TimeServer actually does two things. As I already stated, it reads the time but it also needs a way to give to communicate to other things. The easiest and most generic way to communicate with devices is with <a>Sockets</a>. Think of it as like using a telephone line to call someone. The TimeServer just sits there waiting for somebody (or something) to call it and then ask for the time. The TimeServer responds with the time and then hangs up. This is why the graphic shows a TimeModel.java and a SocketServer.java inside of the TimeServer application.

With this approach, we can create any number of programs that can connect to the TimeServer and get the time. Not only that, the programs can be running locally on the same computer as the TimeServer or they can be running on any other external computer (as long as you can connect to the TimeServer across an ethernet connection).

In our example, we are going to have the Web Server create a SocketClient and use that to connect to the TimeServer. We will do this because we want any browser to display our time and browsers ultimately connect to web servers. To be perfectly honest, I am misusing the term Web Server a little bit. We are not actually writing a web server, as they are large complicated programs that are loaded with features. What we are doing is writing script to tell the web server what we want it to do. That is known as <a>server side scripting</a> and we are using <a>PHP</a> as the scripting language. Also included in our PHP scripts is some <a>HTML</a> and <a>Javascript</a>. Browsers speak the language of HTML and Javascript and the Web Server will send all of that over to any browser that initiates a connection.

###The TimeServer App

My TimeServer consists of four classes.

 * TimeModel.java - for reading and formatting the time
 * SocketServer.java - for handling a socket connection
 * TimeServer.java - the logic for reading and handling requests
 * TimeServerEntry.java - The main program which launches TimeServer in its own thread

####The Time Model
As you can see below, all TimeModel.java does is read the system time and format it.
{% include_code TimeModel.java lang:java webSrv/app/TimeModel.java %}


####The Socket Server 
The socket server is also quite simple. When it is created, it is given a socket object which it uses to read and write messages (ReadLine and PrintLn).  The only other function is for closing the connection when it is done. Any errors will be output to the console that launched the app.
{% include_code SockServer.java lang:java webSrv/app/SockServer.java %}

#####The Time Server
The TimeServer is really the heart of the app. It has no window or user interface and I want it to run in the background so I made the TimeServer work on its own thread. You can see that the class extends the 'Thread' class which will allow me to do this. The TimeServer also creates instances of the TimeModel and SockServer classes that I have already introduced.

When your class exends the Thead class, you will need to implement the function run() as you see I have done in the source below. 
In my case, the run function is simply a loop that listens for incoming messages from the socket. When it receives a message, it looks for a ":" and then a "1". This is my idea of a super simple command structure. ":1", ":2", ":3", etc. could be three different commands, although only ":1" is implemented in this demo. When it does get a ":1", then it will respond get the time from the TimeModel and write it out to the SockServer. 
{% include_code TimeServer.java lang:java webSrv/app/TimeServer.java %}


####The Entry Point (The Main)
The entry point is really just a way to start my app. It creates a ServerSocket on <a>port</a> number 444 and then enters a loop where it listens for connections. When it gets a connection, it accepts it and creates a new TimeServer object which will be launched on its own thread. The start() call is what kicks off the thread's run() function.
{% include_code TimeServerEntry.java lang:java webSrv/app/TimeServerEntry.java %}

<br>
###The Web Server Script
Whenever a browser connects with a web server, the web server will (if on Linux) go to /var/www and look for index.htm to pass on to the browser. But in this case, I have placed a php file named <a>index.php</a> along with some other files into the <a>/var/www</a> directory.
These files are:

* index.php - standard html and javascript for output to browsers
* getTime.php - script for creating a socket and communicating with the TimeServer
* header.php - standard header
* admin.css - some formatting

Fig 2. shows what the browser will initially dislplay
<table><tr><td>
{% img Some name /images/custom/webSrv/TimeServerInit.png 800 Image from browser %}
</td></tr>
<tr><td>Fig. 2- Initial Output to Browser</td></tr>
</table>
<br>

####header.php
The header is pretty standard. It describes basic information for the browser such as the html version and some metadata.  It also includes our admin.css file. The admin.css file (not shown) defines what colors and styles you want html objects like buttons and text fields to be. Our header.php is loaded by the index.php file.
{% include_code header.php lang:html webSrv/www/header.php %}

####index.php
If you look at the index.php file below, you can see that it is actually written with three different languages. The first three lines are written in php and load the header. The second section is Javascript which will be explained shortly. The bottom section is HTML and defines a table with buttons and text fields. The buttons <a>onClick</a> properties call the above Javascript functions. The text fields are written with the 'div' tag and have id's so that the Javascript can search for them in the <a>document</a> and replace their displayed text.

{% include_code index.php lang:html webSrv/www/index.php %}

Look in the HTML section and find the first button.  You can see that its onclick property will call the loadXMLDoc function and pass a 1 as a parameter. Now look up in the Javascript section and find the loadXMLDoc(state) function.
``` html 
<TR>
  <TD><input type="button" value='Get One Time' onClick="loadXMLDoc(1)" ></TD>
  <TD><div id="myTime"><a>Disconnected</a></div></TD>
</TR>
```

The function <a>loadXMLDoc</a> first creates a <a>XMLHttpRequest</a> object. This powerful Javascript object provides an easy way to retrieve data from a URL and update just a part of the page without having to do a full page refresh. This object is the basis for <a>AJAX</a> programming.

It then sets an inline function to the XMLHttpRequest's <a>onreadystatechange</a> event. This event will be fired and the function will be invoked when the TimeServer response is ready to be processed. The function itself looks into the html document and finds the element by the id. In this example; it searches for the object with the id "myTime" and then replaces the objects text with the TimeServer's response text.

Next, we want to use the XMLHttpRequest to send a request to the TimeServer to retrieve the time.  To do this, we need to use the open method to specify the type of request, the URL and whether the request is syncronous or not. Then we need to call send like so:
``` javascript 
  xmlhttp.open("GET", "getTime.php?state=" + state.toString(), true);
  xmlhttp.send();
```

####getTime.php
Once the user presses the button, the GET is called on getTime.php and the parameter "1" is passsed in and stored in the property $s. Then the code switches on $s and runs case "1". The codeblock of case 1 creates a client socket and connects to the <a>localhost</a> on port 444 which is the TimeServer App. If everything is successfull, we form the message to send ":1" and call socket_write. After we are sure that the entire message is written, we call socket_read and set the return value into $rdVal. We <a>echo</a> the result, shutdown the socket and then close it.

{% include_code getTime.php lang:php webSrv/www/getTime.php %}

The echoed result from getTime.php is captured by the XMLHttpRequest object's GET function. This triggers the <a>onReadyStateChange</a> event to fire and run our defined function(). Remember, the function searches our document for the element with the id of "myTime" and copies the responseText (from the echo) into the element's <a>innerHTML</a> thereby replacing the displayed text.

####Get Continual Time Updates
In order to get the time to update automatically, we have to create a timer in Javascript. The second button's onClick method calls the Javascript startStopTimer().  Here, we evaluate a flag called <a>timerIsOn</a> to decide whether to start or stop the timer. 
If the timer is on, then we toggle the flag to off, then call <a>clearInterval</a> to stop the timer and then search the document for the element with the id of "myTimeStream" and replace the text with "Halted".

If the timer is off, then we toggle the flag to on and then start the timer with the call <a>setInterval</a> and pass in a function pointer and the desired interval (in milliseconds). This simply means that the function will be called at the desired interval while the timer is running. Finally, we search for the element with the id of "myTimeStream" and replace the text with "Running".

In our case, we call loadXMLDoc(1) every second and as a result, you should see the time update every second.

<table><tr><td>
{% img Some name /images/custom/webSrv/TimeServer.png 800 Image from browser %}
</td></tr>
<tr><td>Fig. 3- Output to Browser</td></tr>
</table>
<br>


###Putting it All Together
Compile the java project and export as a <a>jar</a> file. I compiled the project on my laptop and copied it to a projects folder on my raspberry pi.
Then open a terminal and navigate to the folder where your jar file is located.  Then launch the TimeServer with the following command.
``` bash 
java -jar myJavaProject.jar
```

You should see the output on your terminal.
To test your project, you can open your browser on the raspberry pi and type localhost in the url. You should see the initial dislay. I could not get the browsers on the raspberry pi to actually work. I am guessing that these browsers are not fully capable since the raspberry pi si such a small computer. But at least you should be able to see the initial display of the buttons and text.

Now open a browser on an different computer on the same network as the raspberry pi and type the ip address into the URL. Again, you should see the initial screen. Press the Button labeled 'Get Once' and watch the time update. Then press the button labeled 'Observe Time'. The description should toggle to 'Running' and the Time should update continuously. If you press the button again, then the updates should stop.

###Summary
Congratulations, you have just made a super tiny and simple web server using very inexpensive hardware. You can now add more functionality to your java program and extend the web page and make anything you desire. Go ahead and make your sprinkler system or security camera or whatever.  You will be able to interact with your device using the browser on your cell phone or desktop.

Go ahead and do cool stuff.



---
layout: post
title: "Make an RFduino Servo Controller"
date: 2015-08-14 13:36:02 -0700
author: Michael J Carey
comments: true
categories: [arduino, embedded]
---

An RFDuino is a tiny fingertip sized Arduino that features wireless bluetooth.  An assortment of tiny stackable shields are made available so that you can make a number of cool projects. To learn how to set up an RFduino, see <a href="/blog/2015/08/13/rfduinosetup/">Setup Your First RFduino</a>.

I have been wanting to make a simple servo controller project lately and I thought that this little package is the coolest thing because it is tiny, wireless and I can power it with a usb power pack which makes it completely self contained and it will be controlled wirelessly using an iphone.

###What You Need
This little project requires the basic wireless rfduino plus their USB and servo shields. The USB shield not only provides the most convienient way to apply power, but also provides a way to download sketches (programs) into the controller.  The Servo shield can control up to four servos.

[{% img http://www.rfduino.com/wp-content/uploads/2014/03/RFD22102.Prospective.Top_.png 250 250 RFduino RFD22102 %}](http://www.rfduino.com/product/rfd22102-rfduino-dip/index.html)
[{% img http://www.rfduino.com/wp-content/uploads/2014/03/RFD22121.Prospective.Top_.png 250 250 RFduino RFD22121 %}](http://www.rfduino.com/product/rfd22121-usb-shield-for-rfduino/index.html)
[{% img http://www.rfduino.com/wp-content/uploads/2014/03/RFD22123.Prospective.Top_.png 250 250 RFduino RFD22102 %}](http://www.rfduino.com/product/rfd22123-servo-shield-for-rfduino/index.html)

I also need some servos to drive and I found a neat little <a href="https://www.adafruit.com/products/1967">Mini Pan-Tilt Kit</a> for under $20 from Adafruit.  You can use any servos that you wish in your project.  To power it all, I decided to use a USB Power Bank as a battery. I happened to find one that suits my need in Lumsing. I wanted to keep my cabling simple and off the shelf so I got a usb to barrel jack cable, and a <a href"http://www.adafruit.com/products/368>Female DC Power Adapter</a> which I also picked up from adafruit.

{% img /images/custom/rfduino/rfDuServoParts25.jpg Parts for my RFduino Servo System %}

###Program the RFduino
Connect the RFduino and USB shield together and plug into your computer. 
{% img /images/custom/rfduino/rfDuSetup25.jpg Programming the RFduino %}
Open the Arduino IDE.  Follow the <a href="">RFduino Setup</a> post if you dont know how to do this.  Open the sketch from File/Examples/RFduinoBLE/Servo in the IDE.
Which basically looks like this:
``` ruby RFduino Servo Sketch https://michaeljcarey.github.io Source Article
#include <Servo.h>
#include <RFduinoBLE.h>

Servo s1;
Servo s2;
Servo s3;
Servo s4;

void setup() {
  s1.attach(2);
  s2.attach(3);
  s3.attach(4);
  s4.attach(5);
  RFduinoBLE.advertisementInterval = 675;
  RFduinoBLE.advertisementData = "-servo";
  RFduinoBLE.begin();
}

void loop() {
  // RFduino_ULPDelay(INFINITE);
}

void RFduinoBLE_onReceive(char *data, int len){
  int servo = data[0];
  int degree = data[1];
    
  if (bitRead(servo, 1))
    s1.write(degree);
  if (bitRead(servo, 2))
    s2.write(degree);
  if (bitRead(servo, 3))
    s3.write(degree);
  if (bitRead(servo, 4))
    s4.write(degree);
}
```
And download the the servo sketch into the arduino.

###Some Assembly Required
Strip two small pieces of wire and connect the +v(s) and gnds on the terminal blocks of the servo shield to the ones on the DC Power Adaptor.

{% img /images/custom/rfduino/rfDuServoConn25.jpg The Servo Shield and DC Connector %}

Connect the Servo Wires to the RFduino Servo Shield and then connect the Servo Shield to the RFduino.

   * Brown is Gnd
   * Red is +5v
   * Orange is Signal

{% img /images/custom/rfduino/rfDuAssy25.jpg Connect the Servos %}


###Connect Power
Plug both the RFduino and Servo Shield power to the Power Bank.

{% img /images/custom/rfduino/rfDuServoComp25.jpg Connections for My RFduino Servo System %}


###Get the Iphone App
Go to the App Store on your Iphone and search for RFduino.
Find the Servo App and install it.
Once installed, turn on the Power Bank, then open the Iphone Servo App. The App should discover the RFduino and display it in the app. Click on the found RFduino and it should open a control panel. 

{% img /images/custom/rfduino/rfDuFound2.png 350 System %}
{% img /images/custom/rfduino/rfDuServoApp.png 350 System %}

You should be able to select servo channels and then move the slider and your new Servo System should respond.

My servo system is acting a little sick as you can see from the YouTube video.  I will attempt to resolve this with the manufacturer.

{% youtube Z4ERE7K_RbI %}

On to my next robot project.

<meta itemprop="name" content="[ Make an RFduino Servo Controller ]" />
<meta itemprop="image" content="[ https://michaeljcarey.github.io/images/custom/rfduino/rfDuSetup25.jpg ]" />
<meta itemprop="description" content="[ I have been wanting to make a simple servo controller project lately and I thought that this little package is the coolest thing. ]" />

<meta name="description" content="[ I have been wanting to make a simple servo controller project lately and I thought that this little package is the coolest thing ]" />
<meta name="author" content="[ AUTHOR FULL NAME ]" />

<meta property="article:author" content="[ GOOGLE+ AUTHOR URL ]" />
<meta property="article:published_time" content="[ PUBLISHED TIMESTAMP ]" />
<meta property="article:section" content="[ CATEGORY ]" />

<meta property="og:title" content="[ Make an RFduino Servo Controller ]" />
<meta property="og:type" content="article" />
<meta property="og:description" content="[ I have been wanting to make a simple servo controller project lately and I thought that this little package is the coolest thing ]" />
<meta property="og:image" content="[ LISTING IMAGE ]" />
<meta property="og:url" content="[ CANONICAL URL OF ITEM ]" />
<meta property="og:site_name" content="[ WEBSITE NAME ]" />

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="[ Make an RFduino Servo Controller ]">
<meta name="twitter:description" content="[ I have been wanting to make a simple servo controller project lately and I thought that this little package is the coolest thing ]">
<meta name="twitter:image" content="[ LISTING IMAGE ]">
<meta name="twitter:url" content="[ CANONICAL URL OF ITEM ]">





---
layout: post
title: "Blogging Basics I I I, Make Your Octopress Blog Active with Comments, Analytics and Product Links"
date: 2015-08-12 11:25:22 -0700
comments: true
categories: [blog, howto, software]
---

Welcome to Part 3 of 'Blogging Basics - Make Your Octopress Blog Site Active with Comments, Analytics and Monetization'.  How do you know what others are thinking about your blog, how many people visit your site and what are they doing when they are there?  If you can gain this kind of insight, you can tune your blog for more interest and you can even add advertising links to monetize your site.  This post can get you started on your way to more hits and popularity. 
<!-- more -->
##Add Comments with Disqus
Despite Octopress being a static site, comments can be added to your posts via Disqus.  Disqus is already set up for you. All you need to do is create a Disqus account and register for a new forum.  https://help.disqus.com/customer/portal/articles/931017-registering-a-new-forum 

The only thing left to do is to set the properties in _config.yml.

``` yaml _config.yml https://michaeljcarey.github.io Source Article
disqus_show_comment_count: true
disqus_short_name: YOUR_DISQUS_ACCOUNT
```

And then make sure that your blog entries have the comments: true option on top.

##Add Google Analytics for Tracking and Monitization
Google Analytics can track how many people go to your site as well as other things like how long they spend on your site and where they are from.  To utilize this feature, go to the Google Analyitics web site, create an account and get your account id.
If you navigate to Admin/Tracking Info/Tracking Code then you will see your tracking code snip.
Google Analytics instructs you to place their code snippet in all of your html files, but in my case I will add the code at the bottom of the _layouts/default.html file.  This file is included in all the pages and posts.

When you follow these instructions, then you are able to log onto Google Analytics and view all the information about page hits.  Spend some time looking through and learning all that google offers.

##Display Page Hit Counters on Your Blog
If you want to display page hits on your blog and pages, then you will need to add XXX to your Octopress pages which will instruct Octopress to go to google analytics and retrieve the hit counts for dislplay.

I dont yet have this display of code hits working quite yet.  But I do see a couple of different ways to do this. I have not used StatCounter, but maybe it works well.


XXXFor others to see also, you can use a third-party API that uses JavaScript. The third-party service tracks pageviews for you and then provides you with a JavaScript snippet that you paste your sidebar or where ever you want the pageviews to show up. StatCounter is an example (didn't verify if it is a good service or not).

There are two other plugins that Octopress provides; jekyll-ga and octopress-page-view.

I am trying page-view over jekyll-ga because I dont see in the jekyll writeup how to display the analytics while page-view does show an example.

I am not sure how  to deal with the google analytics error 'missing tracking code'.  I am currently trying to get the verification for the missing tracking code.  This verification is pending...  more to follow.  Ok, I finally got this resolved.  But I still do not see my hit counters incrementing.

##Add Google's AdSense to Octopress
Create an AdSense Account.  Go to the Adsense signup page  https://www.google.com/adsense/signup and fill out the form.  Once that is done, you will have to wait for an initial approval.  Once you get that, then log on and create an AdUnit.
Name the AdUnit and select what kind of AdUnit you wish.  Then copy the generated script for pasting into your website.

I elected to place a leaderboard ad just above my blog comment section.  To do this, open source/_layouts/post.html and paste the previously copied script just above the &lt;h1>Comments&lt;/h1> section".

Now after generating and previewing your page, you should see a blank gap just above the comments.  This is due to a wait period for google to review and approve your site for ads.

Next, you will want to link your AdSense account to your Google Analytics site.  I was able to click the 'link' action in the AdSense/Google Analytics Integration page which took me to the Google Analytics site where I was able to finish connecting the link.  Now Google Analytics shows that I have linked my Adsense account.

I still have not entered any bank account information so that Google could actually pay me, but I also need to get more traffic for that to happen.

More to come.





gem list --local







##Add Webmaster Tools


###Spider Task 4

This project involves making a bulletin board where users can login or signup to share their posts. Thus it consists of an authentication and authorization system. There are three access levels, namely Visitor,Editor and Admin. A newly signed up user has the access level of Visitor.  
The access rights are as follows:  
+ **Viewer**:Can view posts
+ **Editor** :Can view and add posts
+ **Admin**  :Can view,add and delete posts. Can view and change access levels of other registered users(except admins). Can moderate the posts of any Editor. By moderation,we mean that the posts made by that particular Editor will not appear on the bulletin board directly. Instead, they will show up in the Admin Panel where the Admin can choose to allow or discard the post.

----

**Framework used : PHP on Apache**  
**Database 	 : MySQL**  
**Server	 : Apache2** 

####Necessary Software

+ Install WampServer. Wamp means Apache, MySQL and PHP on Windows.[Click here](http://www.wampserver.com/en/) to download WampServer. It contains all the links and a step by step guide about the installation and functionalities.

The details about the database and the tables used are as follows :

+ The user is 'root'@'localhost'.
+ There is no Password .
+ The database name is 'spider16task3'.

+ The first table is 'users'. The CREATE TABLE command is given below.  
   CREATE TABLE `users` (  
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `name` text NOT NULL, 
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,    
  `level` varchar(10) NOT NULL DEFAULT 'viewer',
  `mod` varchar(10) NOT NULL DEFAULT 'no',  
  PRIMARY KEY (`id`),  
  UNIQUE KEY `user_name` (`user_name`)  
)  

+ The second table is 'posts'. The CREATE TABLE command is given below.  
   CREATE TABLE `posts` (  
  `id` int(11) NOT NULL AUTO_INCREMENT,   
  `post` varchar(1000) NOT NULL,
  `user` varchar(50) NOT NULL,  
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  PRIMARY KEY (`id`),
)  

+ The third table is 'modposts'. The CREATE TABLE command is given below.
   CREATE TABLE `mods` (  
  `id` int(11) NOT NULL AUTO_INCREMENT, 
  `post` varchar(1000) NOT NULL,  
  `user` varchar(50) NOT NULL,  
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)  
) 

+ The MySQL query to create a user with Admin privileges is  
**INSERT INTO users (name,username,password,level,mod) VALUES ('myName','myUsername','myPassword','admin','no');**

----

**Captcha System**

+ The signup page uses Google reCaptcha to prevent bot users.
+ Go to [this link](https://www.google.com/recaptcha/intro/index.html). Click on **get reCaptcha** button in top right corner.
+ Sign in through your Gmail account.(If you are already signed up, then ignore this step).
+ In the **Register a new site** box, type in a label(say localhost) and your domain name(say localhost). 
+ Click on **Register**.
+ You will get two keys, a public key and a private key.
+ Copy the private key. Open signup.php. In the line
```html
$privatekey = "Your-private-key";
```
replace the string "Your-private-key" with your own secret/private key.
+ Copy the public key. Open signup.php. You will see a line 
```html
<div class="g-recaptcha" data-sitekey="Your-public-key"></div>
```
Paste this public key in the 'data-sitekey' attribute,replacing "Your-public-key".

----

**After you are done with the above steps, make necessary changes to conn.php script**.

The **mysqli** library has been used for connecting to the database.

####How to run the scripts
+ Clone this repository into the folder you want. 
+ Start your WampServer.
+ Copy all the files from SpiderWebDevTask4 to your localhost directory i. e. the 'www' directory in your WampServer.
+ Open up your browser. Type http://localhost/ as the URL.
+ Click on homepage.html.

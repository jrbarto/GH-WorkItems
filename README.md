 How to run the code:
  This project was developed and tested on both a Bitnami LAMP stack, and a WampServer stack. You may use either or to run the code. Note that the project will run on any LAMP or WAMP stack, but I have provided specific instructions for running the code using Bitnami LAMP and WampServer.
 
 Bitnami LAMP Setup:
	To setup this project using the Bitnami LAMP software stack, you must first download the installer from https://bitnami.com/stack/lamp. Note that you must be running a Linux operating system to run this installer. The installer will create the “lampstack-<version>” directory in your user’s home directory. Inside you’ll find the “manager-linux-x64.run” file. The manager will list both your apache server and MySQL database, and you may click start to start both.
 
	After starting both servers, you may extract the ‘GH-WorkItems’ directory from the zip file into the “<home>/lampstack<version>/apache2/htdocs” directory. The project page will now be accessible from a web browser at the URL “localhost:8080/GH-WorkItems”. 

WampServer Setup:
	If you are running a Windows operating system, you may install WampServer from https://sourceforge.net/projects/wampserver/. After installation you will have a new application called “Wampserver64”. Executing this application will start up your Apache web server and MySQL database server. Depending on where you install the WampServer, you can extract the “GH-WorkItems” directory into “<installation-directory>/wamp64/www”. The WampServer installation has also setup a virtual host for you to use called “localhost”. This will allow you to navigate in a web browser to “localhost/GH-WorkItems” to access the project. 

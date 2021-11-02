## Sample Modbus Write Register Single via TCP
################

Xampp Setup
------------------
1. Enable Socket Module 
in php.ini uncomment 
extension=sockets

2. Default Project Setting
in httpd.conf

Replace this
DocumentRoot "C:/xampp/htdocs"
<Directory "C:/xampp/htdocs">

To

#DocumentRoot "{{Extracted Zip path}}/public"
#<Directory "{{Extracted Zip path}}/public">
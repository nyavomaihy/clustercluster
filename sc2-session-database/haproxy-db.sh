sudo haproxy -f  /etc/haproxy/haproxy.cfg

USE mysql;
UPDATE user SET authentication_string = PASSWORD('') WHERE user = 'root';
UPDATE user SET plugin = 'mysql_native_password' WHERE user = 'root';
FLUSH PRIVILEGES;
EXIT;

USE mysql;
UPDATE user SET plugin='mysql_native_password' WHERE User='root';
ALTER USER 'root'@'localhost' IDENTIFIED BY '';
FLUSH PRIVILEGES;
EXIT;
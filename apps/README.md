------------------------
START

1.
 $ id
 root
 $ pwd
 /root/html/apps

 $ls
 README.md  collect_kanto_home_information.py  create_insert_ddl.php  data  mysql  old

2.
 $ time python collect_kanto_home_information.py
 .. create json

3. 
 $ php create_insert_ddl.php
 .. create ddl (from json)

4. 
 $ cd mysql
 $ pwd
 /root/html/apps/mysql
 $ ls
 connect_mysql.sh  drop_create_tables.sql  insert_home_m.sql  insert_home_traffic_t.sql
 $ connect_mysql.sh
 $ source drop_create_tables.sql
 $ source insert_home_m.sql
 $ source insert_home_traffic_t.sql

END
------------------------

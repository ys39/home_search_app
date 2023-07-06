#ifndef SEN_MYSQL_H //二重でincludeされることを防ぐ
#define SEN_MYSQL_H

char sen_mysql_connect(char* , char* , char* , char*);
char sen_mysql_query(char*);
void sen_mysql_close();
MYSQL *gConn = NULL;

#endif

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <mysql/mysql.h>
#include "sen_mysql.h"

#include <signal.h>

#include "/usr/include/php/main/php.h"
#include "/usr/include/php/main/php_ini.h"
#include "/usr/include/php/ext/standard/info.h"
#include "/usr/include/php/Zend/zend_smart_str.h"
#include "/usr/include/php/ext/mysqli/php_mysqli_structs.h"
//#include "/usr/include/php/mysqli_priv.h"

// mysql接続用関数
PHP_FUNCTION(sen_mysql_connect){
  char   *hostname = NULL, *username = NULL, *password = NULL, *database = NULL;
  size_t hostname_len = 0, username_len = 0, password_len = 0, database_len = 0;

  if(zend_parse_parameters(ZEND_NUM_ARGS(), "|s!s!s!s!", &hostname, &hostname_len, &username, &username_len, &password, &password_len, &database, &database_len) == FAILURE) {
    RETURN_THROWS();
  }
  mysql->mysql = mysql_init(NULL);

  if ( !mysql_real_connect(mysql->mysql, hostname, username, password, database, 0, NULL, 0)){
    RETURN_FALSE;
  }else{
    RETURN_TRUE;
  }
}
/*
char sen_mysql_connect(char *_host, char *_user, char *_password, char *_database){
  // ローカル変数
  char  *host     = _host;
  char  *user     = _user;
  char  *password = _password;
  char  *database = _database;
  // グローバル変数の初期化
  // mysql_real_connect() に適切な MYSQL オブジェクトを割り当てるか初期化する
  gConn = mysql_init(NULL);
  if( !mysql_real_connect(gConn,host,user,password,database,0,NULL,0) ){
    // fail
    return 1;
  }else{
    // success
    return 0;
  }
}
*/
/*
//mysqlクエリ実行用関数
char sen_mysql_query(char *_sql_str){
  // 変数宣言
  MYSQL_RES *resp = NULL;
  MYSQL_ROW row;
  //char result[255];
  char sql_str[255];
  // メモリ確保
  memset(sql_str, 0x00, sizeof(sql_str));
  // クエリ設定
  snprintf(sql_str, sizeof(sql_str)-1, _sql_str);
  // クエリ実行
  if(mysql_query(gConn, sql_str)){
    // fail
    mysql_close(gConn);
    exit(-1);
    //return 1;
  }else{
    // success
    resp = mysql_use_result(gConn);
    //while((row = mysql_fetch_row(resp)) != NULL );
    while((row = mysql_fetch_row(resp)) != NULL ){
      printf( "%d : %s\n" , atoi(row[0]) , row[1] );
    }

    //result = &row[0];
    // mysql_use_result()によって結果セットに割り当てられたメモリーを解放
    mysql_free_result(resp);
    return 0;
  }
}

// mysqlクローズ用関数
void sen_mysql_close(){
  // 以前にオープンされた接続をクローズ
  mysql_close(gConn);
}

int main(){
  sen_mysql_connect("localhost", "root", "Maplebear1.", "app_test01");
  sen_mysql_query("select * from tb_test;");
  sen_mysql_close();
  return 0;
}
*/

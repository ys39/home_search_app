#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <mysql/mysql.h>
#include "sen_mysql.h"

// mysql接続用関数
char sen_mysql_connect(char *_host, char *_user, char *_password, char *_database){
  // ローカル変数
  char  *host     = _host;
  char  *user     = _user;
  char  *password = _password;
  char  *database = _database;
  // グローバル変数の初期化
  // mysql_real_connect() に適切な MYSQL オブジェクトを割り当てるか初期化する
  gConn = mysql_init(NULL);
  mysql_options(gConn, MYSQL_SET_CHARSET_NAME, "utf8");
  if( !mysql_real_connect(gConn,host,user,password,database,0,NULL,0) ){
    // fail
    return 1;
  }else{
    // success
    return 0;
  }
}

//mysqlクエリ実行用関数
char sen_mysql_query(char *_sql_str){
  // 変数宣言
  MYSQL_RES *resp = NULL;
  MYSQL_ROW row;
  //char result[255];
  //char sql_str[255];
  char *sql_str;
  // メモリ確保
  //memset(sql_str, 0x00, sizeof(sql_str));
  // クエリ設定
  //snprintf(sql_str, sizeof(sql_str)-1, _sql_str);
  sql_str = _sql_str;
  // クエリ実行
  if(mysql_query(gConn, sql_str)){
    // fail
    mysql_close(gConn);
    exit(-1);
    //return 1;
  }else{
    // success
    resp = mysql_use_result(gConn);
    
    if(resp){
      while((row = mysql_fetch_row(resp)) != NULL ){
        printf( "%d : %s\n" , atoi(row[0]) , row[1] );
      }
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
  //sen_mysql_query("select * from home_m where home_id = 1;");
  sen_mysql_query("insert into user_session_t (user_id, session_id, login_time, logout_time) values ('1', '12345678', now(), now());");
  sen_mysql_close();
  return 0;
}

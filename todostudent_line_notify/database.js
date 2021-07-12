const mysql = require('mysql');

class Database{
     constructor(){
        this.connect = this.getConfigDB();
        this.connect.connect((err)=>{
            console.log((err)?'[error connect!]-->'+err:'---[connected!]---');
        });
     }

     getConfigDB(){
        const config = {
            host:'localhost',
            user:'root',
            password:'',
            database:'todo_database',
            charset : 'utf8'
        }
        return mysql.createConnection(config);
    }

    execute(sql){
        return new Promise((resolve,reject)=>{
                this.connect.query(sql,(err,result)=>{
                        (!err)? resolve(result) : reject(err) ;
                });
        });
    }
}

module.exports = Database;

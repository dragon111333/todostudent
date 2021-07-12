const Database = require('./database');
const axios = require('axios');
const db = new Database();

class CheckNotify{
    constructor(timeInterval){
        if(timeInterval!=null){

            //--------- BLOCK DISCONNECTION ---------------
            setInterval(()=>{
                const sql = "SELECT CURRENT_TIMESTAMP";
                db.execute(sql)
                .then((result)=>{
                    console.log('time>',result[0].CURRENT_TIMESTAMP);
                });
            },timeInterval);

        }else{

            this.findWork()
            let checkTime = 6*(1000*60*60);
            setInterval(()=>{this.findWork()},checkTime);

        }
    }

    findWork(){
        const sql = "		SELECT * FROM WORK WHERE \n" +
                    "		DATE(WORK_DEADLINE)  \n" +
                    "		BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE,INTERVAL 3 DAY)\n" +
                    "		AND WORK_STATUS = 1";
        db.execute(sql)
        .then(result=>{
            result.forEach(item => {
                console.log('work>'+item.WORK_NAME);
                this.findUser(item);
            });
        });
    }

    findUser(item){
        const sql = 'SELECT * FROM USER_LINE_TOKEN WHERE USER_ID='+item.USER_ID;
        db.execute(sql)
        .then((result)=>{
            if(result!=null){
                let line = "----------------------------------\n";
                 const frame = this.makeFrame(item.WORK_NAME.length)+"\n";
                const date = String(new Date(item.WORK_DEADLINE).toISOString()).substring(0,10);
                let message = '\n'
                                +frame
                                +'💡 '+item.WORK_NAME+' 💡\n'
                                +frame
                                +'❗️ใกล้ถึงกำหนดส่ง❗️\n'
                                +line
                                +'📋(คำอิบาย) : \n'
                                +item.WORK_DESC+'\n\n'
                                +"📆(วันส่ง) : "+date+"\n"
                                +line+"\n"
                                +'🔎ดูเพิ่มเติมที่:web.todostudent.com\n\n';
                this.sendMessage(result[0].USER_TOKEN,message);
            }
        })
    }

    makeFrame(length){
        let frame = '  ';
        for(let i=0;i<(length+5);i++){
            frame+='*';
        }
        return frame;
    }

    sendMessage(token,message){
        const config = {
            "method" : "POST",
            "url" : "https://notify-api.line.me/api/notify",
            "contentType":"application/x-www-form-urlencoded",
            "headers":{
                "Authorization":"Bearer "+token
            },
            "data":"message="+message
        };
        axios(config)
        .then((response)=>{
            console.log(response.data);
        })
    }

}
new CheckNotify(null);
new CheckNotify(5000);
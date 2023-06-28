require("dotenv").config({path:process.cwd()+"/../.env"});
const database = require('../database');
let generalConfigDB = {};
let paymentUrl = {};
let accessToken = {};

module.exports.getDatabaseConfig = function () {

	return {
        "host": process.env.DB_HOST,
        "user": process.env.DB_USERNAME,
        "password": process.env.DB_PASSWORD,
        "connectionLimit": 10,
        "database": process.env.DB_DATABASE,
        "port": process.env.DB_PORT,
        "debug": false,
        "timezone" : 'utc'
    }
    
}


module.exports.database = database.init(module.exports.getDatabaseConfig());

async function loadGeneralConfiguration()
{
    let conn = await module.exports.database.getConnection();
    let query = `SELECT * FROM site_settings`;

    let queryResult = await conn.query(query);
    conn.release();
    
    
    return queryResult[0];
}

module.exports.init = async function()
{
    let arrConfig = await loadGeneralConfiguration();

    for(var tmpIndex in arrConfig)
    {
        // console.log(arrConfig[tmpIndex].site_url);
        // return;

        generalConfigDB = arrConfig[tmpIndex].site_url;  

        if(arrConfig[tmpIndex].payment_mode == 0)
        {
            paymentUrl = arrConfig[tmpIndex].sandbox_url;
            accessToken = arrConfig[tmpIndex].sandbox_access_token;
        }
        else
        {
            paymentUrl  = arrConfig[tmpIndex].live_url;
            accessToken = arrConfig[tmpIndex].live_access_token;   
        }
        // console.log(generalConfigDB[tmpIndex].site_url);       
    }
}

module.exports.getPortalDetails = function(){


    return {
        'url': generalConfigDB,
        'paymentUrl':paymentUrl,
        'accessToken':accessToken,
        
        // 'url': 'http://localhost:8085'
    }
}

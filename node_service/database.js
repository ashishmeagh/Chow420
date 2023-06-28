const mysql = require('mysql2/promise');

module.exports.init = function(configs){

	
	return mysql.createPool({
		host: process.env.MYSQL_HOST || configs.host,
                user: process.env.MYSQL_USER || configs.user,
                connectionLimit: process.env.MYSQL_CONNECTION_LIMIT || configs.connectionLimit,
                port: process.env.MYSQL_PORT || configs.port,
                password: process.env.MYSQL_PASSWORD || configs.password,
                database: configs.database,
                debug: configs.debug,
                // timezone: 'utc'
	});
}
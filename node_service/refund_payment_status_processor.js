var _ = require('lodash');
const axios = require('axios');
const configs = require("./configs");
const database = require('./database');
const CircularJSON = require('circular-json');
// var dateTime = require('node-datetime');
// var moment = require('moment'); 

let currentlyActiveUserToken = [];

let db=false;
process.on('uncaughtException',function(error){
	console.log("Caught exception: "+error);
	process.exit();
});

async function main()
{	
	await configs.init();
	dbConfig = configs.getDatabaseConfig();
	portalDetails = configs.getPortalDetails();

	db = database.init(dbConfig);

	try
	{
		let tmpConn = await db.getConnection();	
		log("DB Connection Test Passed");
		tmpConn.release();
	}
	catch(e)
	{
		log("DB Connection Test Failed");
		return false;
	}

	initProcess();

}
main().then();

async function initProcess(){
	try
	{
		/* Get Transaction Records */
		let [records] = await getRefundTransactions(db);

		for(let _record of records)
		{
			if((_record.id != null || _record.refund_id != null))
			{
				verifySlug = _record.id+':'+_record.refund_id;

				if(isLockedForOnChainTx(verifySlug))					
				{	
					lockForOnChainTx(verifySlug);		

					log("all records get");
					/*function for get refund status */
					let refundResponse = await getRefundStatus(db,_record.refund_id,verifySlug);

					if(refundResponse != false && refundResponse.data.refund.status != null && refundResponse.data.refund.status == 'COMPLETED')
					{
						/*function for update refund status Success*/
						let updateStatusResponse = await updateRefundStatus(db,_record.id);

						/*send Cancel Order Mail to Buyer, Seller and Admin */
						let sendMailResponse = await sendMailService(_record.id,_record.order_no,_record.buyer_id);
						
												
					}		

					unlockFromOnChainTx(verifySlug);					

				}
				else{
					console.log("Already processing "+verifySlug);
					// unlockFromOnChainTx(verifySlug);
				}						
			}							
		}


		initProcess();			
	}
	catch(e)
	{
		console.log("Caught exception: "+e.message);
		process.exit();
	}
}
async function getRefundStatus(db,_refund_id,_verifySlug) 
{
	if(_refund_id != null)
	{
		return await axios({
						method: 'GET',
						url: portalDetails.paymentUrl+'/v2/refunds/'+_refund_id,
						headers: {
								'Content-Type': 'application/json',
		    					'Authorization': 'Bearer '+portalDetails.accessToken
						}
					});
	}

	unlockFromOnChainTx(_verifySlug);
	return false;
}

async function updateRefundStatus(db,_order_id) 
{
	if(_order_id != null)
	{

		let conn = await db.getConnection();
		let updateQuery = `UPDATE order_details
							SET refund_status = '2'						
							WHERE id='`+_order_id+`'`;

		let queryUpdateResult = conn.query(updateQuery);	
		conn.release();		

		log("update Status of order id "+_order_id);
		return queryUpdateResult;	
	}
	// unlockFromOnChainTx(_verifySlug);
	return false;
}

async function getRefundTransactions(db) 
{
	let conn = await db.getConnection();

	let query = `SELECT 
					* 
					FROM 
					 	order_details
					 WHERE
					 	order_status = '0' 
			 			AND
					 	refund_status = '1'
					 	AND
					 	payment_gateway_used = 'square'
					 	AND
					 	refund_id != 'NULL'					 							 			 	
					`;

	let queryResult = await conn.query(query);

	conn.release();

	return queryResult;	
}

/*Api function (in CommonController) for Send mail to Buyer,Seller and Admin*/
async function sendMailService(_order_id,_order_no,_buyer_id) {

	return axios.get(portalDetails.url+'cancel_order/send_invoice/'+_order_id+'/'+_order_no+'/'+_buyer_id);
}


function isLockedForOnChainTx(_verifySlug)
{
	return _.indexOf(currentlyActiveUserToken, _verifySlug ) == -1
}

function lockForOnChainTx(_verifySlug)
{
	currentlyActiveUserToken.push(_verifySlug);
}	

function unlockFromOnChainTx(_verifySlug)
{
	var tmpIndex = _.indexOf(currentlyActiveUserToken, _verifySlug );
	currentlyActiveUserToken.splice(tmpIndex,1);
}


function log(message,severity)
{
	severity = severity || "info";
	console.log("["+severity+"]["+ new Date() +"]: ",message);
}

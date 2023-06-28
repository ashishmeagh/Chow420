var activeNetwork         = 'main';
var table_buy_list        = false;
var globContractInstance  = false;
var globCoinbase          = false;

  $(document).ready(function()
  {
    /*Escrow Authentication*/
    if(typeof web3 != 'undefined')
    {
      web3 = new Web3(web3.currentProvider);
    }
    else
    {
      web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
    }

    if(web3.currentProvider.publicConfigStore == undefined){

          isMetamaskAvailable = false;
          swal('Get Metamask Wallet', 'You need Metamask to Buy and Sell on Afroin with USDC.<br/> <a href="https://metamask.io/" target="_blank">Click Here to get Metamask</a>', 'error');

    }else{
      web3.currentProvider.publicConfigStore.on('update',(data)=>{
          if(globCoinbase==false || globCoinbase==null){
              checkCurrentNetwork();
          }
      });
    }

    Promise.all([
                  web3.eth.net.getId()
              ]).then( async ([currentNetwork])=>
              {
                // console.log('currentNetwork = '+currentNetwork);
                
                checkMetamaskLogin();
              });


    Promise.all([
        $.getJSON(SITE_URL+'/assets/contracts/Usdcoins.json'),
        $.getJSON(SITE_URL+'/assets/contracts/Escrow.json'),
        $.getJSON(SITE_URL+'/assets/contracts/EscrowForCrypto.json'),
        ]).then(function ([Usdcoins,Escrow,EscrowForCrypto]){
          globUsdcoinsContractInstance = new web3.eth.Contract(Usdcoins.abi, usdcContractAddress);
          globEscrowContractInstance = new web3.eth.Contract(Escrow.abi, escrowApprovalAddress);
          globEscrowForCryptoContractInstance   = new web3.eth.Contract(EscrowForCrypto.abi, escrowContractAddressForCrypto);

          // console.log(globUsdcoinsContractInstance);
          // console.log(globEscrowContractInstance);
          // console.log(globEscrowForCryptoContractInstance);

          web3.eth.getCoinbase()
          .then((_coinbase) => {
            globCoinbase = _coinbase;

            /*decimal value*/
            globUsdcoinsContractInstance.methods.decimals().call()
                .then(function(_decimal)
                {
                  globContractDecimal = _decimal;
                  //get the authorisation amount
                  // CheckAuthorisation();
                });            
          });          
        });
  });
   //check metamask is login or not and if not login then redirect to metamask wallet login page
  function checkMetamaskLogin() {
	    web3.eth.getAccounts(function(err,accounts){
	        if(err){
	            console.log('An error occurred '+ err);
	        }else if(accounts.length == 0){
	            
	            try{
	                swal({
	                  title: "Note!",
	                  text: "For buying trades in OpenBazzar, ETH wallet address needed. <br/> System will take your ETH address from metamask. <br/> Please login to Metamask.",
	                  type: "warning",
	                  confirmButtonText: "OK"
	                },
	                function(isConfirm){
	                  if (isConfirm) {
	                   window.ethereum.enable();
	                  }
	                }); 
	            }
	            catch(e){
	                swal('Error', 'Please login to MetaMask..!', 'error');
	                $("#currentUserAddress").html("0x0000000000000000000000000000000000000000");
	            }
	                
	        }else{
	            checkCurrentNetwork();
	        }
	    });
  }

  /*function check current active network and do next actions accordingly*/
  function checkCurrentNetwork() {
      web3.eth.net.getNetworkType()
      .then((result)=>{                
          if(result==activeNetwork)
          {
              // initAccountDetails();
              return true;
          }else{
              swal('Error', 'Please select '+activeNetwork+' Network.' , 'error');
              return false;
              // $("#currentUserAddress").html("0x0000000000000000000000000000000000000000");
          }
      });
  }

  //get the trade details
  function getTradeDetails() {
	    var trade_ref = $('#trade_ref').val();

	    detailTradeId = ""+web3.utils.fromAscii(trade_ref)+"";

	    globEscrowContractInstance.methods.tradeRegistry(detailTradeId).call()
	    .then(function(_trade)
	    {
	      var trade_amount = _trade._balanceAmount / (10 ** globContractDecimal);

	      $(".trade_details").html();

	        $(".trade_details").html(`
	              <div class="table-responsive">
	                      <table  class="table table-bordered table-striped">
	                              <tr>
	                                  <th>Trade Id</th>
	                                  <td>`+trade_ref+`</td>
	                              </tr>
	                              <tr>
	                                  <th>Buyer Address</th>
	                                  <td>`+_trade._buyerAddress+`</td>
	                              </tr>
	                              <tr>
	                                  <th>Seller Address</th>
	                                  <td>`+_trade._sellerAddress+`</td>
	                              </tr>
	                              <tr>
	                                  <th>Token Address</th>
	                                  <td>`+_trade._tradeTokenAddress+`</td>
	                              </tr>
	                              <tr>
	                                  <th>Balance Amount</th>
	                                  <td>`+trade_amount+`</td>
	                              </tr>
	                              <tr>
	                                  <th>Is Completed</th>
	                                  <td>`+_trade._isCompleted+`</td>
	                              </tr>
	                              <tr>
	                                  <th>Id Disputed</th>
	                                  <td>`+_trade._isDisputed+`</td>
	                              </tr>
	                              <tr>
	                                  <th>Refrerance Data</th>
	                                  <td>`+_trade._refData+`</td>
	                              </tr>
	                      </table>
	                  </div>`);
	    });   
  }

  function scientificToDecimal(num) {
      //if the number is in scientific notation remove it
      if(/\d+\.?\d*e[\+\-]*\d+/i.test(num)) {
          var zero = '0',
              parts = String(num).toLowerCase().split('e'), //split into coeff and exponent
              e = parts.pop(),//store the exponential part
              l = Math.abs(e), //get the number of zeros
              sign = e/l,
              coeff_array = parts[0].split('.');
          if(sign === -1) {
              coeff_array[0] = Math.abs(coeff_array[0]);
              num = '-'+zero + '.' + new Array(l).join(zero) + coeff_array.join('');
          }
          else {
              var dec = coeff_array[1];
              if(dec) l = l - dec.length;
              num = coeff_array.join('') + new Array(l+1).join(zero);
          }
      }      
      return num;
  };
  
  //set the trade commition percentage
  function setConfig() {
    var receiver_address = $('#receiver_address').val().trim();
    var percent          = parseFloat($('#percent').val().trim());
    var divisor          = 100;
    var mode             = $('#mode').val().trim();
    var baseDivisor = 1;
    var decimalCount = countDecimals(percent);
    
    // if(globCoinbase != receiver_address)
    // {
    //    scrollToTop();    
    //    $(".txt_hash").html(`<div class="alert alert-danger">
    //             <strong>Warning!</strong> Your active wallet does not match with your provided wallet, Please switch your wallet</div>`); 

    //   return false;
    // }

    for(var _tmpIdx = 0 ;_tmpIdx < decimalCount; _tmpIdx++)
    {
      baseDivisor*=10;
      divisor*=10;
    }
    
    percent = percent * baseDivisor;   
    globEscrowContractInstance.methods.updateTradeConfig(receiver_address,percent,divisor,mode).send({ from:globCoinbase, to:globEscrowContractInstance._address})
    .on('transactionHash', function (txHash) {         

        // $("#txt_hash").html("Your Transaction is in process <a href='https://www.etherscan.io/tx/"+txHash+"' target='_blank'>click here</a>"+txHash);
        // $(".txt_hash").html("<a href='https://www.etherscan.io/tx/"+txHash+"' target='_blank'>click here</a> to  view your transaction");

        $(".txt_hash").html(`<div class="alert alert-info">
                      <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
                    `</div>`);

        //back total quantity field because we don't want to refresh page so user need to enter quantity then esacrow aturisation check
        //and this is only at the time of trade buying in popup
        $('#total_qty').val('');
    })
    .on('receipt', function (txReceipt) {
      // console.log(txReceipt);
        // console.log("Transaction Receipt is: " + txReceipt);
    })
    .on('error', function (txError) {
        // console.log("Transaction Error is: " + txError);
    });                  
  }

  //set the trade dispute commition percentage
  function setDisputeConfig() {
     var receiver_address = $('#receiver_address').val().trim();
     var percent          = parseFloat($('#percent').val().trim());
     var divisor          = 100;
     var mode             = $('#mode').val().trim();
     var baseDivisor = 1; 
     var decimalCount = countDecimals(percent);
      
      for(var _tmpIdx = 0 ;_tmpIdx < decimalCount; _tmpIdx++)
      {
         baseDivisor*=10;
        divisor*=10;
      }

     percent = percent * baseDivisor;

     globEscrowContractInstance.methods.updateDisputeSettlementConfig(receiver_address,percent,divisor,mode).send({ from:globCoinbase, to:globEscrowContractInstance._address})
        .on('transactionHash', function (txHash) {         
            $(".txt_hash").html(`<div class="alert alert-info">
                      <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
                    `</div>`);

        })
        .on('receipt', function (txReceipt) {
            // console.log("Transaction Receipt is: " + txReceipt);
        })
        .on('error', function (txError) {
            // console.log("Transaction Error is: " + txError);
        }); 
  }

  //count the digits after decimal
  function countDecimals(value) {
    if(Math.floor(value) === value) return 0;
    var tmpArr = value.toString().split(".");
    return tmpArr[1].length || 0;
  }

  //transfer funds to buyer wallet address
  function fillDisputedTrade(paymentData) {

    var sellerTradeId    = ""+web3.utils.fromAscii(paymentData.sellerTradeId)+"";
    var buyerTradeId     = ""+web3.utils.fromAscii(paymentData.buyerTradeId)+"";    
    var buyerAddress     = paymentData.buyerAddress;
    var withdrawlAmount  = paymentData.withdrawlAmount;
    var refData          = '';//optional

    var _DepositTokenAmount = withdrawlAmount * (10 ** globContractDecimal);
    _DepositTokenAmount     = ""+scientificToDecimal(_DepositTokenAmount)+"";


    web3.eth.getCoinbase().then((_coinbase) => {globCoinbase = _coinbase;});
         
    //user pass wallet address
    globEscrowForCryptoContractInstance.methods.fillDisputedTrade(sellerTradeId,
                                                          buyerTradeId,
                                                          buyerAddress,
                                                          _DepositTokenAmount,
                                                          refData).send({ from:globCoinbase, to:globEscrowContractInstance._address})
    
    .on('transactionHash', function (txHash){
      
      scrollToTop();     

      $(".txt_hash").html(`<div class="alert alert-info">
                <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
              `</div>`);


      //store transaction data 
      // var csrf_token = $("input[name=_token]").val();
      $.ajax({
            headers: {'X-CSRF-TOKEN': paymentData.csrf_token},
            url:SITE_URL+'/'+admin_slug+'/CashMarkets/chat/store_usdc_transaction',
            data:{'txHash':txHash,
                  'trade_id':paymentData.trade_primary_id,
                  'total_price':withdrawlAmount,
                  'action':'crypto_trade_dispute_settlement'
                  },
            method:'POST',
            success:function(response)
            { 
              $('#btn_usdc_dispute_settlement').hide();
              // console.log('transaction success');
            }
          });
    })

    .on('receipt', function (txReceipt) {      
      console.log("Transaction Receipt is: "+txReceipt);
    })
    .on('error', function (txError) {
      console.log("Transaction Error is:"+txError);
    });
  }

  function scrollToTop() {
    $('html, body').animate({
      scrollTop:0
    }, $(window).scrollTop() / 3);
    return false;
  };
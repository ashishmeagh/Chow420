var activeNetwork        = 'main';
var globContractInstance = false;
var globCoinbase         = false;
  



  //get escrow authorisation amount
  function CheckAuthorisation()
  {

    globUsdcoinsContractInstance.methods.allowance(globCoinbase,escrowApprovalAddress).call()
        .then(function(result)
        {   
          token = result / (10 ** globContractDecimal);
          // console.log(token);
          $('.approvalAmount').val(token);

          return token;
        });
  }



  function ApproveAmount()
  {
    var approvalAmount        = $("#approvalAmount").val();
    var flag = 1;

    if($.trim(approvalAmount)==''){
      swal('warning','Please enter approval amount','error');
      flag = 0;
    }else if($.trim(approvalAmount)<=0){
      swal('warning','Please enter approval amount greater than zero','error');
      flag = 0;
    }

    if(flag==0)
    {
      return false;
    }

    approvalTokenAmount = (approvalAmount * (10 ** globContractDecimal));
    approvalTokenAmount = ""+scientificToDecimal(approvalTokenAmount)+"";


    globUsdcoinsContractInstance.methods.approve(escrowApprovalAddress,approvalTokenAmount).send({ from:globCoinbase, to:globContractInstance._address})
        .on('transactionHash', function (txHash) {         

            // $(".txt_hash").html("<a href='https://www.etherscan.io/tx/"+txHash+"' target='_blank'>click here</a> to  view your transaction");
            scrollToTop();     

            $(".txt_hash").html(`<div class="alert alert-info">
                      <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
                    `</div>`);
            //back total quantity field because we don't want to refresh page so user need to enter quantity then esacrow aturisation check
            //and this is only at the time of trade buying in popup
            $('#total_qty').val('');
        })
        .on('receipt', function (txReceipt) {
            // console.log("Transaction Receipt is: " + txReceipt);
        })
        .on('error', function (txError) {
            // console.log("Transaction Error is: " + txError);
        });
  }

  function SellerApproveAmount()
  { 

    var approvalAmount        = $("#approvalAmount").val();
    var flag = 1;

    if($.trim(approvalAmount)==''){
      swal('warning','Please enter approval amount','error');
      flag = 0;
    }else if($.trim(approvalAmount)<=0){
      swal('warning','Please enter approval amount greater than zero','error');
      flag = 0;
    }

 /*   globUsdcoinsContractInstance.methods.balanceOf(globCoinbase).call().then(function(result)
    {

        wallet_balance = result / (10 ** globContractDecimal); 
       
        if(approvalAmount>wallet_balance)
        {
            swal('Note','Your wallet amount is less than escrow ammount Please update your escrow ammount','error');
            flag =0;
        } 

    });*/

    
    if(flag==0)
    {
      return false;
    }

   /*if(flag !=0)
   {*/
       
        approvalTokenAmount = (approvalAmount * (10 ** globContractDecimal));
        approvalTokenAmount = ""+scientificToDecimal(approvalTokenAmount)+"";


        globUsdcoinsContractInstance.methods.approve(escrowContractAddressForCrypto,approvalTokenAmount).send({ from:globCoinbase, to:globContractInstance._address})
            .on('transactionHash', function (txHash) {         

                // $(".txt_hash").html("<a href='https://www.etherscan.io/tx/"+txHash+"' target='_blank'>click here</a> to  view your transaction");
                scrollToTop();     

                $(".txt_hash").html(`<div class="alert alert-info">
                          <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
                        `</div>`);
                //back total quantity field because we don't want to refresh page so user need to enter quantity then esacrow aturisation check
                //and this is only at the time of trade buying in popup
                $('#total_qty').val('');
            })
            .on('receipt', function (txReceipt) {
                // console.log("Transaction Receipt is: " + txReceipt);
            })
            .on('error', function (txError) {
                // console.log("Transaction Error is: " + txError);
            });

     
    /*} */  


  }
  
  function scientificToDecimal(num){
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



  /*function check current active network and do next actions accordingly*/
  function checkCurrentNetwork(){
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


  function initiateTrade(paymentData){
    
    var initiateTradeId       = ""+web3.utils.fromAscii(paymentData.trade_ref_id)+"";
    var initiateBuyerAddress  = paymentData.buyerAddress;
    var initiateSellerAddress = paymentData.sellerAddress;
    var initiateDepositAmount = paymentData.depositeAddress;
    var initiateTokenAddress  = paymentData.tokenAddress;
    var initiateTradeRef      = paymentData.tradeRefData;

    initiateDepositTokenAmount = initiateDepositAmount * (10 ** globContractDecimal);
    initiateDepositTokenAmount = ""+scientificToDecimal(initiateDepositTokenAmount)+"";
    
    // if active wallet address not equal to user pass wallet address then do not procced
    var wallet_addr = initiateBuyerAddress.toLowerCase();

    if(globCoinbase != wallet_addr)
    {
       scrollToTop();    
       $(".txt_hash").html(`<div class="alert alert-danger">
                <strong>Warning!</strong> Your active wallet does not match with your provided wallet, Please switch your wallet</div>`); 

      return false;
    }

    //user pass wallet address
    globEscrowContractInstance.methods.initiateTrade(initiateTradeId,initiateBuyerAddress,initiateSellerAddress,initiateDepositTokenAmount,initiateTokenAddress,initiateTradeRef).send({ from:globCoinbase, to:globEscrowContractInstance._address})
    
    .on('transactionHash', function (txHash){
      
      // $(".txt_hash").html("<a href='https://www.etherscan.io/tx/"+txHash+"' target='_blank'>click here</a> for view your transaction");
      scrollToTop();     

      $(".txt_hash").html(`<div class="alert alert-info">
                <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
              `</div>`);

      $('.rm-after-actn').fadeOut();

      //store transaction data and update trade status
      $.ajax({
            headers: {'X-CSRF-TOKEN': paymentData.csrf_token},
            url:SITE_URL+'/buyer/transaction/save_transaction',
            data:{'paymentData':paymentData,
                  'txHash':txHash,
                  'trade_id':paymentData.trade_id,//this is the primary key of trade table,not autogenerated unique trade id
                  'total_price':initiateDepositAmount
                  },
            method:'POST',
            success:function(response)
            {
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

  function completeTrade(transactionData)
  {
    var fromAsciiTradeId       = ""+web3.utils.fromAscii(transactionData.trade_ref_id)+"";

    globEscrowContractInstance.methods.completeTrade(fromAsciiTradeId).send({ from:globCoinbase, to: globEscrowContractInstance._address})
    .on('transactionHash', function (txHash){
      // $(".txt_hash").html("<a href='https://www.etherscan.io/tx/"+txHash+"' target='_blank'>click here</a> to view transaction");
      scrollToTop();     
      $(".txt_hash").html(`<div class="alert alert-info">
                <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
              `</div>`);

      $('.rm-after-actn').fadeOut();

      //store transaction data and update trade status
      $.ajax({
            headers: {'X-CSRF-TOKEN': transactionData.csrf_token},
            url:SITE_URL+'/buyer/transaction/complete_trade',
            data:{'txHash':txHash,
                  'trade_id':transactionData.trade_id,//this is the primary key of trade table,not autogenerated unique trade id
                  },
            method:'POST',
            success:function(response)
            {
              // console.log('transaction success');
            }
          });


    })
    .on('receipt', function (txReceipt) {
      console.log("Transaction Receipt is: " +txReceipt);
    })
    .on('error', function (txError) {
      console.log("Transaction Error is:" +txError);
    });   
  }

  function scrollToTop() {
    $('html, body').animate({
      scrollTop:0
    }, $(window).scrollTop() / 3);
    return false;
  };

   //Load the funds for perticular crypto trade
  function initiateCryptoTrade(ref) {
    
    var trade_id          = $(ref).attr('data-trade-id');

    var sellerAddress     = $(ref).attr('data-seller-wallet-add');
    var depositAmount     = $(ref).attr('deposite-amount');
    var tradeTokenAddress = usdcContractAddress;
    var tradeId           = ""+web3.utils.fromAscii(trade_id)+"";
    var tradePrimary_id   = $(ref).attr('data-trade-primary-id');
    var refData           = 'test';//optional

    var _DepositTokenAmount    = depositAmount * (10 ** globContractDecimal);
    _DepositTokenAmount    = ""+scientificToDecimal(_DepositTokenAmount)+"";
    
    // if active wallet address not equal to user pass wallet address then do not procced
    var wallet_addr = sellerAddress.toLowerCase();
    
    if(globCoinbase != wallet_addr)
    {
       scrollToTop();    
       $(".txt_hash").html(`<div class="alert alert-danger">
                <strong>Warning!</strong> Your active wallet does not match with your provided wallet, Please switch your wallet</div>`); 

      return false;
    }

    //user pass wallet address
    globEscrowForCryptoContractInstance.methods.initiateTrade(tradeId,sellerAddress,_DepositTokenAmount,tradeTokenAddress,refData).send({ from:globCoinbase, to:globEscrowForCryptoContractInstance._address})
    
    .on('transactionHash', function (txHash){
      
      // scrollToTop();     

      $(".txt_hash").html(`<div class="alert alert-info">
                <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
              `</div>`);

      $('#btn-approve-escrow-amt').fadeOut();

      //store transaction data and update trade status
      var csrf_token = $('#csrf_token').val();
      $.ajax({
            headers: {'X-CSRF-TOKEN': csrf_token},
            url:SITE_URL+'/seller/transaction/save_transaction',
            data:{'txHash':txHash,
                  'trade_id':tradePrimary_id,
                  'total_price':depositAmount,
                  'action':'crypto_trade_initialize'
                  },
            method:'POST',
            success:function(response)
            {
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

  //transfer funds to buyer wallet address
  function fillTrade(paymentData) {

    var sellerTradeId    = ""+web3.utils.fromAscii(paymentData.sellerTradeId)+"";
    var buyerTradeId     = ""+web3.utils.fromAscii(paymentData.buyerTradeId)+"";    
    var buyerAddress     = paymentData.buyerAddress;
    var withdrawlAmount  = paymentData.withdrawlAmount;
    var refData          = '';//optional

    var _DepositTokenAmount = withdrawlAmount * (10 ** globContractDecimal);
    _DepositTokenAmount     = ""+scientificToDecimal(_DepositTokenAmount)+"";


    web3.eth.getCoinbase().then((_coinbase) => {globCoinbase = _coinbase;});
         
    //user pass wallet address
    globEscrowForCryptoContractInstance.methods.fillTrade(sellerTradeId,
                                                          buyerTradeId,
                                                          buyerAddress,
                                                          _DepositTokenAmount,
                                                          refData).send({ from:globCoinbase, to:globEscrowForCryptoContractInstance._address})
    
    .on('transactionHash', function (txHash){
      
      scrollToTop();     

      $(".txt_hash").html(`<div class="alert alert-info">
                <strong>Info!</strong>`+` Your transaction is in process <a href='https://www.etherscan.io/tx/`+txHash+`' target='_blank'>click here</a> to view your transaction`+
              `</div>`);

      $('#acknowledgement_btn_div').fadeOut();

      //store transaction data 
      // var csrf_token = $("input[name=_token]").val();
      $.ajax({
            headers: {'X-CSRF-TOKEN': paymentData.csrf_token},
            url:SITE_URL+'/seller/transaction/save_transaction',
            data:{'txHash':txHash,
                  'trade_id':paymentData.trade_primary_id,
                  'total_price':withdrawlAmount,
                  'action':'crypto_trade_acknowledgement'
                  },
            method:'POST',
            success:function(response)
            {
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
  
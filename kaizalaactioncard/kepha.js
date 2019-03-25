var request = require("request");
const sql = require("mssql");
module.exports = function (context, req) {
     context.log('JavaScript HTTP trigger function processed a request.'); 
     //Validate webhook if(req.query.validationToken){ context.res = { body: JSON.parse(req.query.validationToken) } context.done(); } //save data to db 
     const config = { user: "kepha", password: "@jahmedia1", server: "ministryagric.database.windows.net", database: "commodity_market_price", options: { encrypt: true } } 
     // get details from card 
     let data = req.body.data.responseDetails.responseWithQuestions; 
     let variety; 
     let commodity; 
     let unit; 
     let price; 
     let source; 
     let market; 
     let dates; 
     let area; 
     //defining time 
     var today = new Date(); var dd = today.getDate(); var mm = today.getMonth() + 1; 
     //January is 0! 
     var yyyy = today.getFullYear(); today = mm + '-' + dd + '-' + yyyy; 
     //call the save function savePrices();
      function savePrices(){ 
          market = data[0].answer; 
          variety = data[1].answer; 
          commodity = data[2].answer; 
          unit = data[3].answer; 
          price = data[4].answer; 
          source = data[5].answer; 
          dates = today; area = data[8].answer.n;
         // saving data 
         var query = `INSERT INTO commodity_price ( market, variety, commodity, unit, price, source, dates, area ) VALUES( '${market}', '${variety}', '${commodity}', '${unit}', '${price}', '${source}', '${dates}', '${area}' ); SELECT SCOPE_IDENTITY()`; 
         saveToDb(query);
         } 
         function saveToDb(query) { 
            context.log(query); sql.connect(config).then(() => { return sql.query(query) }).then(result => { sql.close(); }).catch(err => { context.log(err) 

                // sendActionToUserWithError(); context.res = { body: err } sql.close(); context.done(); }) sql.on('error', err => { context.log(err) // sendActionToUserWithError(); context.res = { body: err } sql.close(); 
                context.done(); 
            }) } }; 
 

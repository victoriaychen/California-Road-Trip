// JavaScript Document
// connect to Mongodb
const MongoClient = require('mongodb').MongoClient;
const url = "mongodb+srv://salso:Sally98@cluster0.blu27.mongodb.net/Stock_ticker?retryWrites=true&w=majority";

MongoClient.connect(url, {useUnifiedTopology: true}, function(err, db) {
    if(err) { return console.log(err); return;}

    var dbo = db.db("Stock_ticker"); // change
    var coll = dbo.collection('companies'); //change

    console.log("Success!");

    // writes html
    // read in from form input
    var http = require('http');
    var fs = require('fs');
    var qs = require('querystring');
	var port = process.env.PORT || 3000;
    http.createServer(function (req, res) {
        if (req.url == "/")
          {
              file = 'stock_ticker.html';
              fs.readFile(file, function(err, txt) {
              res.writeHead(200, {'Content-Type': 'text/html'});
              res.write(txt);
              //res.end();
              });
          }
        else if (req.url == "/process")
        {

             res.writeHead(200, {'Content-Type':'text/html'});
             pdata = "";
             req.on('data', data => {
               pdata += data.toString();
             });

            // when complete POST data is received
            req.on('end', () => {
                pdata = qs.parse(pdata);
                console.log(pdata);
                input = pdata['input'];
                console.log(input);
                // query db
                if (pdata['rad'] == "on"){
                    query = {"company": input};
                }
                else
                    query = {"ticker": input};

                coll.find(query).toArray(function(err, items){
                    if(err)
                        console.log("Error: " + err);
                    else{
						//console.log(items[i].company);
                        res.write("<table><tr><th>Company</th><th>Ticker</th></tr>");
                        for (i=0; i<items.length; i++){
                            res.write("<tr><td>" + items[i].company + "</td>"
                                     + "<td>" + items[i].ticker + "</td></tr>");
                        }
                        res.write("</table");
                    }

                })
				
                //res.end();
            });

        }
        else 
        {
            res.writeHead(200, {'Content-Type':'text/html'});
            res.write ("Unknown page request");
            //res.end();
        }


    }).listen(port);
});
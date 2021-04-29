var MongoClient = require('mongodb').MongoClient;
var url = "mongodb+srv://vchen05:piano123@cluster0.1dyzc.mongodb.net/road_trip?retryWrites=true&w=majority";

MongoClient.connect(url, function(err, db) {
        if (err) throw err;
        var city = {
            name: "San Diego",
        };
        db.collection("cities").insertOne(myobj, function(err, res) {
            if (err) throw err;
            console.log("1 record inserted");
            db.close();
        });
});

$(function() {
    $".save"
})

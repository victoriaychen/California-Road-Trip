var MongoClient = require('mongodb').MongoClient;
var url = "mongodb+srv://vchen05:piano123@cluster0.1dyzc.mongodb.net/road_trip?retryWrites=true&w=majority";

MongoClient.connect(url, function(err, db) {
    if (err) throw err;
    var dbo = db.db("road_trip");

    dbo.collection("cities").find({}, {
        projection: {
            city: 0,
            address: 0
        }
    }).toArray(function(err, result) {
        if (err) throw err;
        console.log(result[1].address);
    });
    // var myquery = {
    //     address: "Valley 345"
    // };
    // var newvalues = {
    //     $set: {
    //         name: "Mickey",
    //         address: "Canyon 123"
    //     }
    // };
    //
    // dbo.collection("customers").updateOne(myquery, newvalues, function(err, res) {
    //     if (err) throw err;
    //     console.log("1 record inserted");
    //     db.close();
    // });
});

// $(function() {
//     $ ".save"
// })

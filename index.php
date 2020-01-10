<html>
 <head>
 <Title>Registration Form</Title>
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
 </style>
 </head>
 <body>
 <h1>Register here!</h1>
 <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
 <form method="post" action="index.php" enctype="multipart/form-data" >
       Name  <input type="text" name="name" id="name"/></br></br>
       Email <input type="text" name="email" id="email"/></br></br>
       Job <input type="text" name="job" id="job"/></br></br>
       <input type="submit" name="submit" value="Submit" />
       <input type="submit" name="load_data" value="Load Data" />
 </form>
 <?php
    $host = "rachelappserver.database.windows.net";
    $user = "rachel";
    $pass = "gultom12345#";
    $db = "racheldb";
    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }
    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO Registration (name, email, job, date) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $job);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Registration";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>People who are registered:</h2>";
                echo "<table>";
                echo "<tr><th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Job</th>";
                echo "<th>Date</th></tr>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['job']."</td>";
                    echo "<td>".$registrant['date']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
 </html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sub 2 Azure</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
      <div class="container">
        <p class="lead">Upload sebuah gambar!</p>
        <a href="index.php">Kembali</a>
      </div>
    <div class="container container-fluid">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <div class="card p-3 mb-3" style="width: 18rem;">
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="customFile" name="images">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <input type="submit" name="submit" value="Analisis" class="btn btn-primary form-control">
                    </div>

                    <?php
                     
                        if(!empty($_GET['containerName'])){
                            $containerName = $_GET['containerName'];
                            $listBlobsOptions = new ListBlobsOptions();
                        
                            
                            do{
                                $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
                               
                                foreach ($result->getBlobs() as $blob)
                                {
                                
                                    echo '<img src='.$blob->getUrl().' id="images">';
                                }
                                
                                $listBlobsOptions->setContinuationToken($result->getContinuationToken());
                            } while($result->getContinuationToken());
                        }
                    ?>
                </div>
            </div>
            <div class="row" id="result">
                <div class="col-md-12">
                      <h5 id="captions"></h5>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> 
<script>
    $( "#result" ).hide();
</script>
    <?php
        if (!empty($_GET['containerName'])) {
    ?>
        <script type="text/javascript">
           $( "#result" ).show();
                // **********************************************
                // *** Update or verify the following values. ***
                // **********************************************
        
                // Replace <Subscription Key> with your valid subscription key.
                var subscriptionKey = "777d13a2da704f8e8eb1e2e89ecac591";
        
                // You must use the same Azure region in your REST API method as you used to
                // get your subscription keys. For example, if you got your subscription keys
                // from the West US region, replace "westcentralus" in the URL
                // below with "westus".
                //
                // Free trial subscription keys are generated in the "westus" region.
                // If you use a free trial subscription key, you shouldn't need to change
                // this region.
                var uriBase =
                    "https://nickvision.cognitiveservices.azure.com/vision/v2.0/analyze";
        
                // Request parameters.
                var params = {
                    "visualFeatures": "Categories,Description,Color",
                    "details": "",
                    "language": "en",
                };
        
                // Display the image.
                var sourceImageUrl = document.getElementById("images").src;
                // document.querySelector("#sourceImage").src = sourceImageUrl;
        
                // Make the REST API call.
                $.ajax({
                    url: uriBase + "?" + $.param(params),
        
                    // Request headers.
                    beforeSend: function(xhrObj){
                        xhrObj.setRequestHeader("Content-Type","application/json");
                        xhrObj.setRequestHeader(
                            "Ocp-Apim-Subscription-Key", subscriptionKey);
                    },
        
                    type: "POST",
        
                    // Request body.
                    data: '{"url": ' + '"' + sourceImageUrl + '"}',
                })
        
                .done(function(data) {
                    // Show formatted JSON on webpage.
                    $("#captions").text(data['description']['captions'][0]['text']);
                })
        
                .fail(function(jqXHR, textStatus, errorThrown) {
                    // Display error message.
                    var errorString = (errorThrown === "") ? "Error. " :
                        errorThrown + " (" + jqXHR.status + "): ";
                    errorString += (jqXHR.responseText === "") ? "" :
                        jQuery.parseJSON(jqXHR.responseText).message;
                    alert(errorString);
                });
        </script>
    <?php
        }
    ?>
</html>

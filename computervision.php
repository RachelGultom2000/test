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
                var subscriptionKey = "4c89c2f802374e608cc33c0c2e534972";
        
                // You must use the same Azure region in your REST API method as you used to
                // get your subscription keys. For example, if you got your subscription keys
                // from the West US region, replace "westcentralus" in the URL
                // below with "westus".
                //
                // Free trial subscription keys are generated in the "westus" region.
                // If you use a free trial subscription key, you shouldn't need to change
                // this region.
                var uriBase =
                    "https://rachelvision.cognitiveservices.azure.com/";
        
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

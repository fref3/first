<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Devoir</title>
    
          <!-- Custom styles for this template -->
    <link href="css/1-col-portfolio.css" rel="stylesheet">
    
    <script src="js/moment-with-locales.js"></script>
      
    <script
      src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
   
  </head>
      
      <body>
          
        <!-- Page Content -->
        <div class="container">
            <table id="myTable" class="table table-bordered table-dark">
              <tbody>
                <tr>
                    <th colspan="6">
                        <button id="boutonAjouter" type="submit" class="btn btn-primary" style="width:100%;">Ajouter</button>
                    </th>
                </tr>
                  
                <tr>
                      <th scope="col">
                      <input type="text" id="nomDevoir" placeholder="Nom du devoir"></th>
                      <th scope="col">
                      <input type="date" id="dateRecu" placeholder="Date reçu">
                      </th>
                      <th scope="col">
                      <input type="date" id="dateRemettre" placeholder="Date à remettre"></th>
                      <th scope="col">
                      <input type="checkbox" id="boolRemit" style="float: left; margin-top: 5px;>">
                      <div style="margin-left: 25px;">
                            Remit
                        </div>
                      </th>
                      <th scope="col">
                      <input type="text" id="boolRemit" placeholder="Urgence" disabled>
                      </th>
                      <th scope="col">
                      <input type="text" placeholder="Enlever" disabled>
                  </th>
                </tr>
                    <?php
                  include 'dataBaseConection.php';
                    $sql = "SELECT * FROM devoir";
                    $result = $conn->query($sql);
                                   
                    $couleurVert = "#28a745";
                    $couleurRouge = "#dc3545";
                    $couleurOrange = "#ffc107";
                    $couleurRetard = "#6610f2";
                  
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            if($row['fait'] > 0)
    echo "<tr><td>" . $row['nom'] . "</td>  <td>" . $row['dateArriver'] . "</td>  <td>" . $row['dateDue'] . "</td> <td>Oui</td>" . "<td id=\"urgence\" style=\"background-color: $couleurRouge;\"></td>" . "<td><button style=\"margin: 0px; width:100%\" class=\"btn btn-danger\">DELETE</button></td>";
        
                            else
    echo "<tr><td>" . $row['nom'] . "</td>  <td>" . $row['dateArriver'] . "</td>  <td>" . $row['dateDue'] . "</td> <td>Non</td>" . "<td id=\"urgence\" style=\"background-color: $couleurVert;\"></td>" . "<td><button style=\"margin: 0px; width:100%\" class=\"btn btn-danger\">DELETE</button></td>";
                        }
                    }
                    $conn->close();
                    ?>
              </tbody>
            </table>
        </div>
      </body>
            <script>     
                $("#boutonAjouter").click(function(){   
                var nom = $('#nomDevoir').val();
                var dateRecu = $('#dateRecu').val();
                var dateRemettre = $('#dateRemettre').val();
                var checkbox = $('[name="boolRemit"]'); 
                var date = new Date(dateRecu);
                    
                $.ajax({
                  method: "POST",
                  url:    "insert-data.php",
                  data: { "nom": nom, "dateRecu": dateRecu, "dateRemettre": dateRemettre},
                 });
                  
                moment.locale('fr');   
                    
                var newTr = "<tr></tr>";
                var newTd1 = $("<td></td>").text(nom);  
                var newTd2 = $("<td></td>").text(moment(dateRecu).format('dddd') + " le " + moment(dateRecu).format('D ') + moment(dateRecu).format('MMMM'));  
                var newTd3 = $("<td></td>").text((moment(dateRemettre).format('dddd') + " le " + moment(dateRemettre).format('D ') + moment(dateRemettre).format('MMMM'))); 
                    
                if($('#boolRemit').prop('checked')){
                    var newTd4 = $("<td></td>").text("Oui");
                    var newTd5 = $("<td style=\"background-color:#28a745; color:black\"></td>").text(moment(dateRemettre).fromNow(dateRecu));
                }
                else {   
                     var current = moment().startOf('day');
                     var jourDifference = moment.duration(moment(dateRemettre).diff(current)).asDays();
                     if(jourDifference > 2) {
                        var newTd4 = $("<td></td>").text("Non");
                        var newTd5 = $("<td style=\"background-color:#ffc107; color:black\"></td>").text(moment(dateRemettre).fromNow(dateRecu));
                    }
                     else {
                        var newTd4 = $("<td></td>").text("Non");
                        var newTd5 = $("<td style=\"background-color:#dc3545; color:black\"></td>").text(moment(dateRemettre).fromNow(dateRecu));
                     }
                }
                    
               var newTd6 = $("<td><button style=\"width:100%\" class=\"btn btn-danger\">DELETE</button></td>"); 
                    
               $("#myTable tbody").append(newTr).append(newTd1).append(newTd2).append(newTd3).append(newTd4).append(newTd5).append(newTd6);
            });               
    </script>       
</html>

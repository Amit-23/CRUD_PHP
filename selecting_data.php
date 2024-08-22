 <?php
 
 $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn,$sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
               <th scope='row'>". $sno. "</th>
               <td>". $row['title']. "</td>
               <td>". $row['description']. "</td>
               <td>
                 <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> 
                 <button class='delete btn btn-sm btn-danger' id=d".$row['sno'].">Delete</button> 
                 
               </td>
              </tr>";
          }

?>
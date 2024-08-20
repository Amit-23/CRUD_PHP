<?php

$insert = false;
$update = false;
$delete = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
try {
    $conn = mysqli_connect($servername, $username, $password, $database, 8111);
} catch (mysqli_sql_exception $exception) {
    die("Failed to Connect: " . $exception->getMessage());
} 

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno`=$sno";
  $result = mysqli_query($conn,$sql);



}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['snoEdit'])) {
        // Extract the values from the form
        $title = $_POST['titleEdit'];
        $desc = $_POST['descriptionEdit'];
        $sno = $_POST['snoEdit'];

        // Update the note in the database
        $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$desc' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql);

        if ($result) {
          $update = true;
           
        } else {
            die('The note was not updated successfully because of this error --->' . mysqli_error($conn));
        }
    } else {
        $title = $_POST['title'];
        $desc = $_POST['desc'];

        // Insert the note into the database
        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title','$desc');";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $insert = true;
        } else {
            die('The record was not inserted successfully because of this error --->' . mysqli_error($conn));
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>QuickNotez</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">
</head>
<body>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="index.php" method="post">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="mb-3">
            <label for="titleEdit" class="form-label">Note Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" />
          </div>
          <div class="mb-3">
            <label for="descriptionEdit" class="form-label">Description</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="4"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Update Note</button>
        </form>
      </div>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">QuickNotez</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
        <li class="nav-item"><a class="nav-link disabled" aria-disabled="true">Disabled</a></li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<?php
if ($insert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your note has been inserted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}


if ($delete) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your note has been deleted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

if ($update) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your note has been updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}
?>


<div class="container my-5">
  <h2>Add a Note</h2>
  <form action="index.php" method="post">
    <div class="mb-3">
      <label for="title" class="form-label">Note Title</label>
      <input type="text" class="form-control" id="title" name="title" />
    </div>
    <div class="mb-3">
      <label for="desc" class="form-label">Description</label>
      <textarea class="form-control" id="desc" name="desc" rows="4"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add Note</button>
  </form>
</div>

<div class="container">
  <table class="table" id="myTable">
    <thead>
      <tr>
        <th scope="col">S.No</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
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
    </tbody> 
  </table>
</div>
<hr>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
<script>
  let table = new DataTable('#myTable');

  edits = document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener("click",(e)=>{
      tr = e.target.parentNode.parentNode;
      title = tr.getElementsByTagName("td")[0].innerText;
      description = tr.getElementsByTagName("td")[1].innerText;
      titleEdit.value = title;
      descriptionEdit.value = description;
      snoEdit.value = e.target.id;
      $('#editModal').modal('toggle');
      // to trigger modal via js
    })
  })

 deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((element) => {
    element.addEventListener("click", (e) => {
        // Extracting the number after the first character of the ID
        let sno = e.target.id.substr(1); 
        if (confirm("Are you sure you want to delete this note?")) {
            console.log("Yes, deleting note", sno);
            window.location = `/CRUD/index.php?delete=${sno}`;
        } else {
            console.log("No, cancel delete");
        }
    });
});

</script>
</body>
</html>

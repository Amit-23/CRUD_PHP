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
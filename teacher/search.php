<div id="id03" class="modal">
<form class="modal-content animate" action="./index.php#showPro" method="post">
  <div class="imgcontainer">
  <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close">&times;</span> 
  </div>
  <div class="container">
    <?php
    if (isset($_SESSION["error"])) {
    echo "<div style='color:red'>" . $_SESSION["error"] . "</div>";
    unset($_SESSION["error"]);
    }
    ?>
    <p>
      <label for="prod"><b>Search our product</b></label>
      <input  type="text" placeholder="Enter products name" id="searchword" autocomplete="off" name="product" required>
    </p>
    <button class="lo" type="submit" name="search" title="search">Search</button>
  </div>
</form>

</div>   
<script type="text/javascript">
  // When the user clicks anywhere outside of the modal, close it
  var searchForm = document.getElementById('id03');
  window.onclick = function(event) {
    if (event.target == searchForm) {
      searchForm.style.display = "none";
    }
  }

  $(function() {
    $( "#searchword" ).autocomplete({
      source: 'search_suggest.php',
    });
  });
</script>


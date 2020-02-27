function loadMoreProducts(){
    var current_count,total_count;
    //get the values to be sent to the server.
     current_count = document.getElementById("current_displayed_items").innerHTML;
    
     total_count   = document.getElementById("total_items").innerHTML;
    
    if (window.XMLHttpRequest) {
        //modern browsers
        var xhttp = new XMLHttpRequest();
    }

  /*
  * Sets the callback function when the request status.
  */
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          $("#product-container").append(this.responseText);
          new_count = parseInt(current_count)+3;
          document.getElementById("current_displayed_items").innerHTML = new_count;
          
          //check if all products are displayed
          if(new_count >= total_count){
              //then hide load more button
              $('#load-more').hide();
          }
      }
};
    //sends the request to the server
    xhttp.open("GET", "process.php?&current_count="+current_count, true);
    xhttp.send();
}


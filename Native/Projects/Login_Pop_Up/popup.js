// cara 1
function openForm() {
    document.getElementById("myForm").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }

  // cara 2
  var Form = document.getElementById("myForm");

  function openForm() {
    Form.style.display = "block";
  }

  function closeForm() {
    Form.style.display = "none";
  }


/* Load the repositories select box based on the org when the document loads */
$(document).ready(function(){
  var orgSel = document.getElementById("org");
  orgSel.addEventListener("change", function() {
    getRepos();
  });

  /* Load repos for the default selection */
  getRepos();
});

function getRepos() {
  var orgVal = document.getElementById("org").value;
  var repoSelect = document.getElementById("repo");
  repoSelect.innerHTML = "";

  $.ajax({                                                                                                            
    url: "/GH-WorkItems/php/get_repos.php",                                                                                 
    type: "POST",                                                                                   
    data: {
      org: orgVal
    },
    success : function(data) {
      var json = JSON.parse(data);
      for (i = 0; i < json.length; i++) {
        var repo = json[i];
        console.log("REPO IS " + repo.repo_name);
        var option = document.createElement("option");
        option.innerHTML = repo.repo_name;
        option.value = repo.repo_name;
        repoSelect.appendChild(option);
      }

      /* Re-initialize Google Materialize select box */
      $('select').formSelect();
    }                                                                                            
  });
}
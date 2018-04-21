/* The API URL for all GitHub REST API endpoints */
const GH_API = "https://api.github.com";

/* Get arguments passed as script attributes */
var github_auth = document.currentScript.getAttribute('github_auth');
var github_user = document.currentScript.getAttribute('github_user');

var jsonData = [];

var orgContainer = document.getElementById("org-container");
var repoSection = document.createElement("div");
repoSection.classList.add("section");
orgContainer.appendChild(repoSection);

var orgsRequest = new XMLHttpRequest();

orgsRequest.onreadystatechange = function() {
  /* Wait until request is complete */
  if (orgsRequest.readyState == XMLHttpRequest.DONE) {
    var response = orgsRequest.response;
    var orgs = JSON.parse(response);

    for (var i = 0; i < orgs.length; i++) {
      var org = orgs[i]

      var orgJson = {
        "org_name" : org.login,
        "repos_url" : org.repos_url,
        "repos" : []
      };

      jsonData.push(orgJson);
    }

    getRepos(0);
  }
}

httpGet(GH_API + "/user/orgs", orgsRequest);

function getRepos(index) {
  var org = jsonData[index];
  var reposRequest = new XMLHttpRequest();
  
  reposRequest.onreadystatechange = function() {
    if (reposRequest.readyState == XMLHttpRequest.DONE) {
      var response = reposRequest.response;
      var repos = JSON.parse(response);

      for (var i = 0; i < repos.length; i++) {
        var repo = repos[i];
        var repoJSON = {
          "repo_name" : repo.name
        }

        org.repos.push(repoJSON);
      }

      /* If there are more orgs in the json, continue requesting repositories */
      if (jsonData.length > ++index) {
        getRepos(index);
      }
      else {
        /* Populate database with json data */
        $.ajax({                                                                                                            
          url: "/GH-WorkItems/php/update_db.php",                                                                                 
          type: "POST",                                                                                   
          data: {
            jsonData: JSON.stringify(jsonData)
          },
          success : function(data) {
            var json_response = JSON.parse(data);
            
            for (var i = 0; i < json_response.length; i++) {
              var org = json_response[i];
              var repos = org.repos;

              var orgRow = document.createElement("div");
              orgRow.classList.add("row", "center");
              repoSection.appendChild(orgRow);
              var orgCol = document.createElement("div");
              orgCol.classList.add("col", "s12");
              orgRow.appendChild(orgCol);
              var orgHeader = document.createElement("h4");
              orgHeader.classList.add("indigo-text");
              orgHeader.innerHTML = org.org_name + " Organization Repositories:";
              orgCol.appendChild(orgHeader);

              var headRow = document.createElement("div");
              headRow.classList.add("row");
              repoSection.appendChild(headRow);
              
              var repoCol = document.createElement("div");
              repoCol.classList.add("col", "left", "s4");
              headRow.appendChild(repoCol);
              var repoHeader = document.createElement("h5");
              repoHeader.innerHTML = "Repository Name";
              repoCol.appendChild(repoHeader);

              var countCol = document.createElement("div");
              countCol.classList.add("col", "center", "s4");
              headRow.appendChild(countCol);
              var countHeader = document.createElement("h5");
              countHeader.innerHTML = "Ticket Count";
              countCol.appendChild(countHeader);

              var buttonCol = document.createElement("div");
              buttonCol.classList.add("col", "right");
              headRow.appendChild(buttonCol);
              var buttonHeader = document.createElement("h5");
              buttonHeader.innerHTML = "Repository Page";
              buttonCol.appendChild(buttonHeader);

              var row = document.createElement("div");
              row.classList.add("row");
              row.style.marginBottom = "50px";
              repoSection.appendChild(row);
              
              for (var j = 0; j < repos.length; j++) {
                var col = document.createElement("div");
                col.classList.add("col", "s12");
                row.appendChild(col);
                var toast = document.createElement("div");
                toast.classList.add("toast", "indigo");
                col.appendChild(toast);
                var repo = repos[j];
                var nameCol = document.createElement("div");
                nameCol.classList.add("container", "left");
                toast.appendChild(nameCol);
                var repoName = document.createElement("p");
                repoName.innerHTML = repo.repo_name;
                nameCol.appendChild(repoName);

                var ticketCol = document.createElement("div");
                ticketCol.classList.add("container", "center")
                toast.appendChild(ticketCol);
                var ticketCount = document.createElement("p");
                ticketCount.innerHTML = repo.ticket_count;
                ticketCol.appendChild(ticketCount);

                var buttonCol = document.createElement("div");
                buttonCol.classList.add("container", "right")
                toast.appendChild(buttonCol);
                var button = document.createElement("button");
                button.classList.add("waves-effect", "waves-light", "btn", "orange", "right");
                buttonCol.appendChild(button);
                button.innerHTML = "View Tickets"
                var icon = document.createElement("i");
                icon.classList.add("material-icons", "right");
                icon.innerHTML = "speaker_notes";
                button.appendChild(icon);

                /* Store variables for use on button event */
                button.org = org.org_name;
                button.repo = repo.repo_name;
                button.addEventListener("click", function(e) {
                  viewTickets(this.org, this.repo);
                });
              }
            }
          }                                                                                            
        });
      }
    }
  }

  httpGet(org.repos_url, reposRequest);
}

function viewTickets(org, repo) {
  /* Navigate to php page to request and display tickets from the database */
  console.log("THIS WILL GET THE TICKETS");
}

function httpGet(url, request) {
  request.open("GET", url);
  request.setRequestHeader("Authorization", "Basic " + github_auth);
  request.setRequestHeader("Accept", "application/json");
  request.send();
}
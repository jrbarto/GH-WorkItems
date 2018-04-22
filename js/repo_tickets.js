/* Get arguments passed as script attributes */
var jsonString = document.currentScript.getAttribute('json_string');
var json = JSON.parse(jsonString);

/* Generate tickets after list is created */
function generateTickets() {
  var ticketList = document.getElementById('ticket-list');

  if (json.length == 0) {
    var message = document.createElement("h5");
    message.innerHTML = "No Tickets Have Been Filed Against This Repository.";
    message.classList.add("center");
    ticketList.parentNode.appendChild(message);
    ticketList.parentNode.removeChild(ticketList);
  }

  for (i = 0; i < json.length; i++) {
    var ticket = json[i];
    var id = ticket.id;
    var contact = ticket.contact;
    var description = ticket.description;
    var status = ticket.status;

    /* List of all possible statuses */
    var statuses = ["new", "in-progress", "invalid", "complete"];
    /* Remove the current status */
    var index = statuses.indexOf(status);
    statuses.splice(index, 1);

    var item = document.createElement("li");
    ticketList.appendChild(item);
    var header = document.createElement("div");
    header.classList.add("collapsible-header");
    item.appendChild(header);
    var icon = document.createElement("i");
    icon.classList.add("material-icons");
    icon.innerHTML = "receipt";
    header.appendChild(icon);
    var idSpan = document.createElement("span");
    idSpan.innerHTML = "Ticket ID #" + id;
    header.appendChild(idSpan);
    var badgeSpan = document.createElement("span");
    badgeSpan.classList.add("badge");
    badgeSpan.innerHTML = status;
    header.appendChild(badgeSpan);

    var body = document.createElement("div");
    body.classList.add("collapsible-body");
    item.appendChild(body);
    var statRow = document.createElement("div");
    statRow.classList.add("row");
    body.appendChild(statRow);
    var contactCol = document.createElement("div");
    contactCol.classList.add("col", "s6");
    statRow.appendChild(contactCol);
    var contactText = document.createElement("p");
    contactText.innerHTML = "<b>Contact Email:</b> " + contact;
    contactCol.appendChild(contactText);

    var statCol = document.createElement("div");
    statCol.classList.add("col", "s6");
    statRow.appendChild(statCol);
    var select = document.createElement("select");
    statCol.appendChild(select);

    /* Create the current status of the ticket as selected */
    var currOption = document.createElement("option");
    currOption.value = status;
    currOption.innerHTML = status;
    currOption.selected = true;
    select.appendChild(currOption);

    for (j = 0; j < statuses.length; j++) {
      var statusEntry = statuses[j];
      var option = document.createElement("option");
      option.value = statusEntry;
      option.innerHTML = statusEntry;
      select.appendChild(option);
    }

    var label = document.createElement("label");
    label.innerHTML = "Status";
    statCol.appendChild(label);

    var headerRow = document.createElement("div");
    headerRow.classList.add("row");
    body.appendChild(headerRow);
    var headerCol = document.createElement("div");
    headerCol.classList.add("col", "s12");
    headerRow.appendChild(headerCol);
    var headerText = document.createElement("p");
    headerText.innerHTML = "<b>Description:</b>";
    headerCol.appendChild(headerText);

    var descRow = document.createElement("div");
    descRow.classList.add("row");
    body.appendChild(descRow);
    var descCol = document.createElement("div");
    descCol.classList.add("col" ,"s12");
    descRow.appendChild(descCol);
    var descText = document.createElement("p");
    descText.innerHTML = description;
    descCol.appendChild(descText);
  }

  /* Re-initialize Google Materialize dropdown select boxes */
  $('select').formSelect();
}
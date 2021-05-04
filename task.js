var title = document.getElementById("title");
var desc = document.getElementById("desc");
var date = document.getElementById("date");
var addBtn = document.getElementById("addBtn");
var ul = document.getElementById("ul");
var ul2 = document.getElementById('ul2');


addBtn.onclick = function () {
    //create new list item
  if (title.value !== "") 
  {
    var li = document.createElement("LI");
    ul.appendChild(li);
  }
  if (desc.value !== "") 
  {
    //var li2 = document.createElement("LI");
   //ul.appendChild(li2);
  }
  else {
    alert("List item cannot be empty");
  }
  ///var newlist = new Array[li, li2];
  ///ul.appendChild(newlist);
    
//check off ui    
var list = document.querySelector('ul');
list.addEventListener('click', function(ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);   
    

    
    
    
//add text to li
  var entry = document.createElement("SPAN");
  var entryText = document.createTextNode(title.value);
  var space = document.createTextNode("- ");
  var entryText2 = document.createTextNode(desc.value); 
  //var date = document.createTextNode(date.value);
  entry.className = "userEntry";
  entry.appendChild(entryText);
  entry.appendChild(space);
  entry.appendChild(entryText2);
  //entry.appendChild(space);
  //entry.appendChild(date);
  li.appendChild(entry);
  //li2.appendChild(entry);
    
    
//create x button
  var close = document.createElement("SPAN");
  var cText = document.createTextNode("\u00D7");
  close.className = "close";
  close.appendChild(cText);
  li.appendChild(close);
  //li2.appendChild(close);
  close.onclick = function () {
      this.parentElement.style.display = "none";
  }

  //edit button
  var edit = document.createElement("SPAN");
  var eText = document.createTextNode("\u270E");
  edit.className = "edit";
  edit.appendChild(eText);
  li.appendChild(edit);
  //li2.appendChild(edit);
  edit.onclick = function () {
      var p = prompt("Type title and description");
      var entry = this.parentElement.getElementsByClassName("userEntry")[0]; // get sibling userEntry element
      entry.innerText = p;
  }
  
  
//not really necessary
  li.onclick = function () {
      var x=document.getElementsByTagName("LI").innerHTML;
      document.getElementById("new").innerHTML=x;
      li = document.createElement("LI");
      //ul.appendChild(li);
      ///li.appendChild(x);
  }

  title.value = "";
  desc.value = "";
  date.value = "";
}
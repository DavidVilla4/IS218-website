// Create a "close" button and append it to each list item
var myNodelist = document.getElementsByTagName("LI");
var i;
for (i = 0; i < myNodelist.length; i++) {
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  myNodelist[i].appendChild(span);
}

// Click on a close button to hide the current list item
var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
      div.style.display = "none";
    
    
    
  }
  
}
var li=document.querySelector('li');
var check = li.classList.contains('checked');
//document.getElementById("new").innerHTML=check;
var num =3
// Add a "checked" symbol when clicking on a list item

var list = document.querySelector('ul');
list.addEventListener('click', function(ev) {
  
  if (ev.target.tagName === 'LI') {
      
    ev.target.classList.toggle('checked');
      check = li.classList.contains('checked');
    //compTask();
    
    }
  
}, false);
// Create a new list item when clicking on the "Add" button
function newTask() {
  var li = document.createElement("li");
  li.id="list-item"
  li.onclick="compTask()"
  var inputValue = document.getElementById("newTask").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("You must write something!");
  } else {
    document.getElementById("todo").appendChild(li);
  }
  document.getElementById("newTask").value = "";

  var span = document.createElement("SPAN");
    
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }
    
}






function compTask()
{
    var ul=document.getElementById('todo');
    var nodelist=ul.getElementsByTagName("LI");
      
      //check = li.classList.contains('checked');
        //document.getElementById("new").innerHTML=check;
    var i;
    for (i=0;i<nodelist.length;i++)
        {
            if(check==true)
                {
                    x=nodelist[i].innerHTML;
                    document.getElementById("new").innerHTML=x;
                }
        }
   

}

var menu = Ti.UI.createMenu(),
fileItem = Ti.UI.createMenuItem('FATj.Net'),
exitItem = fileItem.addItem('Exit', function() {
  if (confirm('Are you sure you want to quit?')) {
    Ti.App.exit();
  }
});

menu.appendItem(fileItem);
Ti.UI.setMenu(menu);

function startScript(){
	var res = location.search();
	alert(res);

/*	var tmp = document.getElementById("frm1").value;
	document.getElementById("demo").innerHTML = tmp;
*/
}
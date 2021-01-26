//mubdiul
var d = new Date();
var month_name = ['January','February','March','April','May','June','July','August','September','October','November','December'];
var month = d.getMonth();
var year = d.getFullYear();
var dateDB=[];
var monthDB=[];
var yearDB=[];
var taskDB=[];
window.onload = function(){
    
    var first_date = month_name[month] + " " + 1 + " " + year;
    var tmp = new Date(first_date).toDateString();
    var first_day = tmp.substring(0, 3); 
    var day_name = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    var day_no = day_name.indexOf(first_day); 
    var days = new Date(year, month+1, 0).getDate();    
	var index=[];
	console.log(yearDB);
	for(var i = 0;i<yearDB.length;i++)
	{
		if(yearDB[i]==year)
		{
			for(var j=0;j<monthDB.length;j++)
			{
				if(monthDB[j]-1==month)
				{
					index.push(j);
				}
			}	
		}
	}
    var calendar = get_calendar(day_no, days, index);
    document.getElementById("calendar-month-year").innerHTML = month_name[month]+" "+year;
    document.getElementById("calendar-dates").appendChild(calendar);
}

function get_calendar(day_no, days, index){
	//console.log(index);
	
    var table = document.createElement('table');
	table.setAttribute("id", "dates");
    var tr = document.createElement('tr');
    
    //row for the day letters
    for(var c=0; c<=6; c++){
        var td = document.createElement('td');
        td.innerHTML = "MTWTFSS"[c];
        tr.appendChild(td);
    }
    table.appendChild(tr);
    
    //create 2nd row
    tr = document.createElement('tr');
    var c;
    for(c=0; c<=6; c++){
        if(c == day_no){
            break;
        }
        var td = document.createElement('td');
        td.innerHTML = "";
        tr.appendChild(td);
    }
    
    var count = 1;
    for(; c<=6; c++){
        var td = document.createElement('td');
		for(var i=0;i<index.length;i++)
		{
			if(count==dateDB[index[i]])
			{
				console.log(dateDB[index[i]]);
				td.setAttribute("class", "cycle");
				td.setAttribute("data-title", taskDB[index[i]]);
			}
		}
        td.innerHTML = count;
        count++;
        tr.appendChild(td);
    }
    table.appendChild(tr);
    
    //rest of the date rows
    for(var r=3; r<=7; r++){
        tr = document.createElement('tr');
        for(var c=0; c<=6; c++){
            if(count > days){
                table.appendChild(tr);
                return table;
            }
            var td = document.createElement('td');
			for(var i=0;i<index.length;i++)
		{
			if(count==dateDB[index[i]])
			{
				console.log(dateDB[index[i]]);
				td.setAttribute("class", "circle");
				td.setAttribute("data-title", taskDB[index[i]]);
			}
		}
            td.innerHTML = count;
            count++;
            tr.appendChild(td);
        }
        table.appendChild(tr);
    }
    return table;
}
function goPreviousMonth()
{
	month-=1;
	if(month<0)
	{
		year-=1;
		month = 11;
	}
	var index=[];
	for(var i = 0;i<yearDB.length;i++)
	{
		if(yearDB[i]==year)
		{
			for(var j=0;j<monthDB.length;j++)
			{
				if(monthDB[j]-1==month)
				{
					index.push(j);
				}
			}	
		}
	}
	var first_date = month_name[month] + " " + 1 + " " + year;
	
    var tmp = new Date(first_date).toDateString();
	
    var first_day = tmp.substring(0, 3);
	
    var day_name = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    var day_no = day_name.indexOf(first_day);  
	
    var days = new Date(year, month+1, 0).getDate();  
	
	var tabl = document.getElementById("dates");
    tabl.parentNode.removeChild(tabl);
	
    var calendar = get_calendar(day_no, days, index);
	
    document.getElementById("calendar-month-year").innerHTML = month_name[month]+" "+year;
    document.getElementById("calendar-dates").appendChild(calendar);
}
function goNextMonth()
{
	month+=1;
	if(month>11)
	{
		year+=1;
		month=0;
	}
	var index=[];
	for(var i = 0;i<yearDB.length;i++)
	{
		if(yearDB[i]==year)
		{
			for(var j=0;j<monthDB.length;j++)
			{
				if(monthDB[j]-1==month)
				{
					index.push(j);
				}
			}	
		}
	}
	var first_date = month_name[month] + " " + 1 + " " + year;
	
    var tmp = new Date(first_date).toDateString();
	
    var first_day = tmp.substring(0, 3);   
    var day_name = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    var day_no = day_name.indexOf(first_day);
    var days = new Date(year, month+1, 0).getDate();
	
	var tabl = document.getElementById("dates");
    tabl.parentNode.removeChild(tabl);
    var calendar = get_calendar(day_no, days, index);
	
    document.getElementById("calendar-month-year").innerHTML = month_name[month]+" "+year;
    document.getElementById("calendar-dates").appendChild(calendar);
}
function getDatabaseInfo(dates, months, years, taskNames)
{
	dateDB.push(dates);
	monthDB.push(months);
	yearDB.push(years);
	taskDB.push(taskNames);
	
}
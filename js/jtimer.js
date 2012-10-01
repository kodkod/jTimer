var clients = new Array();
var tasks = new Array();
var jsTimerManager = null;

jQuery(document).ready(function() {
    //reset all forms
	$( "input" ).val('');
	$( "textarea" ).val('');
	if(typeof(Storage)!=="undefined")
    {
		$(".inline").colorbox({inline:true});

		//$('#start_tracking_form').
		//delete localStorage['jsTimerManager'];
        console.log('LocalStorage available');
		//localStorage.setObject('jsTimerManager',obj);
        //console.log(localStorage);
        jsTimerManager = localStorage.getObject('jsTimerManager');
        if (jsTimerManager == null) {
        	jsTimerManager = new Object(); //initiate me :)
            console.log('first use');
        } else {
            console.log('got data');
            console.log(jsTimerManager);
            if (jsTimerManager.clients != null) {
            	clients = jsTimerManager.clients;
            }
            if (jsTimerManager.tasks != null) {
            	tasks = jsTimerManager.tasks;
            	pre_process_tasks(jsTimerManager.tasks);
            }
            pre_process_clients(jsTimerManager.clients);
        }
    }
  else
    {
    // Sorry! No web storage support..
    // TODO: FALL BACK!!!!!!!!
	    alert('no support!');
    }
});
$("#reset_account").click(function(e) {
    e.preventDefault();
    reset_account();
});
function reset_account() {
	delete localStorage['jsTimerManager'];
	document.location.reload(true);
}
function pre_process_clients(pre_clients) {
    /* getting the clients that are in your localstorage */
    for (x in pre_clients) {
    	add_client_to_list((parseInt(x)+1), pre_clients[x].client_name, pre_clients[x].client_desc);
    }
}
function pre_process_tasks(pre_tasks) {
	for (x in pre_tasks) {
		add_task_to_list(x, pre_tasks[x].task_notes, pre_tasks[x].task_stamp, pre_tasks[x].task_end_stamp, pre_tasks[x].client_name);
    }
}
function add_task_to_list(task_id, task_notes, task_stamp, task_end_stamp, client_name) {
	var start_stamp = new Date(task_stamp);
	var d = new Date();
	if (task_end_stamp == null) {
		var end_stamp = '';
		task_end_stamp = d.getTime();
	} else {
		var end_stamp = new Date(task_end_stamp);
		end_stamp = end_stamp.getDate().padZero()+'/'+end_stamp.getMonth().padZero()+'/'+end_stamp.getFullYear()+' '+end_stamp.getHours().padZero()+':'+end_stamp.getMinutes().padZero();
	}

	var task_duration = task_end_stamp-task_stamp;

	start_stamp = start_stamp.getDate().padZero()+'/'+start_stamp.getMonth().padZero()+'/'+start_stamp.getFullYear()+' '+start_stamp.getHours().padZero()+':'+start_stamp.getMinutes().padZero();


	task_id = parseInt(task_id)+1;


	$('#tasks tbody').append('<tr><td>'+task_id+'</td><td>'+task_notes+'</td><td>'+start_stamp+'</td><td>'+end_stamp+'</td><td>'+msToTime(task_duration)+'</td><td>'+client_name+'</td></tr>');
}
function process_stop_tracking() {
	$('#stop_tracking_dialog').colorbox.close();
	var client_name = $('#stop_tracking_dialog #client_name').val();
	var task_notes = $('#stop_tracking_dialog #task_notes').val();
	//stop tracking :)
	var d = new Date();
	var task_id = tasks.length;
	var task_end_stamp = d.getTime();
	//need to find which task to stop.. we are only stating user so need to find task_id by client_name
	var task_id = get_task_id_by_client_name(client_name);

	if (task_id) {
		if (task_notes != '') {
        	//need to turn task notes into ol li list if there are any notes need to add this one
        	//need to check if the task have notes
        	//TODO: FIX task_notes to add notes and not overwrite it!
			var task_notes = '<ol><li>'+task_notes+'</li></ol>';
    	} else {
	    	var task_notes = '<ol><li>Work for '+client_name+'</li></ol>';
    	}
    	tasks[task_id].task_end_stamp = task_end_stamp;
		tasks[task_id].status = 0;
		tasks[task_id].task_notes = task_notes;
		//need to update list
		//update_task_list(task_id, task_notes, task_stamp, task_end_stamp, client_name)
		update_task_list(task_id, task_notes, tasks[task_id].task_stamp, task_end_stamp, client_name);

		//need to update the localStorage
		jsTimerManager.tasks = tasks;
		console.log(jsTimerManager);
		localStorage.setObject('jsTimerManager',jsTimerManager);

	} else {
		//couldn't find task id from client
		alert('cannot find client');
	}


	return false;
}
function get_task_id_by_client_name(client_name) {
    for (x in tasks) {
		if (tasks[x].status == 1 && tasks[x].client_name == client_name) {
    		return x;
		}
	}
	return false;
}
function process_tracking() {
	$('#start_tracking_dialog').colorbox.close();
	var client_name = $('#start_tracking_dialog #client_name').val();
	//need to start tracking time to client_name
	var d = new Date();
	var task_id = tasks.length;
	var task_stamp = d.getTime();
	tasks[task_id] = {task_id:task_id,client_name:client_name,task_stamp:task_stamp,task_end_stamp:null,status:1,task_notes:'',task_duration:0};
	//var task_notes = '<ol><li>Note #1</li><li>Note #2</li></ol>';
	var task_notes = '';
	add_start_task_to_list((parseInt(task_id)+1), task_notes, task_stamp, client_name);

	//need to update the localStorage
	jsTimerManager.tasks = tasks;
	localStorage.setObject('jsTimerManager',jsTimerManager);
	
	return false;
}
function process_client() {
	$('#new_client_dialog').colorbox.close();
	var client_name = $('#new_client_dialog #client_name').val();
	var client_desc = $('#new_client_dialog #client_desc').val();

	clients.push({client_name:client_name, client_desc:client_desc});
	//need to update the localStorage
	jsTimerManager.clients = clients;
	localStorage.setObject('jsTimerManager',jsTimerManager);
	
	var client_id = clients.length; 
	add_client_to_list(client_id, client_name, client_desc);
	return false;
}
function add_client_to_list(client_id, client_name, client_description) {
	client_hours = total_client_time(client_name);
	$('#clients tbody').append('<tr><td>'+client_id+'</td><td>'+client_name+'</td><td>'+client_description+'</td><td>'+msToTime(client_hours)+'</td></tr>');
	$('#clients_list').append('<option value="'+client_name+'">');
}
function add_start_task_to_list(task_id, task_notes, task_stamp, client_name) {
	var start_stamp = new Date(task_stamp);
	start_stamp = start_stamp.getDate().padZero()+'/'+start_stamp.getMonth().padZero()+'/'+start_stamp.getFullYear()+' '+start_stamp.getHours().padZero()+':'+start_stamp.getMinutes().padZero(); 
	$('#tasks tbody').append('<tr><td>'+task_id+'</td><td>'+task_notes+'</td><td>'+start_stamp+'</td><td></td><td></td><td>'+client_name+'</td></tr>');
}
function update_task_list(task_id, task_notes, task_stamp, task_end_stamp, client_name) {
	var start_stamp = new Date(task_stamp);
	if (task_end_stamp != null) {
		var end_stamp = new Date(task_end_stamp);

		var task_duration = task_end_stamp-task_stamp;

		end_stamp = end_stamp.getDate().padZero()+'/'+end_stamp.getMonth().padZero()+'/'+end_stamp.getFullYear()+' '+end_stamp.getHours().padZero()+':'+end_stamp.getMinutes().padZero();

		tasks[task_id].task_duration = task_duration; //SILLY HACK!!!
		
	} else {
		end_stamp = '';
		task_duration = '';
	}
	start_stamp = start_stamp.getDate().padZero()+'/'+start_stamp.getMonth().padZero()+'/'+start_stamp.getFullYear()+' '+start_stamp.getHours().padZero()+':'+start_stamp.getMinutes().padZero();

	task_id = parseInt(task_id)+1;

	//find row and remove it
	$("#tasks table tr").each(function() {
		var find_id = $(this).find('td:first').text();
		if (find_id != '' && find_id == task_id) {
			selected_row = $(this);
		}
	});
	$(selected_row).find('td').remove();
	 
	$(selected_row).append('<td>'+task_id+'</td><td>'+task_notes+'</td><td>'+start_stamp+'</td><td>'+end_stamp+'</td><td>'+msToTime(task_duration)+'</td><td>'+client_name+'</td>');
}
function total_client_time(client_name) {
	var total_time = 0;
	for(x in tasks) {
		if (tasks[x].client_name == client_name) {
			total_time += tasks[x].task_duration;
		}  
	}
	return total_time;
}

Storage.prototype.setObject = function(key, value) {
    this.setItem(key, JSON.stringify(value));
}

Storage.prototype.getObject = function(key) {
    return JSON.parse(this.getItem(key));
}
Number.prototype.padZero= function(len){
	 var s= String(this), c= '0';
	 len= len || 2;
	 while(s.length < len) s= c + s;
	 return s;
}
function msToTime(ms){
    var secs = Math.floor(ms / 1000);
    var msleft = ms % 1000;
    var hours = Math.floor(secs / (60 * 60));
    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);
    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);
    //return hours + ":" + minutes + ":" + seconds  + ":" + msleft;
    return hours.padZero() + ":" + minutes.padZero() + ":" + seconds.padZero(); 
}
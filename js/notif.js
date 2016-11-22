window.setInterval(get_notifs, 3000);
var temp;

function get_notifs()
{
  $(document).ready(function(){
    $.ajax({
      type: 'post',
      dataType: 'json',
      url:'notif.php', 
      success: function(dataNotif)
      {
        if(temp!=dataNotif.countid)
        {     
          if(dataNotif.countid != 0)
          {
            $('.label-notif').text(dataNotif.countid);
            $('.notif-header').text('You have ' + dataNotif.countid + ' update/s.');
            if(dataNotif.account == 'Staff')
            {
              notify = new Notification('Request Update', {
                body: 'You have ' + dataNotif.countid + ' request update/s.',
                icon: './img/notif2.png'
              });
            
              notify.onclick = function()
              {
                window.location = 'viewRequestedRooms.php';  
                update_notif(dataNotif.account);         
              }
            }
            else
            {
              notify = new Notification('New Requests', {
                body: 'You have ' + dataNotif.countid + ' new request/s',
                icon: './img/notif2.png'
              });
            
              notify.onclick = function()
              {  
                window.location = 'dv-main.php';  
                update_requests(dataNotif.account);
                update_notif(dataNotif.account);         
              }
            }
      
            temp=dataNotif.countid;
          }
        }

        $('.notifications-menu').click(function(event)
        {
          $('.label-notif').text('');
          show_notifs(dataNotif.account, dataNotif.countid, dataNotif.userid, dataNotif.dept);
          update_notif(dataNotif.account); 
        });
      }
    });

    

  });
}

function update_notif(account)
{
  $.ajax({
    type: 'post',
    url:'notifupdate.php', 
    data: {account:account},
    success: function(data)
    {

    }
  });
}

function update_requests(account)
{
   $.ajax({
    type: 'post',
    url:'ajax_dv_main.php', 
    data: {account:account},
    success: function(data)
    {
      $('.table-requests').html(data);
    }
  });
}

function show_notifs(account, countid, userid, dept)
{
  $.ajax({
    type: 'post',
    url:'notifshow.php', 
    data: {account:account, countid:countid, userid:userid, dept:dept},
    success: function(data)
    {
       $('.notif-menu').html(data);
    }
  });
}
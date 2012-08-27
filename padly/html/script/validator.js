<script type="text/javascript" src="./padly/html/script/jquery.js">
</script>

<script type="text/javascript" src="./padly/html/script/formvalidatorclass.js">
</script>

<script type="text/javascript">

var fvc = new FVC();
var uname;



window.onload = function()
{


    
sbtn = $('input[type=submit]');

sbtn.attr({id:'sbtn'});

sbtn = document.getElementById('sbtn');

uname = document.getElementById('Username');
uname_msg = document.getElementById('msg_Username');

email = document.getElementById('Email Address');
email_msg = document.getElementById('msg_Email_Address');


uname.addEventListener('blur',
                       function() {
                        
                        $(uname_msg).css('display','inline');
                        
                        
                        if (fvc.checkIfExistTest('username',uname.value,'Username',pd_base))
                        {
                            //clear off message
                            
                            $(uname_msg).css('display','none');
                        }
                        else
                        {
                            
                            $(uname_msg).html('<em style="color:red">  The Username has already been taken</em>');
                        }
                        
                    
                        
                       },
                       false);



email.addEventListener('blur',
                       function() {
                       
                        $(email_msg).css('display','inline');
                        
                        if (fvc.checkIfExistTest('email',email.value,'Email_Address',pd_base))
                        {
                            //clear off message
                            
                            $(email_msg).css('display','none');
                        }
                        else
                        {
                            
                            $(email_msg).html('<em style="color:red">  The Email has already been taken</em>');
                            
                        }
                        
                       },
                       
                       false);




sbtn.addEventListener('click',
                      function()
                      {
                       $('#pd_signupform').unbind();
                       if(fvc.CheckIfEmpty() == 'error')
                       {
                            $('#pd_signupform').submit(function()
                                                       {
                                                        
                                                        return false;
                                                       });
                      
                        }
                            
                        
                      },
                      false);

}






</script>
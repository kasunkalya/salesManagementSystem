
<style type="text/css">
  .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
    color: #D96557;
    text-decoration: none;
    background-color: #f5f5f5;
}

.dropdown-menu > li > a {
    display: block;
    padding: 5px 10px;
    clear: both;
    font-weight: normal;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
}

.dropdown-menu > li > a {
    padding-right: 15px;
    padding-left: 15px;
    color: #616161;
    font-size: 13px;
    
}



</style>
<li>
    <a href="javascript:;" data-toggle="dropdown">
      <img src="{{asset('assets/sammy_new/images/avatar.jpg')}}" class="header-avatar img-circle ml10" alt="user" title="user">
      <span class="pull-left">@if(isset($user)) {{{$user->full_name}}} @endif</span>
    </a>
    <ul class="dropdown-menu">
          <li style="padding-top: 5px;padding-left: 7px;padding-right: 7px;">
             <a href="javascript:;"><i class="fa fa-cog" style="width: 28px;"></i>Settings</a>
          </li>
          <li style="padding-top: 5px;padding-left: 7px;padding-right: 7px;">
            <a href="javascript:;"><i class="fa fa-info" style="width: 30px;"></i>Help</a>
          </li>
         <li style="padding-top: 5px;padding-left:7px;padding-right: 7px;padding-bottom: 5px;">
          <a href="{{{url('user/logout')}}}"><i class="fa fa-sign-out" style="width: 30px;"></i>Logout</a>
         </li>
    </ul>
</li>
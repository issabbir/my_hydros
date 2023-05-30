<!DOCTYPE html>
<html lang="en">

<body>

<p>Dear {{ $name }}</p>
<p>You can change your account password by  clicking this link</p>
<p><a href="{{ route('forget_password_confirmation',['id'=>$id ,"token"=>$forget_password_token]) }}">
        {{ route('forget_password_confirmation',['id'=>$id ,"token"=>$forget_password_token]) }}
    </a></p>

<p>Thanks</p>
<p>Hydrography Department</p>

</body>

</html>

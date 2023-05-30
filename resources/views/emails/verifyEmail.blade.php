<!DOCTYPE html>
<html lang="en">

<body>

<p>Dear {{ $name }}</p>
<p>Your account has been created, please activate your account by clicking this link</p>
<p><a href="{{ route('email-verify',['id'=>$id ,"token"=>$email_verification_token]) }}">
        {{ route('email-verify',['id'=>$id ,"token"=>$email_verification_token]) }}
    </a></p>

<p>Thanks</p>
<p>Hydrography Department</p>

</body>

</html>

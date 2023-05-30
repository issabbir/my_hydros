<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data['title']}}</title>

<style>
body {
    padding: 0;
    margin: 0;
}

html { -webkit-text-size-adjust:none; -ms-text-size-adjust: none;}
@media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
    *[class="table_width_100"] {
		width: 96% !important;
	}
	*[class="border-right_mob"] {
		border-right: 1px solid #dddddd;
	}
	*[class="mob_100"] {
		width: 100% !important;
	}
	*[class="mob_center"] {
		text-align: center !important;
	}
	*[class="mob_center_bl"] {
		float: none !important;
		display: block !important;
		margin: 0px auto;
	}
	.iage_footer a {
		text-decoration: none;
		color: #929ca8;
	}
	img.mob_display_none {
		width: 0px !important;
		height: 0px !important;
		display: none !important;
	}
	img.mob_width_50 {
		width: 40% !important;
		height: auto !important;
	}
}
.table_width_100 {
	width: 680px;
}
</style>
</head>
<body>
<!--
Responsive Email Template by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
-->

<div id="mailsub" class="notification" align="center">
    <!--<div align="center">
       <img src="http://talmanagency.com/wp-content/uploads/2014/12/cropped-logo-new.png" width="250" alt="Metronic" border="0"  />
    </div> -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;"><tr><td align="center" bgcolor="#eff3f8">


<!--[if gte mso 10]>
<table width="680" border="0" cellspacing="0" cellpadding="0">
<tr><td>
<![endif]-->

<table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%" style="max-width: 680px; min-width: 300px;>
    <tr><td>
	<!-- padding -->
	</td></tr>
	<!--header -->
	<tr><td align="center" bgcolor="#ffffff">
		<!-- padding -->
		<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#fbfcfd">
			<tr>
{{--                <td align="left">--}}
{{--			    		<a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; float:left; width:100%; padding:20px;text-align:center; font-size: 13px;">--}}
{{--									<font face="Arial, Helvetica, sans-seri; font-size: 13px;" size="3" color="#596167">--}}
{{--									<img src="data:image/png;base64,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--}}
{{--"   alt="Metronic" border="0"  /></font></a>--}}
{{--					</td>--}}
					<td align="right">
				<!--[endif]--><!--

			</td>
			</tr>
		</table>
		<!-- padding -->
	</td></tr>
	<!--header END-->

	<!--content 1 -->
	<tr><td align="center" bgcolor="#fbfcfd">
	    <font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;">
		<table width="90%" border="0" cellspacing="0" cellpadding="0" style="padding: 15px">
			<tr><td>
{{--                    @dd($data)--}}
			    Dear  {{ $data['receiver_name'] }},<br/><br/>
                Thank you for your patience.<br/><br/>
                <p class="font-weight-bold">{{ $data['body'] }}</p><br/><br/>
			    Regards<br/>
                 <img style="margin-top: 10px" src="data:image/png;base64,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
"   alt="CPA" border="0"  /><br/>
   			</td></tr>

		</table>
		</font>
	</td></tr>
	<!--content 1 END-->


	<!--footer -->
	<tr><td class="iage_footer" align="center" bgcolor="#ffffff">


		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td align="center" style="padding:20px;flaot:left;width:100%; text-align:center;">
				<font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5" style="font-size: 13px;">
				<span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
					2020 © CPA. ALL Rights Reserved.
				</span></font>
			</td></tr>
		</table>
	</td></tr>
	<!--footer END-->
	<tr><td>

	</td></tr>
</table>
<!--[if gte mso 10]>
</td></tr>
</table>
<![endif]-->

</td></tr>
</table>

</body>
</html>
<html>

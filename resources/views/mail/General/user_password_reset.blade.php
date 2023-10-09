@extends('layouts.mail_new.app')
@section('content')

    
            <tr>
				<td class="pb-4" style="padding-bottom:  1.5rem!important;"><h1 style="font-size: 20px;color: #404040;">Password reset</h1></td>
			</tr>

            <tr>
				<td class="pb-2" style="padding-bottom:  1.5rem!important;">Hello there,</td>
			</tr>

            <tr>
				<td class="pb-4" style="padding-bottom:  1.5rem!important;">We’ve received a request to reset your password for your {{site_name}} account.</td>
			</tr>
            <tr>
				<td class="pb-2" style="padding-bottom:  1.5rem!important;"><span><b>To reset your password, please click on the button below.</b></span></td>
			</tr>
            <tr>
				<td class="pb-4" style="padding-bottom:  1.5rem!important;"><a style="background: #A8D08D; padding: 5px;text-decoration: underline;color: #404040;font-weight: 500;"  href="{{route('front.forgot_password_view',$user->reset_token)}}">PASSWORD RESET</a></td>
			</tr>

			<tr>
				<td class="pb-4"  style="padding-bottom:  1.5rem!important;">Thanks.</td>
			</tr>

            <tr>
             <td class="pb-5" style="padding-bottom:  3rem!important;">Regards,</td>
             </tr>

            <tr>
                <td><b>The {{site_name}} team</b></td>
            </tr>

@endsection

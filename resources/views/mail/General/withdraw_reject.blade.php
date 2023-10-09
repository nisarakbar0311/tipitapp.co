@extends('layouts.mail_new.app')
@section('content')

<tr>
    <td class="pb-4" style="padding-bottom:  1.5rem!important;">
        <h1 style="font-size: 20px;color: #404040;">Withdraw Request Rejected</h1>
    </td>
</tr>
<tr>
    <td class="pb-4" style="padding-bottom:  1.5rem!important;">Dear {{$user->name}},</td>
</tr>
<tr>
    <td class="pb-4" style="padding-bottom:  1.5rem!important;">Your withdraw request rejected below reasons.</td>
</tr>

<tr>
    <td class="pb-4" style="padding-bottom:  1.5rem!important;"><b>{{$reason }}</b> </td>


</tr>

<tr>
    <td class="pb-5" style="padding-bottom:  3rem!important;">Regards,</td>
</tr>

<tr>
    <td><b>The {{site_name}} team</b></td>
</tr>
@endsection
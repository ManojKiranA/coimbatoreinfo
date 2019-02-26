@extends('layouts.authorize')
@section('title')Login-@endsection
@section('content')
<div class="login100-pic js-tilt" data-tilt>
   <!-- <img src="{{asset('logos/CCYM-logo.png')}}" alt="IMG"> -->
   <!-- {{ config('app.name', 'CoimbatoreInfo') }} -->
</div>
<form method="POST" action="{{ route('login') }}">
   @csrf
   <span class="login100-form-title">
{{ config('app.name', 'CoimbatoreInfo') }}
   </span>
   @if ($errors->any())
   <div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
   @endif
   <div class="wrap-input100 validate-input" data-validate = "Valid User name is required: johndoe">
      <input class="input100" type="text" name="email" placeholder="Username" id="email" value="{{old('email')}}" required autofocus>
      <span class="focus-input100"></span>
      <span class="symbol-input100">
      <i class="fa fa-user" aria-hidden="true"></i>
      </span>
   </div>
   <div class="wrap-input100 validate-input" data-validate = "Entert the password">
      <input class="input100" type="password" name="password" placeholder="Password" id="password"  required autofocus>
      <span class="focus-input100"></span>
      <span class="symbol-input100">
      <i class="fa fa-user" aria-hidden="true"></i>
      </span>
   </div>



   

   <div class="container-login100-form-btn">
      <button class="login100-form-btn">
      Login
      </button>
   </div>

   <div class="text-center p-t-12">
      <span class="txt1">
         <!-- Forgot -->
      </span>
      <a class="txt2" href="#">
         <!-- Username / Password? -->
      </a>
   </div>
   <div class="text-center p-t-136">
      <a class="txt2" href="#">
         <!-- Create your Account -->
         <i class="fa" aria-hidden="true"></i>
      </a>
   </div>
</form>
@endsection
@extends('layouts.frontend')
@section('content')
<!-- Destinations -->
         <div class="destinations" id="destinations">
            <div class="container">
               <div class="row">
                  <div class="col text-center">
                     @if(isset($busResultCollection))
                        <div class="section_subtitle">{{$busResultCollection->count()}}-{{$busResultCollection->count() <= 1 ? 'Bus':'Busses' }}</div>
                        <div class="section_title">
                           <h2>List of Busses From {{$currentTime}} to {{$nextTimeLimit}} </h2>
                        </div>
                     @endif
                     
                  </div>
               </div>
               <div class="row destinations_row">
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">Bus Name</th>
                           <th scope="col">Bus From</th>
                           <th scope="col">Bus To</th>
                           <th scope="col">Bus Time</th>
                           <th scope="col">Bus Going Via</th>
                        </tr>
                     </thead>
                     <tbody>
                        
                        
                        @if($isBusAvailable == "AVAILABLE")
                        @foreach($busResult as $item)
                        <tr>
                           <td>{{$loop->iteration}}</td>
                           <td>{{$item->busName}}</td>
                           <td>{{$item->locationFrom}}</td>
                           <td>{{$item->toLocation}}</td>
                           <td>{{ApplicationHelper::convertToFormattedDate($item->bus_time,9)}}</td>
                           <td>{{$item->busGoingVia}}</td>
                        </tr>
                        @endforeach
                        
                        </tr>
                        @endif
                     </tbody>
                  </table>
                  <center>
                     {{$busResult->links()}}  
                  </center>
               </div>
            </div>
         </div>
@endsection
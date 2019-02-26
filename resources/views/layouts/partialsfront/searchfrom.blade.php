<!-- Search -->
         <div class="home_search">
            <div class="container">
               <div class="row">
                  <div class="col">
                     <div class="home_search_container">
                        <div class="home_search_title">Search for your Bus</div>
                        <div class="home_search_content">
                              <form action="{{route('search.busses')}}" method="GET" role="search" class="home_search_form">
                                 
                              <div class="d-flex flex-lg-row flex-column align-items-center justify-content-lg-between justify-content-center">
                                 @php
                                 $modelPath = ['App','Models'];
                                 $busFromArray = ApplicationHelper::toDropDown('CbeInfoLocationFrom',$modelPath,'location_from_name','id','Select From Location');
                                 $busToArray = ApplicationHelper::toDropDown('CbeInfoLocationTo',$modelPath,'location_to_name','id','Select To Location');
                                    
                                 @endphp
                                 
                                 {!! Form::select('location_from', $busFromArray, isset($fromLocation) ?  $fromLocation : '', ['class' =>'search_input search_input_1','id' => 'location_from']) !!}

                                 {!! Form::select('location_to', $busToArray, isset($toLocation) ?  $toLocation : '', ['class' =>'search_input search_input_2','id' => 'location_to']) !!}

                                 <button class="home_search_button" type="submit">search</button>
                              </div>
                           </form>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
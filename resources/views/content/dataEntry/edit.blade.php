
@extends('layouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')

<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">
                <h3><strong>Payroll Data Entry Point</strong></h3>
                <hr class="mt-4 mx-4">
                <form id="data_entry_from" action="{{route('data_entry_point.update',$dataEntry->id)}}" method="POST" novalidate enctype="multipart/form-data"> 
                  @csrf
                    <div class="row mx-4">
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="number" readonly value="{{$employee->contact_number}}" class="form-control" name="contact_number" id="data_contact_number" placeholder="999666..." aria-describedby="data_contact_numberHelp" />
                                  <label for="data_contact_number">Contact Number</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                  <input type="text" name="first_name" class="form-control" id="first_name" placeholder="John" value="{{$employee->first_name}}" readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
                                  <label for="first_name">First Name</label>
                                </div>
                                <span id="errNm1"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" readonly class="form-control" name="last_name" id="last_name" placeholder="Doe"  value="{{$employee->last_name}}" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="last_name">Last Name</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="sin" value="{{$dataEntry->sin}}" id="SIN" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="SIN">SIN</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" value="{{$dataEntry->line_1}}" name="line_1" id="line_1" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="line_1">LINE 1</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" value="{{$dataEntry->line_2}}"  name="line_2" id="line_2" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="line_2">LINE 2</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                     
                        <div class="col-md-4">
                          <div class=" mb-4">
                            <div class="">
                              <div class="form-floating">
                                  <select id="country" name="country" class="form-select">
                                      <option value="">Please select country</option>
                                      @foreach($country as $k => $value)
                                        <option value="{{$value->id}}" {{$dataEntry->country == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
                                      @endforeach
                                    </select>
                                <label for="country">Country</label>
                              </div>
                            </div>
                          </div>
                      </div>
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                    <select id="Provience" name="provience" class="form-select">
                                        <option value="">Please select Provience</option>
                                        @foreach($provience as $k => $value)
                                            <option value="{{$value->id}}" {{$dataEntry->provience == $value->id ? 'selected' : ''}}>{{$value->provience_name}}</option>
                                        @endforeach
                                      </select>
                                  <label for="Provience">Provience</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                          <div class=" mb-4">
                            <div class="">
                              <div class="form-floating">
                                  <select id="city" name="city_id" class="form-select">
                                      <option value="">Please select city</option>
                                      @foreach($city as $k => $value)
                                            <option value="{{$value->id}}" {{$dataEntry->city_id == $value->id ? 'selected' : ''}}>{{$value->city_title}}</option>
                                        @endforeach
                                    </select>
                                <label for="city">CITY</label>
                              </div>
                            </div>
                          </div>
                      </div>
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" value="{{$dataEntry->postal_code}}"  name="postal_code" id="Postal_code" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="Postal_code">Postal Code</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-center">BANK DETAILS</p>
                        <div class="col-md-3">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" value="{{$dataEntry->transit_number}}" name="transit_number" id="transit_number" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="transit_number">Transit Number</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" value="{{$dataEntry->institution_number}}" name="institution_number" id="Institution_number" placeholder="Enter Institution Number" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="Institution_number">Institution Number</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="account_number" id="Account_number" value="{{$dataEntry->account_number}}" placeholder="Eneter Account No" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="Account_number">Account Number</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-top: -15px">
                            <label for="formFile" class="form-label text-start w-100" id="license_text">Personal Identification</label>
                            <input class="form-control" value={{$dataEntry->personal_identification}} type="file" name="personal_identification" id="formFile">
                            <input type="hidden" name="" id="edit_license_view" data-href="{{ asset('storage/assets/' . $dataEntry->personal_identification) }}">
                          </div>
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary" id="employee_button">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset("assets/js/custom/data_entry.js")}}"></script>
<script>
  @php
    $eroor_message = '';
    if ($errors->any()){
      foreach ($errors->all() as $error){
        $eroor_message .= $error;
      }
    }
  @endphp
  @if($eroor_message != '')
    swal("Oops...", "{{ $eroor_message }}", "error");
  @endif
</script>
@endsection


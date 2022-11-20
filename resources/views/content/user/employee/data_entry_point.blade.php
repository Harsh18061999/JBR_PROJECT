
@extends('uselayouts/contentNavbarLayout')

@section('title', ' Horizontal Layouts - Forms')

@section('content')

<div class="card shadow bg-transparent" id="grad1">
    <div class="row mt-0">
        <div class="text-center p-0">
            <div class="card px-0 pt-4 pb-0 d-flex justify-content-center">

                <img src="{{asset('/assets/img/JBR_Staffing_Solutions.jpg')}}" class="m-auto" alt="" width="250px" height="250px">
                <h3><strong>Payroll Data Entry Point</strong></h3>
                <hr class="mt-4 mx-4">
                <form id="data_entry_from" action="{{route('data_entry_point.store')}}" method="POST" novalidate enctype="multipart/form-data"> 
                  @csrf
                    <div class="row mx-4">
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="number" class="form-control" name="contact_number" id="data_contact_number" placeholder="999666..." aria-describedby="data_contact_numberHelp" />
                                  <label for="data_contact_number">Contact Number</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <input type="hidden" name="employee_id" id="employee_id">
                        <div class="col-md-4">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating error_message">
                                  <input type="text" name="first_name" class="form-control" id="first_name" placeholder="John" readonly aria-describedby="floatingInputHelp" data-error="errNm1" />
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
                                  <input type="text" readonly class="form-control" name="last_name" id="last_name" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
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
                                  <input type="number" class="form-control" name="sin" id="SIN" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
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
                                  <input type="text" class="form-control" name="line_1" id="line_1" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
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
                                  <input type="text" class="form-control" name="line_2" id="line_2" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
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
                                        <option value="{{$value->id}}">{{$value->name}}</option>
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
                                  <input type="number" class="form-control" name="postal_code" id="Postal_code" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
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
                                  <input type="number" class="form-control" name="transit_number" id="Postal_code" placeholder="Doe" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="Postal_code">Transit Number</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class=" mb-4">
                              <div class="">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="institution_number" id="Institution_number" placeholder="Enter Institution Number" aria-describedby="floatingInputHelp" data-error="errNm2" />
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
                                  <input type="text" class="form-control" name="account_number" id="Account_number" placeholder="Eneter Account No" aria-describedby="floatingInputHelp" data-error="errNm2" />
                                  <label for="Account_number">Account Number</label>
                                </div>
                                <span id="errNm2"></span>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-top: -15px">
                            <label for="formFile" class="form-label text-start w-100" id="license_text">Personal Identification</label>
                            <input class="form-control" type="file" name="personal_identification" id="formFile">
                          </div>
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary" id="employee_button">Register</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12 mx-4">
                        <form action="">
                            <div class="row">

                                
                            </div>
                        </form>
                    </div>
                </div>
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


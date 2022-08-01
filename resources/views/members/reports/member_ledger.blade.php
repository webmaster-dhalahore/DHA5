@extends('layouts.admin', ['title'=> 'Member Ledger Report', 'page_title' => 'Member Ledger Report'])

@section('buttons')
@if($memberid)
@include('members.includes.printButton')
@include('members.includes.editButton', ['memberid' => $memberid])
@include('members.includes.profileButton', ['memberid' => $memberid])
@include('members.includes.infoButton', ['memberid' => $memberid])
@endif

@include('members.includes.homeButton')
@stop

<?php
$fromDate = $from_date ? $from_date : '2019-07-01';
$toDate = $to_date ? $to_date : date('Y-m-d');
?>

@section('content')

<div class="content">
  <div class="container-fluid">

    <form action="{{ route('member.reports.member-ledgerPost') }}" method="post">
      @csrf
      <div class="row d-print-none">
        <div class="col-sm-3"></div>
        <div class="col-6 col-sm-6">
          <div class="card card-primary card-outline">
            <div class="card-body">

              <div class="row">
                <div class="col-sm-12 mb-0">
                  <div class="form-group row mb-0 required">
                    <label for="from_date" class="col-sm-5 col-form-label">From Date</label>
                    <div class="col-sm-7">
                      <input type="date" class="form-control form-control-sm {{ $errors->has('from_date') ? 'is-invalid' : ''}}" value="{{ old('from_date', $fromDate) }}" id="from_date" name="from_date" required />
                      @error('from_date')
                      <div class="invalid-feedback" id="ifb_from_date">
                        {{$errors->first('from_date')}}
                      </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 mb-0">
                  <div class="form-group row mb-0 required">
                    <label for="to_date" class="col-sm-5 col-form-label">To Date</label>
                    <div class="col-sm-7">
                      <input type="date" value="{{ old('to_date', $toDate) }}" class="form-control form-control-sm {{ $errors->has('to_date') ? 'is-invalid' : ''}}" id="to_date" name="to_date" required />
                      @error('to_date')
                      <div class="invalid-feedback" id="ifb_to_date">
                        {{$errors->first('to_date')}}
                      </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 mb-0">
                  <div class="form-group row mb-0 required">
                    <label for="memberid" class="col-sm-5 col-form-label">Member ID</label>
                    <div class="col-sm-7">
                      <input value="{{ old('memberid', $memberid) }}" class="uppercase form-control form-control-sm {{ $errors->has('memberid') ? 'is-invalid' : ''}}" id="memberid" name="memberid" placeholder="Member ID" required />
                      @error('memberid')
                      <div class="invalid-feedback" id="ifb_memberid">
                        {{$errors->first('memberid')}}
                      </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="offset-sm-5 col-sm-7 mt-2">
                  <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search mr-2"></i> SEARCH</button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>
    @if($transactions)
    @if(count($transactions))
    <?php
    $balance = $opening_balance;
    $debit_sum = 0;
    $credit_sum = 0;
    ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="d-none" id="loaderdiv"><span>Please Wait...</span></div>
        <div class="card card-primary card-outline" id="tableDivSearchResults">
          <div class="card-header p-2 d-print-none">
            <div class="row d-flex justify-content-between">
              <div class="col-sm-8">
              </div>
              <div class="col-sm-4 float-right">
                <button type="button" class="btn btn-sm btn-primary mr-1 float-right" id="download-pdf"><i class="fas fa-download mr-1"></i> Download PDF</button>
              </div>
            </div>
          </div><!-- /.card-header -->

          <div class="card-body">
            <h3 style="text-align: center; font-weight: 400; font-size: 20px;">DEFENCE CLUB DHA</h3>
            <div class="row mb-2">
              <div class="col-sm-2 text-bold">Member ID</div>
              <div class="col-sm-7">{{$memberid}}</div>
              <div class="col-sm-2 text-bold">Opening Balance</div>
              <div class="col-sm-1" style="text-align: right; border: 1px solid;">{{number_format($opening_balance)}}</div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-2 text-bold">Member Name</div>
              <div class="col-sm-6">{{$membername}}</div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-2 text-bold">Dates Between</div>
              <div class="col-sm-6">{{ \Carbon\Carbon::parse($from_date)->format('d-M-Y') }} - {{ \Carbon\Carbon::parse($to_date)->format('d-M-Y') }}</div>
            </div>
            <table class="table table-borderless" id="ledger_tbl">
              <thead>
                <tr>
                  <th class="border-bottom" width="1px">SR</th>
                  <th class="border-bottom">Doc Date</th>
                  <th class="border-bottom">Doc No</th>
                  <th class="border-bottom">Description</th>
                  <th class="border-bottom text-right">DR</th>
                  <th class="border-bottom text-right">CR</th>
                  <th class="border-bottom text-right">Balance</th>
                </tr>
              </thead>
              <tbody id="ledger_tbl_body">
                @foreach($transactions as $transaction)
                <?php
                $dr = $transaction->dr ? round($transaction->dr) : null;
                $cr = $transaction->cr ? round($transaction->cr) : null;
                if ($dr) {
                  $balance += $transaction->dr;
                  $debit_sum += $transaction->dr;
                }
                if ($cr) {
                  $balance -= $transaction->cr;
                  $credit_sum += $transaction->cr;
                }
                ?>
                <tr>
                  <td widtd="1px">{{ $loop->iteration }}</td>
                  <td>{{ $transaction->docdate ? \Carbon\Carbon::parse($transaction->docdate)->format('d-M-Y') : '' }}</td>
                  <td>{{ $transaction->docno }}</td>
                  <td>{{ $transaction->area_desc }}</td>
                  <td class="text-right">{{ $dr ? number_format($dr) : '' }}</td>
                  <td class="text-right">{{ $cr ? number_format($cr) : '' }}</td>
                  <td class="text-right">{{ number_format(round($balance)) }}</td>
                </tr>
                @endforeach
                <tr>
                  <th class="border-top" width="1px"></th>
                  <th class="border-top">Total</th>
                  <th class="border-top"></th>
                  <th class="border-top"></th>
                  <th class="border-top text-right">{{ $debit_sum ? number_format(round($debit_sum)) : '' }}</th>
                  <th class="border-top text-right">{{ $credit_sum ? number_format(round($credit_sum)) : '' }}</th>
                  <th class="border-top text-right"></th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @else
    <h3 class="text-center">No entries between this period...</h3>
    @endif
    @endif
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@stop

@push('custom-styles')
<link rel="stylesheet" href="{{ asset('dist/custom_css/members/loader.css') }}">
@endpush

@push('custom-scripts')
<script>
  const downloadRoute = "{{ route('member.reports.member-ledger-download') }}";
  const memberid = "{{$memberid}}" || 'member-ledger';
  const from_date = "{{$from_date}}";
  const to_date = "{{$to_date}}";
</script>
<script src="{{ asset('dist/js/members/reports/member_ledger.js') }}" defer></script>
@endpush
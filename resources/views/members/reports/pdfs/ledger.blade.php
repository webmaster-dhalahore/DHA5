@extends('layouts.pdf', ['title'=> 'Member Ledger : ' . $membername, 'page_title' => 'Member Ledger 1x'])

@push('custom-styles')
<style>
  *{
    font-family: Arial, Helvetica, sans-serif;
    font-size: .8rem;
  }

  table {
    /* font-size: .7rem; */
    border-collapse: collapse;
    width: 100%;
  }

  #ledgerInfo td,
  #ledgerInfo th {
    border: none;
    padding-top: 8px;
    padding-bottom: 8px;
  }

  #memberLedger td,
  #memberLedger th {
    border: none;
    padding-top: 11px;
    padding-bottom: 11px;
  }

  #memberLedger tr:last-child {
    border-top: 1px solid black;
    border-bottom: 1px solid black;
  }

  #memberLedger th {
    padding-top: 12px;
    padding-bottom: 12px;
    color: black;
  }
</style>
</head>

<body>
  </style>
  @endpush


  @section('content')
  <?php
  $balance = $opening_balance;
  $debit_sum = 0;
  $credit_sum = 0;
  ?>
  <div class="content mt-5">
    <h1 style="text-align: center;">DEFENCE CLUB DHA</h1>
    <table id="ledgerInfo">
      <tbody>
        <tr>
          <th align="left" width="100px">Member ID</th>
          <td align="left">{{$memberid}}</td>
          <td></td>
          <th align="left" width="130px">Opening Balance</th>
          <td align="right" width="80px" style="border: 1px solid black; padding-right: 7px"><b>{{ number_format($opening_balance) }}</b></td>
        </tr>
        <tr>
          <th align="left" width="80px">Member Name</th>
          <td align="left" colspan="4">{{$membername}}</td>
        </tr>
        <tr>
          <th align="left" width="80px">Dates Between</th>
          <td align="left" colspan="4">{{ \Carbon\Carbon::parse($from_date)->format('d-M-Y') }} - {{ \Carbon\Carbon::parse($to_date)->format('d-M-Y') }}</td>
        </tr>
        <tr>
          <th  colspan="5"></th>
        </tr>
      </tbody>
    </table>
    <table id="memberLedger">
      <thead>
        <tr>
          <th align="left">Doc Date</th>
          <th align="left">Doc No</th>
          <th align="left">Description</th>
          <th align="right">DR</th>
          <th align="right">CR</th>
          <th align="right">Balance</th>
        </tr>
      </thead>
      <tbody>
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
          <td class="fontWeight">{{ $transaction->docdate ? \Carbon\Carbon::parse($transaction->docdate)->format('d-M-Y') : '' }}</td>
          <td class="fontWeight">{{ $transaction->docno }}</td>
          <td class="fontWeight" align="left">{{ $transaction->area_desc }}</td>
          <td class="fontWeight" align="right">{{ $dr ? number_format($dr) : '' }}</td>
          <td class="fontWeight" align="right">{{ $cr ? number_format($cr) : '' }}</td>
          <td class="fontWeight" align="right">{{ number_format(round($balance)) }}</td>
        </tr>
        @endforeach
        <tr>
          <td align="left" colspan="3" class="fontWeight"><b>Total</b></td>
          <td align="right" class="fontWeight"><b>{{ number_format(round($debit_sum)) }}</b></td>
          <td align="right" class="fontWeight"><b>{{ number_format(round($credit_sum)) }}</b></td>
          <td align="right" class="fontWeight"></td>
        </tr>
      </tbody>
    </table>
  </div>
  @stop
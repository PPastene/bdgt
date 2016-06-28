@extends('app')

@section('breadcrumbs.items')
	<li><a href="/accounts">Accounts</a></li>
	<li class="active">{{ $account->name }}</li>
@endsection

@section('breadcrumbs.actions')
	<a href="#editAccountModal" data-toggle="modal" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Edit</a>
	<!-- <a href="#deleteAccountModal" data-toggle="modal" class="btn btn-danger btn-xs"><i class="fa fa-close"></i> Delete</a> -->
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="{{ config('layout.grid_class') }}">
				<h2>
					{{ $account->name }}
					<span class="pull-right">
						$ {{ number_format($account->running_balance, 2) }}
					</span>
				</h2>
				<p class="pull-right">
					{{ number_format($account->interest, 2) }}%
				</p>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="{{ config('layout.grid_class') }}">
				<p class="lead">Transactions</p>
				<table class="table">
					{!! $transactions !!}
				</table>
			</div>
		</div>
		<div class="row">
			<div class="{{ config('layout.grid_class') }}">
				<a href="#deleteAccountModal" data-toggle="modal" class="pull-right">Delete this account</a>
			</div>
		</div>
	</div>

	@include('account.modals.edit')
	@include('account.modals.delete')
@endsection
@extends('app')

@section('css')
	<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" rel="stylesheet">
@endsection

@section('js')
	<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-push-7">
				<div class="list-group">
					<div class="list-group-item">
						<div class="list-group-item-text">
							<div class="pull-right">
								<a href="#addBillModal" data-toggle="modal" class="btn btn-success">
									<i class="fa fa-plus"></i> Add Bill
								</a>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					@foreach ($bills as $bill)
						<a href="/bills/{{ $bill->id }}" class="list-group-item">

							@if ($bill->total >= $bill->amount)
								<span class="pull-right label label-success">PAID</span>
							@else
								<span class="pull-right label label-danger">UNPAID</span>
							@endif

							<h4 class="list-group-item-heading">{{ $bill->label }}</h4>
							<p class="list-group-item-text pull-right">Due <span class="moment">{{ $bill->nextDue }}</span></p>
							<p class="list-group-item-text">$ {{ number_format($bill->amount, 2) }}</p>
						</a>
					@endforeach
				</div>
			</div>
			<div class="col-md-6 col-md-pull-3">
				<div id="calendar"></div>
			</div>
		</div>
	</div>

	<div id="addBillModal" class="modal fade">
		<div class="modal-dialog">
			<form class="modal-content form-horizontal" method="POST" action="/bills">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Add a Bill</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Payee</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="label" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Amount</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="amount">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Date</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="start_date" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Frequency</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="frequency" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
@endsection

@section('scripts')
var bills = {!! json_encode(array_values($bills->toArray())) !!};

$('#calendar').fullCalendar({
	events: bills,
	eventDataTransform: function(rawEventData) {
		return {
				id: rawEventData.id,
				title: rawEventData.label + ' due',
				start: rawEventData.nextDue,
				end: rawEventData.nextDue
		};
	}
});
@endsection